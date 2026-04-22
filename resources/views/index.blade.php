<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Keuangan Harian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg-color: #f3f4f6;
            --surface: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --success: #059669;
            --success-bg: #d1fae5;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --radius: 12px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body { background-color: var(--bg-color); color: var(--text-main); -webkit-font-smoothing: antialiased; padding-bottom: 60px; }

        .container { max-width: 1100px; margin: 0 auto; padding: 0 24px; }

        /* Navbar */
        .navbar { background-color: var(--surface); border-bottom: 1px solid var(--border); padding: 16px 0; margin-bottom: 32px; box-shadow: var(--shadow-sm); }
        .navbar-content { max-width: 1100px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; }
        .brand { font-size: 18px; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .brand-icon { color: var(--primary); }
        .nav-actions { display: flex; align-items: center; gap: 16px; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 8px 16px; font-size: 14px; font-weight: 500; border-radius: 8px; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; text-decoration: none; }
        .btn-primary { background-color: var(--primary); color: #fff; box-shadow: var(--shadow-sm); }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-outline { background-color: transparent; border-color: var(--border); color: var(--text-main); }
        .btn-outline:hover { background-color: #f9fafb; }
        .btn-danger { background-color: transparent; color: var(--danger); border-color: var(--danger-bg); }
        .btn-danger:hover { background-color: var(--danger-bg); }

        /* Dashboard Grid */
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
        @media (max-width: 768px) { .grid-3 { grid-template-columns: 1fr; } }
        
        .card { background-color: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 24px; box-shadow: var(--shadow-sm); }
        
        /* Stat Cards */
        .stat-label { font-size: 14px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .stat-value { font-size: 30px; font-weight: 700; color: var(--text-main); letter-spacing: -0.5px; }
        .stat-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .icon-blue { background-color: #e0e7ff; color: var(--primary); }
        .icon-green { background-color: var(--success-bg); color: var(--success); }
        .icon-red { background-color: var(--danger-bg); color: var(--danger); }

        /* Main Section Grid */
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
        @media (max-width: 992px) { .main-grid { grid-template-columns: 1fr; } }

        /* Table Section */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .section-title { font-size: 18px; font-weight: 600; color: var(--text-main); }
        
        .search-box { position: relative; width: 100%; max-width: 300px; }
        .search-input { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; color: var(--text-main); outline: none; transition: border-color 0.2s; }
        .search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px 16px; font-size: 12px; font-weight: 500; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border); }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        
        .tx-desc { font-weight: 500; color: var(--text-main); }
        .tx-date { font-size: 13px; color: var(--text-muted); margin-top: 4px; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; }
        .badge-masuk { background-color: var(--success-bg); color: var(--success); }
        .badge-keluar { background-color: var(--danger-bg); color: var(--danger); }

        .amount { font-weight: 600; font-size: 14px; text-align: right; }
        .amount.masuk { color: var(--success); }
        .amount.keluar { color: var(--text-main); }

        .table-actions { display: flex; justify-content: flex-end; gap: 8px; }
        .icon-btn { color: var(--text-muted); background: none; border: none; cursor: pointer; padding: 6px; border-radius: 6px; transition: all 0.2s; text-decoration: none; display: inline-flex; }
        .icon-btn:hover { background-color: #f3f4f6; color: var(--text-main); }

        /* Custom Checkbox */
        .checkbox { width: 16px; height: 16px; border: 1px solid var(--text-muted); border-radius: 4px; cursor: pointer; accent-color: var(--primary); }
        
        .bulk-bar { background-color: #f9fafb; border: 1px solid var(--border); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }

        /* Print Styles */
        @media print {
            .navbar, .bulk-bar, .table-actions, .filter-section, th:first-child, td:first-child, th:last-child, td:last-child, .chart-card { display: none !important; }
            body { background: white; padding: 0; }
            .card { box-shadow: none; border: 1px solid #ccc; margin-bottom: 20px;}
            .container { padding: 0; max-width: 100%; }
            .grid-3 { gap: 10px; }
            .main-grid { display: block; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-content">
            <a href="/transaksi" class="brand">
                <i data-lucide="pie-chart" class="brand-icon"></i> Keuangan Harian
            </a>
            <div class="nav-actions">
                <a href="/transaksi/create" class="btn btn-primary">
                    <i data-lucide="plus" style="width: 16px;"></i> Tambah Data
                </a>
            </div>
        </div>
    </div>

    <div class="container">

        <!-- Advanced Filters -->
        <div class="filter-section card" style="margin-bottom: 24px; padding: 20px;">
            <form action="/transaksi" method="GET" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
                <div class="search-box">
                    <label style="font-size: 13px; color: var(--text-muted); display: block; margin-bottom: 6px; font-weight: 500;">Pencarian Teks</label>
                    <input type="text" name="search" class="search-input" placeholder="Ketik deskripsi..." value="{{ request('search') }}">
                </div>
                <div>
                    <label style="font-size: 13px; color: var(--text-muted); display: block; margin-bottom: 6px; font-weight: 500;">Bulan Laporan</label>
                    <input type="month" name="bulan" class="search-input" style="width: 180px;" value="{{ request('bulan') }}">
                </div>
                <div>
                    <label style="font-size: 13px; color: var(--text-muted); display: block; margin-bottom: 6px; font-weight: 500;">Jenis Transaksi</label>
                    <select name="jenis" class="search-input" style="width: 160px;">
                        <option value="">Semua Data</option>
                        <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Pemasukan Saja</option>
                        <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Pengeluaran Saja</option>
                    </select>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary" style="padding: 9px 16px;"><i data-lucide="filter" style="width: 16px;"></i> Terapkan Filter</button>
                    <a href="/transaksi" class="btn btn-outline" style="padding: 9px 16px;">Reset</a>
                </div>
                <div style="margin-left: auto;">
                    <button type="button" class="btn btn-outline" onclick="window.print()" style="padding: 9px 16px; color: var(--primary); border-color: var(--primary);"><i data-lucide="printer" style="width: 16px;"></i> Cetak PDF / Laporan</button>
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div class="grid-3">
            <div class="card">
                <div class="stat-label">Total Saldo (Keseluruhan)</div>
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div class="stat-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                    <div class="stat-icon icon-blue"><i data-lucide="wallet" style="width: 20px;"></i></div>
                </div>
            </div>
            <div class="card">
                <div class="stat-label">Total Pemasukan @if(request('bulan') || request('jenis'))(Sesuai Filter)@endif</div>
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <div class="stat-value" style="color: var(--success);">Rp {{ number_format($pemasukanFilter, 0, ',', '.') }}</div>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Info: Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }} (Bulan Ini)</div>
                    </div>
                    <div class="stat-icon icon-green"><i data-lucide="trending-up" style="width: 20px;"></i></div>
                </div>
            </div>
            <div class="card">
                <div class="stat-label">Total Pengeluaran @if(request('bulan') || request('jenis'))(Sesuai Filter)@endif</div>
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <div class="stat-value">Rp {{ number_format($pengeluaranFilter, 0, ',', '.') }}</div>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Info: Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }} (Bulan Ini)</div>
                    </div>
                    <div class="stat-icon icon-red"><i data-lucide="trending-down" style="width: 20px;"></i></div>
                </div>
            </div>
        </div>

        <div class="main-grid">
            <!-- Table -->
            <div class="card">
                <div class="section-header">
                    <div class="section-title">Riwayat Transaksi Lengkap</div>
                    <span style="font-size: 13px; color: var(--text-muted);">Menampilkan {{ count($data) }} data</span>
                </div>

                <form action="/transaksi/bulk-delete" method="POST" id="bulk-form">
                    @csrf
                    <div class="bulk-bar" id="bulk-bar" style="display: none;">
                        <span style="font-size: 14px; font-weight: 500; color: var(--text-muted);"><span id="selected-count">0</span> data dipilih untuk dihapus massal</span>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus transaksi yang dipilih secara permanen?')">
                            <i data-lucide="trash" style="width: 16px;"></i> Hapus Terpilih
                        </button>
                    </div>

                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" id="checkAll" class="checkbox"></th>
                                    <th>Keterangan & Tanggal</th>
                                    <th>Kategori</th>
                                    <th style="text-align: right;">Nominal</th>
                                    <th width="80" style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $t)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{ $t->id }}" class="checkbox check-item"></td>
                                        <td>
                                            <div class="tx-desc">{{ $t->keterangan }}</div>
                                            <div class="tx-date">{{ date('d M Y', strtotime($t->tanggal)) }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $t->jenis == 'masuk' ? 'badge-masuk' : 'badge-keluar' }}">
                                                {{ $t->jenis == 'masuk' ? 'Pemasukan' : 'Pengeluaran' }}
                                            </span>
                                        </td>
                                        <td class="amount {{ $t->jenis }}">
                                            {{ $t->jenis == 'masuk' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="/transaksi/edit/{{ $t->id }}" class="icon-btn" title="Edit Data"><i data-lucide="edit-2" style="width: 16px;"></i></a>
                                                <a href="/transaksi/delete/{{ $t->id }}" onclick="return confirm('Yakin ingin menghapus data ini?')" class="icon-btn" style="color: var(--danger);" title="Hapus"><i data-lucide="trash-2" style="width: 16px;"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if(count($data) == 0)
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                            <i data-lucide="inbox" style="width: 40px; height: 40px; margin-bottom: 12px; opacity: 0.5;"></i>
                                            <p>Data transaksi tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <!-- Chart -->
            <div class="card chart-card" style="align-self: start;">
                <div class="section-title" style="margin-bottom: 24px;">Ringkasan Visual</div>
                <div style="height: 250px; position: relative;">
                    <canvas id="chartPie"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Checkbox logic
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.check-item');
        const bulkBar = document.getElementById('bulk-bar');
        const countSpan = document.getElementById('selected-count');

        function updateBulk() {
            const count = document.querySelectorAll('.check-item:checked').length;
            countSpan.textContent = count;
            bulkBar.style.display = count > 0 ? 'flex' : 'none';
        }

        checkAll.addEventListener('change', e => {
            checkboxes.forEach(cb => cb.checked = e.target.checked);
            updateBulk();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', () => {
            checkAll.checked = document.querySelectorAll('.check-item:checked').length === checkboxes.length;
            updateBulk();
        }));

        // Chart
        const ctx = document.getElementById('chartPie').getContext('2d');
        const p = {{ $pemasukanFilter }};
        const k = {{ $pengeluaranFilter }};

        if(p === 0 && k === 0) {
            new Chart(ctx, {
                type: 'doughnut',
                data: { labels: ['Kosong'], datasets: [{ data: [1], backgroundColor: ['#e5e7eb'], borderWidth: 0 }] },
                options: { cutout: '75%', plugins: { legend: { display: false }, tooltip: { enabled: false } } }
            });
        } else {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{ data: [p, k], backgroundColor: ['#059669', '#f43f5e'], borderWidth: 0, hoverOffset: 4 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '75%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { family: 'Inter', size: 12 } } }
                    }
                }
            });
        }
    </script>
</body>
</html>