<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root { --bg: #f3f4f6; --surface: #ffffff; --text: #111827; --muted: #6b7280; --border: #d1d5db; --primary: #4f46e5; --primary-hover: #4338ca; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--text); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .card { background: var(--surface); width: 100%; max-width: 450px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); padding: 32px; border: 1px solid #e5e7eb;}
        .title { font-size: 20px; font-weight: 600; margin-bottom: 24px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; color: #374151; }
        input, select { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; outline: none; transition: 0.2s; }
        input:focus, select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .btn { width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 500; font-size: 14px; cursor: pointer; transition: 0.2s; margin-top: 8px; }
        .btn:hover { background: var(--primary-hover); }
        .back { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 24px; text-decoration: none; color: var(--muted); font-size: 14px; }
        .back:hover { color: var(--text); }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="title">Tambah Transaksi Baru</h2>
        <form action="/transaksi" method="POST">
            @csrf
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" placeholder="Contoh: Gaji bulanan, Beli makan" required>
            </div>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="jumlah" placeholder="Contoh: 50000" min="0" required>
            </div>
            <div class="form-group">
                <label>Jenis Transaksi</label>
                <select name="jenis" required>
                    <option value="" disabled selected>Pilih jenis...</option>
                    <option value="masuk">Pemasukan (+)</option>
                    <option value="keluar">Pengeluaran (-)</option>
                </select>
            </div>
            <button type="submit" class="btn">Simpan Data</button>
        </form>
        <a href="/transaksi" class="back"><i data-lucide="arrow-left" style="width: 16px;"></i> Kembali ke Dashboard</a>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>