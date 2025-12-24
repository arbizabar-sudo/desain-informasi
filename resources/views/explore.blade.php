<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
      /* icon button style for explore modal (compact) */
      .icon-btn { background:#f7f7f7; border:none; padding:4px; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:50%; }
      .icon-btn img { width:14px; height:14px; transition: transform 160ms ease, opacity 160ms ease; display:block; }
      .icon-btn:hover { background:#efefef; }
      .icon-animate { transform: scale(1.12); }
    </style>
    <title>DCH - When Creative Meet It's Place</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>

     body {
         font-family: 'Manrope', sans-serif;
     }

         .container {
           margin: 0;
           padding: 0 20px 0 96px; /* leave room for collapsed sidebar (increased) */
           transition: padding-left 0.28s ease;
           background: none; /* atau transparent */
           border-radius: 0;
           box-shadow: none;
           max-width: 100%;
       }



        /* Hero Section */
        .hero {
            padding: 20px 50px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 36px;
            color: #333;
            margin: 0;
            line-height: 1.2;
        }

        .hero-image {
            background: #e0e0e0;
            padding: 0px 0px;
            height: 400px;
            border-top-left-radius: 100px;
            border-bottom-right-radius: 100px;
            overflow: hidden;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            padding: 0px;
            object-fit: cover;
        }

        /* Search Bar */
        .search-section {
            display: flex;
            align-items: left;
        }

        .search-bar {
            display: flex;
            align-items: left;
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            padding: 10px 180px;
            border-top-left-radius: 999px;
            border- /* pill */
            gap: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
            transition: box-shadow 0.3s;
        }

        .search-bar:hover {
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        .search-bar form { flex: 1; display:flex; align-items:center; gap:10px; margin: 0; }
        .search-bar input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 16px;
            color: #333;
        }

        .search-bar input::placeholder {
            color: #999;
        }

        .search-icon {
            width: 44px;
            height: 44px;
            min-width: 44px;
            border-radius: 50%;
            background: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            cursor: pointer;
        }
        .search-icon img { width: 18px; height: 18px; display: block; }

        /* Categories */
     .categories {
  padding: 20px 40px;
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}

.category-btn {
  padding: 10px 20px;
  background: #ffffffff;
  border: 0px solid #ccc; /* stroke */
  border-radius: 50px;     /* bentuk bulat seperti di gambar */
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s ease;
  font-size: 14px;
}

.category-btn:hover {
  background: #eaa666;
  color: white;
  border-color: #eaa666;
}

/* Tombol Filter dengan bentuk unik */
.category-btn.filter {
  border-top-left-radius: 900px;
  border-bottom-right-radius: 500px;
  border: 3px solid #b33636ff
Group 20
  color: white;
  font-weight: 600;
}



        /* Portfolio Grid */
        .portfolio-grid {
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            grid-auto-rows: 200px;
        }

        .portfolio-item {
            background : #d0d0d0;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .portfolio-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .portfolio-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .portfolio-item.tall {
            grid-row: span 2;
        }

        .portfolio-item.wide {
            grid-column: span 2;
        }

        .portfolio-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
        }

        .portfolio-info h3 {
            color: white;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .portfolio-info p {
            color: #ddd;
            font-size: 12px;
        }

        /* Footer */
        footer {
            background: #f8f9fa;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 30px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .footer-brand h3 {
            color: #333;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            color: #666;
            text-decoration: none;
            font-size: 20px;
        }

        .footer-section h4 {
            color: #333;
            margin-bottom: 15px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #ea9066ff;
        }


        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            display: flex;
            gap: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .modal-left {
            flex: 1;
        }

        .modal-left img {
            width: 100%;
            border-radius: 10px;
            max-height: 400px;
            object-fit: cover;
        }

        .modal-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
        }

        .modal-creator {
            text-align: center;
        }

        .modal-description {
            text-align: left;
            margin-top: 20px;
        }

        /* Modal typography and wrapping improvements (prevent overlap) */
        .modal-creator > div {
          display: flex;
          align-items: center;
          gap: 10px;
          flex-wrap: wrap; /* allow title and avatar to wrap instead of overlap */
        }

        #modalTitle, .modal-title {
            font-size: 1.1rem;
            line-height: 1.15;
            margin: 6px 0 0 0;
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: break-word;
            font-weight: 700;
        }

        #modalDesc, .modal-desc {
            color: #666;
            font-size: 0.9rem;
            white-space: normal;
            max-width: 100%;
            display: block;
            margin: 0;
            font-weight: 500;
        }

        #modalArtworkDesc, .modal-artwork-desc {
            font-size: 0.9rem;
            color: #555;
            margin: 8px 0 0 0;
            line-height: 1.4;
            white-space: normal;
            overflow-wrap: break-word;
            font-weight: 400;
        }        #modalDate {
          margin-top: 8px;
          font-size: 0.82rem;
          color: #666;
        }

        /* Ensure the right column can scroll if content grows */
        .modal-right {
          flex: 1;
          display: flex;
          flex-direction: column;
          justify-content: flex-start;
          position: relative;
          min-width: 0; /* allow children to shrink/wrap */
        }

        .close, .modal-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            cursor: pointer;
            color: #666;
            transition: color 0.18s;
            background: transparent;
            border: none;
            padding: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .close:hover, .modal-close:hover {
            color: #333;
            background: rgba(0,0,0,0.03);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            nav {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            footer {
                grid-template-columns: 1fr 1fr;
            }

            .portfolio-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
             
            }

            .portfolio-item img {
                width: 100%;
                cursor: pointer;
                   border-top-left-radius: 70px
            }

            .modal-content {
                flex-direction: column;
                width: 95%;
                max-width: none;
                padding: 15px;
            }

            .modal-left img {
                max-height: 250px;
            }
        }
        /* Sidebar styles */
        .app-sidebar {
          position: fixed;
          left: 0;
          top: 0;
          height: 100vh;
          width: 72px;
          background: #efefef;
          border-right: 1px solid #e6e6e6;
          box-shadow: 2px 0 10px rgba(0,0,0,0.03);
          transition: width 0.28s ease, box-shadow 0.28s ease;
          z-index: 9998;
          overflow: hidden;
          display: flex;
          flex-direction: column;
          align-items: flex-start;
          padding-top: 6px; /* move sidebar content higher */
          padding-left: 8px;
          cursor: pointer;
        }

        .app-sidebar.open {
          width: 260px;
          box-shadow: 6px 0 30px rgba(0,0,0,0.08);
        }

        .sidebar-toggle {
          width: 36px;
          height: 36px;
          border-radius: 8px;
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          margin-bottom: 8px; /* tighter spacing */
          transition: opacity 0.22s cubic-bezier(.2,.9,.2,1), transform 0.22s cubic-bezier(.2,.9,.2,1);
        }

        .app-sidebar.open .sidebar-toggle {
          opacity: 0;
          transform: translateX(-8px) scale(.98);
          pointer-events: none;
        }

        .sidebar-brand {
          width: 100%;
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 6px 10px 6px 6px; /* reduce vertical padding */
          cursor: pointer;
          margin-bottom: 4px;
          box-sizing: border-box;
          /* ensure brand vertically lines up with the items */
        }

        .sidebar-brand .brand-img {
          width: 40px; /* match sidebar-icon size so centers align */
          height: 40px;
          border-radius: 6px;
          overflow: hidden;
          display: inline-block;
          opacity: 1;
          transform: scale(.94) translateX(-2px);
          transition: opacity 0.22s cubic-bezier(.2,.9,.2,1), transform 0.22s cubic-bezier(.2,.9,.2,1), width 0.22s;
        }

        .sidebar-brand .brand-img img {
          width: 100%;
          height: 100%;
          object-fit: contain; /* prevent cropping */
          display: block;
        }

        .brand-link { text-decoration:none; color:inherit; display:flex; align-items:center; gap:10px; }

        .brand-label {
          display: inline-flex;
          flex-direction: column;
          gap: 0;
          line-height: 1;
          font-size: 14px;
          color: #111;
          opacity: 0;
          transform: translateX(-6px);
          transition: opacity 0.25s cubic-bezier(.2,.9,.2,1), transform 0.25s cubic-bezier(.2,.9,.2,1);
        }

        .brand-line-1 { font-weight: 800; font-size:14px; }
        .brand-line-2 { font-weight: 800; font-size:14px; }

        .app-sidebar.open .brand-label {
          opacity: 1;
          transform: translateX(0);
        }

        /* When collapsed, show only small logo area and keep label hidden */
        .app-sidebar:not(.open) .brand-img { opacity: 1; transform: scale(.9); }
        .app-sidebar:not(.open) .brand-label { opacity: 0; transform: translateX(-6px); }
        .app-sidebar.open { align-items: flex-start; padding-left: 14px; }
        .app-sidebar.open .brand-img { width:48px; height:48px; opacity:1; transform: none; }

        .app-sidebar.open .sidebar-brand .brand-img {
            opacity: 1;
            transform: scale(1) translateX(0);
        }

        .sidebar-list {
          list-style: none;
          padding: 0;
          margin: 0;
          width: 100%;
        }

        .sidebar-item {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 10px 14px;
          cursor: pointer;
          color: #333;
          transition: background 0.18s, color 0.18s;
        }

        .sidebar-item:hover {
          background: #f6f8fa;
        }

        .sidebar-icon {
          width: 40px;
          height: 40px;
          min-width: 40px;
          border-radius: 50%;
          background: #efefef;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          overflow: hidden;
        }

        .sidebar-icon img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
        }

        .sidebar-label {
          white-space: nowrap;
          opacity: 0;
          transform: translateX(-6px);
          transition: opacity 0.2s, transform 0.2s;
          font-weight: 600;
        }

        .app-sidebar.open .sidebar-label {
          opacity: 1;
          transform: translateX(0);
        }

        /* push page content when sidebar opens (use padding so fixed sidebar doesn't cover content) */
        .container.sidebar-open {
          padding-left: 260px;
        }

        /* Small screens: make sidebar act as overlay (do not push content) */
        @media (max-width: 768px) {
          .app-sidebar {
            left: -260px;
            width: 260px;
            transition: left 0.28s ease;
          }

          .app-sidebar.open {
            left: 0;
          }

          /* on small screens don't push content — keep normal small padding */
          .container {
            padding-left: 16px;
          }

          .container.sidebar-open {
            padding-left: 16px;
          }
        }
    </style>
