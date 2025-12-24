@extends('layout')

@section('content')
<x-sidebar />
<div class="profile-page container">
    <style>
        .profile-cover { width: 1200px; height:300px; background-size:cover; background-position:center; border-bottom-left-radius:48px; border-bottom-right-radius:48px; margin-bottom:46px; box-shadow: inset 0 -20px 60px rgba(0,0,0,0.02); }
        .profile-main { display:flex; gap:28px; align-items:flex-start; position:relative; }
        .profile-avatar { margin: -80px auto 0; width:160px; height:160px; border-radius:50%; overflow:hidden; border:8px solid white; background:#efefef; box-shadow:0 6px 18px rgba(0,0,0,0.08); }
        .profile-left { width:320px; }
        .profile-card { background:white; padding:20px; border-radius:12px; box-shadow:0 6px 24px rgba(10,10,10,0.03); }
        .profile-name { margin:0; font-size:20px; font-weight:700; }
        .profile-username { color:#666; margin-top:4px; }
        .profile-bio { margin-top:12px; color:#444; }
        .pills { display:flex; gap:8px; margin-top:12px; }
        .pill { background:#f2f2f2; padding:8px 12px; border-radius:999px; font-weight:600; font-size:13px; }
        .btn-pill { background:#fff; border:1px solid #e6e6e6; padding:8px 14px; border-radius:999px; display:inline-block; text-decoration:none; color:#222; }
        .profile-right { flex:1; }
        .tabs { display:flex; gap:18px; align-items:center; margin-bottom:12px; }
        .tab { font-weight:700; padding:8px 12px; border-radius:8px; cursor:pointer; }
        .tab.active { background:#fff; box-shadow:0 6px 18px rgba(0,0,0,0.04); }
        .chips { display:flex; gap:8px; margin:12px 0 18px; flex-wrap:wrap; }
        .chip { background:#fff; border:1px solid #eee; padding:8px 12px; border-radius:999px; font-size:13px; display:inline-flex; gap:8px; align-items:center; }
        .masonry { column-gap:18px; column-count:3; }
        .masonry .art-card { display:inline-block; width:100%; margin:0 0 18px; break-inside:avoid; background:white; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.03); }
        .art-card img { width:100%; height:auto; display:block; }
        .art-card .meta { padding:12px; }
        @media (max-width:1024px){ .masonry{ column-count:2 } .profile-avatar{ width:140px; height:140px; margin-top:-70px } }
        @media (max-width:720px){ .masonry{ column-count:1 } .profile-main{ flex-direction:column } .profile-left{ width:100%; margin-left:0 } .profile-avatar{ width:120px;height:120px; margin-top:-60px } }
        /* Modal styles */
        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.45); display:flex; align-items:center; justify-content:center; padding:20px; z-index:60 }
        .modal-card { background:white; border-radius:12px; padding:18px; width:820px; max-width:100%; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
        .modal-grid { display:flex; gap:18px; }
        .modal-left { width:160px; flex-shrink:0; display:flex; flex-direction:column; align-items:center; }
        .avatar-preview { width:120px; height:120px; border-radius:50%; overflow:hidden; background:#f0f0f0; border:1px solid #eee }
        .avatar-preview img { width:100%; height:100%; object-fit:cover; display:block }
        .upload-link { color:#1a73e8; cursor:pointer; display:inline-block; margin-top:8px }
        .modal-right { flex:1 }
        .modal-right input, .modal-right textarea { width:100%; padding:10px; border:1px solid #e6e6e6; border-radius:6px }
        .row-two { display:flex; gap:12px }
        .row-two input { width:100% }
    </style>

    <div class="profile-cover" id="profileCover" style="background-image: url('{{ $user->cover_image ? asset('storage/'.$user->cover_image) : '/images/default-cover.png' }}')"></div>

    @auth
        @if(auth()->id() === $user->id)
            <form id="coverUploadForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display:none">
                @csrf
                @method('PUT')
                <input id="coverInput" type="file" name="cover_image" accept="image/*">
            </form>
        @endif
    @endauth

    <div class="profile-main">
        <div class="profile-left">
            <div class="profile-avatar">
                <img src="{{ $user->avatar_url }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;display:block">
            </div>
            <div class="profile-card">
                <h2 class="profile-name">{{ $user->name ?? $user->username }}</h2>
                <div class="profile-username">{{ $user->role ? ucfirst($user->role) : '' }} {{ optional($user->created_at)->year ? optional($user->created_at)->year : '' }}</div>
                <div class="profile-bio">{{ $user->bio }}</div>

                {{-- Account info under avatar --}}
                <div style="margin-top:12px;">
                    @if($user->headline)
                        <div style="font-weight:700">{{ $user->headline }}</div>
                    @endif
                    @if($user->institution || $user->location)
                        <div style="color:#666; margin-top:6px">{{ $user->institution }}{{ $user->institution && $user->location ? ' · ' : '' }}{{ $user->location }}</div>
                    @endif
                    @if($user->website)
                        <div style="margin-top:6px"><a href="{{ $user->website }}" target="_blank" class="btn-pill">Website</a></div>
                    @endif
                </div>

                {{-- Edit profile info modal for owners --}}
                @auth
                    @if(auth()->id() === $user->id)
                        <div style="margin-top:12px">
                            <button id="openEditModal" class="btn-pill">Edit profile info</button>
                        </div>

                        <!-- Modal -->
                        <div id="editProfileModal" class="modal-overlay" style="display:none">
                            <div class="modal-card">
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="username" value="{{ $user->username }}">
                                    <div class="modal-grid">
                                        <div class="modal-left">
                                            <div id="modalCoverPreview" style="width:160px; height:90px; border-radius:8px; background-image: url('{{ $user->cover_image ? asset('storage/'.$user->cover_image) : '/images/default-cover.jpg' }}'); background-size:cover; background-position:center; margin-bottom:10px; border:1px solid #eee"></div>
                                            <div class="avatar-preview" style="width:120px; height:120px;">
                                                <img id="modalAvatarImg" src="{{ $user->avatar_url }}" alt="avatar">
                                            </div>
                                            <div style="margin-top:10px">
                                                <label class="upload-link" for="modalAvatarInput">Upload avatar</label>
                                                <input id="modalAvatarInput" type="file" name="avatar" accept="image/*" style="display:none">
                                            </div>
                                            <div style="margin-top:8px">
                                                <label class="upload-link" for="modalCoverInput">Upload cover</label>
                                                <input id="modalCoverInput" type="file" name="cover_image" accept="image/*" style="display:none">
                                            </div>
                                        </div>

                                        <div class="modal-right">
                                            <div>
                                                <label style="font-weight:700">Headline</label>
                                                <input name="headline" placeholder="Ex: Senior Designer, Art Director, Student" value="{{ old('headline', $user->headline) }}">
                                            </div>

                                            <div>
                                                <label style="font-weight:700">Institution</label>
                                                <input name="institution" placeholder="Institution" value="{{ old('institution', $user->institution) }}">
                                            </div>

                                            <div>
                                                <label style="font-weight:700">Location</label>
                                                <input name="location" placeholder="City or Country" value="{{ old('location', $user->location) }}">
                                            </div>

                                            <div>
                                                <label style="font-weight:700">URL</label>
                                                <input name="website" placeholder="https://..." value="{{ old('website', $user->website) }}">
                                            </div>

                                            <div style="display:flex; gap:8px; margin-top:12px">
                                                <button class="btn-pill" type="submit">Save</button>
                                                <button type="button" id="closeEditModal" class="btn-pill">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth

                <div class="pills">
                    <div class="pill"><strong>{{ $followersCount ?? 0 }}</strong>&nbsp;<span style="font-weight:400; color:#666; margin-left:8px">Followers</span></div>
                    <div class="pill"><strong>{{ $followingCount ?? 0 }}</strong>&nbsp;<span style="font-weight:400; color:#666; margin-left:8px">Following</span></div>
                </div>

                <div style="margin-top:12px">
                    @if($user->ig)
                        <a href="{{ $user->ig }}" target="_blank" class="btn-pill">Instagram</a>
                    @endif
                </div>

                <div style="margin-top:12px">
                    @auth
                        @if(auth()->id() !== $user->id)
                            <form method="POST" action="{{ $isFollowing ? route('profile.unfollow',$user->username) : route('profile.follow',$user->username) }}">
                                @csrf
                                <button class="btn-pill">{{ $isFollowing ? 'Unfollow' : 'Follow' }}</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="profile-right">
            <div class="tabs">
                <div class="tab active" data-tab="work">Work</div>
                <div class="tab" data-tab="saved">Saved</div>
                <div class="tab" data-tab="liked">Liked</div>
                <div class="tab" data-tab="articles">Articles</div>
            </div>

            <div class="tab-content" id="tab-work">
                <div class="masonry">
                    @foreach($artworks as $art)
                        <div class="art-card">
                            @php
                                $imgSrc = $art->image_path ? asset('storage/'.$art->image_path) : '';
                                $creatorUsername = optional($art->user)->username ?? optional($art->user)->name ?? '';
                                $creatorName = optional($art->user)->name ?? optional($art->user)->username ?? '';
                                $creatorAvatar = optional($art->user)->avatar_url ?? '/images/icon/profil.png';
                                $likeCount = is_object($art) && method_exists($art, 'likedBy') ? $art->likedBy()->count() : 0;
                                $saveCount = is_object($art) && method_exists($art, 'savedBy') ? $art->savedBy()->count() : 0;
                                $shareCount = $art->share_count ?? 0;
                            @endphp
                                <img src="{{ $imgSrc }}" alt="{{ $art->title }}" class="thumbnail"
                                    data-title="{{ $art->title ?? '' }}"
                                    data-desc="{{ $art->description ?? '' }}"
                                    data-creator-name="{{ $creatorName }}"
                                    data-creator-username="{{ $creatorUsername }}"
                                    data-creator-id="{{ optional($art->user)->id ?? '' }}"
                                    data-creator-id="{{ optional($art->user)->id ?? '' }}"
                                    data-creator-url="{{ $creatorUsername ? route('profile.show', $creatorUsername) : ($art->user?->id ? route('profile.show', $art->user->id) : '') }}"
                                    data-artwork-desc="{{ $art->description ?? '' }}"
                                    data-date="{{ isset($art->created_at) ? $art->created_at->diffForHumans() : '' }}"
                                    data-avatar="{{ $creatorAvatar }}"
                                    data-creator-role="{{ optional($art->user)->role ?? '' }}"
                                    data-artwork-id="{{ $art->id }}"
                                    data-like-count="{{ $likeCount }}"
                                    data-save-count="{{ $saveCount }}"
                                    data-share-count="{{ $shareCount }}"
                                    data-can-delete="{{ auth()->check() && auth()->id() === $art->user_id ? '1' : '0' }}"
                                    data-delete-url="{{ route('profile.artworks.destroy', $art->id) }}"
                                >
                            <div class="meta">
                                <div style="font-weight:700">{{ $art->title }}</div>
                                <div style="font-size:13px; color:#666">{{ $art->category?->name }}</div>
                            </div>
                            <div class="portfolio-meta" style="display:flex;gap:8px;align-items:center;margin-top:8px;">
                                <span class="thumb-like" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/like.png" alt="like" style="width:16px;height:16px"/>
                                    <span class="thumb-like-count">{{ $likeCount }}</span>
                                </span>
                                <span class="thumb-save" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/love.png" alt="save" style="width:16px;height:16px"/>
                                    <span class="thumb-save-count">{{ $saveCount }}</span>
                                </span>
                                <span class="thumb-share" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/share.png" alt="share" style="width:16px;height:16px"/>
                                    <span class="thumb-share-count">{{ $shareCount }}</span>
                                </span>
                            </div>
                        </div>
                @endforeach
                </div>

                <div style="margin-top:12px">{{ $artworks->withQueryString()->links() }}</div>
            </div>

            <div class="tab-content" id="tab-saved" style="display:none">
                <div class="masonry">
                    @foreach($saved as $art)
                        <div class="art-card">
                            <img src="{{ $art->image_path ? asset('storage/'.$art->image_path) : '' }}" alt="{{ $art->title }}" class="thumbnail"
                                data-artwork-id="{{ $art->id }}"
                                data-title="{{ $art->title ?? '' }}"
                                data-desc="{{ $art->description ?? '' }}"
                                data-creator-name="{{ optional($art->user)->name ?? optional($art->user)->username ?? '' }}"
                                data-creator-id="{{ optional($art->user)->id ?? '' }}"
                                data-creator-url="{{ optional($art->user)->username ? route('profile.show', optional($art->user)->username) : (optional($art->user)->id ? route('profile.show', optional($art->user)->id) : '') }}"
                                data-creator-username="{{ optional($art->user)->username ?? '' }}"
                                data-avatar="{{ optional($art->user)->avatar_url ?? '/images/icon/profil.png' }}"
                                data-like-count="{{ $art->likedBy()->count() }}"
                                data-save-count="{{ $art->savedBy()->count() }}"
                                data-share-count="{{ $art->share_count ?? 0 }}">
                            <div class="meta">
                                <div style="font-weight:700">{{ $art->title }}</div>
                                <div style="font-size:13px; color:#666">{{ $art->category?->name }}</div>
                            </div>
                            <div class="portfolio-meta" style="display:flex;gap:8px;align-items:center;margin-top:8px;">
                                <span class="thumb-like" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/like.png" alt="like" style="width:16px;height:16px"/>
                                    <span class="thumb-like-count">{{ $art->likedBy()->count() }}</span>
                                </span>
                                <span class="thumb-save" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/love.png" alt="save" style="width:16px;height:16px"/>
                                    <span class="thumb-save-count">{{ $art->savedBy()->count() }}</span>
                                </span>
                                <span class="thumb-share" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/share.png" alt="share" style="width:16px;height:16px"/>
                                    <span class="thumb-share-count">{{ $art->share_count ?? 0 }}</span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:12px">{{ $saved->withQueryString()->links() }}</div>
            </div>

            <div class="tab-content" id="tab-liked" style="display:none">
                <div class="masonry">
                    @foreach($liked as $art)
                        <div class="art-card">
                            <img src="{{ $art->image_path ? asset('storage/'.$art->image_path) : '' }}" alt="{{ $art->title }}" class="thumbnail"
                                data-artwork-id="{{ $art->id }}"
                                data-title="{{ $art->title ?? '' }}"
                                data-desc="{{ $art->description ?? '' }}"
                                data-creator-name="{{ optional($art->user)->name ?? optional($art->user)->username ?? '' }}"
                                data-creator-id="{{ optional($art->user)->id ?? '' }}"
                                data-creator-url="{{ optional($art->user)->username ? route('profile.show', optional($art->user)->username) : (optional($art->user)->id ? route('profile.show', optional($art->user)->id) : '') }}"
                                data-creator-username="{{ optional($art->user)->username ?? '' }}"
                                data-avatar="{{ optional($art->user)->avatar_url ?? '/images/icon/profil.png' }}"
                                data-like-count="{{ $art->likedBy()->count() }}"
                                data-save-count="{{ $art->savedBy()->count() }}"
                                data-share-count="{{ $art->share_count ?? 0 }}">
                            <div class="meta">
                                <div style="font-weight:700">{{ $art->title }}</div>
                                <div style="font-size:13px; color:#666">{{ $art->category?->name }}</div>
                            </div>
                            <div class="portfolio-meta" style="display:flex;gap:8px;align-items:center;margin-top:8px;">
                                <span class="thumb-like" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/like.png" alt="like" style="width:16px;height:16px"/>
                                    <span class="thumb-like-count">{{ $art->likedBy()->count() }}</span>
                                </span>
                                <span class="thumb-save" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/love.png" alt="save" style="width:16px;height:16px"/>
                                    <span class="thumb-save-count">{{ $art->savedBy()->count() }}</span>
                                </span>
                                <span class="thumb-share" style="display:flex;align-items:center;gap:6px;">
                                    <img src="/images/icon/share.png" alt="share" style="width:16px;height:16px"/>
                                    <span class="thumb-share-count">{{ $art->share_count ?? 0 }}</span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:12px">{{ $liked->withQueryString()->links() }}</div>
            </div>

            <div class="tab-content" id="tab-articles" style="display:none">
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px">
                    @foreach($articles as $article)
                        <div class="article-card" data-article-id="{{ $article->id }}" style="background:white;border-radius:8px;overflow:hidden; padding:12px">
                            @if($article->image_path)
                                <img src="{{ asset('storage/'.$article->image_path) }}" style="width:100%;height:180px;object-fit:cover">
                            @endif
                            <h3 style="margin:0">{{ $article->title }}</h3>
                            <div style="color:#666;font-size:13px">{{ $article->created_at->diffForHumans() }}</div>
                            <p style="margin-top:8px;color:#333">{{ Str::limit(strip_tags($article->body), 180) }}</p>
                            <a href="{{ route('articles.show', $article->id) }}" class="btn">Read more</a>
                            @auth
                                @if(auth()->id() === $article->user_id)
                                    <form method="POST" action="{{ route('articles.destroy', $article->id) }}" class="article-delete-form" data-ajax="true" style="display:inline-block; margin-left:8px;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn delete-btn" type="button" style="background:#e53935;color:white;border:none;">Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:12px">{{ $articles->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</div>
<!-- Confirm delete modal (reused on profile/article pages) -->
<div id="confirmDeleteModal" style="display:none;position:fixed;inset:0;align-items:center;justify-content:center;background:rgba(0,0,0,0.35);z-index:999;">
    <div style="background:white;padding:20px;border-radius:10px;max-width:420px;width:90%;box-shadow:0 10px 30px rgba(0,0,0,0.12);">
        <h3 style="margin:0 0 8px 0;font-size:18px;color:#333">Konfirmasi Hapus</h3>
        <p id="confirmDeleteText" style="margin:0 0 16px 0;color:#555">Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button id="cancelDeleteBtn" style="padding:8px 14px;border-radius:6px;border:1px solid #ddd;background:#fff;cursor:pointer;">Batal</button>
            <button id="confirmDeleteBtn" style="padding:8px 14px;border-radius:6px;border:none;background:#e53935;color:#fff;cursor:pointer;">Hapus</button>
        </div>
    </div>
</div>

<!-- Artwork detail modal (same structure as explore) -->
<div id="frameModal" class="modal" style="display:none; position:fixed; inset:0; align-items:center; justify-content:center; background:rgba(0,0,0,0.45); z-index:999;">
    <div class="modal-content" style="background:white; width:90%; max-width:980px; border-radius:12px; padding:18px; display:flex; gap:18px;">
        <div class="modal-left" style="flex:1">
            <img id="modalImage" src="" alt="Artwork" style="width:100%; border-radius:10px; max-height:400px; object-fit:cover;">
            <div id="modalDate" style="color:#888; font-size:12px; margin-top:8px"></div>
        </div>
        <div class="modal-right" style="width:360px; display:flex; flex-direction:column; gap:8px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px; position:relative; padding-right:40px;">
                <img id="modalAvatar" src="/images/icon/profil.png" alt="Avatar" style="width:50px; height:50px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                <div style="display:flex; flex-direction:column;">
                    <a id="modalCreatorLink" href="#" style="text-decoration:none; color:inherit">
                        <div id="modalCreatorName" style="font-weight:700"></div>
                        <div id="modalCreatorUsername" style="color:#666; font-size:13px"></div>
                    </a>
                </div>

                <!-- Close button -->
                <button class="modal-close" aria-label="Tutup modal" style="position:absolute; top:-10px; right:-10px; background:transparent; border:none; padding:0; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    <img src="/images/back.png" alt="Tutup" style="width:28px; height:28px; object-fit:contain;">
                </button>
            </div>

            <div style="flex:1">
                <strong id="modalTitle" class="modal-title"></strong>
                <p id="modalArtworkDesc" class="modal-artwork-desc" style="margin-top:8px; color:#444">Deskripsi karya akan ditampilkan di sini.</p>
            </div>
            <!-- Interaction buttons -->
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
            </div>
            <!-- Delete form (hidden by default, shown only when owner) -->
            <form id="modalDeleteForm" method="POST" action="#" data-ajax="true" style="display:none; margin-top:10px;">
                @csrf
                @method('DELETE')
                <button id="modalDeleteBtn" type="button" class="btn-pill delete-btn" style="background:#e53935; color:white; border:none;">Delete artwork</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Modal open/close
        const openBtn = document.getElementById('openEditModal');
        const modal = document.getElementById('editProfileModal');
        const closeBtn = document.getElementById('closeEditModal');
        if(openBtn && modal){
            openBtn.addEventListener('click', ()=> { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; });
        }
        if(closeBtn && modal){
            closeBtn.addEventListener('click', ()=> { modal.style.display = 'none'; document.body.style.overflow = ''; });
        }
        // close when clicking outside modal-card
        if(modal){
            modal.addEventListener('click', function(e){ if(e.target === modal){ modal.style.display = 'none'; document.body.style.overflow = ''; } });
        }

        // Avatar preview in modal
        const avatarInput = document.getElementById('modalAvatarInput');
        const avatarImg = document.getElementById('modalAvatarImg');
        if(avatarInput && avatarImg){
            avatarInput.addEventListener('change', function(){
                const f = this.files[0];
                if(!f) return;
                const reader = new FileReader();
                reader.onload = function(ev){ avatarImg.src = ev.target.result; };
                reader.readAsDataURL(f);
            });
        }

        // Cover preview in modal
        const modalCoverInput = document.getElementById('modalCoverInput');
        const modalCoverPreview = document.getElementById('modalCoverPreview');
        if (modalCoverInput && modalCoverPreview) {
            modalCoverInput.addEventListener('change', function(){
                const f = this.files[0];
                if(!f) return;
                const reader = new FileReader();
                reader.onload = function(ev){ modalCoverPreview.style.backgroundImage = 'url(' + ev.target.result + ')'; };
                reader.readAsDataURL(f);
            });
        }

        // cover click -> open file input (only if form exists)
        const cover = document.getElementById('profileCover');
        const coverInput = document.getElementById('coverInput');
        const coverForm = document.getElementById('coverUploadForm');
        if(cover && coverInput && coverForm){
            cover.style.cursor = 'pointer';
            cover.addEventListener('click', ()=> coverInput.click());
            coverInput.addEventListener('change', ()=> {
                if(coverInput.files.length) coverForm.submit();
            });
        }

        // Artwork modal (for thumbnails on this page)
        const thumbnails = document.querySelectorAll('.thumbnail');
        const frameModal = document.getElementById('frameModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalArtworkDesc = document.getElementById('modalArtworkDesc');
        const modalDate = document.getElementById('modalDate');
        const closeBtnArt = document.querySelector('.modal-close');

        // shared modal state and handlers (aligned with Explore modal behavior)
        let currentImg = null;
        const modalLikeBtn = document.getElementById('modalLikeBtn');
        const modalSaveBtn = document.getElementById('modalSaveBtn');
        const modalShareBtn = document.getElementById('modalShareBtn');
        const modalLikeCount = document.getElementById('modalLikeCount');
        const modalSaveCount = document.getElementById('modalSaveCount');
        const modalShareCount = document.getElementById('modalShareCount');

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

        const CSRF_TOKEN = (document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content')) || '';
        const XSRF_TOKEN_COOKIE = (function(){ const m = document.cookie.match(new RegExp('(^|; )' + 'XSRF-TOKEN' + '=([^;]*)')); return m ? decodeURIComponent(m[2]) : ''; })();

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

        async function handleLikeClick(e){
            e.preventDefault();
            if (!currentImg) return;
            const artId = currentImg.dataset.artworkId;
            if (modalLikeBtn.dataset.pending === '1') { console.debug('profile like ignored - pending', artId); return; }
            modalLikeBtn.dataset.pending = '1';

            const beforeCount = parseInt(currentImg.dataset.likeCount || '0');
            const wasActive = modalLikeBtn.classList.contains('active');
            const pendingLiked = !wasActive;
            const pendingCount = beforeCount + (pendingLiked ? 1 : -1);
            if (modalLikeCount) modalLikeCount.textContent = pendingCount ?? '';
            modalLikeBtn.classList.toggle('active', pendingLiked);
            setIconState(modalLikeBtn, pendingLiked, 'like');
            try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = pendingCount ?? ''; } catch (e){ console.debug('thumb optimistic like error', e); }

            try {
                const payload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
                const res = await fetch('/artworks/' + artId + '/like', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: payload });
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
                try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = finalCount ?? ''; } catch (e){}
                try { const card = currentImg && (currentImg.closest('.art-card') || currentImg.closest('.portfolio-item')); const cardHtml = card ? card.outerHTML : null; const owner_username = currentImg?.dataset?.creatorUsername || null; const owner_id = currentImg?.dataset?.creatorId || null; const owner = owner_username || owner_id || null; const actor = window.CURRENT_USERNAME || null; const title = currentImg?.dataset?.title || null; const broadcast = { id: artId, action: 'like', state: !!finalLiked, cardHtml: cardHtml, owner, owner_username, owner_id, actor, title, t: Date.now() }; console.log('broadcast artwork-action', broadcast); localStorage.setItem('artwork-action', JSON.stringify(broadcast)); try { window.dispatchEvent(new CustomEvent('artwork-action', { detail: broadcast })); } catch(e) {} setTimeout(()=> localStorage.removeItem('artwork-action'), 600); } catch(e) {}
            } catch (err) {
                console.debug('profile like handler error', err);
                if (modalLikeCount) modalLikeCount.textContent = beforeCount ?? '';
                modalLikeBtn.classList.toggle('active', wasActive);
                setIconState(modalLikeBtn, wasActive, 'like');
                try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const lc = container?.querySelector('.thumb-like-count'); if (lc) lc.textContent = beforeCount ?? ''; } catch (e){}
            } finally { modalLikeBtn.dataset.pending = '0'; }
        }

        async function handleSaveClick(e){
            e.preventDefault();
            if (!currentImg) return;
            const artId = currentImg.dataset.artworkId;
            if (modalSaveBtn.dataset.pending === '1') { console.debug('profile save ignored - pending', artId); return; }
            modalSaveBtn.dataset.pending = '1';

            const beforeCount = parseInt(currentImg.dataset.saveCount || '0');
            const wasActive = modalSaveBtn.classList.contains('active');
            const pendingSaved = !wasActive;
            const pendingCount = beforeCount + (pendingSaved ? 1 : -1);
            if (modalSaveCount) modalSaveCount.textContent = pendingCount ?? '';
            modalSaveBtn.classList.toggle('active', pendingSaved);
            setIconState(modalSaveBtn, pendingSaved, 'save');
            try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = pendingCount ?? ''; } catch (e){ console.debug('thumb optimistic save error', e); }

            try {
                const payload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
                const res = await fetch('/artworks/' + artId + '/save', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: payload });
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
                setIconState(modalSaveBtn, finalSaved, 'save');
                try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = finalCount ?? ''; } catch (e){}
                try { const card = currentImg && (currentImg.closest('.art-card') || currentImg.closest('.portfolio-item')); const cardHtml = card ? card.outerHTML : null; const owner_username = currentImg?.dataset?.creatorUsername || null; const owner_id = currentImg?.dataset?.creatorId || null; const owner = owner_username || owner_id || null; const actor = window.CURRENT_USERNAME || null; const title = currentImg?.dataset?.title || null; const broadcast = { id: artId, action: 'save', state: !!finalSaved, cardHtml: cardHtml, owner, owner_username, owner_id, actor, title, t: Date.now() }; console.log('broadcast artwork-action', broadcast); localStorage.setItem('artwork-action', JSON.stringify(broadcast)); try { window.dispatchEvent(new CustomEvent('artwork-action', { detail: broadcast })); } catch(e) {} setTimeout(()=> localStorage.removeItem('artwork-action'), 600); } catch(e) {}
            } catch (err) {
                console.debug('profile save handler error', err);
                if (modalSaveCount) modalSaveCount.textContent = beforeCount ?? '';
                modalSaveBtn.classList.toggle('active', wasActive);
                setIconState(modalSaveBtn, wasActive, 'save');
                try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-save-count'); if (sc) sc.textContent = beforeCount ?? ''; } catch (e){}
            } finally { modalSaveBtn.dataset.pending = '0'; }
        }

        async function handleShareClick(e){
            e.preventDefault();
            if (!currentImg) return;
            const artId = currentImg.dataset.artworkId;
            const url = window.location.origin + '/artworks/' + artId;
            if (modalShareBtn.dataset.pending === '1') { console.debug('profile share ignored - pending', artId); return; }
            modalShareBtn.dataset.pending = '1';

        const beforeCount = parseInt(currentImg.dataset.shareCount || '0');
        const pendingCount = beforeCount + 1;
        if (modalShareCount) modalShareCount.textContent = pendingCount ?? '';
        setIconState(modalShareBtn, true, 'share');
        try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = pendingCount ?? ''; } catch (e){ console.debug('thumb optimistic share error', e); }

        try {
            try { if (navigator.share) { await navigator.share({ title: currentImg.dataset.title || 'Artwork', url }); } else if (navigator.clipboard && navigator.clipboard.writeText) { await navigator.clipboard.writeText(url); alert('Link disalin ke clipboard'); } else { prompt('Salin link ini:', url); } } catch (e) { /* ignore */ }
            const sharePayload = JSON.stringify({ _token: CSRF_TOKEN || XSRF_TOKEN_COOKIE });
            const res = await fetch('/artworks/' + artId + '/share', { method: 'POST', credentials: 'include', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'X-XSRF-TOKEN': (CSRF_TOKEN || XSRF_TOKEN_COOKIE), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: sharePayload });
            const d = await parseJsonIfPossible(res);
            if (!res.ok) { alert('Gagal mencatat share'); if (modalShareCount) modalShareCount.textContent = beforeCount ?? ''; try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = beforeCount ?? ''; } catch (e){}; return; }
            const finalCount = (d && d.share_count !== undefined) ? d.share_count : pendingCount;
            if (modalShareCount) modalShareCount.textContent = finalCount ?? '';
            currentImg.dataset.shareCount = finalCount ?? '';
            setIconState(modalShareBtn, true, 'share');
            try { const container = currentImg.closest('.portfolio-item') || currentImg.closest('.art-card'); const sc = container?.querySelector('.thumb-share-count'); if (sc) sc.textContent = finalCount ?? ''; } catch (e){ console.debug('thumb sync share error', e); }
            try { const card = currentImg && (currentImg.closest('.art-card') || currentImg.closest('.portfolio-item')); const cardHtml = card ? card.outerHTML : null; const owner_username = currentImg?.dataset?.creatorUsername || null; const owner_id = currentImg?.dataset?.creatorId || null; const owner = owner_username || owner_id || null; const actor = window.CURRENT_USERNAME || null; const title = currentImg?.dataset?.title || null; const broadcast = { id: artId, action: 'share', state: true, cardHtml: cardHtml, owner, owner_username, owner_id, actor, title, t: Date.now() }; console.log('broadcast artwork-action', broadcast); localStorage.setItem('artwork-action', JSON.stringify(broadcast)); try { window.dispatchEvent(new CustomEvent('artwork-action', { detail: broadcast })); } catch(e) {} setTimeout(()=> localStorage.removeItem('artwork-action'), 600); } catch(e) {}
        } catch (err) { console.debug('profile share handler error', err); if (modalShareCount) modalShareCount.textContent = beforeCount ?? ''; setIconState(modalShareBtn, false, 'share'); } finally { modalShareBtn.dataset.pending = '0'; }
        }

        if (modalLikeBtn) modalLikeBtn.addEventListener('click', handleLikeClick);
        if (modalSaveBtn) modalSaveBtn.addEventListener('click', handleSaveClick);
        if (modalShareBtn) modalShareBtn.addEventListener('click', handleShareClick);

        function thumbnailClickHandler() {
            const img = this;
            if(!frameModal) return;
            frameModal.style.display = 'flex';
            modalImage.src = img.src;
            modalTitle.textContent = img.dataset.title || '';
            // populate creator info with fallbacks
            const avatarEl = document.getElementById('modalAvatar');
            if (avatarEl) avatarEl.src = img.dataset.avatar || '/images/icon/profil.png';
            const creatorName = img.dataset.creatorName || img.getAttribute('alt') || '';
            const creatorNameEl = document.getElementById('modalCreatorName');
            if (creatorNameEl) creatorNameEl.textContent = creatorName;
            const creatorUsername = img.dataset.creatorUsername || '';
            const creatorUsernameEl = document.getElementById('modalCreatorUsername');
            if (creatorUsernameEl) creatorUsernameEl.textContent = creatorUsername ? ('@' + creatorUsername) : '';
            // set profile link if available
            const creatorUrl = img.dataset.creatorUrl || '';
            const creatorLink = document.getElementById('modalCreatorLink');
            if(creatorLink){
                if(creatorUrl){
                    creatorLink.href = creatorUrl;
                } else {
                    creatorLink.removeAttribute('href');
                }
            }
            const descEl = document.getElementById('modalArtworkDesc');
            if(descEl) descEl.textContent = img.dataset.artworkDesc || 'Deskripsi karya belum tersedia.';
            if(modalDate) modalDate.textContent = img.dataset.date || '';

            // handle delete button visibility and action
            const canDelete = img.dataset.canDelete === '1';
            const deleteForm = document.getElementById('modalDeleteForm');
            const modalDeleteBtn = document.getElementById('modalDeleteBtn');
            if (deleteForm) {
                if (canDelete) {
                    deleteForm.style.display = 'block';
                    const deleteUrl = img.dataset.deleteUrl || '#';
                    deleteForm.action = deleteUrl;
                    // mark for AJAX delete and wire modal button to open confirmation modal
                    deleteForm.dataset.ajax = 'true';
                    if (modalDeleteBtn) {
                        modalDeleteBtn.type = 'button';
                        modalDeleteBtn.classList.add('delete-btn');
                        modalDeleteBtn.onclick = function(e){
                            // close the artwork modal first, then open confirmation modal
                            const fm = document.getElementById('frameModal');
                            if (fm && fm.style.display && fm.style.display !== 'none') fm.style.display = 'none';
                            // set pending form and open confirmation modal
                            window._pendingDeleteForm = deleteForm;
                            const m = document.getElementById('confirmDeleteModal'); if (m) m.style.display = 'flex';
                        };
                    }
                } else {
                    deleteForm.style.display = 'none';
                }
            }

            // add like/save/share controls and set counts (buttons are handled by shared handlers)

            // initialize counts from dataset
            if (modalLikeCount) modalLikeCount.textContent = img.dataset.likeCount || '0';
            if (modalSaveCount) modalSaveCount.textContent = img.dataset.saveCount || '0';
            if (modalShareCount) modalShareCount.textContent = img.dataset.shareCount || '0';

            // add like/save/share controls and set counts (use global handlers like Explore)
            currentImg = img;
            if (modalLikeCount) modalLikeCount.textContent = img.dataset.likeCount || '0';
            if (modalSaveCount) modalSaveCount.textContent = img.dataset.saveCount || '0';
            if (modalShareCount) modalShareCount.textContent = img.dataset.shareCount || '0';
            // set active states and icons
            if (modalLikeBtn) { modalLikeBtn.classList.toggle('active', (img.dataset.liked === '1' || img.dataset.liked === 'true')); setIconState(modalLikeBtn, modalLikeBtn.classList.contains('active'), 'like'); modalLikeBtn.dataset.pending = '0'; }
            if (modalSaveBtn) { modalSaveBtn.classList.toggle('active', (img.dataset.saved === '1' || img.dataset.saved === 'true')); setIconState(modalSaveBtn, modalSaveBtn.classList.contains('active'), 'save'); modalSaveBtn.dataset.pending = '0'; }
            if (modalShareBtn) { setIconState(modalShareBtn, false, 'share'); modalShareBtn.dataset.pending = '0'; }
        }

        thumbnails.forEach(img => img.addEventListener('click', thumbnailClickHandler));
        if (closeBtnArt) closeBtnArt.addEventListener('click', function(e){ e.stopPropagation(); if(frameModal) frameModal.style.display = 'none'; });
        window.onclick = e => { if (e.target === frameModal) frameModal.style.display = 'none'; };

        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        tabs.forEach(t => t.addEventListener('click', function(){
            const which = this.dataset.tab || 'work';
            tabs.forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            tabContents.forEach(tc => tc.style.display = (tc.id === 'tab-'+which) ? '' : 'none');
        }));
        // Modal-driven delete flow: show modal on delete button click, confirm to proceed
        window._pendingDeleteForm = null;
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e){
                const form = this.closest('.article-delete-form') || this.closest('#modalDeleteForm') || document.getElementById('modalDeleteForm');
                if (!form) return;
                // close artwork modal if open before showing confirmation
                const fm = document.getElementById('frameModal');
                if (fm && fm.style.display && fm.style.display !== 'none') fm.style.display = 'none';
                window._pendingDeleteForm = form;
                const m = document.getElementById('confirmDeleteModal');
                if (m) m.style.display = 'flex';
            });
        });

        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', function(){ const m = document.getElementById('confirmDeleteModal'); if (m) m.style.display = 'none'; window._pendingDeleteForm = null; });
        if (confirmDeleteBtn) confirmDeleteBtn.addEventListener('click', async function(){
            const m = document.getElementById('confirmDeleteModal');
            if (! window._pendingDeleteForm) return; 
            const form = window._pendingDeleteForm;
            // if form is marked for AJAX, perform fetch and remove tile; otherwise submit normally
            if (form.dataset.ajax === 'true') {
                try {
                    const res = await fetch(form.action, {
                        method: 'DELETE',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (res.ok) {
                        const wrapper = form.closest('.article-card') || form.closest('.art-card');
                        if (wrapper) wrapper.remove();
                        // also close artwork modal if open
                        const fm = document.getElementById('frameModal'); if (fm) fm.style.display = 'none';
                        showFlash('Artikel berhasil dihapus');
                    } else if (res.status === 403) {
                        showFlash('Tidak diizinkan.');
                    } else {
                        showFlash('Gagal menghapus artikel');
                    }
                } catch (err) {
                    console.error('Delete error', err);
                    showFlash('Terjadi kesalahan, coba lagi');
                }
            } else {
                // normal form submit
                form.submit();
            }
            if (m) m.style.display = 'none';
            _pendingDeleteForm = null;
        });

        // simple transient flash helper
        function showFlash(msg) {
            const f = document.createElement('div');
            f.textContent = msg;
            f.style.position = 'fixed';
            f.style.right = '20px';
            f.style.top = '20px';
            f.style.background = '#111';
            f.style.color = '#fff';
            f.style.padding = '10px 14px';
            f.style.borderRadius = '6px';
            f.style.boxShadow = '0 6px 18px rgba(0,0,0,0.2)';
            f.style.zIndex = 1200;
            document.body.appendChild(f);
            setTimeout(()=>{ f.style.opacity = '0'; setTimeout(()=>f.remove(), 300); }, 2000);
        }    });
</script>
@endsection
