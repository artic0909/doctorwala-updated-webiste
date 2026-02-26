@extends('frontend.layout.app')

@section('title', 'Read Blogs | Doctorwala.info')

@section('content')

<head>
    @foreach($blogs as $blog)
    <meta name="description" content="{{ $blog->blg_desc }}">

    <meta name="keywords" content="{{ isset($blog->tags) ? implode(',', $blog->tags) : '' }}">

    <meta property="og:title" content="{{ $blog->blg_title }}">
    <meta property="og:description" content="{{ $blog->blg_desc }}">
    <meta property="og:image" content="{{ asset('storage/' . $blog->blg_image) }}">
    <meta property="og:url" content="{{ route('blogpage', ['id' => $blog->id]) }}">

    <meta name="twitter:title" content="{{ $blog->blg_title }}">
    <meta name="twitter:description" content="{{ $blog->blg_desc }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $blog->blg_image) }}">
    @endforeach

    <link href="{{asset('./css/blog.css')}}" rel="stylesheet">
</head>


<!-- ═══════════════ HERO ═══════════════ -->
<div class="bl-hero">
    <div class="bl-hero__circle-a"></div>
    <div class="bl-hero__circle-b"></div>
    <div class="bl-hero__circle-c"></div>

    <div class="bl-hero__inner">

        <div class="bl-hero__pill">
            <span class="live-dot"></span>
            DoctorWala Health Blog
        </div>

        <h1 class="bl-hero__title">Latest News &amp;<br>Health Insights</h1>

    </div>

    <div class="bl-hero__wave">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,40 C360,0 1080,80 1440,20 L1440,60 L0,60 Z" fill="#f0f9ff" />
        </svg>
    </div>
</div>


<!-- ═══════════════ BLOGS ═══════════════ -->
<section class="bl-section">
    <div class="bl-wrap">

        <div class="bl-section__top">
            <div>
                <div class="bl-tag">
                    <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="6" />
                    </svg>
                    Stay Informed
                </div>
                <h2 class="bl-heading">Health Articles &amp; <span>Expert Blogs</span></h2>
            </div>

            @guest
            <a href="/contact" class="bl-btn-primary">
                Get in Touch
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
            @endguest
            @auth
            <a href="/dw/contact" class="bl-btn-primary">
                Get in Touch
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
            @endauth
        </div>

        <!-- Grid -->
        <div class="bl-grid">
            @foreach($blogs as $blog)
            <article class="bl-card">

                <div class="bl-card__img">
                    <img src="{{ asset('storage/' . $blog->blg_image) }}" alt="{{ $blog->blg_title }}">
                    <span class="bl-card__badge">Health</span>
                    <div class="bl-card__logo">
                        <img src="{{ asset('img/logo.png') }}" alt="DoctorWala">
                    </div>
                </div>

                <div class="bl-card__body">

                    <div class="bl-card__meta">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        {{ $blog->created_at->format('M d, Y') }}
                        <span class="dot"></span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        5 min read
                    </div>

                    <h3 class="bl-card__title">{{ $blog->blg_title }}</h3>
                    <p class="bl-card__desc">{{ $blog->blg_desc }}</p>

                    <div class="bl-card__foot">
                        <div class="bl-card__author">
                            <div class="bl-card__av">DW</div>
                            <div>
                                <div class="bl-card__aname">DoctorWala</div>
                                <div class="bl-card__arole">Health Expert</div>
                            </div>
                        </div>
                        @guest
                        @if($blog->slug)
                        <a href="{{ route('blogpage.details', ['slug' => $blog->slug]) }}" class="bl-card__readmore">
                            Read More
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                        @endif
                        @endguest
                        @auth
                        <a href="{{ route('dw.blog.details', ['slug' => $blog->slug]) }}" class="bl-card__readmore">
                            Read More
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                        @endauth
                    </div>

                </div>
            </article>
            @endforeach
        </div>


        <!-- PAGINATION -->
        @php
        $current = $blogs->currentPage();
        $last = $blogs->lastPage();
        $prevUrl = $blogs->previousPageUrl();
        $nextUrl = $blogs->nextPageUrl();
        @endphp

        <nav class="bl-pagination" aria-label="Blog pages">

            <a href="{{ $prevUrl ?? '#' }}" class="bl-pg bl-pg--nav {{ is_null($prevUrl) ? 'off' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Prev
            </a>

            <a href="{{ $blogs->url(1) }}" class="bl-pg {{ $current===1 ? 'bl-pg--on' : '' }}">1</a>

            @if($current > 4)
            <span class="bl-pg bl-pg--dots">···</span>
            @endif

            @php $s = max(2,$current-1); $e = min($last-1,$current+1); @endphp
            @for($p=$s; $p<=$e; $p++)
                <a href="{{ $blogs->url($p) }}" class="bl-pg {{ $current===$p ? 'bl-pg--on' : '' }}">{{ $p }}</a>
                @endfor

                @if($current < $last - 3)
                    <span class="bl-pg bl-pg--dots">···</span>
                    @endif

                    @if($last > 1)
                    <a href="{{ $blogs->url($last) }}" class="bl-pg {{ $current===$last ? 'bl-pg--on' : '' }}">{{ $last }}</a>
                    @endif

                    <a href="{{ $nextUrl ?? '#' }}" class="bl-pg bl-pg--nav {{ is_null($nextUrl) ? 'off' : '' }}">
                        Next
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>

        </nav>

    </div>
</section>

@endsection