</head>
<body>
    <x-navbar></x-navbar>
    <div class="container">
      <!-- Sidebar component (extracted) -->
      <x-sidebar />

            <!-- Search Bar -->
            @if($showHero ?? true)
              <section class="hero">
            <div class="hero-content">
                <h1>Find Your Best Designer</h1>
          </div>
          <div class="search-section">
            <div class="search-bar">
              <span class="search-icon"><img src="images/icon/search.png"></span>
              <form action="/search" method="GET" style="display:flex; align-items:center; flex:1; gap:10px;">
                <input type="text" name="q" placeholder=" Search for a category, artist, or service" style="flex:1; border:none; background:transparent; outline:none; font-size:16px; color:#333;">
                <button type="submit" style="background:transparent; border:none; cursor:pointer; color:#666; font-size:16px; padding:0; display:flex; align-items:center;">
                </button>
              </form>
            </div>
        </section>
         
        <!-- Hero Section -->
                  <div class="hero-image">
                <img src="images/banner.svg" alt="Creative workspace">
            </div>
        </section>
        @endif

        @if(session('success'))
          <div style="background:#4caf50;color:white;padding:10px;border-radius:8px;margin:12px 0">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div style="background:#e53935;color:white;padding:10px;border-radius:8px;margin:12px 0">{{ session('error') }}</div>
        @endif

     

        <!-- Online users (dashboard only) -->
        @if(($showHero ?? true) === false)
            <div class="online-users" style="padding:12px 24px; display:flex; align-items:center; gap:12px; border-radius:8px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.04); margin:12px 0;">
                <div style="font-weight:600; color:#333; min-width:120px">Online now</div>
                <div style="display:flex; gap:12px; align-items:center; overflow:auto; padding-bottom:4px;">
                    @if(isset($onlineUsers) && $onlineUsers->count())
                        @foreach($onlineUsers as $u)
                            <a href="{{ $u->username ? route('profile.show', $u->username) : '#' }}" title="{{ $u->name ?? $u->username }}" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:inherit;">
                                <img src="{{ optional($u)->avatar_url ?? '/images/icon/profil.png' }}" alt="{{ $u->name ?? $u->username }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #e9f7ea;">
                                <div style="font-size:13px;color:#444;display:block;margin-left:4px">{{ $u->username ?? $u->name }}</div>
                            </a>
                        @endforeach
                    @else
                        <div style="color:#666">No one is online right now.</div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Categories -->
    <div class="categories">
  <a href="/explore" class="category-btn filter" style="text-decoration:none; color:inherit;">Filter</a>
  <a href="/category/graphic" class="category-btn" style="text-decoration:none; color:inherit; display:flex; align-items:center;"><img src="images/Group 15.png" alt="Graphic Design" style="width:20px; height:20px; margin-right:10px; vertical-align:middle;">Graphic Design</a>
  <a href="/category/illustration" class="category-btn" style="text-decoration:none; color:inherit; display:flex; align-items:center;"><img src="images/icon/ilustrasi.svg" alt="Illustration" style="width:20px; height:20px; margin-right:10px; vertical-align:middle;">Illustration</a>
  <a href="/category/photography" class="category-btn" style="text-decoration:none; color:inherit; display:flex; align-items:center;"><img src="images/icon/fotografi.svg" alt="Photography" style="width:20px; height:20px; margin-right:10px; vertical-align:middle;">Photography</a>
  <a href="/category/typography" class="category-btn" style="text-decoration:none; color:inherit; display:flex; align-items:center;"><img src="images/icon/tipografi.svg" alt="Typography" style="width:20px; height:20px; margin-right:10px; vertical-align:middle;">Typography</a>
  <a href="/category/uiux" class="category-btn" style="text-decoration:none; color:inherit; display:flex; align-items:center;"><img src="images/Group 20.png" alt="UI/UX" style="width:20px; height:20px; margin-right:10px; vertical-align:middle;">UI/UX</a>
  <a href="/category/identity" class="category-btn" style="text-decoration:none; color:inherit; display:flex; align-items:center;"><img src="images/Group 22.png" alt="Visual Identity" style="width:20px; height:20px; margin-right:10px; vertical-align:middle;">Visual Identity</a>
