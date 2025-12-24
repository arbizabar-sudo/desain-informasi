    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 10px 40px;
            border-bottom: 2px solid #f0f0f0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99;
            background: white;
            transition: transform 0.3s ease;
        }

        header.hidden {
            transform: translateY(-100%);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: 30px;
            margin-top: -10px;
        }

        .logo-icon {

        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #bfff8647;
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
            margin-left: auto;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .user-menu .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
        }

        .user-menu .username {
            font-weight: 600;
            color: #333;
            margin-right: 8px;
        }

        .role-badge {
            font-size: 0.75em;
            border-radius: 999px;
            padding: 4px 8px;
            color: white;
            font-weight: 700;
        }
        .role-mahasiswa { background: #28a745; } /* green */
        .role-dosen { background: #007bff; } /* blue */
        .role-client { background: #6c757d; } /* gray */

        .btn-logout {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #e74c3c;
            background: #fff;
            color: #e74c3c;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-logout:hover {
            background: #e74c3c;
            color: white;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-register {
            background: #ffffffff;
            color: black;
        }

        .btn-register:hover {
            background: #c82333;
        }

        .btn-login {
            background: transparent;
            color: #333;
            border: 2px solid #333;
        }

        .btn-login:hover {
            background: #333;
            color: white;
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: #333;
            border-radius: 3px;
        }

        /* Floating Search Button */
        .floating-search {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 98;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.8);
            transition: all 0.3s ease;
        }

        .floating-search.show {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        .floating-search-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            background: #7BB63E;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .floating-search-btn:hover {
            background: #c82333;
            box-shadow: 0 6px 16px rgba(200, 35, 51, 0.25);
            transform: translateY(-2px);
        }

        /* Adjust body padding for fixed header */
        body.navbar-fixed {
            padding-top: 45px;
        }
    </style>

    <header>
        <div class="logo">
            <div class="logo-icon"><a href="/"> <img src="/images/image-3-148.png" height="60" width="40" alt=""> </a> </div>
        </div>
        <nav>
            <a href="/">Explore</a>
            <a href="/community">Community</a>
            <a href="/about">About</a>
        </nav>
        <div class="auth-buttons">
            @guest
                <a href="/register" class="btn btn-register">Register</a>
                <a href="/login" class="btn btn-login">Login</a>
            @endguest
            @auth
                @php
                    $user = Auth::user();
                    $avatar = $user->avatar_url;
                    $displayName = $user->username ?? $user->name;
                @endphp
                <div class="user-menu">
                    <button id="userToggleBtn" class="btn" aria-haspopup="true" aria-expanded="false" style="display:flex;align-items:center;gap:8px;background:transparent;border:0;padding:0;">
                        <img src="{{ $avatar }}" alt="avatar" class="avatar">
                        <div class="username">{{ $displayName }}</div>
                        @if (!empty($user->role))
                            <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        @endif
                    </button>

                    <div id="userDropdown" style="display:none; position:absolute; right:16px; top:60px; background:white; border:1px solid #eee; box-shadow:0 6px 18px rgba(0,0,0,0.08); border-radius:8px; overflow:hidden; min-width:160px; z-index:200;">
                        <a href="{{ route('profile.show', $user->username ?: $user->id) }}" style="display:block;padding:10px 14px;color:#333;text-decoration:none;border-bottom:1px solid #f5f5f5;">Profile</a>
                        <a href="/settings" style="display:block;padding:10px 14px;color:#333;text-decoration:none;border-bottom:1px solid #f5f5f5;">Settings</a>
                        <form id="logoutFormNav" method="POST" action="/logout" style="margin:0;">
                            @csrf
                        </form>
                        <button type="button" onclick="showLogoutModal('logoutFormNav')" style="width:100%;text-align:left;padding:10px 14px;border:0;background:none;color:#e74c3c;cursor:pointer;">Logout</button>
                    </div>
                </div>
                <script>
                    (function(){
                        const btn = document.getElementById('userToggleBtn');
                        const dd = document.getElementById('userDropdown');
                        if (!btn) return;
                        btn.addEventListener('click', function(e){
                            e.stopPropagation();
                            const shown = dd.style.display === 'block';
                            dd.style.display = shown ? 'none' : 'block';
                        });
                        document.addEventListener('click', function(){
                            if (dd) dd.style.display = 'none';
                        });
                    })();
                </script>
            @endauth
        </div>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <!-- Floating Search Button -->
    <div class="floating-search">
        <button class="floating-search-btn" onclick="document.querySelector('.search-bar input').focus(); document.querySelector('.search-bar input').scrollIntoView({ behavior: 'smooth', block: 'center' });">
            🔍 Search
        </button>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" style="display:none;position:fixed;inset:0;align-items:center;justify-content:center;background:rgba(0,0,0,0.35);z-index:999;">
        <div style="background:white;padding:20px;border-radius:10px;max-width:420px;width:90%;box-shadow:0 10px 30px rgba(0,0,0,0.12);">
            <h3 style="margin:0 0 8px 0;font-size:18px;color:#333">Konfirmasi Logout</h3>
            <p style="margin:0 0 16px 0;color:#555">Apakah Anda yakin ingin logout sekarang? Anda harus login kembali untuk mengakses fitur akun.</p>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button id="cancelLogoutBtn" style="padding:8px 14px;border-radius:6px;border:1px solid #ddd;background:#fff;cursor:pointer;">Batal</button>
                <button id="confirmLogoutBtn" style="padding:8px 14px;border-radius:6px;border:none;background:#e74c3c;color:#fff;cursor:pointer;">Logout</button>
            </div>
        </div>
    </div>

    <script>
        let lastScrollTop = 0;
        let headerTimeout;

        window.addEventListener('scroll', function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            const header = document.querySelector('header');
            const floatingSearch = document.querySelector('.floating-search');

            // Hide header when scrolling down
            if (currentScroll > lastScrollTop && currentScroll > 100) {
                header.classList.add('hidden');
                floatingSearch.classList.add('show');
            } 
            // Show header when scrolling up
            else if (currentScroll < lastScrollTop) {
                header.classList.remove('hidden');
                floatingSearch.classList.remove('show');
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });

        // Ensure body has proper padding
        document.body.classList.add('navbar-fixed');
        // Logout modal logic
        function showLogoutModal(formId) {
            window._logoutFormId = formId;
            const m = document.getElementById('logoutModal');
            if (m) m.style.display = 'flex';
        }
        document.addEventListener('DOMContentLoaded', function(){
            const cancel = document.getElementById('cancelLogoutBtn');
            const confirm = document.getElementById('confirmLogoutBtn');
            if (cancel) cancel.addEventListener('click', function(){
                const m = document.getElementById('logoutModal'); if (m) m.style.display = 'none';
            });
            if (confirm) confirm.addEventListener('click', function(){
                const formId = window._logoutFormId;
                if (formId) {
                    const f = document.getElementById(formId);
                    if (f) f.submit();
                }
            });
            // close modal on outside click
            const m = document.getElementById('logoutModal');
            if (m) m.addEventListener('click', function(e){ if (e.target === m) m.style.display = 'none'; });
        });
    </script>
  

