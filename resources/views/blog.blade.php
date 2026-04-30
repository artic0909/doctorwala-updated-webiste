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
                    <!-- <p class="bl-card__desc">{!! $blog->blg_desc !!}</p> -->
                    <p class="bl-card__desc">{{ Str::limit(strip_tags($blog->blg_desc), 150) }}</p>

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
                        <a href="{{ $blog->slug ? route('dw.blog.details', ['slug' => $blog->slug]) : '#' }}" class="bl-card__readmore">
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


@guest
<!-- {{-- Modal Overlay --}} -->
<div id="healthCardModal"
    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:16px;"
    onclick="if(event.target===this) document.getElementById('healthCardModal').style.display='none'">

    <div style="background:#fff;border-radius:14px;width:100%;max-width:500px;box-shadow:0 8px 32px rgba(0,0,0,0.18);overflow:hidden;font-family:'Segoe UI',Arial,sans-serif;">


        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px 14px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="color:#e53935;font-size:20px;font-weight:900;">✚</span>
                <span style="font-size:19px;font-weight:800;color:#111;letter-spacing:-0.5px;">
                    <span style="color:#e53935;">DOCTORWALA</span>
                </span>
                <span style="font-size:11px;background:#f3f4f6;color:#6b7280;padding:2px 9px;border-radius:20px;font-weight:600;">Medical Card</span>
            </div>
            <button onclick="document.getElementById('healthCardModal').style.display='none'"
                style="background:none;border:1px solid #e5e7eb;color:#6b7280;width:28px;height:28px;border-radius:6px;cursor:pointer;font-size:13px;">
                ✕
            </button>
        </div>

        <hr style="margin:0;border:none;border-top:1px solid #f0f0f0;">

        <div style="padding:18px 22px 14px;">
            <div style="background:linear-gradient(135deg,#29b6f6 0%,#1976d2 50%,#1565c0 100%);border-radius:14px;padding:18px 20px;box-shadow:0 6px 20px rgba(21,101,192,0.3);">


                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <div style="display:flex;align-items:center;gap:9px;">
                        <div style="width:30px;height:30px;border-radius:8px;background-color:white;display:flex;align-items:center;justify-content:center;">
                            <span style="color:#22c55e;font-weight:900;font-size:14px;"><img src="{{asset('./img/logo.png')}}" alt="" width="20"></span>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:#fff;">Doctorwala</div>
                            <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.6);letter-spacing:1.5px;">MEDICAL CARD</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:26px;border-radius:5px;background:linear-gradient(135deg,#f59e0b,#d97706);"></div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="rgba(255,255,255,0.7)">
                            <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" />
                        </svg>
                    </div>
                </div>


                <div style="margin-bottom:16px;font-size:17px;letter-spacing:1px;">
                    <span style="color:rgba(255,255,255,0.55);font-size:11px;">●●●● ●●●●&nbsp;&nbsp;</span>
                    <span style="color:#fff;font-weight:700;letter-spacing:3px;">DW27&nbsp;&nbsp;5541</span>
                </div>


                <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                    <div>
                        <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.55);letter-spacing:1.5px;margin-bottom:3px;">CARD HOLDER</div>
                        <div style="font-size:14px;font-weight:700;color:#fff;">YOUR NAME</div>
                    </div>
                    <div style="display:flex;gap:20px;">
                        <div>
                            <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.55);letter-spacing:1.5px;margin-bottom:3px;">MEMBER ID</div>
                            <div style="font-size:12px;font-weight:700;color:#fff;">DW-2024-XXXXX</div>
                        </div>
                        <div>
                            <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.55);letter-spacing:1.5px;margin-bottom:3px;">EXPIRY DATE</div>
                            <div style="font-size:14px;font-weight:700;color:#fff;">12/28</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <hr style="margin:0;border:none;border-top:1px solid #f0f0f0;">


        <div style="padding:16px 22px;">
            <p style="font-size:13px;font-weight:700;color:#111;margin:0 0 10px;">What you get with your Health Card</p>
            <ul style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:7px;">
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Access all your medical reports &amp; lab results anytime</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Store prescriptions digitally — never lose one again</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Book and track doctor appointments easily</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Save emergency info: blood group, allergies &amp; contacts</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Maintain complete vaccination records with reminders</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Cashless treatment at 500+ partner hospitals &amp; clinics</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Track vitals — heart rate, BP, oxygen, weight over time</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Share your card instantly with any doctor or hospital</span>
                </li>
            </ul>
        </div>

        <hr style="margin:0;border:none;border-top:1px solid #f0f0f0;">


        <div style="padding:16px 22px 20px;display:flex;align-items:center;gap:14px;">
            <a href="/dw/user-auth"
                style="background:#16a34a;color:#fff;border-radius:8px;padding:10px 22px;font-size:14px;font-weight:700;text-decoration:none;display:inline-block;">
                Create Your Card
            </a>
                         <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth&pcampaignid=web_share"
                style="background:#16a34a;color:#fff;border-radius:8px;padding:10px 22px;font-size:14px;font-weight:700;text-decoration:none;display:inline-block;">
               <i class="fa-brands fa-google-play"></i> Download Doctorwala App
            </a>
        </div>

    </div>
</div>
<!-- Modal -->
<script>
    window.addEventListener('load', function() {
        document.getElementById('healthCardModal').style.display = 'flex';
    });
