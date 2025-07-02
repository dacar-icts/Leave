<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Error - {{ $code ?? 500 }}</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .error-container {
            max-width: 500px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .error-icon {
            font-size: 64px;
            color: #e53935;
            margin-bottom: 20px;
        }
        
        h1 {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 24px;
        }
        
        p {
            color: #666;
            margin-bottom: 20px;
        }
        
        .error-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: left;
            font-family: monospace;
            white-space: pre-wrap;
            word-break: break-word;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <span class="material-icons error-icon">error_outline</span>
        <h1>{{ $message ?? 'An error occurred' }}</h1>
        <p>Sorry, we couldn't complete your request.</p>
        
        @if(isset($details) && app()->environment('local'))
        <div class="error-details">
            {{ $details }}
        </div>
        @endif
        
        <a href="{{ url()->previous() }}" class="btn">Go Back</a>
    </div>
</body>
</html> 