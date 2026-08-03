<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} | Cloud Engineer</title>
    <link rel="stylesheet" href="/assets/css/style-modern.css">
    <link rel="stylesheet" href="/assets/css/terminal-mode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- PrismJS for Markdown Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>
<body class="dark-theme" style="background: #0f172a; overflow-y: auto;">
    <div class="aurora-bg"></div>

    <header class="app-header scrolled" style="position: fixed; top: 0; width: 100%; z-index: 1000; background: rgba(15, 23, 42, 0.9);">
        <div class="logo"><a href="/" style="color: inherit; text-decoration: none;">user@cloud-env:~$</a></div>
        <nav class="main-nav">
            <a href="/" class="nav-btn" style="text-decoration: none;"><span class="i18n" data-en="Home" data-ar="الرئيسية">Home</span></a>
            <a href="/blog" class="nav-btn" style="text-decoration: none;"><span class="i18n" data-en="Blog" data-ar="المدونة">Blog</span></a>
        </nav>
        <div class="nav-actions">
            <button id="btn-lang-toggle" style="background: transparent; color: var(--accent-color); border: 1px solid var(--accent-color); padding: 5px 10px; border-radius: 4px; cursor: pointer; font-family: inherit;">العربية</button>
        </div>
    </header>

    <main style="padding-top: 100px; padding-bottom: 50px; min-height: 100vh; position: relative; z-index: 10;">
        <article class="stat-card reveal-up" style="max-width: 800px; margin: 40px auto; padding: 40px; background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px);">
            @if($article->image_url)
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" style="width: 100%; height: auto; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 30px;">
            @endif
            
            <h1 style="color: var(--accent-color); font-size: 2.5em; margin-bottom: 10px; line-height: 1.3;">{{ $article->title }}</h1>
            <div style="color: #94a3b8; font-size: 0.9em; margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
                <span><i class="fa-regular fa-calendar"></i> {{ $article->published_at->format('F d, Y') }}</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" style="color: #38bdf8; text-decoration: none;"><i class="fa-brands fa-twitter"></i> Share</a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" style="color: #0a66c2; text-decoration: none;"><i class="fa-brands fa-linkedin"></i> Share</a>
            </div>

            <div class="markdown-body" style="font-size: 1.1em; line-height: 1.8; color: #e2e8f0;">
                {!! Str::markdown($article->markdown_content) !!}
            </div>
            
            <div style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; text-align: center;">
                <a href="/blog" class="btn btn-primary i18n" data-en="← Back to Blog" data-ar="← العودة للمدونة">← Back to Blog</a>
            </div>
        </article>
    </main>

    <style>
        .markdown-body h2, .markdown-body h3 { color: #fff; margin-top: 1.5em; margin-bottom: 0.5em; }
        .markdown-body p { margin-bottom: 1.5em; }
        .markdown-body pre { background: #1e1e1e; padding: 15px; border-radius: 8px; overflow-x: auto; margin-bottom: 1.5em; }
        .markdown-body code { font-family: 'Fira Code', monospace; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px; color: #38bdf8; }
        .markdown-body pre code { background: none; padding: 0; color: inherit; }
        .markdown-body a { color: #10b981; text-decoration: none; border-bottom: 1px dashed #10b981; }
        .markdown-body ul, .markdown-body ol { margin-bottom: 1.5em; padding-left: 20px; }
        .markdown-body blockquote { border-left: 4px solid var(--accent-color); padding-left: 15px; margin-left: 0; color: #94a3b8; font-style: italic; background: rgba(16,185,129,0.05); padding: 10px 15px; border-radius: 0 8px 8px 0; }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-yaml.min.js"></script>
    
    <script src="/assets/js/main.js"></script>
</body>
</html>
