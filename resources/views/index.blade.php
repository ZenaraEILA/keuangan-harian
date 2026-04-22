<!DOCTYPE html>
<html>
<head>
    <title>Keuangan Harian</title>
<style>
    body { font-family: Arial; background: #f4f6f9; padding: 20px; }
    .card { background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
    .saldo { font-size: 20px; font-weight: bold; color: green; }
    .btn { background: blue; color: white; padding: 8px; text-decoration: none; }
    .item { padding: 10px; border-bottom: 1px solid #ddd; }
    .masuk { color: green; }
    .keluar { color: red; }
</style>
</head>
<body>

    <h1>Catatan Keuangan</h1>
        <div class="card saldo">
            Saldo: Rp {{ $saldo }}
        </div>
        <a href="/transaksi/create" class="btn">Tambah</a>
        <div class="card">
        @foreach($data as $t)
            <div class="item">
            {{ $t->tanggal }} | {{ $t->keterangan }}
                @if($t->jenis == 'masuk')
                    <span class="masuk">+ Rp{{ $t->jumlah }}</span>
                @else
                    <span class="keluar">- Rp{{ $t->jumlah }}</span>
                @endif
            </div>
        @endforeach
    </div>
</body>
</html>