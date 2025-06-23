<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 40px 0 40px;
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
        .stats-row {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 220px;
        }
        .stat-card .icon {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #1ecb6b;
        }
        .stat-card .count {
            font-size: 2em;
            font-weight: 700;
            color: #222;
        }
        .stat-card .label {
            font-size: 1em;
            color: #888;
            margin-top: 4px;
            text-align: center;
        }
        .admin-actions {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }
        .action-card {
            background: linear-gradient(to bottom, #43a047 60%, #eafbe7 100%);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 40px 20px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 220px;
            cursor: pointer;
            transition: box-shadow 0.2s;
        }
        .action-card:hover {
            box-shadow: 0 4px 16px rgba(67,160,71,0.15);
        }
        .action-card .icon {
            font-size: 2.5em;
            color: #fff;
            margin-bottom: 10px;
        }
        .action-card .label {
            font-size: 1.1em;
            color: #226d1b;
            font-weight: 700;
            margin-top: 12px;
            text-align: center;
            letter-spacing: 1px;
        }
        @media (max-width: 900px) {
            .header, .dashboard-body {
                padding: 20px;
            }
            .sidebar {
                width: 100px;
                padding-top: 10px;
            }
            .main-content {
                margin-left: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="https://i.ibb.co/6bQw4yT/da-logo.png" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1960</p>
        <a href="#" class="dashboard-link">
            <span class="material-icons">dashboard</span>
            Admin Dashboard
        </a>
        <div class="nav-menu">
            <a href="#" class="active">List of Employees</a>
            <a href="#">History</a>
        </div>
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
            <div class="header-title">Admin</div>
            <div class="profile">
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
            <div class="profile-info">
                <span>{{ auth()->user()->name }}</span>
                <a href="#">#{{ auth()->user()->id }}</a>
            </div>
            </div>
        </div>
        <div class="dashboard-body">
            <div class="stats-row">
                <div class="stat-card">
                    <span class="material-icons icon">check_circle</span>
                    <div class="count">50</div>
                    <div class="label">Total No. of HR Certified Applicants</div>
                </div>
            </div>
            <div class="admin-actions">
                <div class="action-card">
                    <span class="material-icons icon">groups</span>
                    <div class="label">LIST OF EMPLOYEES</div>
                </div>
                <div class="action-card">
                    <span class="material-icons icon">history</span>
                    <div class="label">HISTORY</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
