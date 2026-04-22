<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }
        $data = $query->orderBy('tanggal', 'desc')->get();
        
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

    public function edit($id)
    {
        $transaksi = Transaksi::find($id);
        return view('edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        if($transaksi){
            $transaksi->update([
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
            ]);
        }
        return redirect('/transaksi');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        if($transaksi){
            $transaksi->delete();
        }
        return redirect('/transaksi');
    }

    public function bulkDelete(Request $request)
    {
        if($request->has('ids')) {
            Transaksi::whereIn('id', $request->ids)->delete();
        }
        return redirect('/transaksi');
    }
}