</div>




        <!-- Portfolio Grid -->
        
       <div class="portfolio-grid">
            @foreach($artworks as $art)
                <div class="portfolio-item {{ $art->size === 'tall' ? 'tall' : '' }}">
                        @php
                          $imgSrc = !empty($art->image_path) ? asset('storage/'.$art->image_path) : (!empty($art->image) ? $art->image : null);
                          $creatorUsername = optional($art->user)->username ?? optional($art->user)->name ?? '';
                          $creatorName = optional($art->user)->name ?? optional($art->user)->username ?? '';
                          $creatorAvatar = optional($art->user)->avatar_url ?? '/images/icon/profil.png';
                        @endphp
                        @if($imgSrc)
                            <img src="{{ $imgSrc }}" alt="Artwork" class="thumbnail"
                              data-artwork-id="{{ $art->id }}"
                              data-title="{{ $art->title ?? '' }}"
                              data-desc="{{ $art->description ?? '' }}"
                              data-creator-name="{{ $creatorName }}"
                              data-creator-id="{{ optional($art->user)->id ?? '' }}"
                              data-creator-url="{{ $creatorUsername ? route('profile.show', $creatorUsername) : ($art->user?->id ? route('profile.show', $art->user->id) : '') }}"
                              data-creator-username="{{ $creatorUsername }}"
                              data-artwork-desc="{{ $art->description ?? '' }}"
                              data-date="{{ isset($art->created_at) ? $art->created_at->diffForHumans() : '' }}"
                              data-avatar="{{ $creatorAvatar }}"
                              data-creator-role="{{ optional($art->user)->role ?? '' }}"
                              data-like-count="{{ is_object($art) && method_exists($art, 'likedBy') ? $art->likedBy()->count() : 0 }}"
                              data-save-count="{{ is_object($art) && method_exists($art, 'savedBy') ? $art->savedBy()->count() : 0 }}"
                              data-share-count="{{ is_object($art) && isset($art->share_count) ? $art->share_count : 0 }}"
                              data-liked="{{ auth()->check() && $art->likedBy()->where('users.id', auth()->id())->exists() ? '1' : '0' }}"
                              data-saved="{{ auth()->check() && $art->savedBy()->where('users.id', auth()->id())->exists() ? '1' : '0' }}"
                            />
                        @else
                            <div style="background:#eee;width:100%;height:100%"></div>
                        @endif
                    <div class="portfolio-info">
                        <h3>{{ $art->title }}</h3>
                        <p>{{ optional($art->user)->username ?? optional($art->user)->name ?? '' }}</p>
                    </div>
                    <div class="portfolio-meta" style="display:flex;gap:8px;align-items:center;margin-top:8px;">
                      <span class="thumb-like" style="display:flex;align-items:center;gap:6px;">
                        <img src="/images/icon/like.png" alt="like" style="width:16px;height:16px"/>
                        <span class="thumb-like-count">{{ is_object($art) && method_exists($art, 'likedBy') ? $art->likedBy()->count() : 0 }}</span>
                      </span>
                      <span class="thumb-save" style="display:flex;align-items:center;gap:6px;">
                        <img src="/images/icon/love.png" alt="save" style="width:16px;height:16px"/>
                        <span class="thumb-save-count">{{ is_object($art) && method_exists($art, 'savedBy') ? $art->savedBy()->count() : 0 }}</span>
                      </span>
                      <span class="thumb-share" style="display:flex;align-items:center;gap:6px;">
                        <img src="/images/icon/share.png" alt="share" style="width:16px;height:16px"/>
                        <span class="thumb-share-count">{{ isset($art->share_count) ? $art->share_count : 0 }}</span>
                      </span>
                    </div>
                </div>
            @endforeach
        </div>

