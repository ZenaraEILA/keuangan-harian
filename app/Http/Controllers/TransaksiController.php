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

        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        if ($request->has('bulan') && $request->bulan != '') {
            $parts = explode('-', $request->bulan);
            if(count($parts) == 2) {
                $query->whereYear('tanggal', $parts[0])->whereMonth('tanggal', $parts[1]);
            }
        }

        $data = $query->orderBy('tanggal', 'desc')->get();
        
        $pemasukanTotal = Transaksi::where('jenis', 'masuk')->sum('jumlah');
        $pengeluaranTotal = Transaksi::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $pemasukanTotal - $pengeluaranTotal;

        $pemasukanFilter = $data->where('jenis', 'masuk')->sum('jumlah');
        $pengeluaranFilter = $data->where('jenis', 'keluar')->sum('jumlah');

        $pemasukanBulanIni = Transaksi::where('jenis', 'masuk')->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->sum('jumlah');
        $pengeluaranBulanIni = Transaksi::where('jenis', 'keluar')->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->sum('jumlah');

        return view('index', compact('data', 'saldo', 'pemasukanFilter', 'pengeluaranFilter', 'pemasukanBulanIni', 'pengeluaranBulanIni'));
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
