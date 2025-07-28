
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/loginsystem.css">
@endsection

@section('body-content')
    @livewire('login')
@endsection

@section('js')
 <script>
        // DOM要素の取得
        const formContainer = document.getElementById('formContainer');
        const showSignupBtn = document.getElementById('showSignup');
        const showLoginBtn = document.getElementById('showLogin');
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');
        const toggleLoginPassword = document.getElementById('toggleLoginPassword');
        const toggleSignupPassword = document.getElementById('toggleSignupPassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        
        // フォーム切り替え
        showSignupBtn.addEventListener('click', (e) => {
            e.preventDefault();
            formContainer.style.transform = 'translateX(-50%)';
        });
        
        showLoginBtn.addEventListener('click', (e) => {
            e.preventDefault();
            formContainer.style.transform = 'translateX(0)';
        });
        
        // パスワード表示切り替え
        function togglePasswordVisibility(inputId, buttonElement) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            // アイコン切り替え
            if (type === 'text') {
                buttonElement.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                `;
            } else {
                buttonElement.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                `;
            }
        }
        
        toggleLoginPassword.addEventListener('click', () => {
            togglePasswordVisibility('loginPassword', toggleLoginPassword);
        });
        
        toggleSignupPassword.addEventListener('click', () => {
            togglePasswordVisibility('signupPassword', toggleSignupPassword);
        });
        
        toggleConfirmPassword.addEventListener('click', () => {
            togglePasswordVisibility('confirmPassword', toggleConfirmPassword);
        });
        
        // バリデーション関数
        // function validateId(id) {
        //     return id.trim().length >= 4;
        // }
        
        // function validateEmail(email) {
        //     const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //     return re.test(email.toLowerCase());
        // }
        
        // function validatePassword(password) {
        //     return password.length >= 8;
        // }
        
        // function validateConfirmPassword(password, confirmPassword) {
        //     return password === confirmPassword;
        // }
        
        // // エラー表示関数
        // function showError(inputElement, errorElement, isValid) {
        //     if (!isValid) {
        //         inputElement.classList.add('error');
        //         inputElement.classList.remove('success');
        //         errorElement.style.display = 'block';
        //     } else {
        //         inputElement.classList.remove('error');
        //         inputElement.classList.add('success');
        //         errorElement.style.display = 'none';
        //     }
        // }
        
        // // ログインフォーム送信
        // loginForm.addEventListener('submit', (e) => {
        //     e.preventDefault();
            
        //     const loginId = document.getElementById('loginId');
        //     const loginPassword = document.getElementById('loginPassword');
        //     const loginIdError = document.getElementById('loginIdError');
        //     const loginPasswordError = document.getElementById('loginPasswordError');
            
        //     const isIdValid = validateId(loginId.value);
        //     const isPasswordValid = loginPassword.value.trim() !== '';
            
        //     showError(loginId, loginIdError, isIdValid);
        //     showError(loginPassword, loginPasswordError, isPasswordValid);
            
        //     if (isIdValid && isPasswordValid) {
        //         // ここでログイン処理を行う
        //         // 例: APIリクエストを送信するなど
        //         console.log('ログイン処理:', {
        //             id: loginId.value,
        //             password: loginPassword.value,
        //             rememberMe: document.getElementById('rememberMe').checked
        //         });
                
        //         // 成功時の処理（例：ダッシュボードへリダイレクト）
        //         alert('ログインに成功しました！');
        //         // window.location.href = '/dashboard';
        //     }
        // });
        
        // // 登録フォーム送信
        // signupForm.addEventListener('submit', (e) => {
        //     e.preventDefault();
            
        //     const signupId = document.getElementById('signupId');
        //     const signupEmail = document.getElementById('signupEmail');
        //     const signupPassword = document.getElementById('signupPassword');
        //     const confirmPassword = document.getElementById('confirmPassword');
            
        //     const signupIdError = document.getElementById('signupIdError');
        //     const signupEmailError = document.getElementById('signupEmailError');
        //     const signupPasswordError = document.getElementById('signupPasswordError');
        //     const confirmPasswordError = document.getElementById('confirmPasswordError');
            
        //     const isIdValid = validateId(signupId.value);
        //     const isEmailValid = validateEmail(signupEmail.value);
        //     const isPasswordValid = validatePassword(signupPassword.value);
        //     const isConfirmPasswordValid = validateConfirmPassword(signupPassword.value, confirmPassword.value);
            
        //     showError(signupId, signupIdError, isIdValid);
        //     showError(signupEmail, signupEmailError, isEmailValid);
        //     showError(signupPassword, signupPasswordError, isPasswordValid);
        //     showError(confirmPassword, confirmPasswordError, isConfirmPasswordValid);
            
        //     if (isIdValid && isEmailValid && isPasswordValid && isConfirmPasswordValid) {
        //         // ここで登録処理を行う
        //         // 例: APIリクエストを送信するなど
        //         console.log('登録処理:', {
        //             id: signupId.value,
        //             email: signupEmail.value,
        //             password: signupPassword.value
        //         });
                
        //         // 成功時の処理
        //         alert('アカウント登録に成功しました！ログインしてください。');
                
        //         // フォームをリセットしてログイン画面に戻る
        //         signupForm.reset();
        //         formContainer.style.transform = 'translateX(0)';
        //     }
        // });
        
        // // 入力フィールドのリアルタイムバリデーション
        // document.getElementById('signupId').addEventListener('input', function() {
        //     const isValid = validateId(this.value);
        //     showError(this, document.getElementById('signupIdError'), isValid);
        // });
        
        // document.getElementById('signupEmail').addEventListener('input', function() {
        //     const isValid = validateEmail(this.value);
        //     showError(this, document.getElementById('signupEmailError'), isValid);
        // });
        
        // document.getElementById('signupPassword').addEventListener('input', function() {
        //     const isValid = validatePassword(this.value);
        //     showError(this, document.getElementById('signupPasswordError'), isValid);
            
        //     // パスワード確認フィールドも再検証
        //     const confirmPassword = document.getElementById('confirmPassword');
        //     if (confirmPassword.value) {
        //         const isConfirmValid = validateConfirmPassword(this.value, confirmPassword.value);
        //         showError(confirmPassword, document.getElementById('confirmPasswordError'), isConfirmValid);
        //     }
        // });
        
        // document.getElementById('confirmPassword').addEventListener('input', function() {
        //     const password = document.getElementById('signupPassword').value;
        //     const isValid = validateConfirmPassword(password, this.value);
        //     showError(this, document.getElementById('confirmPasswordError'), isValid);
        // });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9643ad6b5274d793',t:'MTc1MzM2MjgzMy4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>

@endsection
