<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Department of Agriculture</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

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
                background: linear-gradient(135deg, #0f3a0f, #1a5f1a, #DAA520, #2d7a2d);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
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
                animation: wave 18s linear infinite;
            }
            
            .wave:nth-child(2) {
                background: rgba(215, 230, 7, 0.15);
                animation: wave 22s linear infinite reverse;
                animation-delay: -7s;
            }
            
            .wave:nth-child(3) {
                background: rgba(172, 148, 14, 0.18);
                animation: wave 25s linear infinite;
                animation-delay: -6s;
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
                animation: float 8s ease-in-out infinite;
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
            
            /* Floating leaves animation */
            .leaf {
                position: absolute;
                width: 25px;
                height: 25px;
                background: linear-gradient(45deg, #228B22, #32CD32);
                border-radius: 0 100% 0 100%;
                animation: leafFall 12s linear infinite;
                opacity: 0.4;
            }
            
            .leaf:nth-child(1) { left: 5%; animation-delay: 0s; transform: rotate(15deg); }
            .leaf:nth-child(2) { left: 15%; animation-delay: 3s; transform: rotate(-20deg); }
            .leaf:nth-child(3) { left: 25%; animation-delay: 6s; transform: rotate(10deg); }
            .leaf:nth-child(4) { left: 35%; animation-delay: 9s; transform: rotate(-15deg); }
            .leaf:nth-child(5) { left: 45%; animation-delay: 1.5s; transform: rotate(25deg); }
            .leaf:nth-child(6) { left: 55%; animation-delay: 4.5s; transform: rotate(-10deg); }
            .leaf:nth-child(7) { left: 65%; animation-delay: 7.5s; transform: rotate(20deg); }
            .leaf:nth-child(8) { left: 75%; animation-delay: 10.5s; transform: rotate(-25deg); }
            .leaf:nth-child(9) { left: 85%; animation-delay: 2s; transform: rotate(30deg); }
            .leaf:nth-child(10) { left: 95%; animation-delay: 5s; transform: rotate(-30deg); }
            
            @keyframes leafFall {
                0% {
                    transform: translateY(-100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 0.6;
                }
                90% {
                    opacity: 0.4;
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
                padding: 3.5rem 3rem;
                box-shadow: 
                    0 25px 80px rgba(0, 0, 0, 0.25),
                    0 0 0 1px rgba(255, 255, 255, 0.05),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
                text-align: center;
                max-width: 500px;
                width: 92%;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.18);
                position: relative;
                z-index: 10;
                animation: containerEntrance 1s cubic-bezier(0.4, 0, 0.2, 1);
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
                animation: shimmer 3s ease-in-out infinite;
            }

            @keyframes shimmer {
                0% { background-position: -300% 0; }
                100% { background-position: 300% 0; }
            }
            
            @keyframes containerEntrance {
                0% {
                    opacity: 0;
                    transform: translateY(60px) scale(0.8) rotateX(15deg);
                    filter: blur(10px);
                }
                50% {
                    opacity: 0.8;
                    transform: translateY(20px) scale(0.95) rotateX(5deg);
                    filter: blur(2px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1) rotateX(0deg);
                    filter: blur(0);
                }
            }
            
            .logo-container {
                margin-bottom: 2.5rem;
                position: relative;
            }
            
            .logo {
                font-size: 2.4rem;
                font-weight: 700;
                color: #1a5f1a;
                margin-bottom: 1.5rem;
                text-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.8rem;
                opacity: 0;
                animation: logoEntrance 2.5s cubic-bezier(0.4, 0, 0.2, 1) 0.8s forwards;
            }
            
            @keyframes logoEntrance {
                0% {
                    opacity: 0;
                    transform: translateY(30px) scale(0.8);
                    filter: blur(5px);
                }
                60% {
                    opacity: 0.8;
                    transform: translateY(-5px) scale(1.05);
                    filter: blur(1px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                    filter: blur(0);
                }
            }
            
            .logo-icon {
                height: 4.5rem;
                width: 4.5rem;
                object-fit: contain;
                filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
                animation: iconFloat 4s ease-in-out infinite;
                transition: transform 0.3s ease;
            }

            .logo-icon:hover {
                transform: scale(1.1) rotate(5deg);
            }
            
            @keyframes iconFloat {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-8px) rotate(2deg); }
            }
            
            .title-text {
                position: relative;
                display: inline-block;
                overflow: hidden;
            }

            .title-text span {
                display: inline-block;
                opacity: 0;
                animation: letterReveal 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            .title-text span:nth-child(1) { animation-delay: 1.2s; }
            .title-text span:nth-child(2) { animation-delay: 1.3s; }
            .title-text span:nth-child(3) { animation-delay: 1.4s; }
            .title-text span:nth-child(4) { animation-delay: 1.5s; }
            .title-text span:nth-child(5) { animation-delay: 1.6s; }
            .title-text span:nth-child(6) { animation-delay: 1.7s; }
            .title-text span:nth-child(7) { animation-delay: 1.8s; }
            .title-text span:nth-child(8) { animation-delay: 1.9s; }
            .title-text span:nth-child(9) { animation-delay: 2.0s; }
            .title-text span:nth-child(10) { animation-delay: 2.1s; }
            .title-text span:nth-child(11) { animation-delay: 2.2s; }
            .title-text span:nth-child(12) { animation-delay: 2.3s; }
            .title-text span:nth-child(13) { animation-delay: 2.4s; }
            .title-text span:nth-child(14) { animation-delay: 2.5s; }
            .title-text span:nth-child(15) { animation-delay: 2.6s; }
            .title-text span:nth-child(16) { animation-delay: 2.7s; }
            .title-text span:nth-child(17) { animation-delay: 2.8s; }
            .title-text span:nth-child(18) { animation-delay: 2.9s; }
            .title-text span:nth-child(19) { animation-delay: 3.0s; }
            .title-text span:nth-child(20) { animation-delay: 3.1s; }
            .title-text span:nth-child(21) { animation-delay: 3.2s; }
            .title-text span:nth-child(22) { animation-delay: 3.3s; }
            .title-text span:nth-child(23) { animation-delay: 3.4s; }
            .title-text span:nth-child(24) { animation-delay: 3.5s; }

            @keyframes letterReveal {
                0% {
                    opacity: 0;
                    transform: translateY(50px) rotateX(90deg);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) rotateX(0deg);
                }
            }
            
            .word-space {
                display: inline-block;
                width: 0.25em;
                min-width: 0.15em;
                height: 1em;
                vertical-align: middle;
            }
            .word {
                display: inline-block;
                opacity: 0;
                animation: wordReveal 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }
            .word:nth-child(1) { animation-delay: 1.2s; }
            .word-space:nth-child(2) { animation-delay: 1.9s; }
            .word:nth-child(3) { animation-delay: 2.0s; }
            .word-space:nth-child(4) { animation-delay: 2.5s; }
            .word:nth-child(5) { animation-delay: 2.6s; }
            @keyframes wordReveal {
                0% {
                    opacity: 0;
                    transform: translateY(50px) rotateX(90deg);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) rotateX(0deg);
                }
            }
            
            .title-svg {
                position: absolute;
                top: -10px;
                left: -10px;
                width: calc(100% + 20px);
                height: calc(100% + 20px);
                pointer-events: none;
                z-index: -1;
            }
            
            .title-path {
                stroke: #DAA520;
                stroke-width: 3;
                fill: none;
                stroke-dasharray: 3000;
                stroke-dashoffset: 3000;
                animation: drawPath 4s ease-out 3.8s forwards;
                stroke-linecap: round;
                stroke-linejoin: round;
                filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.3));
            }
            
            .title-path-secondary {
                stroke: #8B4513;
                stroke-width: 2;
                fill: none;
                stroke-dasharray: 2000;
                stroke-dashoffset: 2000;
                animation: drawPathSecondary 3.5s ease-out 4.2s forwards;
                stroke-linecap: round;
                stroke-linejoin: round;
                opacity: 0.8;
            }
            
            .leaf-accent {
                fill: #228B22;
                opacity: 0;
                animation: leafGrow 2s ease-out 4.8s forwards;
                filter: drop-shadow(0 1px 2px rgba(34, 139, 34, 0.5));
            }
            
            @keyframes drawPath {
                to {
                    stroke-dashoffset: 0;
                }
            }
            
            @keyframes drawPathSecondary {
                to {
                    stroke-dashoffset: 0;
                }
            }
            
            @keyframes leafGrow {
                0% {
                    opacity: 0;
                    transform: scale(0) rotate(0deg);
                }
                100% {
                    opacity: 0.9;
                    transform: scale(1) rotate(360deg);
                }
            }
            
            .subtitle {
                margin-bottom: 3rem;
                font-size: 1.3rem;
                color: #555;
                font-weight: 500;
                opacity: 0;
                animation: subtitleFadeIn 1.5s ease-out 1.5s forwards;
                position: relative;
            }

            .subtitle::after {
                content: '';
                position: absolute;
                bottom: -15px;
                left: 50%;
                transform: translateX(-50%);
                width: 100px;
                height: 2px;
                background: linear-gradient(90deg, transparent, #DAA520, transparent);
                opacity: 0;
                animation: underlineGrow 1s ease-out 6s forwards;
            }

            @keyframes underlineGrow {
                0% {
                    width: 0;
                    opacity: 0;
                }
                100% {
                    width: 100px;
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
            
            .auth-buttons {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                opacity: 0;
                animation: buttonsFadeIn 1.5s ease-out 2.5s forwards;
            }
            
            @keyframes buttonsFadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(30px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .auth-btn {
                display: block;
                padding: 1.2rem 2.5rem;
                border-radius: 15px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                font-size: 1.1rem;
                border: none;
                cursor: pointer;
                position: relative;
                overflow: hidden;
                transform: translateY(0);
            }
            
            .auth-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.6s;
            }
            
            .auth-btn:hover::before {
                left: 100%;
            }

            .auth-btn::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: width 0.6s, height 0.6s;
            }

            .auth-btn:hover::after {
                width: 300px;
                height: 300px;
            }
            
            .login-btn {
                background: linear-gradient(135deg, #1a5f1a, #2d7a2d, #1a5f1a);
                background-size: 200% 200%;
                color: white;
                box-shadow: 0 10px 30px rgba(26, 95, 26, 0.4);
                border: 2px solid transparent;
                animation: gradientMove 3s ease infinite;
            }

            @keyframes gradientMove {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .login-btn:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 15px 40px rgba(26, 95, 26, 0.5);
                border-color: rgba(255, 255, 255, 0.3);
            }
            
            .register-btn {
                border: 2px solid #DAA520;
                color: #8B4513;
                background: linear-gradient(135deg, rgba(218, 165, 32, 0.1), rgba(255, 255, 255, 0.95));
                box-shadow: 0 10px 30px rgba(218, 165, 32, 0.2);
                position: relative;
            }
            
            .register-btn:hover {
                background: linear-gradient(135deg, rgba(218, 165, 32, 0.2), rgba(255, 255, 255, 1));
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 15px 40px rgba(218, 165, 32, 0.3);
                border-color: #B8860B;
            }
            
            .copyright {
                margin-top: 3rem;
                font-size: 0.9rem;
                color: #666;
                opacity: 0;
                animation: copyrightFadeIn 1s ease-out 3s forwards;
                padding-top: 2rem;
                border-top: 1px solid rgba(0, 0, 0, 0.1);
            }

            @keyframes copyrightFadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(10px);
                }
                100% {
                opacity: 0.8;
                    transform: translateY(0);
                }
            }
            
            .farm-bg {
                position: absolute;
                top: 0; left: 0; width: 100vw; height: 100vh;
                object-fit: cover;
                opacity: 0.08;
                z-index: 0;
                pointer-events: none;
            }
            
            /* Decorative elements */
            .decorative-line {
                position: absolute;
                height: 3px;
                background: linear-gradient(90deg, transparent, #DAA520, transparent);
                border-radius: 2px;
                opacity: 0;
                animation: lineReveal 2s ease-out 7.5s forwards;
            }
            
            .decorative-line.top {
                top: 25px;
                left: 25px;
                right: 25px;
            }
            
            .decorative-line.bottom {
                bottom: 25px;
                left: 25px;
                right: 25px;
            }
            
            @keyframes lineReveal {
                0% {
                    opacity: 0;
                    transform: scaleX(0);
                }
                100% {
                    opacity: 0.6;
                    transform: scaleX(1);
                }
            }

            /* Responsive design */
            @media (max-width: 768px) {
                .login-container {
                    padding: 2.5rem 2rem;
                    margin: 1rem;
                }
                
                .logo {
                    font-size: 2rem;
                    flex-direction: column;
                    gap: 1rem;
                }
                
                .logo-icon {
                    height: 3.5rem;
                    width: 3.5rem;
                }
                
                .subtitle {
                    font-size: 1.1rem;
                }
                
                .auth-btn {
                    padding: 1rem 2rem;
                    font-size: 1rem;
                }
            }
        </style>
    </head>
    <body>
        <img src="Logo.png" alt="Farm background" class="farm-bg">
        
        <!-- SVG Background Pattern -->
        <svg class="svg-background" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
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
        
        <!-- Floating leaves -->
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        <div class="leaf"></div>
        
        <div class="login-container">
            <!-- Decorative elements -->
            <!-- <div class="decorative-line top"></div>
            <div class="decorative-line bottom"></div> -->
            
            <div class="logo-container">
                <div class="logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo" class="logo-icon">
                    <div class="title-text">
                        <span class="word"><span>D</span><span>e</span><span>p</span><span>a</span><span>r</span><span>t</span><span>m</span><span>e</span><span>n</span><span>t</span></span><span class="word-space"></span><span class="word"><span>o</span><span>f</span></span><span class="word-space"></span><span class="word"><span>A</span><span>g</span><span>r</span><span>i</span><span>c</span><span>u</span><span>l</span><span>t</span><span>u</span><span>r</span><span>e</span></span>
                        <!-- <svg class="title-svg" viewBox="0 0 500 100"> -->
                            <!-- Enhanced vine paths -->
                            <path class="title-path" d="M25,50 Q45,25 65,50 T105,50 T145,50 T185,50 T225,50 T265,50 T305,50 T345,50 T385,50 T425,50 T465,50" />
                            
                            <!-- Main branch systems -->
                            <path class="title-path-secondary" d="M65,50 Q75,30 85,50 Q95,30 105,50" />
                            <path class="title-path-secondary" d="M145,50 Q155,30 165,50 Q175,30 185,50" />
                            <path class="title-path-secondary" d="M225,50 Q235,30 245,50 Q255,30 265,50" />
                            <path class="title-path-secondary" d="M305,50 Q315,30 325,50 Q335,30 345,50" />
                            <path class="title-path-secondary" d="M385,50 Q395,30 405,50 Q415,30 425,50" />
                            
                            <!-- Leaf clusters -->
                            <g class="leaf-accent">
                                <path d="M55,45 Q60,30 65,45 Q60,60 55,45 Z" />
                                <path d="M135,45 Q140,30 145,45 Q140,60 135,45 Z" />
                                <path d="M215,45 Q220,30 225,45 Q220,60 215,45 Z" />
                                <path d="M295,45 Q300,30 305,45 Q300,60 295,45 Z" />
                                <path d="M375,45 Q380,30 385,45 Q380,60 375,45 Z" />
                                
                                <!-- Small decorative leaves -->
                                <path d="M85,35 Q87,25 89,35 Q87,45 85,35 Z" />
                                <path d="M165,35 Q167,25 169,35 Q167,45 165,35 Z" />
                                <path d="M245,35 Q247,25 249,35 Q247,45 245,35 Z" />
                                <path d="M325,35 Q327,25 329,35 Q327,45 325,35 Z" />
                                <path d="M405,35 Q407,25 409,35 Q407,45 405,35 Z" />
                                
                                <!-- Vine tendrils -->
                                <path d="M105,50 Q110,45 115,50 Q120,45 125,50" />
                                <path d="M185,50 Q190,45 195,50 Q200,45 205,50" />
                                <path d="M265,50 Q270,45 275,50 Q280,45 285,50" />
                                <path d="M345,50 Q350,45 355,50 Q360,45 365,50" />
                                <path d="M425,50 Q430,45 435,50 Q440,45 445,50" />
                                
                                <!-- Berries/fruits -->
                                <circle cx="75" cy="40" r="2" />
                                <circle cx="155" cy="40" r="2" />
                                <circle cx="235" cy="40" r="2" />
                                <circle cx="315" cy="40" r="2" />
                                <circle cx="395" cy="40" r="2" />
                            </g>
                        </svg>
                    </div>
                </div>
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
                <p style="font-size: 0.8rem; margin-top: 0.5rem; opacity: 0.7;">Empowering Agriculture, Nurturing Growth</p>
            </div>
        </div>
    </body>
</html>