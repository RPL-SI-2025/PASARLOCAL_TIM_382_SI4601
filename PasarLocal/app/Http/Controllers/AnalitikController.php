<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExportExcel;
use Maatwebsite\Excel\Facades\Excel;

class AnalitikController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start_date') ?? Carbon::now()->startOfMonth()->toDateString();
        $end = $request->input('end_date') ?? Carbon::now()->endOfMonth()->toDateString();

        return view('admin.analitik.index', compact('start', 'end'));
    }

    public function data(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        // Jika tidak ada input tanggal, beri default (awal dan akhir bulan ini)
        if (!$start || !$end) {
            $start = Carbon::now()->startOfMonth()->toDateString();
            $end = Carbon::now()->endOfMonth()->toDateString();
        }

        // Konversi ke datetime lengkap (start dan end of day)
        $startDateTime = Carbon::parse($start)->startOfDay()->toDateTimeString();
        $endDateTime = Carbon::parse($end)->endOfDay()->toDateTimeString();

        // Ambil pemesanan dengan status 'Selesai' dan tanggal di rentang
        $pemesananIds = DB::table('pemesanans')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->where('status', 'Selesai')
            ->pluck('id');

        if ($pemesananIds->isEmpty()) {
            // Kalau gak ada pemesanan selesai di rentang itu, return array kosong supaya front gak error
            return response()->json([
                'revenuePerProduct' => [],
                'revenuePerPedagang' => [],
                'revenuePerPasar' => [],
                'customerSegmentation' => [],
                'onlineUsers' => [],
                'dailyRevenue' => [],
            ]);
        }

        $revenuePerProduct = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('produk', 'produk.id', '=', 'produk_pedagang.id_produk')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('produk.nama_produk', DB::raw('SUM(detail_pemesanans.harga * detail_pemesanans.jumlah) as total'))
            ->groupBy('produk.nama_produk')
            ->get();

        $revenuePerPedagang = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pedagang.nama_toko', DB::raw('SUM(detail_pemesanans.harga * detail_pemesanans.jumlah) as total'))
            ->groupBy('pedagang.nama_toko')
            ->get();

        $revenuePerPasar = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->join('pasar', 'pasar.id_pasar', '=', 'pedagang.id_pasar')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pasar.nama_pasar', DB::raw('SUM(detail_pemesanans.harga * detail_pemesanans.jumlah) as total'))
            ->groupBy('pasar.nama_pasar')
            ->get();

        $customerSegmentation = DB::table('pemesanans')
            ->join('customers', 'pemesanans.customer_id', '=', 'customers.id')
            ->whereBetween('pemesanans.created_at', [$startDateTime, $endDateTime])
            ->select('customers.kecamatan', DB::raw('count(*) as total'))
            ->groupBy('customers.kecamatan')
            ->get();

        $onlineUsers = User::where('role', 'customer')
            ->where('updated_at', '>=', Carbon::now()->subMinutes(5))
            ->select('name', 'email')
            ->get();

        $dailyRevenue = $this->getDailyRevenue($startDateTime, $endDateTime);

        $paymentMethodUsage = DB::table('pemesanans')
            ->whereIn('id', $pemesananIds)
            ->select('metode_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_pembayaran')
            ->get();
        return response()->json([
            'revenuePerProduct' => $revenuePerProduct,
            'revenuePerPedagang' => $revenuePerPedagang,
            'revenuePerPasar' => $revenuePerPasar,
            'customerSegmentation' => $customerSegmentation,
            'onlineUsers' => $onlineUsers,
            'dailyRevenue' => $dailyRevenue,
            'paymentMethodUsage' => $paymentMethodUsage,
        ]);
    }

    private function getDailyRevenue($startDateTime, $endDateTime)
    {
        $pemesananIds = DB::table('pemesanans')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->where('status', 'Selesai')
            ->pluck('id');

        if ($pemesananIds->isEmpty()) {
            return collect();
        }

        $dailyRevenue = DB::table('detail_pemesanans')
            ->join('pemesanans', 'detail_pemesanans.pemesanan_id', '=', 'pemesanans.id')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->whereBetween('pemesanans.created_at', [$startDateTime, $endDateTime])
            ->select(
                DB::raw('DATE(pemesanans.created_at) as tanggal'),
                DB::raw('SUM(detail_pemesanans.harga * detail_pemesanans.jumlah) as total')
            )
            ->groupBy(DB::raw('DATE(pemesanans.created_at)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        return $dailyRevenue;
    }

    public function exportPdf(Request $request)
    {
        $start = $request->input('start_date') ?? Carbon::now()->startOfMonth()->toDateString();
        $end = $request->input('end_date') ?? Carbon::now()->endOfMonth()->toDateString();

        $startDateTime = Carbon::parse($start)->startOfDay()->toDateTimeString();
        $endDateTime = Carbon::parse($end)->endOfDay()->toDateTimeString();

        $data = $this->getAnalyticData($startDateTime, $endDateTime);

        $pdf = Pdf::loadView('admin.analitik.exportpdf', [
            'data' => $data,
            'start' => $start,
            'end' => $end,
        ]);

        return $pdf->download('dashboard.pdf');
    }

    private function getAnalyticData($startDateTime, $endDateTime)
    {
        $pemesananIds = DB::table('pemesanans')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->where('status', 'Selesai')
            ->pluck('id');

        if ($pemesananIds->isEmpty()) {
            return [
                'revenuePerProduct' => [],
                'revenuePerPedagang' => [],
                'revenuePerPasar' => [],
                'customerSegmentation' => [],
                'onlineUsers' => [],
                'dailyRevenue' => [],
            ];
        }

        $revenuePerProduct = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('produk', 'produk.id', '=', 'produk_pedagang.id_produk')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('produk.nama_produk', DB::raw('SUM(detail_pemesanans.harga * detail_pemesanans.jumlah) as total'))
            ->groupBy('produk.nama_produk')
            ->get();

        $revenuePerPedagang = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pedagang.nama_toko', DB::raw('SUM(detail_pemesanans.harga * detail_pemesanans.jumlah) as total'))
            ->groupBy('pedagang.nama_toko')
            ->get();

        $revenuePerPasar = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->join('pasar', 'pasar.id_pasar', '=', 'pedagang.id_pasar')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pasar.nama_pasar', DB::raw('SUM(detail_pemesanans.harga * detail_pemesanans.jumlah) as total'))
            ->groupBy('pasar.nama_pasar')
            ->get();

        $customerSegmentation = DB::table('pemesanans')
            ->join('customers', 'pemesanans.customer_id', '=', 'customers.id')
            ->whereBetween('pemesanans.created_at', [$startDateTime, $endDateTime])
            ->select('customers.kecamatan', DB::raw('count(*) as total'))
            ->groupBy('customers.kecamatan')
            ->get();

        $onlineUsers = User::where('role', 'customer')
            ->where('updated_at', '>=', Carbon::now()->subMinutes(5))
            ->select('name', 'email')
            ->get();

        $dailyRevenue = $this->getDailyRevenue($startDateTime, $endDateTime);

        $paymentMethodUsage = DB::table('pemesanans')
            ->whereIn('id', $pemesananIds)
            ->select('metode_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        return [
            'revenuePerProduct' => $revenuePerProduct,
            'revenuePerPedagang' => $revenuePerPedagang,
            'revenuePerPasar' => $revenuePerPasar,
            'customerSegmentation' => $customerSegmentation,
            'onlineUsers' => $onlineUsers,
            'dailyRevenue' => $dailyRevenue,
            'paymentMethodUsage' => $paymentMethodUsage
        ];
    }
}