<!-- Infinite scroll trigger -->
<div id="infiniteScrollTrigger" style="text-align:center; padding:40px; color:#999;">
  <p>Loading more artworks...</p>
</div>

  <!-- Gallery -->
 <div id="frameModal" class="modal">
    <div class="modal-content">

      <!-- Karya -->
      <div class="modal-left">
        <img id="modalImage" src="" alt="Artwork" style="width:100%; border-radius:10px; max-height:400px; object-fit:cover;">
        <div id="modalDate"></div>
      </div>

      <!-- Info Kreator -->
      <div class="modal-right">
        <!-- Avatar + creator name (top row) -->
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px; position:relative; padding-right:40px;">
          <img id="modalAvatar" src="/images/icon/profil.png" alt="Avatar" style="width:50px; height:50px; border-radius:50%; object-fit:cover; flex-shrink:0;">
          <a id="modalCreatorLink" href="#" style="text-decoration:none; color:inherit">
            <div style="display:flex; flex-direction:column;">
              <div id="modalCreatorName" style="font-weight:700"></div>
              <div id="modalCreatorUsername" style="color:#666; font-size:13px"></div>
            </div>
          </a>

          <!-- Close button -->
          <button class="modal-close" aria-label="Tutup modal" style="position:absolute; top:-10px; right:-10px; background:transparent; border:none; padding:0; cursor:pointer; display:flex; align-items:center; justify-content:center;">
            <img src="/images/back.png" alt="Tutup" style="width:28px; height:28px; object-fit:contain;">
          </button>
        </div>

        <!-- Badge + Follow button (below name row, aligned left) -->
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px;">
          <span id="modalCreatorRoleBadge" style="display:none;background:#4caf50;color:white;font-size:0.8em;padding:2px 6px;border-radius:4px;"></span>
          <button id="modalFollowBtn" style="padding:5px 10px; background:#ff6ec4; color:white; border:none; border-radius:20px; cursor:pointer; font-size:0.85em;">Follow</button>
        </div>

        <!-- Artwork title and description -->
        <div style="flex:1;">
          <strong id="modalTitle" class="modal-title"></strong>
          <p id="modalArtworkDesc" class="modal-artwork-desc">Deskripsi karya akan ditampilkan di sini.</p>
        </div>

        <!-- Social icons + interactions -->
        
         <div style="display:flex; gap:8px; margin-top:10px; align-items:center;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <button id="modalLikeBtn" class="icon-btn" type="button" aria-pressed="false" title="Like"><img id="modalLikeBtnIcon" src="/images/icon/unlike.png" alt="like" /></button>
                    <span id="modalLikeCount" class="count" style="color:#666;font-size:13px;margin-left:6px"></span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <button id="modalSaveBtn" class="icon-btn" type="button" aria-pressed="false" title="Save"><img id="modalSaveBtnIcon" src="/images/icon/unsave.png" alt="save" /></button>
                    <span id="modalSaveCount" class="count" style="color:#666;font-size:13px;margin-left:6px"></span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <button id="modalShareBtn" class="icon-btn" type="button" aria-pressed="false" title="Share"><img id="modalShareBtnIcon" src="/images/icon/unshare.png" alt="share" /></button>
                    <span id="modalShareCount" class="count" style="color:#666;font-size:13px;margin-left:6px"></span>
                </div>
            @auth
            <a id="modalViewProfileLink" href="{{ route('profile.show', auth()->user()->username ?? auth()->id()) }}?tab=saved" style="display:none; margin-left:10px; font-size:13px; color:#3b82f6; text-decoration:none">Lihat di profil</a>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>



</div>




        </div>

           <script>
       // Menu toggle for mobile
document.querySelector('.menu-toggle')?.addEventListener('click', function() {
  const nav = document.querySelector('nav');
  if (nav) {
    nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
  }
});



