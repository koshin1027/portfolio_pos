
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/startsystem.css">
@endsection

@section('body-content')
    @livewire('start-up')
@endsection

@section('js')
 <script>
        // パーティクルの生成
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // ランダムなサイズ、位置、アニメーション時間を設定
                const size = Math.random() * 5 + 2;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                particle.style.opacity = Math.random() * 0.3 + 0.05;
                
                // アニメーションを追加
                particle.style.animation = `float ${duration}s ${delay}s infinite linear`;
                
                // キーフレームアニメーションを動的に作成
                const keyframes = `
                    @keyframes float {
                        0% {
                            transform: translate(0, 0) rotate(0deg);
                            opacity: ${Math.random() * 0.3 + 0.05};
                        }
                        25% {
                            transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) rotate(${Math.random() * 360}deg);
                            opacity: ${Math.random() * 0.3 + 0.1};
                        }
                        50% {
                            transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) rotate(${Math.random() * 360}deg);
                            opacity: ${Math.random() * 0.3 + 0.05};
                        }
                        75% {
                            transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) rotate(${Math.random() * 360}deg);
                            opacity: ${Math.random() * 0.3 + 0.1};
                        }
                        100% {
                            transform: translate(0, 0) rotate(0deg);
                            opacity: ${Math.random() * 0.3 + 0.05};
                        }
                    }
                `;
                
                // スタイルシートにキーフレームを追加
                const styleSheet = document.createElement('style');
                styleSheet.textContent = keyframes;
                document.head.appendChild(styleSheet);
                
                particlesContainer.appendChild(particle);
            }
        }
        
        // 起動シーケンス
        function startupSequence() {
            const progressBar = document.getElementById('progressBar');
            const statusMessage = document.getElementById('statusMessage');
            const loadingContainer = document.getElementById('loadingContainer');
            const loadingText = document.getElementById('loadingText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const startButton = document.getElementById('startButton');
            
            const statusMessages = [
                "初期化しています...",
                "システムファイルを読み込み中...",
                "データベースに接続中...",
                "商品マスタを同期中...",
                "売上データを準備中...",
                "周辺機器を確認中...",
                "設定を適用中...",
                "起動処理を完了中..."
            ];
            
            let progress = 0;
            let messageIndex = 0;
            
            // プログレスバーとステータスメッセージの更新
            const interval = setInterval(() => {
                // 進捗を更新
                progress += Math.random() * 5 + 1;
                
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    
                    // ローディング表示を非表示にする
                    loadingContainer.style.display = 'none';
                    
                    // スタートボタンを表示
                    startButton.classList.add('visible');
                }
                
                // プログレスバーの更新
                progressBar.style.width = `${progress}%`;
                
                // 進捗に応じてメッセージを更新
                if (progress > (messageIndex + 1) * (100 / statusMessages.length)) {
                    messageIndex = Math.min(messageIndex + 1, statusMessages.length - 1);
                    statusMessage.textContent = statusMessages[messageIndex];
                    
                    // メッセージ変更時のアニメーション
                    statusMessage.style.animation = 'none';
                    void statusMessage.offsetWidth; // リフロー
                    statusMessage.style.animation = 'fadeIn 0.5s ease-out';
                }
                
            }, 200);
        }
        
        // ページ読み込み完了時に実行
        window.addEventListener('load', () => {
            createParticles();
            startupSequence();
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9640f9ce031de357',t:'MTc1MzMzNDUwNC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>
@endsection

