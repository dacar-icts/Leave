<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f9f9e6;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
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
            margin-left: 220px;
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
        .header-title i {
            font-style: italic;
            font-weight: 400;
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
            color: #888;
        }
        .stat-card .count {
            font-size: 2em;
            font-weight: 700;
            color: #e53935;
        }
        .stat-card .label {
            font-size: 1em;
            color: #888;
            margin-top: 4px;
            text-align: center;
        }
        .search-bar {
            display: flex;
            align-items: center;
            float: right;
            margin-bottom: 16px;
            margin-top: -10px;
        }
        .search-bar .material-icons {
            color: #444;
            font-size: 1.5em;
            margin-right: 8px;
        }
        .search-bar input {
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 1em;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
            outline: none;
        }
        .table-container {
            background: linear-gradient(to right, #43a047 0%, #a8e063 100%);
            border-radius: 12px 12px 0 0;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 0 0 12px 12px;
            overflow: hidden;
        }
        th, td {
            padding: 16px 18px;
            text-align: left;
        }
        th {
            background: transparent;
            color: #fff;
            font-size: 1.1em;
            font-weight: 700;
        }
        tr:not(:last-child) {
            border-bottom: 1px solid #e0e0e0;
        }
        .status-pending {
            color: #e53935;
            font-weight: 700;
        }
        .status-certified {
            color: #1ecb6b;
            font-weight: 700;
        }
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.3em;
            color: #1ecb6b;
            margin-right: 8px;
        }
        .icon-btn.edit {
            color: #43a047;
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
            HR Dashboard
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
            <div class="header-title">
                Application Leave Form <i>(Requests)</i>
            </div>
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
                    <span class="material-icons icon">access_time</span>
                    <div class="count">{{ $pendingCount }}</div>
                    <div class="label">Pending Approval</div>
                </div>
            </div>
            <div class="search-bar">
                <span class="material-icons">search</span>
                <input type="text" placeholder="Search Name or ID #">
                <span class="material-icons" style="color:#888;cursor:pointer;">close</span>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>ID #</th>
                            <th>NAME</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $leave)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($leave->created_at)->format('n/j/Y') }}</td>
                            <td>#{{ $leave->user->id }}</td>
                            <td>{{ strtoupper($leave->user->name) }}</td>
                            <td class="{{ $leave->status === 'Pending' ? 'status-pending' : ($leave->status === 'Certified' ? 'status-certified' : '') }}">
                                {{ $leave->status === 'Certified' ? 'HR CERTIFIED' : strtoupper($leave->status) }}
                            </td>
                            <td>
                                <button class="icon-btn" title="View"><span class="material-icons">visibility</span></button>
                                @if($leave->status === 'Pending')
                                    <button class="icon-btn edit" title="Edit"><span class="material-icons">edit</span></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
