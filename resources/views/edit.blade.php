<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 5px; max-width: 400px; margin: auto; border: 1px solid #ccc; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #ffc107; color: black; border: none; cursor: pointer; font-weight: bold;}
        button:hover { background: #e0a800; }
        .back-link { display: block; margin-top: 15px; text-align: center; color: blue; text-decoration: none; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Edit Transaksi</h2>
        <form action="/transaksi/update/{{ $transaksi->id }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $transaksi->tanggal }}" required>
            </div>
            <div class="form-group">
                <label>Keterangan:</label>
                <input type="text" name="keterangan" value="{{ $transaksi->keterangan }}" required>
            </div>
            <div class="form-group">
                <label>Jumlah (Rp):</label>
                <input type="number" name="jumlah" value="{{ $transaksi->jumlah }}" required>
            </div>
            <div class="form-group">
                <label>Jenis:</label>
                <select name="jenis" required>
                    <option value="masuk" {{ $transaksi->jenis == 'masuk' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="keluar" {{ $transaksi->jenis == 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <button type="submit">Update</button>
        </form>
        <a href="/transaksi" class="back-link">Batal</a>
    </div>

</body>
</html>
