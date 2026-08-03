@extends("admin.layout")
@section("content")
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Cloud Portfolio</title>
    <link rel="stylesheet" href="/assets/css/admin.css">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>
<body style="display: flex; justify-content: center; align-items: center; background: #2c3e50;">
    <div style="background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-top: 0; color: #333;">Admin Area</h2>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">Please login to access the dashboard.</p>
        
        <?php if(isset($login_error)): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
                <?= $login_error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" class="cv-form">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required style="max-width: 100%;">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required style="max-width: 100%;">
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; font-size: 1.1em;">Login</button>
        </form>
    </div>
</body>
</html>
@endsection
