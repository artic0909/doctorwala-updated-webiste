@extends('frontend.layout.app')

@section('title', $blog->blg_title . ' - DoctorWala Blog')

@section('content')

<head>
    <link href="{{asset('./css/blog-details.css')}}" rel="stylesheet">

    <meta name="description" content="{{ $blog->blg_desc }}">
    <meta name="keywords" content="{{ isset($blog->tags) ? implode(',', $blog->tags) : '' }}">
    <meta property="og:title" content="{{ $blog->blg_title }}">
    <meta property="og:description" content="{{ $blog->blg_desc }}">
    <meta property="og:image" content="{{ asset('storage/' . $blog->blg_image) }}">
    @guest
    <meta property="og:url" content="{{ route('blogpage.details', ['slug' => $blog->slug]) }}">
    @endguest
    @auth
    <meta property="og:url" content="{{ route('dw.blog.details', ['slug' => $blog->slug]) }}">
    @endauth
    <meta name="twitter:title" content="{{ $blog->blg_title }}">
    <meta name="twitter:description" content="{{ $blog->blg_desc }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $blog->blg_image) }}">
</head>


<!-- ═══════════════ HERO ═══════════════ -->
<div class="bd-hero">
    <div class="bd-hero__c1"></div>
    <div class="bd-hero__c2"></div>

    <div class="bd-hero__inner">
        <div class="bd-hero__badge">
            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor">
                <circle cx="12" cy="12" r="6" />
            </svg>
            Health Article
        </div>

        <h1 class="bd-hero__title">{{ $blog->blg_title }}</h1>
    </div>

    <div class="bd-hero__wave">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,40 C360,0 1080,80 1440,20 L1440,60 L0,60 Z" fill="#f0f9ff" />
        </svg>
    </div>
</div>


<!-- ═══════════════ CONTENT ═══════════════ -->
<div class="bd-wrap">
    <div class="bd-layout">

        <!-- MAIN -->
        <main class="bd-main">

            <div class="bd-main__meta">
                <span class="bd-badge-coral">Health</span>
                <span class="bd-meta-chip">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    {{ $blog->created_at->format('F d, Y') }}
                </span>
                <span class="bd-meta-chip">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                    5 min read
                </span>
            </div>

            <h1 class="bd-main__title">{{ $blog->blg_title }}</h1>

            <div class="bd-cover">
                <img src="{{ asset('storage/' . $blog->blg_image) }}" alt="{{ $blog->blg_title }}">
                <div class="bd-cover__logo">
                    <img src="{{ asset('img/logo.png') }}" alt="DoctorWala">
                </div>
            </div>

            <div class="bd-author-bar">
                <div class="bd-author-av">DW</div>
                <div>
                    <div class="bd-author-name">DoctorWala</div>
                    <div class="bd-author-role">Health Expert &bull; Medical Writer</div>
                </div>
            </div>

            <div class="bd-body">
                {!! $blog->blg_desc !!}
            </div>

            @guest
            <a href="/blog" class="bd-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Back to Blogs
            </a>
            @endguest
            @auth
            <a href="/blog" class="bd-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Back to Blogs
            </a>
            @endauth

        </main>

        <!-- SIDEBAR -->
        <aside class="bd-sidebar">

            <!-- Article Info -->
            <div class="bd-sblock">
                <div class="bd-sblock__head">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4M12 16h.01" />
                    </svg>
                    Article Info
                </div>

                <div class="bd-info-row">
                    <div class="bd-info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="bd-info-label">Author</div>
                        <div class="bd-info-val">DoctorWala</div>
                    </div>
                </div>

                <div class="bd-info-row">
                    <div class="bd-info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                    </div>
                    <div>
                        <div class="bd-info-label">Published</div>
                        <div class="bd-info-val">{{ $blog->created_at->format('M d, Y') }}</div>
                    </div>
                </div>

                <div class="bd-info-row">
                    <div class="bd-info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 7h10M7 12h10M7 17h6" />
                        </svg>
                    </div>
                    <div>
                        <div class="bd-info-label">Category</div>
                        <div class="bd-info-val">Health &amp; Wellness</div>
                    </div>
                </div>

                <div class="bd-info-row">
                    <div class="bd-info-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                    <div>
                        <div class="bd-info-label">Read Time</div>
                        <div class="bd-info-val">5 Minutes</div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="bd-cta">
                <div class="bd-cta__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.12.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.09-1.09a2 2 0 012.11-.45c.91.34 1.85.58 2.81.7A2 2 0 0122 16.92z" />
                    </svg>
                </div>
                <h3>Need Medical Guidance?</h3>
                <p>Connect with our health experts for personalized advice and consultations.</p>
                @guest
                <a href="/contact">Get in Touch</a>
                @endguest
                @auth
                <a href="/dw/contact">Get in Touch</a>
                @endauth
            </div>

        </aside>

    </div>
</div>

@endsection