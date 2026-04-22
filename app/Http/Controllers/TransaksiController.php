<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::orderBy('tanggal', 'desc')->get();
        
        $pemasukan = Transaksi::where('jenis', 'masuk')->sum('jumlah');
        $pengeluaran = Transaksi::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        return view('index', compact('data', 'saldo'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        Transaksi::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
        ]);

        return redirect('/transaksi');
    }
}
