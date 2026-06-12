<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#042f2e">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قراءة الجزء {{ $juz->juz_number }} | ختمة النور</title>

    <meta property="og:title" content="قراءة الجزء {{ $juz->juz_number }} | ختمة النور">
    <meta property="og:description" content="أقرأ الآن الجزء {{ $juz->juz_number }} كصدقة جارية على روح المغفور له بإذن الله (زين العابدين محمد سليم السكري). تقبل الله منا ومنكم.">
    <meta property="og:image" content="https://img.freepik.com/premium-photo/quran-book-with-rosary-beads_1235831-72995.jpg">
    <meta property="og:url" content="{{ url()->current() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const hour = new Date().getHours();
        if (hour >= 18 || hour <= 6) { document.documentElement.classList.add('dark'); }
        tailwind.config = { darkMode: 'class' }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Amiri+Quran&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Amiri', serif; transition: background-color 0.5s, color 0.5s; overflow-x: hidden; }
        .bg-islamic { background-color: #064E3B; }
        .text-gold { color: #D4AF37; }

        /* تصميم ورقة المصحف الفخمة */
        .mushaf-paper {
            background-color: #fdf6e3;
            background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png');
            border: 2px solid #D4AF37;
            outline: 10px solid #064E3B;
            outline-offset: -2px;
            box-shadow: inset 0 0 40px rgba(0,0,0,0.05), 0 15px 35px rgba(0,0,0,0.15);
            transition: all 0.4s ease;
        }
        .dark .mushaf-paper {
            background-color: #0f172a;
            background-image: none;
            border: 2px solid #D4AF37;
            outline: 10px solid #1e293b;
            box-shadow: inset 0 0 40px rgba(0,0,0,0.5), 0 15px 35px rgba(0,0,0,0.8);
        }

        /* خط القرآن */
        .quran-text {
            font-family: 'Amiri Quran', serif;
            text-align: justify;
            text-align-last: center;
        }

        /* تصميم الآية والتظليل */
        .ayah-span { cursor: pointer; transition: all 0.2s ease; border-radius: 4px; padding: 0 4px; }
        .ayah-span:hover { background-color: rgba(212, 175, 55, 0.15); }
        .ayah-span.active-ayah { background-color: rgba(212, 175, 55, 0.4); box-shadow: 0 0 12px rgba(212, 175, 55, 0.3); font-weight: bold; }

        /* رقم الآية */
        .ayah-number {
            display: inline-flex; justify-content: center; align-items: center;
            width: 38px; height: 38px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="none" stroke="%23D4AF37" stroke-width="5" d="M50 5 L85 25 L85 75 L50 95 L15 75 L15 25 Z"/></svg>');
            background-size: contain; background-repeat: no-repeat; background-position: center;
            font-size: 15px; margin: 0 8px; color: #064E3B; font-family: Arial, sans-serif; font-weight: bold;
        }
        .dark .ayah-number { color: #D4AF37; }

        /* تأثير تقليب الصفحة */
        @keyframes flipPage {
            from { opacity: 0; transform: scale(0.98) translateY(15px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-page { animation: flipPage 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    </style>
</head>
<body class="bg-[#f8fafc] dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 min-h-screen pb-20">

    <header class="bg-islamic dark:bg-gray-900 text-center py-4 md:py-6 shadow-xl border-b-4 border-gold sticky top-0 z-50 transition-colors">
        <button onclick="document.documentElement.classList.toggle('dark')" class="absolute right-3 top-3 md:right-4 md:top-4 bg-white/20 text-white p-2 md:p-3 rounded-full hover:bg-white/30 transition">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        </button>

        <a href="{{ url('/') }}" class="absolute left-3 top-3 md:left-4 md:top-4 bg-white/20 text-white p-2 md:p-3 rounded-full hover:bg-white/30 transition flex items-center justify-center">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>

        <h1 class="text-2xl md:text-4xl font-bold text-gold mt-1 md:mt-2">الجزء {{ $juz->juz_number }}</h1>
    </header>

    @php
        $mushafPages = [];
        if(!empty($surahs)){
            foreach($surahs as $surah){
                foreach($surah['ayahs'] as $ayah){
                    $pageNum = $ayah['page'];
                    if(!isset($mushafPages[$pageNum])){
                        $mushafPages[$pageNum] = [];
                    }
                    $mushafPages[$pageNum][] = [
                        'global_id' => $ayah['number'],
                        'text' => $ayah['text'],
                        'numberInSurah' => $ayah['numberInSurah'],
                        'surah_name' => $surah['name'],
                        'surah_number' => $surah['number']
                    ];
                }
            }
        }
        $pageNumbers = array_keys($mushafPages);
        sort($pageNumbers);
    @endphp

    <main class="max-w-4xl mx-auto mt-6 md:mt-10 px-3 md:px-4">

        @if(!empty($mushafPages))
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md rounded-2xl p-4 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between sticky top-[80px] md:top-[100px] z-40">
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
                    <span class="text-sm font-bold text-gray-500 dark:text-gray-400">القارئ:</span>
                    <select id="audio-reciter" class="w-full md:w-auto bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-gold text-sm font-bold">
                        <option value="ar.minshawi">الشيخ محمد صديق المنشاوي</option>
                        <option value="ar.abdulbasitmurattal">الشيخ عبد الباسط عبد الصمد</option>
                        <option value="ar.alafasy">الشيخ مشاري العفاسي</option>
                        <option value="ar.husary">الشيخ محمود خليل الحصري</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button onclick="startSmartAudio()" id="btn-play" class="flex-1 md:flex-none bg-gold text-islamic px-6 py-2 rounded-lg font-bold hover:bg-yellow-500 transition shadow-md flex items-center justify-center gap-2">
                        <span>▶</span> <span>تشغيل من هذه الصفحة</span>
                    </button>
                    <button onclick="stopAudio()" id="btn-stop" class="hidden flex-1 md:flex-none bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 transition shadow-md flex items-center justify-center gap-2">
                        <span>⏹</span> <span>إيقاف</span>
                    </button>
                </div>
            </div>

            <audio id="global-audio" class="hidden"></audio>

            <div id="mushaf-book" class="relative">
                @foreach($pageNumbers as $index => $pageNum)
                    <div class="mushaf-page {{ $index === 0 ? 'block animate-page' : 'hidden' }}" id="page-index-{{ $index }}">

                        <div class="mushaf-paper px-4 py-8 md:px-12 md:py-12 rounded-xl mb-6">
                            @php
                                $pageSurahs = collect($mushafPages[$pageNum])->pluck('surah_name')->unique();
                            @endphp
                            <div class="flex justify-between items-center border-b-2 border-gold/50 pb-2 mb-6">
                                <span class="font-bold text-sm md:text-base text-islamic dark:text-gold">سورة {{ $pageSurahs->implode(' ، ') }}</span>
                                <span class="font-bold text-sm md:text-base text-islamic dark:text-gold">الجزء {{ $juz->juz_number }}</span>
                            </div>

                            <div class="quran-text leading-[2.6] md:leading-[3] text-[24px] md:text-[28px] text-gray-900 dark:text-gray-100">
                                @php $currentSurah = 0; @endphp
                                @foreach($mushafPages[$pageNum] as $ayah)
                                    @if($ayah['surah_number'] != $currentSurah)
                                        @if($currentSurah != 0) <br> @endif
                                        <div class="my-6 py-3 bg-islamic text-gold text-center font-bold text-2xl md:text-3xl rounded-lg border-2 border-gold shadow-md" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');">
                                            سُورَةُ {{ $ayah['surah_name'] }}
                                        </div>
                                        @php $currentSurah = $ayah['surah_number']; @endphp
                                    @endif

                                    <span class="ayah-span inline" data-global-id="{{ $ayah['global_id'] }}" onclick="highlightAyah(this)">
                                        {{ $ayah['text'] }}
                                        <span class="ayah-number">{{ $ayah['numberInSurah'] }}</span>
                                    </span>
                                @endforeach
                            </div>

                            <div class="text-center mt-8 pt-2 border-t-2 border-gold/50 font-bold text-sm md:text-base text-islamic dark:text-gold">
                                {{ $pageNum }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-12">
                <button onclick="prevPage()" id="btn-prev" class="bg-islamic text-white px-4 md:px-6 py-2 md:py-3 rounded-xl font-bold shadow-md hover:bg-emerald-900 transition flex gap-1 md:gap-2 items-center text-sm md:text-base disabled:opacity-50">
                    <span>السابق</span>
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <span id="page-counter" class="font-bold text-lg text-gray-700 dark:text-gold font-sans">
                    1 / {{ count($pageNumbers) }}
                </span>

                <button onclick="nextPage()" id="btn-next" class="bg-islamic text-white px-4 md:px-6 py-2 md:py-3 rounded-xl font-bold shadow-md hover:bg-emerald-900 transition flex gap-1 md:gap-2 items-center text-sm md:text-base disabled:opacity-50">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span>التالي</span>
                </button>
            </div>

            <div class="mt-8 text-center">
                <button type="button" onclick="document.getElementById('doaaModal').classList.remove('hidden')" class="w-full md:w-auto bg-gradient-to-r from-yellow-600 to-yellow-400 text-islamic px-8 py-4 md:px-14 md:py-6 rounded-2xl md:rounded-full font-bold text-xl md:text-2xl hover:scale-105 transition-transform shadow-[0_10px_30px_rgba(212,175,55,0.4)]">
                    أتممت قراءة الجزء بفضل الله
                </button>
            </div>

        @else
            <p class="text-center text-red-500 font-bold text-xl p-10">عذراً، تأكد من اتصال الإنترنت.</p>
        @endif
    </main>

    <div id="doaaModal" class="hidden fixed inset-0 bg-black/90 backdrop-blur-sm flex items-center justify-center z-[100] px-4">
        <div class="bg-white dark:bg-gray-900 rounded-3xl md:rounded-[40px] p-6 md:p-10 max-w-2xl w-full shadow-2xl relative border-4 border-gold">
            <h3 class="text-3xl md:text-4xl font-bold text-islamic dark:text-gold mb-6 md:mb-8 text-center font-['Amiri']">دعاء الختم</h3>
            <div class="bg-[#f8fafc] dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-5 md:p-8 rounded-2xl md:rounded-3xl mb-8 shadow-inner">
                <p class="text-xl md:text-2xl text-gray-800 dark:text-white leading-loose text-center font-bold font-['Amiri']">
                    "اللهم اجعل هذا القرآن العظيم شفيعاً لـ (زين العابدين محمد سليم السكري) ونوراً في قبره، وارزقه الفردوس الأعلى من الجنة بغير حساب ولا سابقة عذاب."
                </p>
            </div>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <form action="{{ route('khatma.complete', $juz->id) }}" method="POST" class="w-full md:w-auto">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 md:px-10 md:py-4 bg-islamic text-white font-bold rounded-xl hover:bg-emerald-900 transition shadow-xl text-lg md:text-xl">إنهاء وتسجيل الجزء</button>
                </form>
                <button type="button" onclick="document.getElementById('doaaModal').classList.add('hidden')" class="w-full md:w-auto px-6 py-3 md:px-10 md:py-4 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-white font-bold rounded-xl hover:bg-gray-300 transition text-lg md:text-xl">إلغاء</button>
            </div>
        </div>
    </div>

    <script>
        let currentPageIdx = 0;
        const totalPages = {{ isset($pageNumbers) ? count($pageNumbers) : 0 }};
        const pages = document.querySelectorAll('.mushaf-page');

        function updatePagination() {
            pages.forEach((page, idx) => {
                if(idx === currentPageIdx) {
                    page.classList.remove('hidden');
                    page.classList.add('animate-page');
                } else {
                    page.classList.add('hidden');
                    page.classList.remove('animate-page');
                }
            });

            document.getElementById('page-counter').innerText = (currentPageIdx + 1) + ' / ' + totalPages;
            document.getElementById('btn-prev').disabled = (currentPageIdx === 0);
            document.getElementById('btn-next').disabled = (currentPageIdx === totalPages - 1);
        }

        function nextPage() {
            if(currentPageIdx < totalPages - 1) {
                currentPageIdx++;
                updatePagination();
                window.scrollTo({ top: document.getElementById('mushaf-book').offsetTop - 80, behavior: 'smooth' });
            }
        }

        function prevPage() {
            if(currentPageIdx > 0) {
                currentPageIdx--;
                updatePagination();
                window.scrollTo({ top: document.getElementById('mushaf-book').offsetTop - 80, behavior: 'smooth' });
            }
        }

        if(totalPages > 0) updatePagination();

        // ----------------------------------------------------
        // نظام التلاوة السريعة (بدون تقطيع) بالتحميل المسبق الخفي
        // ----------------------------------------------------
        let playlist = [];
        let currentAudioIdx = 0;
        const audioElement = document.getElementById('global-audio');
        let isPlaying = false;
        let nextAudioPreload = null; // الكائن المسؤول عن الكاش المسبق

        function highlightAyah(element) {
            document.querySelectorAll('.ayah-span').forEach(el => el.classList.remove('active-ayah'));
            if(element) element.classList.add('active-ayah');
        }

        function startSmartAudio() {
            const activePage = document.getElementById('page-index-' + currentPageIdx);
            if (!activePage) return;

            const allAyahs = Array.from(document.querySelectorAll('.ayah-span'));
            const firstAyahInPage = activePage.querySelector('.ayah-span');
            const startIndex = allAyahs.indexOf(firstAyahInPage);

            if (startIndex === -1) return;

            playlist = allAyahs.slice(startIndex);
            currentAudioIdx = 0;
            isPlaying = true;

            document.getElementById('btn-play').classList.add('hidden');
            document.getElementById('btn-stop').classList.remove('hidden');

            playCurrentAyahFromList();
        }

        function playCurrentAyahFromList() {
            if (currentAudioIdx >= playlist.length) {
                stopAudio();
                return;
            }

            const reciterCode = document.getElementById('audio-reciter').value;
            const currentAyahSpan = playlist[currentAudioIdx];
            const globalAyahId = currentAyahSpan.getAttribute('data-global-id');

            highlightAyah(currentAyahSpan);

            const pageDiv = currentAyahSpan.closest('.mushaf-page');
            const targetPageIdx = parseInt(pageDiv.id.replace('page-index-', ''));
            if (targetPageIdx !== currentPageIdx) {
                currentPageIdx = targetPageIdx;
                updatePagination();
            }

            // تشغيل الصوت الفوري للآية الحالية (غالباً محملة مسبقاً في الكاش)
            audioElement.src = `https://cdn.islamic.network/quran/audio/128/${reciterCode}/${globalAyahId}.mp3`;
            audioElement.play();

            // فكرة عبقرية: البدء فوراً في تحميل الآية التالية بالخلفية لإنهاء التوقف
            preloadNextAyah();
        }

        function preloadNextAyah() {
            const nextIdx = currentAudioIdx + 1;
            if (nextIdx < playlist.length) {
                const reciterCode = document.getElementById('audio-reciter').value;
                const nextAyahSpan = playlist[nextIdx];
                const nextGlobalAyahId = nextAyahSpan.getAttribute('data-global-id');

                // إجبار المتصفح على بدء تحميل الداتا للآية القادمة من الآن
                nextAudioPreload = new Audio();
                nextAudioPreload.src = `https://cdn.islamic.network/quran/audio/128/${reciterCode}/${nextGlobalAyahId}.mp3`;
                nextAudioPreload.preload = "auto";
                nextAudioPreload.load();
            }
        }

        audioElement.addEventListener('ended', () => {
            if(isPlaying) {
                currentAudioIdx++;
                playCurrentAyahFromList();
            }
        });

        function stopAudio() {
            isPlaying = false;
            audioElement.pause();
            document.getElementById('btn-play').classList.remove('hidden');
            document.getElementById('btn-stop').classList.add('hidden');
            document.querySelectorAll('.ayah-span').forEach(el => el.classList.remove('active-ayah'));
            nextAudioPreload = null;
        }
    </script>
</body>
</html>