</script>
@endguest

@auth
@if(!Auth::user()->medical_card_no)
<!-- {{-- Modal Overlay --}} -->
<div id="healthCardModal"
    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:16px;"
    onclick="if(event.target===this) document.getElementById('healthCardModal').style.display='none'">

    <div style="background:#fff;border-radius:14px;width:100%;max-width:500px;box-shadow:0 8px 32px rgba(0,0,0,0.18);overflow:hidden;font-family:'Segoe UI',Arial,sans-serif;">


        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px 14px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="color:#e53935;font-size:20px;font-weight:900;">✚</span>
                <span style="font-size:19px;font-weight:800;color:#111;letter-spacing:-0.5px;">
                    <span style="color:#e53935;">DOCTORWALA</span>
                </span>
                <span style="font-size:11px;background:#f3f4f6;color:#6b7280;padding:2px 9px;border-radius:20px;font-weight:600;">Medical Card</span>
            </div>
            <button onclick="document.getElementById('healthCardModal').style.display='none'"
                style="background:none;border:1px solid #e5e7eb;color:#6b7280;width:28px;height:28px;border-radius:6px;cursor:pointer;font-size:13px;">
                ✕
            </button>
        </div>

        <hr style="margin:0;border:none;border-top:1px solid #f0f0f0;">

        <div style="padding:18px 22px 14px;">
            <div style="background:linear-gradient(135deg,#29b6f6 0%,#1976d2 50%,#1565c0 100%);border-radius:14px;padding:18px 20px;box-shadow:0 6px 20px rgba(21,101,192,0.3);">


                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <div style="display:flex;align-items:center;gap:9px;">
                        <div style="width:30px;height:30px;border-radius:8px;background-color:white;display:flex;align-items:center;justify-content:center;">
                            <span style="color:#22c55e;font-weight:900;font-size:14px;"><img src="{{asset('./img/logo.png')}}" alt="" width="20"></span>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:#fff;">Doctorwala</div>
                            <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.6);letter-spacing:1.5px;">MEDICAL CARD</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:26px;border-radius:5px;background:linear-gradient(135deg,#f59e0b,#d97706);"></div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="rgba(255,255,255,0.7)">
                            <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" />
                        </svg>
                    </div>
                </div>


                <div style="margin-bottom:16px;font-size:17px;letter-spacing:1px;">
                    <span style="color:rgba(255,255,255,0.55);font-size:11px;">●●●● ●●●●&nbsp;&nbsp;</span>
                    <span style="color:#fff;font-weight:700;letter-spacing:3px;">DW27&nbsp;&nbsp;5541</span>
                </div>


                <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                    <div>
                        <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.55);letter-spacing:1.5px;margin-bottom:3px;">CARD HOLDER</div>
                        <div style="font-size:14px;font-weight:700;color:#fff;">YOUR NAME</div>
                    </div>
                    <div style="display:flex;gap:20px;">
                        <div>
                            <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.55);letter-spacing:1.5px;margin-bottom:3px;">MEMBER ID</div>
                            <div style="font-size:12px;font-weight:700;color:#fff;">DW-2024-XXXXX</div>
                        </div>
                        <div>
                            <div style="font-size:8px;font-weight:600;color:rgba(255,255,255,0.55);letter-spacing:1.5px;margin-bottom:3px;">EXPIRY DATE</div>
                            <div style="font-size:14px;font-weight:700;color:#fff;">12/28</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <hr style="margin:0;border:none;border-top:1px solid #f0f0f0;">


        <div style="padding:16px 22px;">
            <p style="font-size:13px;font-weight:700;color:#111;margin:0 0 10px;">What you get with your Health Card</p>
            <ul style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:7px;">
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Access all your medical reports &amp; lab results anytime</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Store prescriptions digitally — never lose one again</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Book and track doctor appointments easily</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Save emergency info: blood group, allergies &amp; contacts</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Maintain complete vaccination records with reminders</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Cashless treatment at 500+ partner hospitals &amp; clinics</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Track vitals — heart rate, BP, oxygen, weight over time</span>
                </li>
                <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#374151;line-height:1.5;">
                    <span style="color:#16a34a;font-weight:700;font-size:15px;flex-shrink:0;">•</span>
                    <span>Share your card instantly with any doctor or hospital</span>
                </li>
            </ul>
        </div>

        <hr style="margin:0;border:none;border-top:1px solid #f0f0f0;">


        <div style="padding:16px 22px 20px;display:flex;align-items:center;gap:14px;">
            <a href="/dw/profile"
                style="background:#16a34a;color:#fff;border-radius:8px;padding:10px 22px;font-size:14px;font-weight:700;text-decoration:none;display:inline-block;">
                Create Your Card
            </a>
                         <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth&pcampaignid=web_share"
                style="background:#16a34a;color:#fff;border-radius:8px;padding:10px 22px;font-size:14px;font-weight:700;text-decoration:none;display:inline-block;">
               <i class="fa-brands fa-google-play"></i> Download Doctorwala App
            </a>
        </div>

    </div>
</div>
<!-- Modal -->
<script>
    window.addEventListener('load', function() {
        document.getElementById('healthCardModal').style.display = 'flex';
    });
</script>
@endif
@endauth

@endsection