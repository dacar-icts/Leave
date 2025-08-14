<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

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
                background: linear-gradient(135deg, #0f3a0f, #1a5f1a, rgba(101, 151, 3, 0.94), #2d7a2d);
                background-size: 400% 400%;
                animation: gradientShift 6s ease infinite;
                color: #333;
                position: relative;
                overflow: hidden;
            }

            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* SVG Background Pattern */
            .svg-background {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 1;
            }
            
            /* Wave Animation */
            .wave-container {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                overflow: hidden;
                z-index: 2;
            }
            
            .wave {
                position: absolute;
                width: 200%;
                height: 200%;
                top: -50%;
                left: 50%;
                border-radius: 40%;
                background: rgba(46, 106, 48, 0.2);
                animation: wave 7s linear infinite;
            }
            
            .wave:nth-child(2) {
                background: rgba(215, 230, 7, 0.15);
                animation: wave 9s linear infinite reverse;
                animation-delay: -2s;
            }
            
            .wave:nth-child(3) {
                background: rgba(172, 148, 14, 0.18);
                animation: wave 10s linear infinite;
                animation-delay: -2s;
            }
            
            @keyframes wave {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            /* Animated shapes */
            .shape {
                position: absolute;
                border-radius: 50%;
                opacity: 0.12;
                animation: float 3s ease-in-out infinite;
            }
            
            .shape:nth-child(1) {
                width: 100px;
                height: 100px;
                background: radial-gradient(circle, #FFD700, #DAA520);
                top: 15%;
                left: 8%;
                animation-delay: 0s;
            }
            
            .shape:nth-child(2) {
                width: 140px;
                height: 140px;
                background: radial-gradient(circle, #CD853F, #8B4513);
                top: 65%;
                right: 12%;
                animation-delay: 3s;
            }
            
            .shape:nth-child(3) {
                width: 80px;
                height: 80px;
                background: radial-gradient(circle, #DAA520, #B8860B);
                bottom: 15%;
                left: 15%;
                animation-delay: 6s;
            }
            
            .shape:nth-child(4) {
                width: 120px;
                height: 120px;
                background: radial-gradient(circle, #F4A460, #CD853F);
                top: 25%;
                right: 25%;
                animation-delay: 2s;
            }
            
            .shape:nth-child(5) {
                width: 90px;
                height: 90px;
                background: radial-gradient(circle, #FFD700, #FFA500);
                bottom: 35%;
                right: 8%;
                animation-delay: 4s;
            }
            
            .shape:nth-child(6) {
                width: 110px;
                height: 110px;
                background: radial-gradient(circle, #A0522D, #8B4513);
                top: 75%;
                left: 55%;
                animation-delay: 1s;
            }
            
            .shape:nth-child(7) {
                width: 70px;
                height: 70px;
                background: radial-gradient(circle, #F4A460, #DEB887);
                top: 8%;
                right: 55%;
                animation-delay: 5s;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
                33% { transform: translateY(-30px) rotate(120deg) scale(1.1); }
                66% { transform: translateY(15px) rotate(240deg) scale(0.9); }
            }
            
            /* Floating wheat animation */
            .wheat {
                position: absolute;
                width: 2.2em;
                height: 2.2em;
                font-size: 2em;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0.8;
                animation: wheatFall 12s linear infinite;
                background: none;
            }
            .leaves .wheat:nth-child(1) { left: 5%;  top: 10%;  animation-delay: 0s;   transform: rotate(5deg);}
            .leaves .wheat:nth-child(2) { left: 15%; top: 30%;  animation-delay: 3s;  transform: rotate(-10deg);}
            .leaves .wheat:nth-child(3) { left: 25%; top: 60%;  animation-delay: 6s;  transform: rotate(8deg);}
            .leaves .wheat:nth-child(4) { left: 35%; top: 20%;  animation-delay: 9s;  transform: rotate(-7deg);}
            .leaves .wheat:nth-child(5) { left: 45%; top: 50%;  animation-delay: 1.5s;transform: rotate(12deg);}
            .leaves .wheat:nth-child(6) { left: 55%; top: 70%;  animation-delay: 4.5s;transform: rotate(-5deg);}
            .leaves .wheat:nth-child(7) { left: 65%; top: 40%;  animation-delay: 7.5s;transform: rotate(10deg);}
            .leaves .wheat:nth-child(8) { left: 75%; top: 80%;  animation-delay: 10.5s;transform: rotate(-12deg);}
            .leaves .wheat:nth-child(9) { left: 85%; top: 15%;  animation-delay: 2s;  transform: rotate(6deg);}
            .leaves .wheat:nth-child(10){ left: 95%; top: 55%;  animation-delay: 5s;  transform: rotate(-8deg);}
            @keyframes wheatFall {
                0% {
                    transform: translateY(-100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 0.8;
                }
                90% {
                    opacity: 0.7;
                }
                100% {
                    transform: translateY(100vh) rotate(360deg);
                    opacity: 0;
                }
            }
            
            /* Main container with enhanced styling */
            .login-container {
                background: rgba(255, 255, 255, 0.97);
                border-radius: 25px;
                padding: 3rem 2.5rem;
                box-shadow: 
                    0 25px 80px rgba(0, 0, 0, 0.25),
                    0 0 0 1px rgba(255, 255, 255, 0.05),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
                text-align: center;
                max-width: 450px;
                width: 92%;
                /* backdrop-filter: blur(20px); */
                border: 1px solid rgba(255, 255, 255, 0.18);
                position: relative;
                z-index: 10;
                animation: containerEntrance 0.7s cubic-bezier(0.4, 0, 0.2, 1);
                overflow: hidden;
            }

            .login-container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, #1a5f1a, #DAA520, #2d7a2d, #1a5f1a);
                background-size: 300% 100%;
                animation: shimmer 20s ease-in-out infinite;
            }

            @keyframes shimmer {
                0% { background-position: -300% 0; }
                100% { background-position: 300% 0; }
            }
            
            @keyframes containerEntrance {
                0% {
                    opacity: 0;
                    transform: translateY(60px) scale(0.8) rotateX(15deg);
                    filter: blur(0px);
                }
                50% {
                    opacity: 0.8;
                    transform: translateY(20px) scale(0.95) rotateX(5deg);
                    filter: blur(0px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1) rotateX(0deg);
                    filter: blur(0);
                }
            }
            
            .logo-container {
                margin-bottom: 2rem;
                position: relative;
            }
            
            .logo {
                font-size: 2rem;
                font-weight: 700;
                color: #1a5f1a;
                margin-bottom: 1rem;
                text-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                opacity: 0;
                animation: logoEntrance 0.7s cubic-bezier(0.4, 0, 0.2, 1) 0.2s forwards;
            }
            
            @keyframes logoEntrance {
                0% {
                    opacity: 0;
                    transform: translateY(30px) scale(0.8);
                    filter: blur(0);
                }
                60% {
                    opacity: 0.8;
                    transform: translateY(-5px) scale(1.05);
                    filter: blur(0);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                    filter: blur(0);
                }
            }
            
            .logo-icon {
                height: 3.5rem;
                width: 3.5rem;
                object-fit: contain;
                filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
                animation: iconFloat 1.2s ease-in-out infinite;
                transition: transform 0.2s ease;
            }

            .logo-icon:hover {
                transform: scale(1.1) rotate(5deg);
            }
            
            @keyframes iconFloat {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-8px) rotate(2deg); }
            }
            
            .subtitle {
                margin-bottom: 2rem;
                font-size: 1.1rem;
                color: #555;
                font-weight: 500;
                opacity: 0;
                animation: subtitleFadeIn 0.5s ease-out 0.4s forwards;
                position: relative;
            }

            .subtitle::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 80px;
                height: 2px;
                background: linear-gradient(90deg, transparent, #DAA520, transparent);
                opacity: 0;
                animation: underlineGrow 0.3s ease-out 0.7s forwards;
            }

            @keyframes underlineGrow {
                0% {
                    width: 0;
                    opacity: 0;
                }
                100% {
                    width: 80px;
                    opacity: 1;
                }
            }
            
            @keyframes subtitleFadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .form-container {
                opacity: 0;
                animation: formFadeIn 0.5s ease-out 0.7s forwards;
            }

            @keyframes formFadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(30px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
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
                padding: 0.875rem 1rem;
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background-color: rgba(255, 255, 255, 0.9);
                position: relative;
            }
            
            input[type="text"]:focus,
            input[type="password"]:focus,
            input[type="email"]:focus {
                outline: none;
                border-color: #1a5f1a;
                box-shadow: 0 0 0 3px rgba(26, 95, 26, 0.1);
                background-color: white;
                transform: scale(1.02);
            }
            
            .checkbox-group {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
            }
            
            .checkbox-group input[type="checkbox"] {
                margin-right: 0.5rem;
                width: auto;
                transform: scale(1.2);
            }
            
            .checkbox-group label {
                margin-bottom: 0;
                font-size: 0.9rem;
                color: #666;
            }
            
            .error-message {
                background: linear-gradient(135deg, #fee2e2, #fecaca);
                border: 1px solid #fecaca;
                color: #dc2626;
                padding: 0.75rem 1rem;
                border-radius: 12px;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
                animation: errorSlideIn 0.2s ease-out;
            }

            @keyframes errorSlideIn {
                0% {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .success-message {
                background: linear-gradient(135deg, #dcfce7, #bbf7d0);
                border: 1px solid #bbf7d0;
                color: #16a34a;
                padding: 0.75rem 1rem;
                border-radius: 12px;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
                animation: successSlideIn 0.2s ease-out;
            }

            @keyframes successSlideIn {
                0% {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
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
                transition: all 0.3s ease;
                position: relative;
            }

            .forgot-link::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #1a5f1a, #DAA520);
                transition: width 0.3s ease;
            }
            
            .forgot-link:hover {
                color: #0f4f0f;
                transform: translateY(-2px);
            }

            .forgot-link:hover::after {
                width: 100%;
            }
            
            .submit-btn {
                background: linear-gradient(135deg, #1a5f1a, #2d7a2d, #1a5f1a);
                background-size: 200% 200%;
                color: white;
                padding: 0.875rem 2rem;
                border: none;
                border-radius: 12px;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 10px 30px rgba(26, 95, 26, 0.4);
                position: relative;
                overflow: hidden;
                animation: gradientMove 1.2s ease infinite;
            }

            .submit-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.6s;
            }
            
            .submit-btn:hover::before {
                left: 100%;
            }

            @keyframes gradientMove {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .submit-btn:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 15px 40px rgba(26, 95, 26, 0.5);
            }
            
            .back-link {
                display: inline-block;
                margin-top: 1.5rem;
                color: #1a5f1a;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                position: relative;
            }

            .back-link::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #1a5f1a, #DAA520);
                transition: width 0.3s ease;
            }
            
            .back-link:hover {
                color: #0f4f0f;
                transform: translateY(-2px);
            }

            .back-link:hover::after {
                width: 100%;
            }
            
            /* Video background */
            .video-bg {
                position: fixed;
                top: 0; left: 0;
                width: 100vw;
                height: 100vh;
                object-fit: cover;
                z-index: 0;
                opacity: 0.18;
                pointer-events: none;
            }

            /* Responsive design */
            @media (max-width: 768px) {
                .login-container {
                    padding: 2rem 1.5rem;
                    margin: 1rem;
                }
                
                .logo {
                    font-size: 1.8rem;
                    flex-direction: column;
                    gap: 0.5rem;
                }
                
                .logo-icon {
                    height: 3rem;
                    width: 3rem;
                }
                
                .subtitle {
                    font-size: 1rem;
                }
                
                .form-actions {
                    flex-direction: column;
                    gap: 1rem;
                }
                
                .submit-btn {
                    width: 100%;
                }
            }

            /* Corn cursor for precise pointers (mouse/trackpad) */
            @media (pointer: fine) {
                html, body, * { cursor: none !important; }
                .custom-cursor {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 28px;
                    height: 28px;
                    display: grid;
                    place-items: center;
                    font-size: 24px;
                    z-index: 5000;
                    pointer-events: none;
                    transform: translate(-50%, -50%);
                    filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));
                    transition: opacity .15s ease, transform .06s linear;
                    opacity: 0;
                }
            }
        </style>
    </head>
    <body>
        <div id="cornCursor" class="custom-cursor" aria-hidden="true">🌽</div>
        <video class="video-bg" autoplay loop muted playsinline>
            <source src="/wheats.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <!-- SVG Background Pattern -->

            <!-- Decorative agricultural patterns -->
            <defs>
                <pattern id="wheatPattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <path d="M20,80 Q30,60 40,80 Q50,60 60,80 Q70,60 80,80" stroke="#DAA520" stroke-width="2" fill="none" opacity="0.1"/>
                    <circle cx="30" cy="70" r="2" fill="#DAA520" opacity="0.1"/>
                    <circle cx="50" cy="70" r="2" fill="#DAA520" opacity="0.1"/>
                    <circle cx="70" cy="70" r="2" fill="#DAA520" opacity="0.1"/>
                </pattern>
                
                <pattern id="leafPattern" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <path d="M20,40 Q30,20 40,40 Q30,60 20,40 Z" fill="#228B22" opacity="0.08"/>
                    <path d="M60,40 Q70,20 80,40 Q70,60 60,40 Z" fill="#32CD32" opacity="0.08"/>
                </pattern>
            </defs>
            
            <!-- Background patterns -->
            <rect width="100%" height="100%" fill="url(#wheatPattern)"/>
            <rect width="100%" height="100%" fill="url(#leafPattern)"/>
            
            <!-- Decorative corner elements -->
            <g opacity="0.1">
                <path d="M0,0 L100,0 L100,5 L5,5 L5,100 L0,100 Z" fill="#DAA520"/>
                <path d="M1200,0 L1100,0 L1100,5 L1195,5 L1195,100 L1200,100 Z" fill="#DAA520"/>
                <path d="M0,800 L100,800 L100,795 L5,795 L5,700 L0,700 Z" fill="#DAA520"/>
                <path d="M1200,800 L1100,800 L1100,795 L1195,795 L1195,700 L1200,700 Z" fill="#DAA520"/>
            </g>
        </svg>
        
        <!-- Wave Animation -->
        <!-- <div class="wave-container">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div> -->
        
        <!-- Animated background shapes -->
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        
        <!-- Floating wheat -->
        <!-- <div class="leaves">
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
            <div class="wheat">🌾</div>
        </div> -->
        
        <div class="login-container">
            <div class="logo-container">
                <div class="logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo" class="logo-icon">
                    <span>Department of Agriculture</span>
                </div>
            </div>
            
            <p class="subtitle">Online Leave Application System</p>
            
            <div class="form-container">
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
            </div>
            
            <a href="{{ url('/') }}" class="back-link">← Back to Home</a>
        </div>
        <script>
            (function(){
                var cursor = document.getElementById('cornCursor');
                if (!cursor) return;
                var isFine = window.matchMedia && window.matchMedia('(pointer: fine)').matches;
                if (!isFine) { cursor.style.display = 'none'; return; }
                document.addEventListener('mousemove', function(e){
                    cursor.style.opacity = '1';
                    cursor.style.transform = 'translate(' + e.clientX + 'px,' + e.clientY + 'px) scaleX(-1)';
                });
                document.addEventListener('mouseleave', function(){
                    cursor.style.opacity = '0';
                });
                document.addEventListener('mousedown', function(){
                    cursor.style.transform += ' scale(0.95)';
                });
                document.addEventListener('mouseup', function(){
                    cursor.style.transform = cursor.style.transform.replace(' scale(0.95)','');
                });
            })();
        </script>
    </body>
</html>