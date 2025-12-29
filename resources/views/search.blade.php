<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Search Results - DCH</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        .container {
            margin: 0;
            padding: 0 20px 0 96px;
            transition: padding-left 0.28s ease;
            max-width: 100%;
        }

        .search-results-header {
            padding: 20px 40px 20px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:16px;
        }

        .search-results-header .sr-left { flex:1; min-width:0; }

        .search-results-header h1 {
            font-size: 28px;
            color: #333;
            margin: 0 0 6px 0;
            overflow-wrap:break-word;
            word-break:break-word;
        }

        .search-results-header p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .category-asset {
            width:130px;
            height:86px;
            border-radius:12px;
            overflow:hidden;
            background: #ffffffff;
            box-shadow: 
            flex-shrink:0;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .category-asset img {
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }

        .portfolio-grid {
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            grid-auto-rows: 200px;
        }

        .portfolio-item {
            background: #d0d0d0;
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

        .no-results {
            text-align: center;
            padding: 80px 40px;
            color: #999;
        }

        .no-results h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .no-results p {
            font-size: 16px;
        }

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
        }

        #modalDate {
            margin-top: 8px;
            font-size: 0.82rem;
            color: #666;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            cursor: pointer;
        }

        .modal-close:hover {
            background: rgba(0,0,0,0.03);
        }

        .sidebar-open {
            padding-left: 260px !important;
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 16px;
            }

            .portfolio-grid {
                padding: 20px;
                grid-template-columns: repeat(2, 1fr);
            }

            .modal-content {
                flex-direction: column;
                width: 95%;
                max-width: none;
                padding: 15px;
            }
        }

        .app-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 72px;
            z-index: 9998;
        }
    </style>
