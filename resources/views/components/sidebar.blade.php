<aside class="app-sidebar" id="appSidebar" aria-hidden="false">
    <!-- Hamburger removed per request: sidebar opens when clicked anywhere or on logo -->
    <a href="/" class="sidebar-brand brand-link" title="Brand">
        <div class="brand-img">
            <img src="/images/image-3.png" alt="DCH logo">
        </div>
        <div class="brand-label">
            <span class="brand-line brand-line-1">DIGITAL</span>
            <span class="brand-line brand-line-2">CREATIVE HUB</span>
        </div>
    </a>
    <div class="sidebar-close" id="sidebarClose" title="Close sidebar" style="display:none; position:absolute; top:10px; right:12px; cursor:pointer;">✕</div>

    <ul class="sidebar-list">
        <li class="sidebar-item" title="Home">
            <div class="sidebar-icon"><img src="/images/icon/home.png" alt="home icon"></div>
            <div class="sidebar-label">Home</div>
        </li>
        <li class="sidebar-item" title="Dashboard">
            <a href="{{ route('dashboard') }}" style="all:unset;display:flex;align-items:center;gap:12px;width:100%;padding:8px 0;">
                <div class="sidebar-icon"><img src="/images/icon/kategori.png" alt="dashboard icon"></div>
                <div class="sidebar-label">Dashboard</div>
            </a>
        </li>
        <!-- Added primary quick actions: Messages, Notification -->
        <!-- Upload action: main button opens sidebar; sub-actions appear to the right when active -->
        @auth
        <li class="sidebar-item upload-parent" title="Upload" id="uploadParent">
            <button id="uploadPrimary" style="all:unset;display:flex;align-items:center;gap:12px;cursor:pointer;width:100%;padding:8px 0;">
                <div class="sidebar-icon"><img src="/images/icon/upload.png" alt="upload icon"></div>
                <div class="sidebar-label">Upload</div>
            </button>
            <div id="uploadActions" style="display:flex; position:static; background:transparent; display:flex; gap:8px; flex-direction:column; margin-top:8px;">
                <button onclick="showUpload('artwork')" class="btn" style= "background: #7BB63E; color: white">Karya</button>
                <button onclick="showUpload('article')" class="btn"style="background: #FF6600; color: white">Artikel</button>
            </div>
        </li>
        @else
        <li class="sidebar-item upload-parent" title="Upload" id="uploadParentGuest">
            <button id="uploadPrimaryGuest" style="all:unset;display:flex;align-items:center;gap:12px;cursor:pointer;width:100%;padding:8px 0;">
                <div class="sidebar-icon"><img src="/images/icon/upload.png" alt="upload icon"></div>
                <div class="sidebar-label">Upload</div>
            </button>
        </li>
        @endauth
     
        <li class="sidebar-item notification-trigger" title="Notification">
            <div class="sidebar-icon"><img src="/images/icon/notifikasi.png" alt="notification icon"></div>
            <div class="sidebar-label">Notification</div>
        </li>
    </ul>

    <!-- Notification Panel -->
    <div class="notification-panel" id="notificationPanel">
        <div class="notification-header">
            <h3>Notifications</h3>
            <img src="/images/back.png" alt="Close" id="closeNotification" style="width: 24px; height: 24px; cursor: pointer;">
        </div>
        <div class="notification-list" id="notificationList">
            <div class="no-notifications" id="noNotifications" style="color:#666; padding:12px">No notifications yet.</div>
        </div>
        <div style="display:flex; gap:8px; justify-content:flex-end; padding:8px;">
            <button id="clearNotifications" class="btn" type="button" style="background:#eee">Clear</button>
        </div>
    </div>

    <div style="flex:1"></div>

    <ul class="sidebar-list" style="margin-bottom:16px;">
        <li class="sidebar-item" title="Setting">
            <div class="sidebar-icon"><img src="/images/icon/setting.png" alt="setting icon"></div>
            <div class="sidebar-label">Setting</div>
        </li>
        <li class="sidebar-item" title="Help">
            <div class="sidebar-icon"><img src="/images/icon/help.png" alt="help icon"></div>
            <div class="sidebar-label">Help</div>
        </li>
        @auth
        <li class="sidebar-item" title="Logout">
            <form id="logoutFormSidebar" method="POST" action="/logout" style="display:flex;align-items:center;gap:10px;width:100%;">
                @csrf
                <button type="button" onclick="showLogoutModal('logoutFormSidebar')" style="all:unset;display:flex;align-items:center;gap:12px;cursor:pointer;width:100%;padding:8px 0;">
                    <div class="sidebar-icon"><img src="/images/icon/logout.png" alt="logout icon"></div>
                    <div class="sidebar-label">Logout</div>
                </button>
            </form>
        </li>
        @endauth
    </ul>
    @auth
    <!-- Upload Artwork Modal -->
    <div id="uploadArtworkModal" style="display:none; position:fixed; inset:0; align-items:center; justify-content:center; background:rgba(0,0,0,0.35); z-index:999;">
        <div style="background:white;padding:18px;border-radius:10px;max-width:760px;width:96%;">
            <h3>Upload Karya</h3>
            <form method="POST" action="{{ route('upload.artwork') }}" enctype="multipart/form-data">
                @csrf
                <div style="margin-top:8px"><label>Title</label><input name="title" required style="width:100%"></div>
                <div style="margin-top:8px"><label>Category</label>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;">
                        @php
                            $desired = ['graphic','illustration','photography','typography','uiux','identity','semua'];
                        @endphp
                        @foreach($desired as $slug)
                            @php $c = \App\Models\Category::where('slug', $slug)->first(); @endphp
                            @if($c)
                                <label style="display:flex;align-items:center;gap:6px;padding:8px 12px;border:1px solid #e0e0e0;border-radius:20px;cursor:pointer;background:#fff;transition:all 0.2s;">
                                    <input type="radio" name="category_id" value="{{ $c->id }}" style="cursor:pointer;">
                                    <span style="font-size:13px;">{{ $c->name }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div style="margin-top:8px"><label>Image</label><input type="file" name="image" accept="image/*" required style="width:100%"></div>
                <div style="margin-top:8px"><label>Description</label><textarea name="description" rows="4" style="width:100%"></textarea></div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
                    <button type="button" onclick="hideUpload('artwork')" class="btn">Draft</button>
                    <button class="btn" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Article Modal -->
    <div id="uploadArticleModal" style="display:none; position:fixed; inset:0; align-items:center; justify-content:center; background:rgba(0,0,0,0.35); z-index:999;">
        <div style="background:white;padding:18px;border-radius:10px;max-width:760px;width:96%;">
            <h3>Upload Artikel</h3>
            <form method="POST" action="{{ route('upload.article') }}" enctype="multipart/form-data">
                @csrf
                <div style="margin-top:8px"><label>Title</label><input name="title" required style="width:100%"></div>
                <div style="margin-top:8px;display:flex;gap:12px;align-items:center;"><div style="flex:1"><label>Cover Image (optional)</label><input type="file" name="image" accept="image/*"></div>
                </div>
                <div style="margin-top:8px"><label>Body</label><textarea name="body" rows="10" style="width:100%" required></textarea></div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
                    <button type="button" onclick="hideUpload('article')" class="btn">Draft</button>
                    <button class="btn" type="submit">Publish</button>
                </div>
            </form>
        </div>
    </div>
    @endauth

    <script>
        function showUpload(type){
            if(type === 'artwork') document.getElementById('uploadArtworkModal').style.display = 'flex';
            if(type === 'article') document.getElementById('uploadArticleModal').style.display = 'flex';
        }
        function hideUpload(type){
            if(type === 'artwork') document.getElementById('uploadArtworkModal').style.display = 'none';
            if(type === 'article') document.getElementById('uploadArticleModal').style.display = 'none';
        }
        // close on outside click
        document.addEventListener('click', function(e){
            var a = document.getElementById('uploadArtworkModal'); if(a && e.target === a) a.style.display = 'none';
            var b = document.getElementById('uploadArticleModal'); if(b && e.target === b) b.style.display = 'none';
        });
    </script>
    <script>
        // Toggle upload actions to the right of the Upload button
        (function(){
            const parent = document.getElementById('uploadParent');
            const actions = document.getElementById('uploadActions');
            if (!parent || !actions) return;
            parent.addEventListener('click', function(e){
                e.stopPropagation();
                const isShown = actions.style.display === 'flex' || actions.style.display === 'block';
                actions.style.display = isShown ? 'none' : 'flex';
                // ensure vertical layout
                actions.style.flexDirection = 'column';
            });

            document.addEventListener('click', function(e){
                if (!parent.contains(e.target)) actions.style.display = 'none';
            });
        })();
    </script>

    <script>
        // Notifications (sidebar-only, client-side)
        (function(){
            // expose current username and id (null when guest)
            window.CURRENT_USERNAME = @json(auth()->check() ? auth()->user()->username : null);
            window.CURRENT_USER_ID = @json(auth()->check() ? auth()->id() : null);

            const trigger = document.querySelector('.notification-trigger');
            const panel = document.getElementById('notificationPanel');
            const list = panel ? panel.querySelector('.notification-list') : null;
            const iconImg = document.querySelector('.notification-trigger .sidebar-icon img');
            let unseen = 0;

            function formatTimeAgo(ts){
                try {
                    const diff = Math.floor((Date.now() - (ts || Date.now()))/1000);
                    if (diff < 60) return diff + 's';
                    if (diff < 3600) return Math.floor(diff/60) + 'm';
                    if (diff < 86400) return Math.floor(diff/3600) + 'h';
                    return Math.floor(diff/86400) + 'd';
                } catch(e){ return '' }
            }

            function renderNotificationItem({ actor, action, title, t }){
                const item = document.createElement('div');
                item.className = 'notification-item';
                const avatar = document.createElement('div');
                avatar.className = 'notif-avatar';
                avatar.textContent = actor ? (actor.charAt(0).toUpperCase()) : '🔔';
                const content = document.createElement('div');
                content.className = 'notif-content';
                const h = document.createElement('p'); h.className = 'notif-title';
                h.textContent = (actor || 'Someone') + ' ' + (action === 'like' ? 'liked' : action === 'save' ? 'saved' : action === 'share' ? 'shared' : (action || 'interacted with')) + ' your work';
                const m = document.createElement('p'); m.className = 'notif-message';
                m.textContent = title ? ( '“' + title + '”') : (actor || 'Someone') + ' interacted with your artwork';
                const time = document.createElement('span'); time.className = 'notif-time'; time.textContent = formatTimeAgo(t);
                content.appendChild(h); content.appendChild(m); content.appendChild(time);
                item.appendChild(avatar); item.appendChild(content);
                return item;
            }

            function addNotification(n, options = { persist: true, markUnseen: true }){
                if (!list) return;
                const node = renderNotificationItem(n);

                // hide placeholder when first notification arrives
                const placeholder = document.getElementById('noNotifications');
                if (placeholder && placeholder.parentNode) placeholder.style.display = 'none';

                list.insertBefore(node, list.firstChild);
                // persist
                try {
                    if (options.persist) {
                        const stored = JSON.parse(localStorage.getItem('notifications') || '[]');
                        stored.unshift({ actor: n.actor, action: n.action, title: n.title, t: n.t });
                        // limit stored notifications
                        while (stored.length > 50) stored.pop();
                        localStorage.setItem('notifications', JSON.stringify(stored));
                    }
                } catch(e){ console.debug('persist-notification error', e); }

                if (options.markUnseen) {
                    unseen++;
                    try { localStorage.setItem('notifications_unseen', String(unseen)); } catch(e){}
                    if (iconImg) iconImg.src = '/images/icon/notifkasi-add.png';
                    console.log('notification added, unseen count', unseen, 'stored total', localStorage.getItem('notifications') ? JSON.parse(localStorage.getItem('notifications') || '[]').length : 0);
                }
            }

            // Clear notifications button
            const clearBtn = document.getElementById('clearNotifications');
            if (clearBtn) {
                clearBtn.addEventListener('click', function(){
                    try { localStorage.removeItem('notifications'); localStorage.setItem('notifications_unseen', '0'); } catch(e){}
                    // remove items in DOM
                    if (list) {
                        list.querySelectorAll('.notification-item').forEach(n => n.remove());
                        const placeholder = document.getElementById('noNotifications'); if (placeholder) placeholder.style.display = 'block';
                    }
                    unseen = 0;
                    if (iconImg) iconImg.src = '/images/icon/notifikasi.png';
                });
            }

            // Close button marks seen and hides panel
            const closeBtn = document.getElementById('closeNotification');
            if (closeBtn) {
                closeBtn.addEventListener('click', function(){
                    if (!panel) return;
                    panel.classList.remove('show');
                    try { localStorage.setItem('notifications_unseen', '0'); } catch(e){}
                    unseen = 0;
                    if (iconImg) iconImg.src = '/images/icon/notifikasi.png';
                });
            }

            if (trigger) {
                trigger.addEventListener('click', function(e){
                    e.stopPropagation();
                    if (!panel) return;
                    panel.classList.toggle('show');
                    // mark seen when opened
                    if (panel.classList.contains('show')){
                        unseen = 0;
                        if (iconImg) iconImg.src = '/images/icon/notifikasi.png';
                        // mark items as read by clearing stored unseen marker
                        try { localStorage.setItem('notifications_unseen', '0'); } catch(e){}
                    }
                });
            }

            // handle cross-tab events
            function handleArtworkAction(payload){
                if (!payload) return;
                const owner = payload.owner || payload.owner_username || payload.owner_id || null;
                const ownerId = payload.owner_id || null;
                const actor = payload.actor || payload.username || null;
                const action = payload.action || null;
                const title = payload.title || payload.cardTitle || null;
                const t = payload.t || Date.now();
                // only notify if current user is owner (match by username or id) and actor is someone else
                if (!window.CURRENT_USERNAME && !window.CURRENT_USER_ID) return;
                // determine whether payload targets the current user
                const targetsCurrentUser = (
                    (window.CURRENT_USERNAME && owner && owner === window.CURRENT_USERNAME)
                    || (window.CURRENT_USER_ID && (String(owner) === String(window.CURRENT_USER_ID) || String(ownerId) === String(window.CURRENT_USER_ID)))
                );
                if (!targetsCurrentUser) return;
                if (!action) return;
                if (actor && ((window.CURRENT_USERNAME && actor === window.CURRENT_USERNAME) || (window.CURRENT_USER_ID && String(actor) === String(window.CURRENT_USER_ID)))) return;
                addNotification({ actor, action, title, t }, { persist: true, markUnseen: true });
            }

            window.addEventListener('storage', function(e){
                if (!e.key) return;
                if (e.key !== 'artwork-action') return;
                try {
                    const payload = JSON.parse(e.newValue || e.oldValue || '{}');
                    console.log('storage received artwork-action', payload);
                    handleArtworkAction(payload);
                } catch (err){ console.debug('notification parse error', err); }
            });

            // Also listen for in-tab custom events dispatched when actions occur
            window.addEventListener('artwork-action', function(e){
                try { console.log('custom event received artwork-action', e.detail); handleArtworkAction(e.detail); } catch(err){ console.log('custom artwork-action error', err); }
            });

            // Hydrate notifications from storage on load
            try {
                const stored = JSON.parse(localStorage.getItem('notifications') || '[]');
                if (Array.isArray(stored) && stored.length) {
                    stored.slice().reverse().forEach(n => { addNotification(n, { persist: false, markUnseen: false }); });
                    // respect unseen marker
                    const unseenMarker = parseInt(localStorage.getItem('notifications_unseen') || '0');
                    if (unseenMarker > 0) { unseen = unseenMarker; if (iconImg) iconImg.src = '/images/icon/notifkasi-add.png'; }
                }
            } catch(e) { console.debug('hydrate notifications error', e); }

            // close panel when clicking outside
            document.addEventListener('click', function(e){ if (panel && panel.classList.contains('show') && !panel.contains(e.target) && (!trigger || !trigger.contains(e.target))) panel.classList.remove('show'); });
        })();
    </script>
</aside>