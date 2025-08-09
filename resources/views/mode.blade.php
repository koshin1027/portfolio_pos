<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS レジスタート画面</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #121212;
            color: white;
        }
        .menu-item {
            transition: all 0.3s ease;
        }
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }
        .icon {
            stroke: white;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-6xl">
        <!-- ヘッダー部分 -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-white">POS システム</h1>
            <div class="text-right">
                <p class="text-gray-400" id="date">0000年00月00日</p>
                <p class="text-xl text-white" id="clock">00:00:00</p>
            </div>
        </div>

        <!-- メイン画像 -->
        <div class="mb-10 w-full h-48 bg-gray-800 rounded-lg overflow-hidden">
            <svg class="w-full h-full" viewBox="0 0 800 200">
                <defs>
                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#1a1a1a;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#333;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <rect width="800" height="200" fill="url(#grad1)" />
                <text x="400" y="100" font-size="32" fill="white" text-anchor="middle" dominant-baseline="middle">レジシステムへようこそ</text>
                <text x="400" y="140" font-size="18" fill="#aaa" text-anchor="middle" dominant-baseline="middle">操作を選択してください</text>
            </svg>
        </div>

        <!-- メニュー選択部分 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- 管理 -->
            <a href="{{ route('management') }}">
                <div class="menu-item bg-gray-900 rounded-lg p-8 flex flex-col items-center justify-center cursor-pointer border border-gray-700 h-64">
                    <svg class="w-24 h-24 mb-4 icon" viewBox="0 0 24 24">
                        <path d="M12 4V20M4 12H20" />
                        <circle cx="12" cy="12" r="9" />
                    </svg>
                    <h2 class="text-2xl font-bold mb-2">管理</h2>
                    <p class="text-gray-400 text-center">システム設定・売上管理</p>
                </div>
            </a>

            <!-- 注文 -->
            <a href="{{ route('order') }}">
                <div class="menu-item bg-gray-900 rounded-lg p-8 flex flex-col items-center justify-center cursor-pointer border border-gray-700 h-64">
                    <svg class="w-24 h-24 mb-4 icon" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M12 11v6M9 14h6" />
                    </svg>
                    <h2 class="text-2xl font-bold mb-2">注文</h2>
                    <p class="text-gray-400 text-center">注文入力・管理</p>
                </div>
            </a>

            <!-- キッチン -->
            <a href="{{ route('kitchen') }}">
                <div class="menu-item bg-gray-900 rounded-lg p-8 flex flex-col items-center justify-center cursor-pointer border border-gray-700 h-64">
                    <svg class="w-24 h-24 mb-4 icon" viewBox="0 0 24 24">
                        <path d="M15 3v4M6 3v4M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01" />
                        <path d="M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                    </svg>
                    <h2 class="text-2xl font-bold mb-2">キッチン</h2>
                    <p class="text-gray-400 text-center">調理状況・オーダー確認</p>
                </div>
            </a>

            <!-- レジ -->
            <a href="{{ route('cashier') }}">
                <div class="menu-item bg-gray-900 rounded-lg p-8 flex flex-col items-center justify-center cursor-pointer border border-gray-700 h-64">
                    <svg class="w-24 h-24 mb-4 icon" viewBox="0 0 24 24">
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                        <path d="M6 8h.01M6 12h.01M6 16h.01M10 8h8M10 12h8M10 16h8" />
                    </svg>
                    <h2 class="text-2xl font-bold mb-2">レジ</h2>
                    <p class="text-gray-400 text-center">会計・支払い処理</p>
                </div>
            </a>
        </div>
    </div>

    <script>
        // 時計機能
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
            // 日付表示
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            document.getElementById('date').textContent = `${year}年${month}月${day}日`;
        }
        
        setInterval(updateClock, 1000);
        updateClock();

    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9620441f575360ba',t:'MTc1Mjk5MTUxOS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