</head>
<body>
    <x-navbar></x-navbar>
    <div class="container">
        <x-sidebar />

        <div class="search-results-header">
            <div class="sr-left">
              <h1>{{ $pageTitle }}</h1>
              <p>
                  @if(!empty($query))
                      Found {{ count($results) }} result(s) for "<strong>{{ $query }}</strong>"
                  @elseif(!empty($category ?? null))
                      Showing {{ count($results) }} artwork(s) in {{ $pageTitle }}
                  @else
                      Enter a search term to find artworks
                  @endif
              </p>
            </div>
            @php
              use \Illuminate\Support\Str;

              // Default placeholder
              $categoryAsset = '/images/categories/placeholder.svg';

              // Support when $category is either a slug string or a Category model
              $slug = '';
              $name = '';
              if (!empty($category)) {
                if (is_string($category)) {
                  $slug = $category;
                } elseif (is_object($category)) {
                  $slug = (string)($category->slug ?? '');
                  $name = (string)($category->name ?? '');
                }
              }

              // Also consider page title (e.g., "Illustration") when slug/name absent
              $source = Str::lower($slug ?: $name ?: ($pageTitle ?? ''));

              // Explicit mappings for well-known categories
              if (Str::contains($source, ['ui-ux', 'uiux', 'ui'])) {
                $categoryAsset = '/images/UI.png';
              } elseif (Str::contains($source, ['ilustr', 'illustr', 'ilustrasi', 'illustration'])) {
                $categoryAsset = '/images/ILUSTRASI.png';
              } else {
                // Prefer category-specific files in public/images/categories/{slug-or-name}.png|svg
                $candidate = Str::slug($slug ?: $name ?: ($pageTitle ?? ''));
                if ($candidate) {
                  $png = 'images/categories/' . $candidate . '.png';
                  $svg = 'images/categories/' . $candidate . '.svg';
                  if (file_exists(public_path($png))) {
                    $categoryAsset = '/' . $png;
                  } elseif (file_exists(public_path($svg))) {
                    $categoryAsset = '/' . $svg;
                  } else {
                    $categoryAsset = '/images/categories/placeholder.svg';
                  }
                }
              }
            @endphp

            <div class="sr-right">
              <!-- Developer-replaceable category asset (change src or data-asset) -->
              <div id="categoryAsset" class="category-asset" data-asset="{{ $categoryAsset }}">
                <img src="{{ $categoryAsset }}" alt="{{ $category->name ?? 'Category asset' }}">
              </div>
            </div>
        </div>

        @if(!empty($results) && count($results) > 0)
            <div class="portfolio-grid">
                @foreach($results as $item)
                    <div class="portfolio-item {{ $item['size'] === 'tall' ? 'tall' : '' }}">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="thumbnail"
                                data-title="{{ $item['title'] }}" data-desc="{{ $item['description'] }}" data-creator-name="{{ $item['artist'] }}"
                                data-artwork-desc="{{ $item['description'] }}" data-date="{{ $item['date'] }}">
                        <div class="portfolio-info">
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['artist'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-results">
                <h2>No results found</h2>
                <p>
                    @if(!empty($query))
                        We couldn't find any artworks matching "<strong>{{ $query }}</strong>". Try searching for something else.
                    @else
                        Enter a search term to find artworks by title, artist, or description.
                    @endif
                </p>
            </div>
        @endif
    </div>

  <!-- Gallery (shared modal with Explore) -->
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

    <script>
       // Menu toggle for mobile
document.querySelector('.menu-toggle')?.addEventListener('click', function() {
  const nav = document.querySelector('nav');
  if (nav) {
    nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
  }
});



// Modal functionality (copied from Explore for feature parity)
  const modal = document.getElementById("frameModal");
  const modalImage = document.getElementById("modalImage");
  const modalTitle = document.getElementById("modalTitle");
  const modalDesc = document.getElementById("modalDesc");
  const modalArtworkDesc = document.getElementById("modalArtworkDesc");
  const modalDate = document.getElementById("modalDate");
  const closeBtn = document.querySelector(".modal-close");

  // profile base url for "view in profile" link (null when not logged in)
  const MY_PROFILE_URL = @json(auth()->check() ? route('profile.show', auth()->user()->username ?? auth()->id()) : null);

  // Store current artwork references
  let currentArtId = null;
  let currentImg = null;
  const CSRF_TOKEN = (document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content')) || '';
  const XSRF_TOKEN_COOKIE = (function(){ const m = document.cookie.match(new RegExp('(^|; )' + 'XSRF-TOKEN' + '=([^;]*)')); return m ? decodeURIComponent(m[2]) : ''; })();
  console.debug('CSRF sources', { meta: CSRF_TOKEN, cookieXSRF: XSRF_TOKEN_COOKIE });

  // Modal buttons
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

  // Lightweight server-interaction handlers (safe to exist, will guard if no backend)
  async function handleLikeClick(e){
    e.preventDefault();
    if (!currentImg) return;
    const artId = currentImg.dataset.artworkId;
    if (modalLikeBtn.dataset.pending === '1') { console.debug('like ignored - pending', artId); return; }
    modalLikeBtn.dataset.pending = '1';
    const modalLikeCount = modal.querySelector('#modalLikeCount');
    const beforeCount = parseInt(currentImg.dataset.likeCount || '0');
    const wasActive = modalLikeBtn.classList.contains('active');
    const pendingLiked = !wasActive;
    const pendingCount = beforeCount + (pendingLiked ? 1 : -1);
    if (modalLikeCount) modalLikeCount.textContent = pendingCount ?? '';
    modalLikeBtn.classList.toggle('active', pendingLiked);
    setIconState(modalLikeBtn, pendingLiked, 'like');
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = pendingCount ?? ''; } catch (e){ }
    try {
      // attempt server call if endpoint exists
      const likePayload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
      const res = await fetch('/artworks/' + artId + '/like', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: likePayload });
      const data = await parseJsonIfPossible(res);
      if (!res.ok) {
        if (data && data.message === 'Unauthenticated.') { alert('Silakan login untuk like'); }
        if (modalLikeCount) modalLikeCount.textContent = beforeCount ?? '';
        modalLikeBtn.classList.toggle('active', wasActive);
        setIconState(modalLikeBtn, wasActive, 'like');
        try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = beforeCount ?? ''; } catch (e){}
        return;
      }
      const finalCount = (data && data.like_count !== undefined) ? data.like_count : pendingCount;
      const finalLiked = (data && data.liked !== undefined) ? (data.liked === true) : pendingLiked;
      if (modalLikeCount) modalLikeCount.textContent = finalCount ?? '';
      currentImg.dataset.likeCount = finalCount ?? '';
      currentImg.dataset.liked = finalLiked ? '1' : '0';
      modalLikeBtn.classList.toggle('active', finalLiked);
      setIconState(modalLikeBtn, finalLiked, 'like');
    } catch (err) { console.debug('like handler error', err); } finally { modalLikeBtn.dataset.pending = '0'; }
  }

  async function handleSaveClick(e){
    e.preventDefault();
    if (!currentImg) return;
    const artId = currentImg.dataset.artworkId;
    if (modalSaveBtn.dataset.pending === '1') { console.debug('save ignored - pending', artId); return; }
    modalSaveBtn.dataset.pending = '1';
    const modalSaveCount = modal.querySelector('#modalSaveCount');
    const beforeCount = parseInt(currentImg.dataset.saveCount || '0');
    const wasActive = modalSaveBtn.classList.contains('active');
    const pendingSaved = !wasActive;
    const pendingCount = beforeCount + (pendingSaved ? 1 : -1);
    if (modalSaveCount) modalSaveCount.textContent = pendingCount ?? '';
    modalSaveBtn.classList.toggle('active', pendingSaved);
    setIconState(modalSaveBtn, pendingSaved, 'save');
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = pendingCount ?? ''; } catch (e){}
    try {
      const savePayload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
      const res = await fetch('/artworks/' + artId + '/save', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: savePayload });
      const data = await parseJsonIfPossible(res);
      if (!res.ok) {
        if (data && data.message === 'Unauthenticated.') { alert('Silakan login untuk menyimpan'); }
        if (modalSaveCount) modalSaveCount.textContent = beforeCount ?? '';
        modalSaveBtn.classList.toggle('active', wasActive);
        setIconState(modalSaveBtn, wasActive, 'save');
        try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = beforeCount ?? ''; } catch (e){}
        return;
      }
      const finalCount = (data && data.save_count !== undefined) ? data.save_count : pendingCount;
      const finalSaved = (data && data.saved !== undefined) ? (data.saved === true) : pendingSaved;
      if (modalSaveCount) modalSaveCount.textContent = finalCount ?? '';
      currentImg.dataset.saveCount = finalCount ?? '';
      currentImg.dataset.saved = finalSaved ? '1' : '0';
      modalSaveBtn.classList.toggle('active', finalSaved);
    } catch (err) { console.debug('save handler error', err); } finally { modalSaveBtn.dataset.pending = '0'; }
  }

  async function handleShareClick(e){
    e.preventDefault();
    if (!currentImg) return;
    const artId = currentImg.dataset.artworkId;
    const url = window.location.origin + '/artworks/' + artId;
    if (modalShareBtn.dataset.pending === '1') { console.debug('share ignored - pending', artId); return; }
    modalShareBtn.dataset.pending = '1';
    const modalShareCount = modal.querySelector('#modalShareCount');
    const beforeCount = parseInt(currentImg.dataset.shareCount || '0');
    const pendingCount = beforeCount + 1;
    if (modalShareCount) modalShareCount.textContent = pendingCount ?? '';
    setIconState(modalShareBtn, true, 'share');
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = pendingCount ?? ''; } catch (e){}
    try {
      try { if (navigator.share) { await navigator.share({ title: currentImg.dataset.title || 'Artwork', url }); } else if (navigator.clipboard && navigator.clipboard.writeText) { await navigator.clipboard.writeText(url); alert('Link disalin ke clipboard'); } else { prompt('Salin link ini:', url); } } catch (e) { /* ignore */ }
      const sharePayload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
      const res = await fetch('/artworks/' + artId + '/share', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: sharePayload });
      const d = await parseJsonIfPossible(res);
      if (!res.ok) { alert('Gagal mencatat share'); if (modalShareCount) modalShareCount.textContent = beforeCount ?? ''; try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = beforeCount ?? ''; } catch (e){}; return; }
      const finalCount = (d && d.share_count !== undefined) ? d.share_count : pendingCount;
      if (modalShareCount) modalShareCount.textContent = finalCount ?? '';
      currentImg.dataset.shareCount = finalCount ?? '';
      setIconState(modalShareBtn, true, 'share');
    } catch (err) { console.debug('share handler error', err); if (modalShareCount) modalShareCount.textContent = beforeCount ?? ''; setIconState(modalShareBtn, false, 'share'); } finally { modalShareBtn.dataset.pending = '0'; }
  }

  if (modalLikeBtn) modalLikeBtn.addEventListener('click', handleLikeClick);
  if (modalSaveBtn) modalSaveBtn.addEventListener('click', handleSaveClick);
  if (modalShareBtn) modalShareBtn.addEventListener('click', handleShareClick);

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
    if (modalDesc) modalDesc.textContent = img.dataset.desc || img.dataset.artworkDesc || '';
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

    const modalLikeCount = modal.querySelector('#modalLikeCount');
    const modalSaveCount = modal.querySelector('#modalSaveCount');
    const modalShareCount = modal.querySelector('#modalShareCount');
    if (modalLikeCount) modalLikeCount.textContent = img.dataset.likeCount || '0';
    if (modalSaveCount) modalSaveCount.textContent = img.dataset.saveCount || '0';
    if (modalShareCount) modalShareCount.textContent = img.dataset.shareCount || '0';

    if (modalLikeBtn) modalLikeBtn.classList.toggle('active', (img.dataset.liked === '1' || img.dataset.liked === 'true'));
    if (modalSaveBtn) modalSaveBtn.classList.toggle('active', (img.dataset.saved === '1' || img.dataset.saved === 'true'));
    setIconState(modalLikeBtn, modalLikeBtn && modalLikeBtn.classList.contains('active'), 'like');
    setIconState(modalSaveBtn, modalSaveBtn && modalSaveBtn.classList.contains('active'), 'save');
    setIconState(modalShareBtn, modalShareBtn && modalShareBtn.classList.contains('active'), 'share');

    const roleBadgeEl = document.getElementById('modalCreatorRoleBadge');
    const creatorRole = (img.dataset.creatorRole || '').toString();
    if (roleBadgeEl) {
      if (creatorRole) {
        const label = creatorRole.charAt(0).toUpperCase() + creatorRole.slice(1);
        roleBadgeEl.textContent = label;
        roleBadgeEl.style.display = 'inline-block';
        const r = creatorRole.toLowerCase();
        let bg = '#6b7280';
        if (r === 'mahasiswa' || r === 'student') bg = '#4caf50';
        else if (r === 'dosen' || r === 'lecturer' || r === 'teacher') bg = '#ff9800';
        roleBadgeEl.style.background = bg;
      } else {
        roleBadgeEl.style.display = 'none';
      }
    }

    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = img.dataset.likeCount ?? ''; } catch (e){}
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = img.dataset.saveCount ?? ''; } catch (e){}
    try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = img.dataset.shareCount ?? ''; } catch (e){}

  }

  // Attach once using event delegation so dynamically loaded content works
  document.addEventListener('click', function(e){
    const t = e.target.closest('.thumbnail');
    if (!t) return;
    e.preventDefault();
    thumbnailClickHandler.call(t);
  });

  if (closeBtn) closeBtn.addEventListener('click', function(e){ e.stopPropagation(); modal.style.display = 'none'; });
  window.onclick = e => { if (e.target === modal) modal.style.display = "none"; };

  // simple helper to let developers swap the right-side category asset image easily
  (function(){
    const asset = document.getElementById('categoryAsset');
    if (!asset) return;
    const img = asset.querySelector('img');
    const data = asset.dataset && asset.dataset.asset;
    if (data && img) img.src = data;
  })();
    </script>
    <x-sidebar-assets />
</body>
</html>
