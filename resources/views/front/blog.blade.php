<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Blog | Cloud Engineer</title>
    <link rel="stylesheet" href="/assets/css/style-modern.css">
    <link rel="stylesheet" href="/assets/css/terminal-mode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>
<body class="dark-theme" style="background: #0f172a; overflow-y: auto;">
    <div class="aurora-bg"></div>

    <header class="app-header scrolled" style="position: fixed; top: 0; width: 100%; z-index: 1000; background: rgba(15, 23, 42, 0.9);">
        <div class="logo"><a href="/" style="color: inherit; text-decoration: none;">user@cloud-env:~$</a></div>
        <nav class="main-nav">
            <a href="/" class="nav-btn" style="text-decoration: none;"><span class="i18n" data-en="Home" data-ar="الرئيسية">Home</span></a>
            <button class="nav-btn active"><span class="i18n" data-en="Blog" data-ar="المدونة">Blog</span></button>
        </nav>
        <div class="nav-actions">
            <button id="btn-lang-toggle" style="background: transparent; color: var(--accent-color); border: 1px solid var(--accent-color); padding: 5px 10px; border-radius: 4px; cursor: pointer; font-family: inherit;">العربية</button>
        </div>
    </header>

    <main style="padding-top: 120px; min-height: 100vh; position: relative; z-index: 10;">
        <div class="grid-container" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
            <div style="grid-column: 1 / -1; margin-bottom: 20px;">
                <h1 style="color: var(--accent-color); font-size: 2.5em; margin: 0;" class="i18n" data-en="Technical Articles & Insights" data-ar="المقالات التقنية">Technical Articles & Insights</h1>
                <p style="color: #94a3b8; font-size: 1.1em;" class="i18n" data-en="Deep dives into Cloud Architecture, DevOps, and automation." data-ar="تغطية متعمقة لهندسة السحابة وعمليات التطوير والأتمتة.">Deep dives into Cloud Architecture, DevOps, and automation.</p>
            </div>

            @forelse($articles as $article)
                <a href="{{ route('blog.article', $article->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="project-card reveal-up" style="height: 100%; display: flex; flex-direction: column;">
                        @if($article->image_url)
                            <div class="project-img-slider" style="height: 200px;">
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @else
                            <div class="project-thumbnail" style="height: 200px; background: linear-gradient(135deg, var(--bg-color), var(--card-bg)); display: flex; align-items: center; justify-content: center; color: var(--accent-color); font-size: 4em;"><i class="fa-solid fa-file-code"></i></div>
                        @endif
                        <div class="project-card-content" style="flex: 1; display: flex; flex-direction: column;">
                            <h3 style="margin-top: 0; font-size: 1.4em;">{{ $article->title }}</h3>
                            <p style="color: #94a3b8; font-size: 0.9em; margin-bottom: 15px;"><i class="fa-regular fa-calendar"></i> {{ $article->published_at->format('M d, Y') }}</p>
                            <p style="flex-grow: 1; line-height: 1.6;">{{ $article->summary }}</p>
                            <div style="margin-top: 20px; color: var(--accent-color); font-weight: bold;" class="i18n" data-en="Read Article →" data-ar="قراءة المقال ←">Read Article →</div>
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #94a3b8; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px dashed var(--border-color);">
                    <i class="fa-solid fa-folder-open" style="font-size: 3em; margin-bottom: 15px; color: var(--border-color);"></i>
                    <p style="font-size: 1.1em; font-weight: bold;" class="i18n" data-en="No articles published yet." data-ar="لا توجد مقالات منشورة بعد.">No articles published yet.</p>
                </div>
            @endforelse
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>
