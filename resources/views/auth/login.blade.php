<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Figtree', sans-serif;
            }
            
            body {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #1a5f1a, #DAA520,rgb(27, 101, 49));
                color: #333;
                position: relative;
                overflow: hidden;
                padding: 2rem;
            }
            
            /* Wave Animation */
            .wave-container {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                overflow: hidden;
            }
            
            .wave {
                position: absolute;
                width: 200%;
                height: 200%;
                top: -50%;
                left: 50%;
                border-radius: 40%;
                background: rgba(46, 106, 48, 0.3);
                animation: wave 15s linear infinite;
            }
            
            .wave:nth-child(2) {
                background: rgba(215, 230, 7, 0.2);
                animation: wave 18s linear infinite reverse;
                animation-delay: -5s;
            }
            
            .wave:nth-child(3) {
                background: rgba(172, 148, 14, 0.25);
                animation: wave 20s linear infinite;
                animation-delay: -4s;
            }
            
            @keyframes wave {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            /* Animated shapes */
            .shape {
                position: absolute;
                border-radius: 50%;
                opacity: 0.15;
                animation: float 6s ease-in-out infinite;
            }
            
            .shape:nth-child(1) {
                width: 80px;
                height: 80px;
                background: rgb(255, 200, 0);
                top: 20%;
                left: 10%;
                animation-delay: 0s;
            }
            
            .shape:nth-child(2) {
                width: 120px;
                height: 120px;
                background: #8B4513;
                top: 60%;
                right: 15%;
                animation-delay: 2s;
            }
            
            .shape:nth-child(3) {
                width: 60px;
                height: 60px;
                background: #DAA520;
                bottom: 20%;
                left: 20%;
                animation-delay: 4s;
            }
            
            .shape:nth-child(4) {
                width: 100px;
                height: 100px;
                background: #CD853F;
                top: 30%;
                right: 30%;
                animation-delay: 1s;
            }
            
            .shape:nth-child(5) {
                width: 70px;
                height: 70px;
                background: #FFD700;
                bottom: 40%;
                right: 10%;
                animation-delay: 3s;
            }
            
            .shape:nth-child(6) {
                width: 90px;
                height: 90px;
                background: #A0522D;
                top: 70%;
                left: 60%;
                animation-delay: 1.5s;
            }
            
            .shape:nth-child(7) {
                width: 50px;
                height: 50px;
                background: #F4A460;
                top: 10%;
                right: 60%;
                animation-delay: 2.5s;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                33% { transform: translateY(-20px) rotate(120deg); }
                66% { transform: translateY(10px) rotate(240deg); }
            }
            
            .login-container {
                background-color: rgba(255, 255, 255, 0.95);
                border-radius: 12px;
                padding: 2.5rem;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                text-align: center;
                max-width: 400px;
                width: 100%;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                z-index: 10;
            }
            
            .logo {
                font-size: 2rem;
                font-weight: bold;
                color: #1a5f1a;
                margin-bottom: 1.5rem;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            .subtitle {
                margin-bottom: 2rem;
                font-size: 1.1rem;
                color: #555;
                font-weight: 500;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
                text-align: left;
            }
            
            label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 600;
                color: #1a5f1a;
                font-size: 0.9rem;
            }
            
            input[type="text"],
            input[type="password"],
            input[type="email"] {
                width: 100%;
                padding: 0.875rem;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background-color: rgba(255, 255, 255, 0.9);
            }
            
            input[type="text"]:focus,
            input[type="password"]:focus,
            input[type="email"]:focus {
                outline: none;
                border-color: #1a5f1a;
                box-shadow: 0 0 0 3px rgba(26, 95, 26, 0.1);
                background-color: white;
            }
            
            .checkbox-group {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
            }
            
            .checkbox-group input[type="checkbox"] {
                margin-right: 0.5rem;
                width: auto;
            }
            
            .checkbox-group label {
                margin-bottom: 0;
                font-size: 0.9rem;
                color: #666;
            }
            
            .error-message {
                background-color: #fee2e2;
                border: 1px solid #fecaca;
                color: #dc2626;
                padding: 0.75rem;
                border-radius: 8px;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
            }
            
            .success-message {
                background-color: #dcfce7;
                border: 1px solid #bbf7d0;
                color: #16a34a;
                padding: 0.75rem;
                border-radius: 8px;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
            }
            
            .form-actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 2rem;
            }
            
            .forgot-link {
                color: #1a5f1a;
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 500;
                transition: color 0.3s ease;
            }
            
            .forgot-link:hover {
                color: #0f4f0f;
                text-decoration: underline;
            }
            
            .submit-btn {
                background: linear-gradient(135deg, #1a5f1a);
                color: white;
                padding: 0.875rem 2rem;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(26, 95, 26, 0.3);
            }
            
            .submit-btn:hover {
                background: linear-gradient(135deg, #0f4f0f,rgb(192, 165, 29));
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(26, 95, 26, 0.4);
            }
            
            .back-link {
                display: inline-block;
                margin-top: 1.5rem;
                color: #1a5f1a;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.3s ease;
            }
            
            .back-link:hover {
                color: #0f4f0f;
                text-decoration: underline;
            }
            
            .farm-bg {
                position: absolute;
                top: 0; left: 0; width: 100vw; height: 100vh;
                object-fit: cover;
                opacity: 0.18;
                z-index: 0;
                pointer-events: none;
            }
        </style>
    </head>
    <body>
        <!-- Farm AI Image Background -->
        <img src="Logo.png" alt="Farm background" class="farm-bg">
        <!-- Wave Animation -->
        <div class="wave-container">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        
        <!-- Animated background shapes -->
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        
        <div class="login-container">
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.2rem; margin-bottom: 1.5rem;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo" style="height: 3.5rem; width: 3.5rem; object-fit: contain; margin-bottom: 0;">
                <div class="logo" style="margin-bottom: 0;">Department of Agriculture</div>
            </div>
            <p class="subtitle">Leave Management System</p>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- ID Number -->
                <div class="form-group">
                    <label for="id">ID Number</label>
                    <input id="id" type="text" name="id" value="{{ old('id') }}" required autofocus>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>

                <!-- Remember Me -->
                <div class="checkbox-group">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <div class="form-actions">
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif

                    <button type="submit" class="submit-btn">
                        Log in
                    </button>
                </div>
            </form>
            
            <a href="{{ url('/') }}" class="back-link">← Back to Home</a>
        </div>
    </body>
</html>
