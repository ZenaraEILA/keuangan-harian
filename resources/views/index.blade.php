<!DOCTYPE html>
<html>
<head>
    <title>Keuangan Harian</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 600px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #ccc; }
        .saldo-box { text-align: center; }
        .saldo-text { font-size: 24px; font-weight: bold; color: #28a745; margin: 10px 0; }
        .btn { background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; display: inline-block; font-size: 14px; border: none; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; padding: 8px 12px;}
        .btn-danger:hover { background: #c82333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .masuk { color: green; font-weight: bold; }
        .keluar { color: red; font-weight: bold; }
        .btn-delete { background: red; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; font-size: 12px; text-decoration: none; display: inline-block; }
        .btn-delete:hover { background: darkred; }
        .btn-edit { background: #ffc107; color: black; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; font-size: 12px; text-decoration: none; display: inline-block; margin-right: 5px; }
        .btn-edit:hover { background: #e0a800; }
        .text-center { text-align: center; }
        .top-actions { display: flex; justify-content: space-between; margin-bottom: 15px; align-items: center;}
        .search-form { display: flex; gap: 5px; }
        .search-input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center">Catatan Keuangan Harian</h2>

        <div class="card saldo-box">
            <div>Total Saldo Saat Ini:</div>
            <div class="saldo-text">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
        </div>

        <div class="top-actions">
            <a href="/transaksi/create" class="btn">+ Tambah</a>
            <form action="/transaksi" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Cari keterangan..." value="{{ request('search') }}">
                <button type="submit" class="btn" style="margin-bottom: 0;">Cari</button>
            </form>
        </div>

        <div class="card">
            <form action="/transaksi/bulk-delete" method="POST" id="bulk-form">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data yang dipilih?')">Hapus Terpilih</button>
                
                <table>
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" id="checkAll"></th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th width="110">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $t)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $t->id }}" class="check-item"></td>
                                <td>{{ date('d/m/Y', strtotime($t->tanggal)) }}</td>
                                <td>{{ $t->keterangan }}</td>
                                <td>
                                    @if($t->jenis == 'masuk')
                                        <span class="masuk">+ Rp {{ number_format($t->jumlah, 0, ',', '.') }}</span>
                                    @else
                                        <span class="keluar">- Rp {{ number_format($t->jumlah, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/transaksi/edit/{{ $t->id }}" class="btn-edit">Edit</a>
                                    <a href="/transaksi/delete/{{ $t->id }}" onclick="return confirm('Yakin ingin menghapus transaksi ini?')" class="btn-delete">Hapus</a>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($data) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data transaksi.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('checkAll').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.check-item');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>
</body>
</html>