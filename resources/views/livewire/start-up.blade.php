<div>
    <div class="background"></div>
    <div class="grid"></div>
    <div class="particles" id="particles"></div>
    <div class="glow"></div>
    
    <div class="container">
        <div class="logo-container">
            <div class="logo">
                <div class="logo-circle">
                    <div class="logo-inner">
                        <svg class="logo-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                            <path d="M4 15h8"/>
                            <path d="M16 15h4"/>
                            <path d="M4 19h4"/>
                            <path d="M12 19h8"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <h1 class="title">POSシステム</h1>
        <p class="subtitle">ポートフォリオ</p>
        
        <button wire:click="gotoLoginPage" class="start-button" id="startButton">スタート</button>
        
        <div class="loading-container" id="loadingContainer">
            <div class="loading-spinner" id="loadingSpinner"></div>
            <div class="loading-text" id="loadingText">システム起動中...</div>
            <div class="loading-progress">
                <div class="progress-bar" id="progressBar"></div>
            </div>
            <div class="status-message" id="statusMessage">初期化しています...</div>
        </div>
    </div>
    
    <div class="system-info">
        <div>店舗ID: ST-12345</div>
        <div>端末番号: POS-001</div>
    </div>
    
    <div class="version">バージョン 2.5.3</div>
</div>
