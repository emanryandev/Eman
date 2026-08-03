<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - System Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --accent-color: #10b981;
        }
        body {
            background: #0f172a;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }
        #particles-js {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .login-container {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            z-index: 2;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.1);
            animation: formReveal 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes formReveal {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header i {
            font-size: 3em;
            color: var(--accent-color);
            margin-bottom: 10px;
            filter: drop-shadow(0 0 10px rgba(16,185,129,0.5));
        }
        .login-header h2 {
            margin: 0;
            color: #fff;
            font-size: 1.5em;
            letter-spacing: 1px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #94a3b8;
            font-size: 0.9em;
        }
        .input-group input[type="email"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: #fff;
            outline: none;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        .input-group input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
            background: rgba(255,255,255,0.08);
        }
        .error-message {
            color: #ef4444;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .checkbox-group input[type="checkbox"] {
            accent-color: var(--accent-color);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--accent-color);
            color: #000;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-login:hover {
            background: #0ea5e9;
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.4);
            transform: translateY(-2px);
        }
    </style>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>
<body>
    <div id="particles-js"></div>
    <div class="login-container">
        <div class="login-header">
            <i class="fa-solid fa-user-shield"></i>
            <h2>System Auth</h2>
            <p style="color: #64748b; font-size: 0.9em; margin-top: 5px;">Secure Admin Access</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 10px; border-radius: 6px; margin-bottom: 20px; text-align: center; font-size: 0.9em; border: 1px solid rgba(16, 185, 129, 0.3);">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label for="email"><i class="fa-solid fa-envelope"></i> Access ID (Email)</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="password"><i class="fa-solid fa-lock"></i> Passcode</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="checkbox-group">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me" style="margin: 0; color: #94a3b8; font-size: 0.9em; cursor: pointer;">Keep me logged in</label>
            </div>

            <button type="submit" class="btn-login"><i class="fa-solid fa-right-to-bracket"></i> Initialize Session</button>
        </form>
    </div>

    <!-- Scripts for background effect -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof particlesJS !== 'undefined') {
                particlesJS("particles-js", {
                    "particles": {
                        "number": { "value": 50, "density": { "enable": true, "value_area": 800 } },
                        "color": { "value": "#10b981" },
                        "shape": { "type": "circle" },
                        "opacity": { "value": 0.4, "random": false },
                        "size": { "value": 3, "random": true },
                        "line_linked": { "enable": true, "distance": 150, "color": "#10b981", "opacity": 0.3, "width": 1 },
                        "move": { "enable": true, "speed": 1.5, "direction": "none", "random": false, "straight": false, "out_mode": "out", "bounce": false }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": { "onhover": { "enable": true, "mode": "grab" }, "onclick": { "enable": true, "mode": "push" }, "resize": true },
                        "modes": { "grab": { "distance": 140, "line_linked": { "opacity": 1 } }, "push": { "particles_nb": 4 } }
                    },
                    "retina_detect": true
                });
            }
        });
    </script>
</body>
</html>
