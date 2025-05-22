namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['pembayaran', 'customer'])->latest()->get();
        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function accPembayaran($id)
    {
        $pembayaran = Pembayaran::where('id_pesanan', $id)->first();
        if ($pembayaran) {
            $pembayaran->status_pembayaran = 'Lunas';
            $pembayaran->save();
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil di-ACC.');
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status_pesanan = $request->status_pesanan;
        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
