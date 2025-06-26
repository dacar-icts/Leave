<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Logs (2025)</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f9f9e6;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background: linear-gradient(to bottom, #006400 0%, #43a047 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-top: 24px;
            z-index: 100;
            transition: transform 0.3s ease;
        }
        .sidebar img {
            width: 70px;
            margin-left: 24px;
            margin-bottom: 10px;
        }
        .sidebar h2 {
            font-size: 1.2em;
            margin: 0 0 0 24px;
            font-weight: 700;
        }
        .sidebar p {
            margin: 0 0 0 24px;
            font-size: 0.95em;
        }
        .sidebar .dashboard-link {
            margin: 40px 0 0 24px;
            font-size: 1.1em;
            color: #fff;
            background: #388e3c;
            padding: 8px 18px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            font-weight: 500;
            text-decoration: none;
        }
        .sidebar .dashboard-link i {
            margin-right: 8px;
        }
        .sidebar .nav-menu {
            margin-top: 30px;
            width: 100%;
        }
        .sidebar .nav-menu a {
            display: block;
            padding: 14px 0 14px 40px;
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-color 0.2s;
        }
        .sidebar .nav-menu a.active,
        .sidebar .nav-menu a:hover {
            background: #eafbe7;
            color: #226d1b;
            border-left: 4px solid #226d1b;
        }
        .sidebar .logout {
            margin-top: auto;
            margin-bottom: 30px;
            color: #fff;
            font-weight: 500;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.1em;
            margin-left: 24px;
        }
        .sidebar .logout i {
            margin-right: 8px;
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
            flex-wrap: wrap;
        }
        .header-title {
            font-size: 2.3em;
            font-weight: 700;
            color: #222;
        }
        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f5f5f5;
            border-radius: 30px;
            padding: 8px 18px;
        }
        .profile-icon {
            width: 38px;
            height: 38px;
            background: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7em;
            color: #888;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        .profile-info span {
            font-weight: 700;
            color: #222;
            font-size: 1.1em;
        }
        .profile-info a {
            color: #4caf50;
            font-size: 0.95em;
            text-decoration: none;
        }
        .dashboard-body {
            padding: 30px 40px 0 40px;
        }
        /* --- Monthly Log Table Styles --- */
        .month-table-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            background: #fff;
            max-width: 800px;
            margin: 40px auto 0 auto;
            
        }
        .month-table-container table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Roboto', Arial, sans-serif;
            table-layout: fixed;
            
        }
        .month-table-container th, .month-table-container td {
            padding: 18px 18px;
            text-align: left;
        }
        .month-table-container td {
            width: 16.66%;
        }
        .month-table-container td.divider {
            border-left: 2px solid #e0e0e0;
            padding: 0;
            width: 0;
        }
        .month-table-container tbody tr {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
        }
        .month-table-container tbody tr:last-child {
            border-bottom: none;
        }
        .icon-cell {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .icon-star {
            color: #1ecb6b;
            font-size: 1.2em;
            vertical-align: middle;
        }
        .icon-edit {
            color: #1ecb6b;
            font-size: 1.3em;
            cursor: pointer;
            margin-left: 130%;
        }
        .icon-download {
            color: #4fc3f7;
            font-size: 1.3em;
            cursor: pointer;
        }
        .month-label {
            font-weight: 500;
            font-size: 1.08em;
        }
        .table-title {
            background: linear-gradient(to right, #43a047 0%, #a8e063 100%);
            color: #fff;
            font-size: 1.1em;
            font-weight: 700;
            text-align: center;
            padding: 12px 0;
            letter-spacing: 1px;
        }
        /* Responsive styles for dashboard */
        @media (max-width: 1200px) {
            .dashboard-body {
                padding: 20px;
            }
        }
        @media (max-width: 992px) {
            .header-title {
                font-size: 1.8em;
            }
            .sidebar {
                width: 180px;
            }
            .main-content {
                margin-left: 180px;
            }
            .header, .dashboard-body {
                padding: 20px;
            }
            .sidebar .nav-menu a {
                padding: 12px 0 12px 24px;
                font-size: 1em;
            }
        }
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .profile {
                align-self: flex-end;
            }
        }
        @media (max-width: 576px) {
            .header-title {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    <div class="sidebar" id="sidebar">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1960</p>
        <a href="/admin/dashboard" class="dashboard-link">
            <span class="material-icons">account_circle</span>
            Admin Dashboard
        </a>
        <a href="{{ route('logout') }}" class="logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span>
            Log Out
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-title">Monthly Logs (2025)</div>
            <div class="profile">
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                    <a href="#">#{{ auth()->user()->id ?? '0001' }}</a>
                </div>
            </div>
        </div>
        <div class="dashboard-body">
            <div class="month-table-container">
                <div class="table-title">MONTHLY LOGS (2025)</div>
                <table>
                    <tbody>
                        <?php
                            $months = [
                                'January', 'February', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November', 'December'
                            ];
                            $currentMonth = date('F');
                            $half = ceil(count($months) / 2);
                            $col1 = array_slice($months, 0, $half);
                            $col2 = array_slice($months, $half);
                        ?>
                        @for($i = 0; $i < $half; $i++)
                        <tr>
                            <td class="icon-cell">
                                @if(isset($col1[$i]))
                                    <span class="month-label">{{ $col1[$i] }}</span>
                                    @if($col1[$i] === $currentMonth)
                                        <span class="material-icons icon-star">star</span>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col1[$i]))
                                    <span class="material-icons icon-edit">edit_square</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col1[$i]))
                                    <span class="material-icons icon-download">download</span>
                                @endif
                            </td>
                            <td class="divider"></td>
                            <td class="icon-cell">
                                @if(isset($col2[$i]))
                                    <span class="month-label">{{ $col2[$i] }}</span>
                                    @if($col2[$i] === $currentMonth)
                                        <span class="material-icons icon-star">star</span>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col2[$i]))
                                    <span class="material-icons icon-edit">edit_square</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col2[$i]))
                                    <span class="material-icons icon-download">download</span>
                                @endif
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
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
