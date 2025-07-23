<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // ← yang benar, gunakan 'Pdf' dengan huruf besar P kecil di depan

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();

        $pemasukan = $transaksis->where('jenis', 'pemasukan')->sum('jumlah');
        $pengeluaran = $transaksis->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        return view('dashboard', compact('transaksis', 'saldo', 'pemasukan', 'pengeluaran'));
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        Transaksi::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function laporan()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();
        return view('laporan.index', compact('transaksis'));
    }

    public function cetak()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();
        $pdf = Pdf::loadView('laporan.cetak', compact('transaksis')); // ← Ganti PDF:: jadi Pdf::
        return $pdf->download('laporan-keuangan.pdf');
    }
}
