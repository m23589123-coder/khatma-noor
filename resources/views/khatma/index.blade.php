<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#042f2e">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ختمة القرآن الكريم | صدقة جارية</title>

    <meta property="og:title" content="ختمة النور | صدقة جارية">
    <meta property="og:description" content="شاركنا الأجر في ختمة القرآن الكريم كصدقة جارية على روح المغفور له بإذن الله (زين العابدين محمد سليم السكري). اضغط هنا لحجز الجزء الخاص بك.">
    <meta property="og:image" content="https://img.freepik.com/premium-photo/quran-book-with-rosary-beads_1235831-72995.jpg">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body { font-family: 'Amiri', serif; background-color: #042f2e; color: #ecfeff; overflow-x: hidden; }
        .bg-islamic { background-color: #064E3B; }
        .text-gold { color: #D4AF37; }
        .bg-gold { background-color: #D4AF37; }

        /* تأثير الزجاج الفخم (Glassmorphism) */
        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        /* الزخرفة الإسلامية للكروت */
        .islamic-card {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .islamic-card::after {
            content: '۞';
            position: absolute;
            bottom: 12px;
            left: 16px;
            font-size: 18px;
            color: rgba(212, 175, 55, 0.25);
        }

        /* تأثير النبض للجزء الجاري قراءته */
        .pulse-glow { animation: pulse-shadow 2s infinite; }
        @keyframes pulse-shadow {
            0% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.5); }
            70% { box-shadow: 0 0 0 12px rgba(212, 175, 55, 0); }
            100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0); }
        }

        /* تخصيص السكرول بار الصغير الهادئ */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(212, 175, 55, 0.3); border-radius: 10px; }
    </style>
