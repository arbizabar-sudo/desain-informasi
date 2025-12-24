<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }} - Design Information</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 90%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-left h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: 800;
        }

        .login-left p {
            font-size: 1em;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .login-left .features {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
            width: 100%;
        }

        .login-left .feature {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-left .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3em;
        }

        .login-right {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-right .subtitle {
            color: #999;
            margin-bottom: 30px;
            font-size: 0.9em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.2);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.9em;
        }

        .remember-forgot label {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #555;
            cursor: pointer;
            font-weight: 500;
        }

        .remember-forgot a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .remember-forgot a:hover {
            color: #764ba2;
        }

        .login-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.95em;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #764ba2;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
            font-size: 0.85em;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            margin: 0 10px;
        }

        .social-login {
            display: flex;
            gap: 10px;
        }

        .social-btn {
            flex: 1;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            font-size: 1.2em;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .social-btn:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        /* Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-icon {
            font-size: 1.2em;
            flex-shrink: 0;
        }

        .alert-success .alert-icon::before {
            content: '✓';
        }

        .alert-danger .alert-icon::before {
            content: '✕';
        }

        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 1.2em;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .alert-close:hover {
            opacity: 1;
        }

        .form-group input.is-invalid {
            border-color: #dc3545;
            background-color: #fff5f5;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.85em;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-text::before {
            content: '⚠';
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-left {
                display: none;
            }

            .login-right {
                padding: 40px 25px;
            }

            .login-right h2 {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Section -->
        <div class="login-left">
        </div>

        <!-- Right Section -->
        <div class="login-right">
            <h2>Masuk</h2>
            <p class="subtitle">Silakan masukkan detail akun Anda</p>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <div class="alert-icon"></div>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">×</button>
                </div>
            @endif

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <div class="alert-icon"></div>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">×</button>
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="your@email.com" 
                        value="{{ old('email') }}"
                        class="@error('email') is-invalid @enderror"
                        required
                    >
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        class="@error('password') is-invalid @enderror"
                        required
                    >
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    <a href="/forgot-password">Lupa password?</a>
                </div>

                <button type="submit" class="login-btn">Masuk Sekarang</button>
            </form>

         
            <p class="signup-link">
                Belum punya akun? <a href="/register">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>
</html>