<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Design Information</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #000000ff 0%, #000000ff 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .register-left {
            background: linear-gradient(135deg, #000000ff 0%, #222222ff 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .register-left h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: 800;
        }

        .register-left p {
            font-size: 1em;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .register-left .benefits {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
            width: 100%;
        }

        .register-left .benefit {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .register-left .benefit-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3em;
        }

        .register-right {
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
            max-height: 100vh;
        }

        .register-right h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .register-right .subtitle {
            color: #999;
            margin-bottom: 25px;
            font-size: 0.9em;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.2);
        }

        .form-group select {
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            color: #666;
            font-size: 0.9em;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .register-btn {
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
            margin-top: 15px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            color: #666;
            font-size: 0.95em;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
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

        .social-register {
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

        .form-group input.is-invalid,
        .form-group select.is-invalid {
            border-color: #dc3545 !important;
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
            .register-container {
                grid-template-columns: 1fr;
            }

            .register-left {
                display: none;
            }

            .register-right {
                padding: 40px 25px;
                max-height: none;
            }

            .register-right h2 {
                font-size: 1.8em;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Section -->
        <div class="register-left">
        </div>

        <!-- Right Section -->
        <div class="register-right">
            <h2>Daftar Akun</h2>
         <div class="divider">
                <span>Daftar Akun</span>
            </div>

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

            <form method="POST" action="/register" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="first-name">Nama Depan</label>
                        <input 
                            type="text" 
                            id="first-name" 
                            name="first_name" 
                            placeholder="Nama Depan"
                            value="{{ old('first_name') }}"
                            class="@error('first_name') is-invalid @enderror"
                            required
                        >
                        @error('first_name')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last-name">Nama Belakang</label>
                        <input 
                            type="text" 
                            id="last-name" 
                            name="last_name" 
                            placeholder="Nama Belakang"
                            value="{{ old('last_name') }}"
                            class="@error('last_name') is-invalid @enderror"
                            required
                        >
                        @error('last_name')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

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
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        placeholder="Pilih username unik"
                        value="{{ old('username') }}"
                        class="@error('username') is-invalid @enderror"
                        required
                    >
                    @error('username')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bio">Bio Singkat</label>
                    <input 
                        type="text" 
                        id="bio" 
                        name="bio" 
                        placeholder="Ceritakan tentang Anda" 
                        maxlength="100"
                        value="{{ old('bio') }}"
                        class="@error('bio') is-invalid @enderror"
                    >
                    @error('bio')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="@error('role') is-invalid @enderror" required>
                        <option value="">Pilih Role</option>
                        <option value="mahasiswa" @if(old('role')=='mahasiswa') selected @endif>Mahasiswa</option>
                        <option value="dosen" @if(old('role')=='dosen') selected @endif>Dosen</option>
                        <option value="client" @if(old('role')=='client') selected @endif>Client</option>
                    </select>
                    @error('role')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" id="proofUpload" style="display:none;">
                    <label for="proof_image">Upload Bukti (Gambar)</label>
                    <input type="file" id="proof_image" name="proof_image" accept="image/*" class="@error('proof_image') is-invalid @enderror" />
                    @error('proof_image')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                    <img id="proofPreview" src="" alt="Preview Gambar Bukti" style="display:none; max-width: 200px; margin-top: 8px; border-radius: 6px;" />
                </div>

                <div class="form-row">
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
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password</label>
                        <input 
                            type="password" 
                            id="confirm-password" 
                            name="password_confirmation" 
                            placeholder="••••••••"
                            class="@error('password_confirmation') is-invalid @enderror"
                            required
                        >
                        @error('password_confirmation')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" @if(old('terms')) checked @endif required>
                    <label for="terms" style="margin: 0; font-weight: normal;">
                        Saya setuju dengan <a href="#" style="color: #667eea; text-decoration: none;">Syarat dan Ketentuan</a>
                    </label>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="newsletter" name="newsletter">
                    <label for="newsletter" style="margin: 0; font-weight: normal;">
                        Saya ingin menerima tips dan update terbaru
                    </label>
                </div>

                <button type="submit" class="register-btn">Daftar Sekarang</button>
            </form>

            <div class="divider">
                <span></span>
            </div>


            <p class="login-link">
                Sudah punya akun? <a href="/login">Masuk di sini</a>
            </p>
        </div>
    </div>
<script>
    (function(){
        const roleEl = document.getElementById('role');
        const proofEl = document.getElementById('proofUpload');
        const proofInput = document.getElementById('proof_image');
        const previewImg = document.getElementById('proofPreview');
        function toggleProof(){
            if (!roleEl || !proofEl) return;
            const val = roleEl.value;
            if (val === 'mahasiswa' || val === 'dosen'){
                proofEl.style.display = 'block';
                proofInput.setAttribute('required', 'required');
            } else {
                proofEl.style.display = 'none';
                proofInput.removeAttribute('required');
                if (previewImg){
                    previewImg.style.display = 'none';
                    previewImg.src = '';
                }
            }
        }
        if (roleEl) {
            roleEl.addEventListener('change', toggleProof);
            document.addEventListener('DOMContentLoaded', toggleProof);
            // call once for initial page load
            toggleProof();
        }

        if (proofInput && previewImg){
            proofInput.addEventListener('change', function(){
                const file = proofInput.files && proofInput.files[0];
                if (!file) { previewImg.style.display = 'none'; previewImg.src = ''; return; }
                const reader = new FileReader();
                reader.onload = function(e){
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });
        }
    })();
</script>
</body>
</html>