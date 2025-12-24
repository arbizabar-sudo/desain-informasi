<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<x-navbar></x-navbar>

<body>
  <div class="container">
    <x-sidebar />

    <div class="hero">
      <div class="overlay-text">
        <h1>Community Articles</h1>
        <p>Latest articles from creators.</p>
             </div>
    </div>

    @if(session('success'))
      <div style="background:#4caf50;color:white;padding:10px;border-radius:8px;margin:12px 0">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div style="background:#e53935;color:white;padding:10px;border-radius:8px;margin:12px 0">{{ session('error') }}</div>
    @endif

    <!-- Category filter removed per product request -->

    <div class="articles-wrap" style="padding:20px">
        <div class="articles-grid">
            @foreach($articles as $article)
                <article class="article-card">
                    @if($article->image_path)
                        <div class="article-media"><img src="{{ asset('storage/'.$article->image_path) }}" alt="{{ $article->title }}"></div>
                    @else
                        <div class="article-media placeholder"></div>
                    @endif

                    <div class="article-body">
                        <h3 class="article-title">{{ $article->title }}</h3>
                        <div class="article-meta">By 
                            @if($article->user)
                                @php $u=$article->user; $pid = $u->username ?: $u->id; @endphp
                                <a href="{{ route('profile.show', $pid) }}">{{ $u->username ?? $u->name }}</a>
                            @else
                                Unknown
                            @endif
                             • {{ $article->created_at->diffForHumans() }}</div>
                        <p class="article-excerpt">{{ Str::limit(strip_tags($article->body), 220) }}</p>
                        <div class="article-footer">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-read">Read more</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div style="margin-top:12px">{{ $articles->withQueryString()->links() }}</div>
    </div>

    <x-footer></x-footer>
  </div>

  <x-sidebar-assets />
</body>
</html>

<style>


        /* Hero Section */
        .hero {
            padding: 60px 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-image {
            background: #e0e0e0;
            height: 300px;
            border-radius: 15px;
            overflow: hidden;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Search Bar */
        .search-section {
            padding: 0 200px 40px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            padding: 12px 20px;
            border-radius: 25px;
            gap: 10px;
        }

        .search-bar input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 16px;
        }

        .search-icon {
            color: #666;
            cursor: pointer;
        }

body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
}



.hero-text {
  max-width: 500px;
}

.hero-text h1 {
  font-size: 3em;
  margin-bottom: 10px;
}

.hero-text p {
  font-size: 1.2em;
  margin-bottom: 20px;
}

.credit {
  font-size: 0.9em;
  opacity: 0.8;
}

/* Footer utama */
.site-footer {
  background: #ffffffff;padding:30px 40px;border-top:1px solid #dfdfdfff;font-family:inherit
}

/* Articles grid (inspired by explore portfolio layout) */
.articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    align-items: start;
}
.article-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    transition: transform 0.16s ease, box-shadow 0.16s ease;
}
.article-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(0,0,0,0.08); }
.article-media { width:100%; height:200px; overflow:hidden; background:#f0f0f0; }
.article-media img { width:100%; height:100%; object-fit:cover; display:block; }
.article-body { padding:14px; display:flex; flex-direction:column; gap:10px; flex:1; }
.article-title { margin:0; font-size:18px; color:#222; }
.article-meta { color:#666; font-size:13px; }
.article-excerpt { color:#333; margin:0; flex:1; line-height:1.45; }
.article-footer { display:flex; align-items:center; justify-content:space-between; margin-top:12px; }
.btn-read { background:#1a73e8; color:#fff; padding:8px 12px; border-radius:8px; text-decoration:none; }

@media (max-width:720px){
    .article-media { height:160px }
    .articles-grid { grid-template-columns: 1fr; }
}