// Modal functionality
 const thumbnails = document.querySelectorAll(".thumbnail");
  const modal = document.getElementById("frameModal");
  const modalImage = document.getElementById("modalImage");
  const modalTitle = document.getElementById("modalTitle");
  const modalDesc = document.getElementById("modalDesc");
  const modalArtworkDesc = document.getElementById("modalArtworkDesc");
  const modalDate = document.getElementById("modalDate");
  const closeBtn = document.querySelector(".modal-close");

  

  // profile base url for "view in profile" link (null when not logged in)
  const MY_PROFILE_URL = @json(auth()->check() ? route('profile.show', auth()->user()->username ?? auth()->id()) : null);

  // Store current artwork ID for handlers
  let currentArtId = null;
  let currentImg = null;
  // CSRF token (fallback to empty string if meta tag missing to avoid errors)
  const CSRF_TOKEN = (document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content')) || '';
  // read XSRF cookie as a fallback (Laravel sets XSRF-TOKEN cookie); decodeURIComponent because cookie is URL encoded
  const XSRF_TOKEN_COOKIE = (function(){ const m = document.cookie.match(new RegExp('(^|; )' + 'XSRF-TOKEN' + '=([^;]*)')); return m ? decodeURIComponent(m[2]) : ''; })();
  console.debug('CSRF sources', { meta: CSRF_TOKEN, cookieXSRF: XSRF_TOKEN_COOKIE });

  // Modal buttons (single set of handlers — more reliable than reattaching per-open)
  const modalLikeBtn = modal.querySelector('#modalLikeBtn');
  const modalSaveBtn = modal.querySelector('#modalSaveBtn');
  const modalShareBtn = modal.querySelector('#modalShareBtn');

  function setIconState(btn, isActive, type) {
    if (!btn) return;
    const img = btn.querySelector('img') || document.getElementById(btn.id + 'Icon');
    if (!img) return;
    const mapping = {
      like: { on: '/images/icon/like.png', off: '/images/icon/unlike.png' },
      save: { on: '/images/icon/save.png', off: '/images/icon/unsave.png' },
      share: { on: '/images/icon/share.png', off: '/images/icon/unshare.png' }
    };
    img.src = (mapping[type] && (isActive ? mapping[type].on : mapping[type].off)) || img.src;
    img.classList.add('icon-animate');
    setTimeout(()=> img.classList.remove('icon-animate'), 220);
    btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
  }

  async function handleLikeClick(e){
    e.preventDefault();
    if (!currentImg) return;
    const artId = currentImg.dataset.artworkId;
    // guard duplicate requests
    if (modalLikeBtn.dataset.pending === '1') { console.debug('explore like ignored - pending', artId); return; }
    modalLikeBtn.dataset.pending = '1';

    // Optimistic UI: toggle immediately
    const modalLikeCount = modal.querySelector('#modalLikeCount');
    const beforeCount = parseInt(currentImg.dataset.likeCount || '0');
    const wasActive = modalLikeBtn.classList.contains('active');
    const pendingLiked = !wasActive;
    const pendingCount = beforeCount + (pendingLiked ? 1 : -1);
    if (modalLikeCount) modalLikeCount.textContent = pendingCount ?? '';
    modalLikeBtn.classList.toggle('active', pendingLiked);
    setIconState(modalLikeBtn, pendingLiked, 'like');
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = pendingCount ?? ''; } catch (e){ console.debug('thumb optimistic like error', e); }

    try {
      console.debug('global like clicked', artId);
      const likePayload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
      console.debug('like request headers', { 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), body: likePayload });
      const res = await fetch('/artworks/' + artId + '/like', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: likePayload });
      const data = await parseJsonIfPossible(res);
      if (!res.ok) {
        if (data && data.message === 'Unauthenticated.') { alert('Silakan login untuk like'); }
        // revert optimistic
        if (modalLikeCount) modalLikeCount.textContent = beforeCount ?? '';
        modalLikeBtn.classList.toggle('active', wasActive);
        setIconState(modalLikeBtn, wasActive, 'like');
        try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = beforeCount ?? ''; } catch (e){ }
        return;
      }

      // On success, use server count if available otherwise keep optimistic
      const finalCount = (data && data.like_count !== undefined) ? data.like_count : pendingCount;
      const finalLiked = (data && data.liked !== undefined) ? (data.liked === true) : pendingLiked;
      if (modalLikeCount) modalLikeCount.textContent = finalCount ?? '';
      currentImg.dataset.likeCount = finalCount ?? '';
      currentImg.dataset.liked = finalLiked ? '1' : '0';
      modalLikeBtn.classList.toggle('active', finalLiked);
      setIconState(modalLikeBtn, finalLiked, 'like');
      console.debug('explore like updated', { artId, beforeCount, pendingCount, finalCount, finalLiked, server: data });
      try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = finalCount ?? ''; } catch (e){ console.debug('thumb sync like error', e); }
      try {
        // include a small HTML snapshot of the card so profile pages can insert it when they don't have the source
        const card = currentImg && (currentImg.closest('.art-card') || currentImg.closest('.portfolio-item'));
        const cardHtml = card ? card.outerHTML : null;
        const owner_username = currentImg?.dataset?.creatorUsername || null;
        const owner_id = currentImg?.dataset?.creatorId || null;
        const owner = owner_username || owner_id || null;
        const actor = window.CURRENT_USERNAME || null;
        const title = currentImg?.dataset?.title || null;
        const broadcast = { id: artId, action: 'like', state: !!finalLiked, cardHtml: cardHtml, owner, owner_username, owner_id, actor, title, t: Date.now() };
        console.log('broadcast artwork-action', broadcast);
        try { localStorage.setItem('artwork-action', JSON.stringify(broadcast)); window.dispatchEvent(new CustomEvent('artwork-action', { detail: broadcast })); } catch (e) { console.debug('broadcast error', e); }
        setTimeout(()=> localStorage.removeItem('artwork-action'), 600);
      } catch (e) { console.debug('broadcast error', e); }
    } finally { modalLikeBtn.dataset.pending = '0'; }
  }

  async function handleSaveClick(e){
    e.preventDefault();
    if (!currentImg) return;
    const artId = currentImg.dataset.artworkId;
    if (modalSaveBtn.dataset.pending === '1') { console.debug('explore save ignored - pending', artId); return; }
    modalSaveBtn.dataset.pending = '1';

    // Optimistic UI
    const modalSaveCount = modal.querySelector('#modalSaveCount');
    const beforeCount = parseInt(currentImg.dataset.saveCount || '0');
    const wasActive = modalSaveBtn.classList.contains('active');
    const pendingSaved = !wasActive;
    const pendingCount = beforeCount + (pendingSaved ? 1 : -1);
    if (modalSaveCount) modalSaveCount.textContent = pendingCount ?? '';
    modalSaveBtn.classList.toggle('active', pendingSaved);
    setIconState(modalSaveBtn, pendingSaved, 'save');
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = pendingCount ?? ''; } catch (e){ console.debug('thumb optimistic save error', e); }

    try {
      console.debug('global save clicked', artId);
      const savePayload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
      console.debug('save request headers', { 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), body: savePayload });
      const res = await fetch('/artworks/' + artId + '/save', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: savePayload });
      const data = await parseJsonIfPossible(res);
      if (!res.ok) {
        if (data && data.message === 'Unauthenticated.') { alert('Silakan login untuk menyimpan'); }
        if (modalSaveCount) modalSaveCount.textContent = beforeCount ?? '';
        modalSaveBtn.classList.toggle('active', wasActive);
        setIconState(modalSaveBtn, wasActive, 'save');
        try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = beforeCount ?? ''; } catch (e){ }
        return;
      }
      const finalCount = (data && data.save_count !== undefined) ? data.save_count : pendingCount;
      const finalSaved = (data && data.saved !== undefined) ? (data.saved === true) : pendingSaved;
      if (modalSaveCount) modalSaveCount.textContent = finalCount ?? '';
      currentImg.dataset.saveCount = finalCount ?? '';
      currentImg.dataset.saved = finalSaved ? '1' : '0';
      modalSaveBtn.classList.toggle('active', finalSaved);
      console.debug('explore save updated', { artId, beforeCount, pendingCount, finalCount, finalSaved, server: data });
      try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = finalCount ?? ''; } catch (e){ console.debug('thumb sync save error', e); }
      try {
        const card = currentImg && (currentImg.closest('.art-card') || currentImg.closest('.portfolio-item'));
        const cardHtml = card ? card.outerHTML : null;
        const owner = currentImg?.dataset?.creatorUsername || null;
        const actor = window.CURRENT_USERNAME || null;
        const title = currentImg?.dataset?.title || null;
        const broadcast = { id: artId, action: 'save', state: !!finalSaved, cardHtml: cardHtml, owner, actor, title, t: Date.now() }; console.log('broadcast artwork-action', broadcast); localStorage.setItem('artwork-action', JSON.stringify(broadcast)); try { window.dispatchEvent(new CustomEvent('artwork-action', { detail: broadcast })); } catch(e) {}
        setTimeout(()=> localStorage.removeItem('artwork-action'), 600);
      } catch(e) {}
    } catch (err) {
      console.debug('global save handler error', err);
      if (modalSaveCount) modalSaveCount.textContent = beforeCount ?? '';
      modalSaveBtn.classList.toggle('active', wasActive);
      setIconState(modalSaveBtn, wasActive, 'save');
      try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = beforeCount ?? ''; } catch (e){ }
    } finally { modalSaveBtn.dataset.pending = '0'; }
  }

  async function handleShareClick(e){
    e.preventDefault();
    if (!currentImg) return;
    const artId = currentImg.dataset.artworkId;
    const url = window.location.origin + '/artworks/' + artId;
    if (modalShareBtn.dataset.pending === '1') { console.debug('explore share ignored - pending', artId); return; }
    modalShareBtn.dataset.pending = '1';

    // Optimistic: increment share immediately
    const modalShareCount = modal.querySelector('#modalShareCount');
    const beforeCount = parseInt(currentImg.dataset.shareCount || '0');
    const pendingCount = beforeCount + 1;
    if (modalShareCount) modalShareCount.textContent = pendingCount ?? '';
    setIconState(modalShareBtn, true, 'share');
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = pendingCount ?? ''; } catch (e){ console.debug('thumb optimistic share error', e); }

    try {
      console.debug('global share clicked', artId);
      try { if (navigator.share) { await navigator.share({ title: currentImg.dataset.title || 'Artwork', url }); } else if (navigator.clipboard && navigator.clipboard.writeText) { await navigator.clipboard.writeText(url); alert('Link disalin ke clipboard'); } else { prompt('Salin link ini:', url); } } catch (e) { /* ignore */ }
      const sharePayload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
      console.debug('share request headers', { 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), body: sharePayload });
      const res = await fetch('/artworks/' + artId + '/share', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: sharePayload });
      const d = await parseJsonIfPossible(res);
      if (!res.ok) { alert('Gagal mencatat share'); if (modalShareCount) modalShareCount.textContent = beforeCount ?? ''; try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = beforeCount ?? ''; } catch (e){}; return; }
      const finalCount = (d && d.share_count !== undefined) ? d.share_count : pendingCount;
      if (modalShareCount) modalShareCount.textContent = finalCount ?? '';
      currentImg.dataset.shareCount = finalCount ?? '';
      setIconState(modalShareBtn, true, 'share');
      try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = finalCount ?? ''; } catch (e){ console.debug('thumb sync share error', e); }
      try { const card = currentImg && (currentImg.closest('.art-card') || currentImg.closest('.portfolio-item')); const cardHtml = card ? card.outerHTML : null; const owner_username = currentImg?.dataset?.creatorUsername || null; const owner_id = currentImg?.dataset?.creatorId || null; const owner = owner_username || owner_id || null; const actor = window.CURRENT_USERNAME || null; const title = currentImg?.dataset?.title || null; const broadcast = { id: artId, action: 'share', state: true, cardHtml: cardHtml, owner, owner_username, owner_id, actor, title, t: Date.now() }; console.log('broadcast artwork-action', broadcast); localStorage.setItem('artwork-action', JSON.stringify(broadcast)); try { window.dispatchEvent(new CustomEvent('artwork-action', { detail: broadcast })); } catch(e) {} setTimeout(()=> localStorage.removeItem('artwork-action'), 600); } catch(e) {}
    } catch (err) { console.debug('global share handler error', err); if (modalShareCount) modalShareCount.textContent = beforeCount ?? ''; setIconState(modalShareBtn, false, 'share'); } finally { modalShareBtn.dataset.pending = '0'; }
  }

  if (modalLikeBtn) modalLikeBtn.addEventListener('click', handleLikeClick);
  if (modalSaveBtn) modalSaveBtn.addEventListener('click', handleSaveClick);
  if (modalShareBtn) modalShareBtn.addEventListener('click', handleShareClick);

  // helper to parse JSON responses and detect login redirect or HTML login pages
  async function parseJsonIfPossible(res){
      const ct = (res.headers.get('content-type') || '').toLowerCase();
      if (ct.indexOf('application/json') !== -1) {
          try { return await res.json(); } catch(e) { return null; }
      }
      if (res.status === 403 || res.status === 419) return { message: 'Unauthenticated.' };
      const text = await res.text();
      const lower = (text || '').toLowerCase();
      if (lower.indexOf('<html') !== -1 || lower.indexOf('<!doctype') !== -1 || lower.indexOf('csrf-token') !== -1 || lower.indexOf('name="login"') !== -1 || lower.indexOf('password') !== -1) {
          return { message: 'Unauthenticated.' };
      }
      try { return JSON.parse(text); } catch (e) { return null; }
  }



  // Named handler so it can be attached/removed consistently
  function thumbnailClickHandler() {
    const img = this;
    currentImg = img;
    currentArtId = img.dataset.artworkId;
    console.debug('thumbnailClick', { artId: currentArtId, src: img && img.src });
    modal.style.display = "block";
    modalImage.src = img.src;
    modalTitle.textContent = img.dataset.title;
    // guard against missing modalDesc element (older markup)
    if (modalDesc) modalDesc.textContent = img.dataset.desc || img.dataset.artworkDesc || '';
    // populate creator info
    const avatarEl = document.getElementById('modalAvatar');
    if (avatarEl) avatarEl.src = img.dataset.avatar || '/images/icon/profil.png';
    const creatorName = img.dataset.creatorName || img.getAttribute('alt') || '';
    const creatorNameEl = document.getElementById('modalCreatorName');
    if (creatorNameEl) creatorNameEl.textContent = creatorName;
    const creatorUsername = img.dataset.creatorUsername || '';
    const creatorUsernameEl = document.getElementById('modalCreatorUsername');
    if (creatorUsernameEl) creatorUsernameEl.textContent = creatorUsername ? ('@' + creatorUsername) : '';
    const creatorUrl = img.dataset.creatorUrl || '';
    const creatorLink = document.getElementById('modalCreatorLink');
    if(creatorLink){
        if(creatorUrl) creatorLink.href = creatorUrl; else creatorLink.removeAttribute('href');
    }
    if (modalArtworkDesc) modalArtworkDesc.textContent = img.dataset.artworkDesc || "Deskripsi karya belum tersedia.";
    if (modalDate) modalDate.textContent = img.dataset.date;

    // populate counts
    const modalLikeCount = modal.querySelector('#modalLikeCount');
    const modalSaveCount = modal.querySelector('#modalSaveCount');
    const modalShareCount = modal.querySelector('#modalShareCount');
    if (modalLikeCount) modalLikeCount.textContent = img.dataset.likeCount || '0';
    if (modalSaveCount) modalSaveCount.textContent = img.dataset.saveCount || '0';
    if (modalShareCount) modalShareCount.textContent = img.dataset.shareCount || '0';

    // set button active states based on dataset to ensure optimistic toggles use correct baseline
    if (modalLikeBtn) modalLikeBtn.classList.toggle('active', (img.dataset.liked === '1' || img.dataset.liked === 'true'));
    if (modalSaveBtn) modalSaveBtn.classList.toggle('active', (img.dataset.saved === '1' || img.dataset.saved === 'true'));
    // initialize icon images
    setIconState(modalLikeBtn, modalLikeBtn && modalLikeBtn.classList.contains('active'), 'like');
    setIconState(modalSaveBtn, modalSaveBtn && modalSaveBtn.classList.contains('active'), 'save');
    setIconState(modalShareBtn, modalShareBtn && modalShareBtn.classList.contains('active'), 'share');


    
    // populate creator role badge
    const roleBadgeEl = document.getElementById('modalCreatorRoleBadge');
    const creatorRole = (img.dataset.creatorRole || '').toString();
    if (roleBadgeEl) {
      if (creatorRole) {
        // display human-friendly role
        const label = creatorRole.charAt(0).toUpperCase() + creatorRole.slice(1);
        roleBadgeEl.textContent = label;
        roleBadgeEl.style.display = 'inline-block';
        // color mapping (students green, lecturers/or staff orange, default grey)
        const r = creatorRole.toLowerCase();
        let bg = '#6b7280';
        if (r === 'mahasiswa' || r === 'student') bg = '#4caf50';
        else if (r === 'dosen' || r === 'lecturer' || r === 'teacher') bg = '#ff9800';
        roleBadgeEl.style.background = bg;
      } else {
        roleBadgeEl.style.display = 'none';
      }
         // add like/save/share controls and set counts
            const modalLikeBtn = document.getElementById('modalLikeBtn');
            const modalSaveBtn = document.getElementById('modalSaveBtn');
            const modalShareBtn = document.getElementById('modalShareBtn');
            const modalLikeCount = document.getElementById('modalLikeCount');
            const modalSaveCount = document.getElementById('modalSaveCount');
            const modalShareCount = document.getElementById('modalShareCount');

            // initialize counts from dataset
            if (modalLikeCount) modalLikeCount.textContent = img.dataset.likeCount || '0';
            if (modalSaveCount) modalSaveCount.textContent = img.dataset.saveCount || '0';
            if (modalShareCount) modalShareCount.textContent = img.dataset.shareCount || '0';

    }

    // Rely on global modal handlers (defined above) for like/save/share actions to avoid duplicate events.

  }

  // Use event delegation so dynamically loaded thumbnails still open the modal
  document.addEventListener('click', function(e){
    const t = e.target && e.target.closest ? e.target.closest('.thumbnail') : null;
    if (!t) return;
    try { thumbnailClickHandler.call(t); } catch (err) { console.debug('thumbnail click handler error', err); }
  });

  if (closeBtn) closeBtn.addEventListener('click', function(e){
    e.stopPropagation();
    modal.style.display = 'none';
  });
  window.onclick = e => { if (e.target === modal) modal.style.display = "none"; };
  
  // Sidebar toggle logic (supports component close button and mobile overlay)
  (function() {
    const sidebar = document.getElementById('appSidebar');
    const toggle = document.getElementById('sidebarToggle'); // may be null now
    const closeBtnSidebar = document.getElementById('sidebarClose');
    const containerEl = document.querySelector('.container');

    if (!sidebar || !containerEl) return;

    function isSmall() { return window.innerWidth <= 768; }

    function openSidebar() {
      sidebar.classList.add('open');
      if (!isSmall()) containerEl.classList.add('sidebar-open');
      sidebar.setAttribute('aria-hidden','false');
      if (closeBtnSidebar) {
        closeBtnSidebar.style.display = isSmall() ? 'block' : 'none';
      }
    }

    function closeSidebar() {
      sidebar.classList.remove('open');
      containerEl.classList.remove('sidebar-open');
      sidebar.setAttribute('aria-hidden','true');
      if (closeBtnSidebar) closeBtnSidebar.style.display = 'none';
    }

    // Toggle on click (if a toggle exists). We removed the visible hamburger,
    // but keep this handler if an element with id 'sidebarToggle' is present.
    if (toggle) {
      toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        if (sidebar.classList.contains('open')) closeSidebar(); else openSidebar();
      });
    }

    // If the user clicks anywhere on the collapsed sidebar (or the logo), open it.
    // If the click is on the brand link while closed, prevent navigation and open instead.
    sidebar.addEventListener('click', function(e) {
      if (!sidebar.classList.contains('open')) {
        const brandAnchor = e.target.closest('.brand-link');
        if (brandAnchor) e.preventDefault();
        openSidebar();
        e.stopPropagation();
      }
    });

    // Close button inside sidebar (mobile)
    if (closeBtnSidebar) {
      closeBtnSidebar.addEventListener('click', function(e){
        e.stopPropagation();
        closeSidebar();
      });
    }

    // Click outside to close (guard if `toggle` is missing)
    document.addEventListener('click', function(e){
      const clickedInsideSidebar = sidebar.contains(e.target);
      const clickedToggle = toggle && typeof toggle.contains === 'function' ? toggle.contains(e.target) : false;
      const inside = clickedInsideSidebar || clickedToggle;
      if (!inside && sidebar.classList.contains('open')) closeSidebar();
    });

    // On resize, adjust whether container should be pushed
    window.addEventListener('resize', function() {
      if (sidebar.classList.contains('open')) {
        if (!isSmall()) containerEl.classList.add('sidebar-open'); else containerEl.classList.remove('sidebar-open');
      }
    });
  })();

  // Infinite scroll functionality
  (function() {
    const portfolioGrid = document.querySelector('.portfolio-grid');
    const infiniteScrollTrigger = document.getElementById('infiniteScrollTrigger');
    let isLoading = false;
    let pageNum = 2; // Start from page 2 since page 1 is already loaded

    function loadMoreArtworks() {
      if (isLoading) return;
      isLoading = true;
      infiniteScrollTrigger.style.display = 'block';

      // Fetch from API
      fetch(`/api/explore/load-more?page=${pageNum}`)
        .then(response => response.json())
        .then(data => {
          if (data.success && data.items.length > 0) {
            const fragment = document.createDocumentFragment();
            
            data.items.forEach(artwork => {
              const item = document.createElement('div');
              item.className = `portfolio-item ${artwork.size === 'tall' ? 'tall' : ''}`;
              item.innerHTML = `
                <img src="${artwork.image}" alt="Artwork" class="thumbnail"
                     data-artwork-id="${artwork.id}"
                     data-title="${artwork.title || ''}"
                     data-desc="${artwork.description || ''}"
                     data-creator-name="${artwork.user?.name || artwork.artist || ''}"
                     data-creator-id="${artwork.user?.id || ''}"
                     data-creator-username="${artwork.user?.username || artwork.artist || ''}"
                     data-creator-url="${artwork.user?.username ? '/users/' + artwork.user.username : ''}"
                     data-artwork-desc="${artwork.description || ''}"
                     data-date="${artwork.date || ''}"
                     data-avatar="${artwork.user?.avatar || '/images/icon/profil.png'}"
                     data-creator-role="${artwork.user?.role || artwork.user_role || ''}"
                     data-like-count="${artwork.like_count || 0}"
                     data-save-count="${artwork.save_count || 0}"
                     data-share-count="${artwork.share_count || 0}">
                <div class="portfolio-info">
                  <h3>${artwork.title}</h3>
                  <p>${artwork.user?.username || artwork.artist || ''}</p>
                </div>
                <div class="portfolio-meta" style="display:flex;gap:8px;align-items:center;margin-top:8px;">
                  <span class="thumb-like" style="display:flex;align-items:center;gap:6px;">
                    <img src="/images/icon/like.png" alt="like" style="width:16px;height:16px"/>
                    <span class="thumb-like-count">${artwork.like_count || 0}</span>
                  </span>
                  <span class="thumb-save" style="display:flex;align-items:center;gap:6px;">
                    <img src="/images/icon/love.png" alt="save" style="width:16px;height:16px"/>
                    <span class="thumb-save-count">${artwork.save_count || 0}</span>
                  </span>
                  <span class="thumb-share" style="display:flex;align-items:center;gap:6px;">
                    <img src="/images/icon/share.png" alt="share" style="width:16px;height:16px"/>
                    <span class="thumb-share-count">${artwork.share_count || 0}</span>
                  </span>
                </div>
              `;
              fragment.appendChild(item);
            });

            portfolioGrid.appendChild(fragment);
            
            // Re-attach click handlers to new thumbnails
            document.querySelectorAll('.thumbnail').forEach(img => {
              img.removeEventListener('click', thumbnailClickHandler);
              img.addEventListener('click', thumbnailClickHandler);
            });

            pageNum++;
            isLoading = false;
            infiniteScrollTrigger.style.display = 'none';
          } else {
            infiniteScrollTrigger.innerHTML = '<p style="color:#999;">Tidak ada karya lagi</p>';
          }
        })
        .catch(error => {
          console.error('Error loading more artworks:', error);
          isLoading = false;
          infiniteScrollTrigger.style.display = 'none';
        });
    }

    // thumbnailClickHandler is defined above; reuse it for dynamically added thumbnails

    // Intersection Observer for infinite scroll trigger
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            loadMoreArtworks();
          }
        });
      }, { rootMargin: '200px' });

      observer.observe(infiniteScrollTrigger);
    }
  })();
</script>

</body>

</html>

<x-sidebar-assets />