<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 5px; max-width: 400px; margin: auto; border: 1px solid #ccc; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .back-link { display: block; margin-top: 15px; text-align: center; color: blue; text-decoration: none; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Tambah Transaksi</h2>
        <form action="/transaksi" method="POST">
            @csrf
            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" required>
            </div>
            <div class="form-group">
                <label>Keterangan:</label>
                <input type="text" name="keterangan" required>
            </div>
            <div class="form-group">
                <label>Jumlah (Rp):</label>
                <input type="number" name="jumlah" required>
            </div>
            <div class="form-group">
                <label>Jenis:</label>
                <select name="jenis" required>
                    <option value="masuk">Pemasukan</option>
                    <option value="keluar">Pengeluaran</option>
                </select>
            </div>
            <button type="submit">Simpan</button>
        </form>
        <a href="/transaksi" class="back-link">Kembali</a>
    </div>

</body>
</html>