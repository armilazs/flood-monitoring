<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DL-VN Flood Monitoring</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">DL&middot;VN</div>
            <p class="login-subtitle">Sistem Monitoring dan Mitigasi Banjir</p>
            
            <form action="{{ route('monitoring') }}" method="GET">
                <div class="form-group">
                    <label for="email">Email Admin</label>
                    <input type="email" id="email" class="form-control" placeholder="admin@dlvn.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
