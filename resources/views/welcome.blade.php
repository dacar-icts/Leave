<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Department of Agriculture</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Simple inline styles -->
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Figtree', sans-serif;
            }   
            
            body {
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #1a5f1a, #DAA520,rgb(27, 101, 49));
                color: #333;
                position: relative;
                overflow: hidden;
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
                width: 90%;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                z-index: 10;
            }
            
            .logo {
                font-size: 2rem;
                font-weight: bold;
                color: #1a5f1a;
                margin-bottom: 1rem;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                
            }
            
            .subtitle {
                margin-bottom: 2rem;
                font-size: 1.1rem;
                color: #555;
                font-weight: 500;
            }
            
            .auth-buttons {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            
            .auth-btn {
                display: block;
                padding: 0.875rem 1.5rem;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                font-size: 1rem;
                border: none;
                cursor: pointer;
            }
            .auth-btn::after,
            .auth-btn::before {
                content: '';
                position: absolute;
                width: 100%;
                height: 2px;
                background: linear-gradient(to right,rgb(3, 116, 22),rgba(106, 223, 11, 0.62));
                bottom: -2px;
                left: 0;
                transform: scaleX(0);
                transform-origin: right;
                transition: transform 0.4s ease-out;
            }

            .auth-btn::before {
                top: 0;
                transform-origin: left;
            }

            .auth-btn:hover::after,
            .auth-btn:hover::before {
                transform: scaleX(1);
            }
            
            .login-btn {
                background: linear-gradient(135deg, #1a5f1a);
                color: white;
                box-shadow: 0 4px 15px rgba(26, 95, 26, 0.3);
            }
            
            .login-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(26, 95, 26, 0.4);
            }
            
            .register-btn {
                border: 2px solid #DAA520;
                color: #8B4513;
                background-color: transparent;
                box-shadow: 0 4px 15px rgba(218, 165, 32, 0.1);
            }
            
            .register-btn:hover {
                background-color: rgba(218, 165, 32, 0.1);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(218, 165, 32, 0.2);
            }
            
            .copyright {
                margin-top: 2rem;
                font-size: 0.85rem;
                color: #666;
                opacity: 0.8;
            }
            
            .farm-bg {
                position: absolute;
                top: 0; left: 0; width: 100vw; height: 100vh;
                object-fit: cover;
                opacity: 0.1;
                z-index: 0;
                pointer-events: none;
            }
        </style>
    </head>
    <body>
        <img src="https://scontent.fcrk2-4.fna.fbcdn.net/v/t39.30808-6/514980160_1209280941214138_1730418219727192708_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeF53L51Xx3MJ5hm1eYyNliNehNBuVencX96E0G5V6dxf1dUWnmTV00elXiiUXtocUIDoUPmgiMkeLOHOSWaYfUE&_nc_ohc=gJiqtDVyl30Q7kNvwGPIexx&_nc_oc=AdkyReODcZ-Pi8UClM7oqFyedkQmUWrnWS5ol9VLBNJawib9Tkb3aRmFC27KHvFmDsY&_nc_zt=23&_nc_ht=scontent.fcrk2-4.fna&_nc_gid=CK1NJoDxCY8QwSPz4PQP2Q&oh=00_AfObHco4VYuBB4G73HjdjxQio2_Usd5rcowvz-9dENfmxQ&oe=686A4491" alt="Farm background" class="farm-bg">
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
            <div class="logo" style="display: flex; align-items: center; gap: 0.2rem;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo" style="height: 3.5rem; width: 3.5rem; object-fit: contain;">
                <span>Department of Agriculture</span>
            </div>
            <p class="subtitle">Leave Management System</p>
            
            @php
                $dashboardUrl = route('dashboard');
                if (auth()->check()) {
                    $user = auth()->user();
                    if ($user->isAdmin() || $user->id == 2) {
                        $dashboardUrl = route('admin.dashboard');
                    } elseif ($user->isHR() || $user->id == 4) {
                        $dashboardUrl = route('hr.dashboard');
                    }
                }
            @endphp
            
            @if (Route::has('login'))
                <div class="auth-buttons">
                    @auth
                        <a href="{{ $dashboardUrl }}" class="auth-btn login-btn">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="auth-btn login-btn">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="auth-btn register-btn">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Department of Agriculture</p>
            </div>
        </div>
    </body>
</html>
