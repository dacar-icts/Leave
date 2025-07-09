<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f9f9e6;
            min-height: 100vh;
        }
        .main-content {
            margin-left: 240px;
            padding: 0;
            min-height: 100vh;
            background: #f9f9e6;
            transition: margin-left 0.3s ease;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 40px 0 40px;
            min-height: 82px;
            flex-wrap: wrap;
        }
        .header-title {
            font-size: 2.3em;
            font-weight: 700;
            color: #222;
            line-height: 1.1;
            margin-bottom: 0;
        }
        .form-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px;
            margin: 30px;
            max-width: 600px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }
        .form-group .error {
            color: #e53935;
            font-size: 0.85em;
            margin-top: 5px;
        }
        .btn-submit {
            background: #1ecb6b;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 4px;
            margin-top: 15px;
            display: flex;
            align-items: center;
        }
        .success-message .material-icons {
            margin-right: 8px;
        }
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #006400;
            font-size: 2em;
            cursor: pointer;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 200;
        }
        @media (max-width: 992px) {
            .main-content {
                margin-left: 180px;
            }
            .header-title {
                font-size: 1.8em;
            }
        }
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            .main-content {
                margin-left: 0;
            }
            .form-container {
                margin: 20px;
            }
        }
        .logout-icon-btn {
            background: none;
            border: none;
            color: #e53935;
            font-size: 1.7em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        .logout-icon-btn:hover {
            background: #ffeaea;
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    
    <div class="sidebar" id="sidebar">
        <!-- Falling leaves animation -->
        <div class="falling-leaves" style="z-index:0;">
            <span class="leaf" aria-hidden="true">🌿</span>
            <span class="leaf" aria-hidden="true">🍃</span>
            <span class="leaf" aria-hidden="true">🍂</span>
            <span class="leaf" aria-hidden="true">🌱</span>
        </div>
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1960</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    
    <div class="main-content">
        <div class="header">
            <a href="javascript:history.back()" onclick="if(document.referrer===''){window.location.href='{{ route('dashboard') }}';return false;}" style="display:flex;align-items:center;padding:8px 16px;background:#f0f0f0;color:#333;border:1px solid #ddd;border-radius:4px;text-decoration:none;font-weight:500;margin-right:18px;">
                <span class="material-icons" style="margin-right:5px;">arrow_back</span>
                Back
            </a>
            <div class="header-title">Change Password</div>
            <button class="logout-icon-btn" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="material-icons">exit_to_app</span>
            </button>
        </div>
        
        <div style="height:5px;width:100%;background: linear-gradient(to right, var(--primary-green) 0%, var(--accent-green) 100%);margin-bottom:18px;margin-top:18px;"></div>
        
        <div class="form-container">
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                    @if($errors->updatePassword->has('current_password'))
                        <div class="error">{{ $errors->updatePassword->first('current_password') }}</div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password">
                    @if($errors->updatePassword->has('password'))
                        <div class="error">{{ $errors->updatePassword->first('password') }}</div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                    @if($errors->updatePassword->has('password_confirmation'))
                        <div class="error">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                    @endif
                </div>
                
                <button type="submit" class="btn-submit">Update Password</button>
                
                @if (session('status') === 'password-updated')
                    <div class="success-message">
                        <span class="material-icons">check_circle</span>
                        Password updated successfully
                    </div>
                @endif
            </form>
        </div>
    </div>
    
    <script>
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html> 