    <!-- JavaScript Libraries -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('./lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('./lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('./lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('./lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('./lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('./lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('./lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('./lib/twentytwenty/jquery.event.move.js')}}"></script>
    <script src="{{asset('./lib/twentytwenty/jquery.twentytwenty.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('./js/main.js')}}"></script>
    <script src="{{asset('./js/cards-scroll.js')}}"></script>

    <!-- Carousels -->
    <script src="{{asset('./js/opd-carousel-card.js')}}"></script>
    <script src="{{asset('./js/path-carousel-card.js')}}"></script>
    <script src="{{asset('./js/doc-carousel-card.js')}}"></script>

    <script src="{{asset('./js/global-search.js')}}"></script>
    <script src="{{asset('./js/float-btn.js')}}"></script>




    <script>
        document.addEventListener('DOMContentLoaded', async () => {

            // 1. Parse browser & OS from userAgent
            const ua = navigator.userAgent;
            const browser = ua.includes('Chrome') ? 'Chrome' :
                ua.includes('Firefox') ? 'Firefox' :
                ua.includes('Safari') ? 'Safari' :
                ua.includes('Edge') ? 'Edge' :
                'Other';

            const os = ua.includes('Windows') ? 'Windows' :
                ua.includes('Mac') ? 'MacOS' :
                ua.includes('Android') ? 'Android' :
                ua.includes('iPhone') || ua.includes('iPad') ? 'iOS' :
                ua.includes('Linux') ? 'Linux' :
                'Other';

            const deviceType = /Mobi|Android|iPhone|iPad/i.test(ua) ? 'Mobile' : 'Desktop';

            // 2. Get approx location from IP (free, no key needed)
            let country = null,
                city = null;
            try {
                const geo = await fetch('https://ipapi.co/json/');
                const geoData = await geo.json();
                country = geoData.country_name;
                city = geoData.city;
            } catch (e) {}

            // 3. Send to Laravel
            fetch('{{ route("visitor.track") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    page_url: window.location.href,
                    referrer: document.referrer || null,
                    browser: browser,
                    os: os,
                    device_type: deviceType,
                    screen_size: `${screen.width}x${screen.height}`,
                    language: navigator.language,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    country: country,
                    city: city,
                })
            });
        });


        // ── Loading state helper ──
        document.querySelectorAll('.btn-search').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.classList.add('loading');
                setTimeout(() => btn.classList.remove('loading'), 1500);
            });
        });

        // ── Better no-results messages ──
        const showNoResults = (container, msg) => {
            container.innerHTML = `
        <div class="no-results-msg">
            <i class="fa fa-circle-exclamation" style="color: green"></i>
            ${msg}
        </div>`;
        };
    </script>

    <!-- Chatbase Chatbot Integration -->
    <script>
        (function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="rqDR6Kx1HIctWqyibJ7bm";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
    </script>

    @php
        $chatbotToken = null;
        $chatbotSecret = env('CHATBOT_IDENTITY_SECRET');
        if ($chatbotSecret) {
            $chatbotUser = null;
            if (auth('dwuser')->check()) {
                $u = auth('dwuser')->user();
                $chatbotUser = [
                    'user_id' => (string) $u->id,
                    'email' => $u->user_email,
                    'name' => $u->user_name,
                ];
            } elseif (auth('partner')->check()) {
                $u = auth('partner')->user();
                $chatbotUser = [
                    'user_id' => (string) $u->id,
                    'email' => $u->partner_email,
                    'name' => $u->partner_contact_person_name,
                ];
            } elseif (auth()->check()) {
                $u = auth()->user();
                $chatbotUser = [
                    'user_id' => (string) $u->id,
                    'email' => $u->email,
                    'name' => $u->name,
                ];
            }

            if ($chatbotUser) {
                $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
                $payload = json_encode(array_merge($chatbotUser, [
                    'exp' => time() + 3600
                ]));

                $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
                $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
                $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $chatbotSecret, true);
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
                $chatbotToken = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
            }
        }
    @endphp

    @if($chatbotToken)
    <script>
        window.chatbase('identify', { token: '{{ $chatbotToken }}' });
    </script>
    @endif