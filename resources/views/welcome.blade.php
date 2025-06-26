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
                background-color: #f8f8f8;
                background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1932&q=80');
                background-size: cover;
                background-position: center;
                color: #333;
            }
            
            .login-container {
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 8px;
                padding: 2rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                text-align: center;
                max-width: 400px;
                width: 90%;
            }
            
            .logo {
                font-size: 1.8rem;
                font-weight: bold;
                color: #2c5e21;
                margin-bottom: 1rem;
            }
            
            .subtitle {
                margin-bottom: 2rem;
                font-size: 1rem;
                color: #555;
            }
            
            .auth-buttons {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            
            .auth-btn {
                display: block;
                padding: 0.75rem 1.5rem;
                border-radius: 4px;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            
            .login-btn {
                background-color: #2c5e21;
                color: white;
            }
            
            .login-btn:hover {
                background-color: #234919;
            }
            
            .register-btn {
                border: 1px solid #2c5e21;
                color: #2c5e21;
                background-color: transparent;
            }
            
            .register-btn:hover {
                background-color: rgba(44, 94, 33, 0.1);
            }
            
            .copyright {
                margin-top: 2rem;
                font-size: 0.8rem;
                color: #666;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="logo">Department of Agriculture</div>
            <p class="subtitle">Leave Management System</p>
            
            @if (Route::has('login'))
                <div class="auth-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="auth-btn login-btn">Go to Dashboard</a>
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
