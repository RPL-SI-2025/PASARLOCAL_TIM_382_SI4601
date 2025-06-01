<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Customer;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
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

        // Filter pemesanans
        $pemesananIds = DB::table('pemesanans')
            ->whereBetween('created_at', [$start, $end])
            ->pluck('id');

        // Pendapatan per produk
        $revenuePerProduct = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('produk', 'produk.id', '=', 'produk_pedagang.id_produk')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('produk.nama_produk', DB::raw('SUM(detail_pemesanans.price * detail_pemesanans.quantity) as total'))
            ->groupBy('produk.nama_produk')
            ->get();

        // Pendapatan per pedagang
        $revenuePerPedagang = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pedagang.nama_toko', DB::raw('SUM(detail_pemesanans.price * detail_pemesanans.quantity) as total'))
            ->groupBy('pedagang.nama_toko')
            ->get();

        // Pendapatan per pasar
        $revenuePerPasar = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->join('pasar', 'pasar.id_pasar', '=', 'pedagang.id_pasar')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pasar.nama_pasar', DB::raw('SUM(detail_pemesanans.price * detail_pemesanans.quantity) as total'))
            ->groupBy('pasar.nama_pasar')
            ->get();

        // Segmentasi customer
        $customerSegmentation = DB::table('pemesanans')
            ->join('customers', 'pemesanans.customer_id', '=', 'customers.id')
            ->whereBetween('pemesanans.created_at', [$start, $end])
            ->select('customers.kecamatan', DB::raw('count(*) as total'))
            ->groupBy('customers.kecamatan')
            ->get();

        // Customer online
        $onlineUsers = User::where('role', 'customer')
                        ->where('last_seen_at', '>=', Carbon::now()->subMinutes(5))
                        ->select('name', 'email')
                        ->get();

        return response()->json([
            'revenuePerProduct' => $revenuePerProduct,
            'revenuePerPedagang' => $revenuePerPedagang,
            'revenuePerPasar' => $revenuePerPasar,
            'customerSegmentation' => $customerSegmentation,
            'onlineUsers' => $onlineUsers
        ]);
    }

    public function exportPdf(Request $request)
    {
        $start = $request->input('start_date') ?? Carbon::now()->startOfMonth()->toDateString();
        $end = $request->input('end_date') ?? Carbon::now()->endOfMonth()->toDateString();

        $data = $this->getAnalyticData($start, $end);

        $pdf = Pdf::loadView('admin.analitik.exportpdf', [
            'data' => $data,
            'start' => $start,
            'end' => $end,
        ]);

        return $pdf->download('dashboard.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->data($request)->getData(true);

        return Excel::download(new ExportExcel($data), 'Analitik.xlsx');
    }

    private function getAnalyticData($start, $end)
    {
        $pemesananIds = DB::table('pemesanans')
            ->whereBetween('created_at', [$start, $end])
            ->pluck('id');

        $revenuePerProduct = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('produk', 'produk.id', '=', 'produk_pedagang.id_produk')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('produk.nama_produk', DB::raw('SUM(detail_pemesanans.price * detail_pemesanans.quantity) as total'))
            ->groupBy('produk.nama_produk')
            ->get();

        $revenuePerPedagang = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pedagang.nama_toko', DB::raw('SUM(detail_pemesanans.price * detail_pemesanans.quantity) as total'))
            ->groupBy('pedagang.nama_toko')
            ->get();

        $revenuePerPasar = DB::table('detail_pemesanans')
            ->join('produk_pedagang', 'detail_pemesanans.produk_pedagang_id', '=', 'produk_pedagang.id_produk_pedagang')
            ->join('pedagang', 'pedagang.id_pedagang', '=', 'produk_pedagang.id_pedagang')
            ->join('pasar', 'pasar.id_pasar', '=', 'pedagang.id_pasar')
            ->whereIn('detail_pemesanans.pemesanan_id', $pemesananIds)
            ->select('pasar.nama_pasar', DB::raw('SUM(detail_pemesanans.price * detail_pemesanans.quantity) as total'))
            ->groupBy('pasar.nama_pasar')
            ->get();

        $customerSegmentation = DB::table('pemesanans')
            ->join('customers', 'pemesanans.customer_id', '=', 'customers.id')
            ->whereBetween('pemesanans.created_at', [$start, $end])
            ->select('customers.kecamatan', DB::raw('count(*) as total'))
            ->groupBy('customers.kecamatan')
            ->get();

        $onlineUsers = User::where('role', 'customer')
            ->where('updated_at', '>=', Carbon::now()->subMinutes(5))
            ->select('name', 'email')
            ->get();

        return [
            'revenuePerProduct' => $revenuePerProduct,
            'revenuePerPedagang' => $revenuePerPedagang,
            'revenuePerPasar' => $revenuePerPasar,
            'customerSegmentation' => $customerSegmentation,
            'onlineUsers' => $onlineUsers
        ];
    }
}
