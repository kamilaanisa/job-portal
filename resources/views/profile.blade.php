<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
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
            margin-bottom: 20px;
        }
        .info {
            margin: 15px 0;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px 0 0;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Halaman Profile</h1>
        
        <div class="info">
            <strong>Nama:</strong> {{ Auth::user()->name }}
        </div>
        
        <div class="info">
            <strong>Email:</strong> {{ Auth::user()->email }}
        </div>
        
        <div class="info">
            <strong>Role:</strong> {{ Auth::user()->role ?? 'User' }}
        </div>
        
        <div style="margin-top: 20px;">
            <a href="/dashboard" class="btn btn-primary">Dashboard</a>
            
            <form method="POST" action="/logout" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>