</head>
<body class="relative min-h-screen pb-20 overflow-x-hidden" onload="initSmartFeatures()">

    <div class="fixed inset-0 z-[-1] opacity-15" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><path d=%22M50 0 L100 50 L50 100 L0 50 Z%22 fill=%22none%22 stroke=%22%23D4AF37%22 stroke-width=%220.75%22/></svg>'); background-size: 50px 50px; animation: moveBg 80s linear infinite;"></div>
    <style>@keyframes moveBg { 100% { background-position: 500px 500px; } }</style>

    @php
        $completedCount = $juzs->where('status', 'completed')->count();
        $percentage = $juzs->count() > 0 ? round(($completedCount / 30) * 100) : 0;
        $remainingCount = 30 - $completedCount;
    @endphp

    <header class="text-center py-12 md:py-16 relative overflow-hidden">
        <div class="relative z-10 px-4">
            <h1 class="text-5xl md:text-6xl font-bold text-gold mb-3 drop-shadow-2xl">ختمة النور</h1>
            <p class="text-lg md:text-2xl text-white opacity-95 mb-6">
                صدقة جارية على روح<br>
                <span class="text-2xl md:text-5xl text-gold font-bold block mt-2 drop-shadow-[0_0_15px_rgba(212,175,55,0.4)]">زين العابدين محمد سليم السكري</span>
            </p>

            <div class="inline-block glass-panel rounded-2xl px-6 py-3 mb-5">
                <p class="text-white text-sm md:text-base mb-1">إجمالي الختمات المكتملة</p>
                <p class="text-4xl md:text-5xl font-bold text-gold" id="odometer">{{ $totalCompleted ?? 0 }}</p>
            </div>

            <div class="flex flex-col items-center justify-center gap-3">
                @if($percentage == 100)
                    <button onclick="generateCertificate()" class="inline-block bg-gold text-islamic font-bold px-6 py-2.5 rounded-full hover:bg-yellow-500 transition shadow-[0_0_20px_rgba(212,175,55,0.5)] text-md md:text-lg">
                        📜 استخراج شهادة الختمة
                    </button>
                @endif

                <a href="https://api.whatsapp.com/send?text=شاركنا الأجر في ختمة القرآن الكريم صدقة جارية على روح (زين العابدين محمد سليم السكري). احجز الجزء الخاص بك من هنا: {{ urlencode(url('/')) }}" target="_blank" class="inline-flex items-center justify-center bg-green-600 text-white font-bold px-5 py-2.5 rounded-full hover:bg-green-700 transition shadow-md text-md">
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.12.549 4.191 1.594 6.015L.15 24l6.115-1.558c1.764.957 3.766 1.464 5.766 1.464 6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm3.84 17.26c-.173.486-.997.935-1.463 1.011-.466.076-1.026.138-3.415-.845-2.871-1.182-4.707-4.11-4.851-4.301-.144-.191-1.161-1.545-1.161-2.946 0-1.401.722-2.093.98-2.378.258-.285.565-.357.753-.357.188 0 .376 0 .543.008.173.008.405-.065.633.487.23.551.748 1.831.815 1.968.067.137.112.298.026.469-.086.171-.131.277-.258.428-.127.151-.271.32-.383.435-.125.127-.257.265-.11.517.147.253.655 1.08 1.401 1.746.96.86 1.762 1.13 2.016 1.258.254.127.404.106.554-.065.15-.171.65-7.752.822-.888.172-.136.345-.067.553.008.208.075 1.317.621 1.543.734.226.113.376.17.432.264.056.094.056.551-.117 1.037z"/></svg>
                    شارك الختمة على واتساب
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto py-4 px-4 relative z-20">

        <div class="glass-panel p-5 rounded-2xl mb-10 max-w-2xl mx-auto">
            <div class="flex justify-between items-end mb-2">
                <span class="text-base font-bold text-white">إنجاز الختمة الحالية</span>
                <div>
                    <span class="text-xl font-bold text-gold counter" data-target="{{ $percentage }}">0</span>
                    <span class="text-xl text-gold">%</span>
                </div>
            </div>
            <div class="w-full bg-black/40 rounded-full h-3.5 shadow-inner overflow-hidden border border-white/10">
                <div class="bg-gradient-to-r from-yellow-600 to-yellow-300 h-full rounded-full transition-all duration-2000 ease-out w-0" id="progress-bar"></div>
            </div>
            <p class="text-center text-gray-300 mt-3 font-bold text-sm">
                {{ $remainingCount > 0 ? "متبقي $remainingCount أجزاء لتكتمل الختمة" : "اكتملت ختمة النور بفضل الله، جاري بدء ختمة جديدة..." }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 my-8">
            @foreach($juzs as $juz)
                <div class="islamic-card glass-panel p-5 rounded-2xl border-t-4 hover:scale-[1.02] transition-transform duration-300 {{ $juz->status == 'completed' ? 'border-green-500 shadow-[0_4px_15px_rgba(34,197,94,0.1)]' : ($juz->status == 'reserved' ? 'border-yellow-500 pulse-glow' : 'border-gray-600') }}">

                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg md:text-xl font-bold text-white">الجزء {{ $juz->juz_number }}</h3>

                        @if($juz->status == 'completed')
                            <span class="px-2.5 py-0.5 bg-green-500/20 text-green-300 border border-green-500/30 rounded-full text-xs font-bold">مكتمل</span>
                        @elseif($juz->status == 'reserved')
                            <span class="px-2.5 py-0.5 bg-yellow-500/20 text-yellow-300 border border-yellow-500/30 rounded-full text-xs font-bold animate-pulse">جاري القراءة</span>
                        @else
                            <span class="px-2.5 py-0.5 bg-gray-500/20 text-gray-300 border border-gray-500/30 rounded-full text-xs">متاح</span>
                        @endif
                    </div>

                    <div class="min-h-[90px] flex flex-col justify-center">
                        @if($juz->status == 'available')
                            <form action="{{ route('khatma.reserve', $juz->id) }}" method="POST" class="space-y-2">
                                @csrf
                                <input type="text" name="reader_name" placeholder="اسم القارئ (اختياري)" class="w-full text-center p-2 bg-black/20 border border-white/10 rounded-xl text-white text-xs focus:outline-none focus:border-gold">
                                <button type="submit" class="w-full bg-gold text-islamic py-1.5 rounded-xl font-bold hover:bg-yellow-500 transition text-sm shadow-md">احجز واقرأ</button>
                            </form>
                        @elseif($juz->status == 'reserved')
                            <p class="text-gray-300 text-xs mb-2 font-bold truncate">بواسطة: {{ $juz->reader_name }}</p>
                            <a href="{{ route('khatma.read', $juz->id) }}" class="block w-full bg-white/10 text-white border border-white/20 py-1.5 rounded-xl font-bold text-center text-xs hover:bg-white/20 transition">استكمال القراءة</a>
                        @else
                            <p class="text-gray-400 text-xs mb-2">تقبل الله منه صالح الأعمال</p>
                            <a href="{{ route('khatma.read', $juz->id) }}" class="block w-full border border-gold/40 text-gold py-1.5 rounded-xl text-center font-bold text-xs hover:bg-gold hover:text-islamic transition">قراءة للبركة</a>
                        @endif
                    </div>

                    <div class="mt-4 pt-2 border-t border-white/5 flex justify-between items-center text-[11px] text-gray-400">
                        <span>قُرئ: <b class="text-gold">{{ $juz->read_count ?? 0 }}</b> مرات</span>
                        @if($juz->status == 'reserved' && $juz->reserved_at)
                            <span class="opacity-80">منذ {{ \Carbon\Carbon::parse($juz->reserved_at)->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="glass-panel p-5 md:p-8 rounded-2xl mt-12 relative overflow-hidden max-w-4xl mx-auto">
            <h2 class="text-xl md:text-3xl font-bold text-center text-gold mb-6">دفتر الدعاء والنور</h2>

            <form action="{{ route('khatma.doaa') }}" method="POST" class="mb-8 bg-black/20 p-4 rounded-xl border border-white/5">
                @csrf
                <div class="mb-3">
                    <input type="text" name="author_name" placeholder="اسمك الكريم (اختياري)" class="w-full p-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-gold">
                </div>
                <div class="mb-3">
                    <textarea name="message" rows="3" required placeholder="اكتب دعاءً صادقاً للمغفور له بإذن الله..." class="w-full p-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-gold"></textarea>
                </div>
                <button type="submit" class="w-full bg-gold text-islamic py-2.5 rounded-xl font-bold hover:bg-yellow-500 transition text-sm shadow-md">إضافة الدعاء للدفتر</button>
            </form>

            <div class="space-y-4 max-h-96 overflow-y-auto pr-1 custom-scrollbar">
                @if($doaas->count() > 0)
                    @foreach($doaas as $doaa)
                        <div class="glass-panel p-4 rounded-xl border-r-4 border-gold flex flex-col justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-gold text-base mb-1">{{ $doaa->author_name }}</h4>
                                <p class="text-gray-200 leading-relaxed text-sm md:text-base">{{ $doaa->message }}</p>
                            </div>

                            <div class="flex justify-between items-center border-t border-white/5 pt-2 mt-1">
                                <span class="text-[11px] text-gray-400">{{ \Carbon\Carbon::parse($doaa->created_at)->diffForHumans() }}</span>

                                <form action="{{ route('khatma.amen', $doaa->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 bg-gold/10 hover:bg-gold/20 text-gold rounded-full text-xs font-bold transition">
                                        <span>🤲 آمين</span>
                                        <span class="bg-gold text-islamic px-1.5 py-0.5 rounded-full text-[10px] font-sans font-bold">{{ $doaa->amen_count ?? 0 }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-gray-400 text-sm py-4">كن أول من يكتب دعاءً في هذا الدفتر المبارك.</p>
                @endif
            </div>
        </div>
    </main>

    <div id="certificate-card" class="hidden absolute top-0 left-0 bg-islamic w-[800px] h-[600px] p-12 border-[15px] border-gold text-center flex-col justify-center items-center z-[-50]">
        <h1 class="text-6xl font-bold text-gold mb-8 font-['Amiri']">شهادة إتمام ختمة قرآنية</h1>
        <p class="text-3xl text-white mb-6">بفضل الله وتوفيقه، تم إتمام قراءة القرآن الكريم كاملاً</p>
        <p class="text-3xl text-white mb-6">صدقة جارية على روح المغفور له بإذن الله</p>
        <h2 class="text-5xl font-bold text-gold mb-10">زين العابدين محمد سليم السكري</h2>
        <p class="text-2xl text-gray-300">نسأل الله أن يتقبل من جميع القراء وأن يجعله نوراً في قبره.</p>
    </div>

    <div id="install-banner" class="hidden fixed bottom-4 left-0 right-0 mx-auto w-11/12 max-w-md z-[100] bg-islamic/90 backdrop-blur-md border-2 border-gold p-4 rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.5)] flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/3389/3389733.png" alt="App Icon" class="w-12 h-12 rounded-lg border border-gold">
            <div>
                <h4 class="text-gold font-bold text-sm">تطبيق ختمة النور</h4>
                <p class="text-white text-xs">ثبّت التطبيق لسهولة الوصول</p>
            </div>
        </div>
        <button id="install-btn" class="bg-gold text-islamic font-bold px-4 py-2 rounded-xl text-sm hover:scale-105 transition shadow-md">
            تثبيت
        </button>
    </div>

    <script>
        function initSmartFeatures() {
            setTimeout(() => {
                document.getElementById('progress-bar').style.width = '{{ $percentage }}%';
            }, 500);

            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const updateCount = () => {
                    const c = +counter.innerText;
                    const increment = target / 50;
                    if (c < target) {
                        counter.innerText = Math.ceil(c + increment);
                        setTimeout(updateCount, 40);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        }

        function generateCertificate() {
            const cert = document.getElementById('certificate-card');
            cert.classList.remove('hidden');
            cert.classList.add('flex');

            html2canvas(cert).then(canvas => {
                const link = document.createElement('a');
                link.download = 'khatma-certificate.png';
                link.href = canvas.toDataURL();
                link.click();

                cert.classList.add('hidden');
                cert.classList.remove('flex');
            });
        }
    </script>

    <script>
        let deferredPrompt;
        const installBanner = document.getElementById('install-banner');
        const installBtn = document.getElementById('install-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installBanner.classList.remove('hidden');
            installBanner.classList.add('flex');
        });

        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                }
                deferredPrompt = null;
                installBanner.classList.add('hidden');
                installBanner.classList.remove('flex');
            }
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(err => {
                    console.log('Service Worker registration failed:', err);
                });
            });
        }
    </script>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // إعدادات Pusher
        Pusher.logToConsole = false;

        var pusher = new Pusher('5d7772ae4e6d723ac91d', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('khatma-live');

        channel.bind('juz-reserved', function(data) {
            const reader = data.readerName || 'فاعل خير';
            const juz = data.juzNumber;

            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'info',
                title: `📖 ${reader} بدأ قراءة الجزء ${juz} الآن!`,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                background: '#064E3B',
                color: '#D4AF37',
                iconColor: '#D4AF37',
                customClass: {
                    title: 'font-[Amiri] text-lg'
                }
            });

            setTimeout(() => {
                window.location.reload();
            }, 5000);
        });
    </script>
</body>
</html>
