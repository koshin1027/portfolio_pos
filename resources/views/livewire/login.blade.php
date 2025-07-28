<div>
    <div class="container">
        <div class="form-container" id="formContainer">
            <!-- ログインフォーム -->
            <div class="login-container">
                <div class="logo">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#BB86FC" stroke-width="2"/>
                        <path d="M12 7V12L15 15" stroke="#BB86FC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                <div class="form-header">
                    <h2>ログイン</h2>
                    <p>アカウントにログインしてください</p>
                </div>
                
                <form id="loginForm">
                    <div class="form-group">
                        <label for="loginId">ユーザーID</label>
                        <input type="text" id="loginId" class="form-input" placeholder="ユーザーIDを入力" required>
                        <div class="error-message" id="loginIdError">有効なユーザーIDを入力してください</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="loginPassword">パスワード</label>
                        <div class="password-container">
                            <input type="password" id="loginPassword" class="form-input" placeholder="パスワードを入力" required>
                            <button type="button" class="toggle-password" id="toggleLoginPassword">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <div class="error-message" id="loginPasswordError">パスワードを入力してください</div>
                    </div>
                    
                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input type="checkbox" id="rememberMe">
                            ログイン状態を保持
                        </label>
                        <a href="#" class="forgot-password">パスワードを忘れた場合</a>
                    </div>
                    
                    <button wire:click="gotoModePage" type="submit" class="btn btn-primary">ログイン</button>
                    
                    <div class="divider">または</div>
                    
                    <div class="social-login">
                        <a href="#" class="social-btn">
                            <svg class="social-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934 0-.528-.081-1.097-.202-1.625z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-btn">
                            <svg class="social-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-btn">
                            <svg class="social-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.995 6.686a8.1 8.1 0 0 1-2.32.636 4.066 4.066 0 0 0 1.78-2.236 8.14 8.14 0 0 1-2.564.98 4.05 4.05 0 0 0-6.9 3.694 11.508 11.508 0 0 1-8.363-4.236 4.05 4.05 0 0 0 1.253 5.412 4.015 4.015 0 0 1-1.84-.507l-.001.05a4.05 4.05 0 0 0 3.251 3.972 4.09 4.09 0 0 1-1.83.07 4.053 4.053 0 0 0 3.785 2.812 8.118 8.118 0 0 1-5.992 1.679 11.457 11.457 0 0 0 6.207 1.82c7.44 0 11.512-6.166 11.512-11.514 0-.175-.004-.35-.012-.523a8.215 8.215 0 0 0 2.016-2.092z"/>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="form-footer">
                        アカウントをお持ちでない場合は <a href="#" id="showSignup">登録する</a>
                    </div>
                </form>
            </div>
            
            <!-- 登録フォーム -->
            <div class="signup-container">
                <div class="logo">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#BB86FC" stroke-width="2"/>
                        <path d="M12 8V16M8 12H16" stroke="#BB86FC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                <div class="form-header">
                    <h2>アカウント登録</h2>
                    <p>新しいアカウントを作成してください</p>
                </div>
                
                <form id="signupForm">
                    <div class="form-group">
                        <label for="signupId">ユーザーID</label>
                        <input type="text" id="signupId" class="form-input" placeholder="ユーザーIDを入力" required>
                        <div class="error-message" id="signupIdError">4文字以上のユーザーIDを入力してください</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="signupEmail">メールアドレス</label>
                        <input type="email" id="signupEmail" class="form-input" placeholder="メールアドレスを入力" required>
                        <div class="error-message" id="signupEmailError">有効なメールアドレスを入力してください</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="signupPassword">パスワード</label>
                        <div class="password-container">
                            <input type="password" id="signupPassword" class="form-input" placeholder="パスワードを入力" required>
                            <button type="button" class="toggle-password" id="toggleSignupPassword">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <div class="error-message" id="signupPasswordError">8文字以上のパスワードを入力してください</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirmPassword">パスワード（確認）</label>
                        <div class="password-container">
                            <input type="password" id="confirmPassword" class="form-input" placeholder="パスワードを再入力" required>
                            <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <div class="error-message" id="confirmPasswordError">パスワードが一致しません</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">アカウント作成</button>
                    
                    <div class="form-footer">
                        すでにアカウントをお持ちの場合は <a href="#" id="showLogin">ログイン</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>