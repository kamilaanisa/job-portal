<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Jobs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .stats {
            display: flex;
            gap: 20px;
            margin: 30px 0;
        }
        .stat-box {
            flex: 1;
            background: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-box h2 {
            margin: 0;
            font-size: 36px;
        }
        .stat-box p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            color: #333;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Kelola Lowongan Pekerjaan</h1>
        <p style="color: #666;">Admin Dashboard - {{ Auth::user()->name }}</p>
        
        <!-- Statistik Lowongan -->
        <div class="stats">
            <div class="stat-box">
                <h2>{{ $totalJobs }}</h2>
                <p>Total Lowongan</p>
            </div>
            <div class="stat-box" style="background: #28a745;">
                <h2>{{ $activeJobs }}</h2>
                <p>Lowongan Aktif</p>
            </div>
            <div class="stat-box" style="background: #dc3545;">
                <h2>{{ $closedJobs }}</h2>
                <p>Lowongan Ditutup</p>
            </div>
        </div>
        
        <!-- Daftar Lowongan -->
        <h2 style="margin-top: 30px;">Daftar Lowongan</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Posisi</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $index => $job)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $job['position'] }}</td>
                    <td>{{ $job['company'] }}</td>
                    <td>
                        <span style="color: {{ $job['status'] == 'Aktif' ? '#28a745' : '#dc3545' }}; font-weight: bold;">
                            {{ $job['status'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #999;">
                        Belum ada lowongan tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Navigasi -->
        <div style="margin-top: 30px;">
            <a href="/admin" class="btn btn-secondary">Kembali ke Admin</a>
            <a href="/dashboard" class="btn btn-primary">Dashboard</a>
        </div>
    </div>
</body>
</html>