<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $record->heading }} — Files</title>
    <link href="{{asset('fav5.png')}}" rel="icon">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', 'Segoe UI', sans-serif;
            background: #f4f6fb;
            color: #1a1f36;
            min-height: 100vh;
        }

        .vf-header {
            background: #fff;
            border-bottom: 1.5px solid #e8ecf8;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 12px rgba(67, 97, 238, .07);
        }

        .vf-back {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #4361ee;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            padding: 7px 13px;
            border-radius: 9px;
            background: #eef2ff;
            transition: background .15s;
        }

        .vf-back:hover {
            background: #e0e8ff;
        }

        .vf-header__info {
            flex: 1;
        }

        .vf-header__info h1 {
            font-size: 15px;
            font-weight: 700;
            color: #1a1f36;
        }

        .vf-header__meta {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 2px;
        }

        .vf-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .vf-badge--report {
            background: #eff6ff;
            color: #2563eb;
        }

        .vf-badge--prescription {
            background: #fdf4ff;
            color: #9333ea;
        }

        .vf-date {
            font-size: 12px;
            color: #8892b0;
        }

        .vf-body {
            max-width: 960px;
            margin: 0 auto;
            padding: 28px 16px;
        }

        .vf-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 18px;
        }

        .vf-card {
            background: #fff;
            border-radius: 14px;
            border: 1.5px solid #e8ecf8;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(67, 97, 238, .06);
            transition: transform .18s, box-shadow .18s;
            animation: vfCardIn .3s ease both;
        }

        .vf-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(67, 97, 238, .12);
        }

        @keyframes vfCardIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .vf-card a {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .vf-card__thumb {
            width: 100%;
            aspect-ratio: 4/3;
            background: #f7f9ff;
            overflow: hidden;
            position: relative;
        }

        .vf-card__thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }

        .vf-card:hover .vf-card__thumb img {
            transform: scale(1.04);
        }

        .vf-card__pdf-thumb {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe4e4 100%);
            color: #e53e3e;
        }

        .vf-card__pdf-thumb svg {
            opacity: .85;
        }

        .vf-card__pdf-thumb span {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .vf-card__foot {
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .vf-card__name {
            font-size: 12px;
            font-weight: 600;
            color: #5a6282;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 130px;
        }

        .vf-card__open {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #4361ee;
        }

        .vf-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 80px 24px;
            color: #c0c8e0;
        }

        /* Lightbox */
        .vf-lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 12, 26, .92);
            z-index: 999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 16px;
            padding: 16px;
        }

        .vf-lightbox.open {
            display: flex;
        }

        .vf-lightbox img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 10px;
            box-shadow: 0 0 60px rgba(0, 0, 0, .5);
        }

        .vf-lb-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
        }

        .vf-lb-close:hover {
            background: rgba(255, 255, 255, .25);
        }

        .vf-lb-caption {
            color: rgba(255, 255, 255, .6);
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .vf-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

    <div class="vf-header">
        <a href="{{ url()->previous() }}" class="vf-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Back
        </a>
        <div class="vf-header__info">
            <h1>{{ $record->heading }}</h1>
            <div class="vf-header__meta">
                <span class="vf-badge vf-badge--{{ $record->type }}">{{ ucfirst($record->type) }}</span>
                <span class="vf-date">{{ \Carbon\Carbon::parse($record->date_of_report)->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <div class="vf-body">
        @if($record->images && count($record->images))
        <div class="vf-grid">
            @foreach($record->images as $i => $path)
            @php
            $isPdf = str_ends_with(strtolower($path), '.pdf');
            $url = asset('storage/' . $path);
            $name = basename($path);
            @endphp

            <div class="vf-card" style="animation-delay: {{ $i * 60 }}ms">
                @if($isPdf)
                <a href="{{ $url }}" target="_blank">
                    <div class="vf-card__thumb">
                        <div class="vf-card__pdf-thumb">
                            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z" />
                                <polyline points="13 2 13 9 20 9" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                            </svg>
                            <span>PDF Document</span>
                        </div>
                    </div>
                    <div class="vf-card__foot">
                        <span class="vf-card__name">{{ $name }}</span>
                        <span class="vf-card__open">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" />
                                <polyline points="15 3 21 3 21 9" />
                                <line x1="10" y1="14" x2="21" y2="3" />
                            </svg>
                            Open
                        </span>
                    </div>
                </a>
                @else
                <div onclick="openLightbox('{{ $url }}', '{{ $name }}')" style="cursor:zoom-in;">
                    <div class="vf-card__thumb">
                        <img src="{{ $url }}" alt="{{ $name }}" loading="lazy">
                    </div>
                    <div class="vf-card__foot">
                        <span class="vf-card__name">{{ $name }}</span>
                        <span class="vf-card__open">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                            View
                        </span>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="vf-empty">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48" />
            </svg>
            <p>No files attached to this record.</p>
        </div>
        @endif
    </div>

    {{-- Lightbox --}}
    <div class="vf-lightbox" id="vfLightbox" onclick="closeLightbox()">
        <button class="vf-lb-close" onclick="closeLightbox()">✕</button>
        <img id="vfLightboxImg" src="" alt="">
        <span class="vf-lb-caption" id="vfLightboxCaption"></span>
    </div>

    <script>
        function openLightbox(url, name) {
            document.getElementById('vfLightboxImg').src = url;
            document.getElementById('vfLightboxCaption').textContent = name;
            document.getElementById('vfLightbox').classList.add('open');
        }

        function closeLightbox() {
            document.getElementById('vfLightbox').classList.remove('open');
            document.getElementById('vfLightboxImg').src = '';
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
</body>

</html>