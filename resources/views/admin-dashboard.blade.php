<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-green: #2d5a27;
            --secondary-green: #4a7c59;
            --accent-green: #6b8e23;
            --light-green: #9dc183;
            --pale-green:rgb(199, 240, 199);
            --warm-beige: #f5f1e8;
            --earth-brown: #8b7355;
            --sky-blue: #87ceeb;
            --forest-dark: #1a3d1a;
            --leaf-light: #a8d8a8;
            --shadow-soft: rgba(45, 90, 39, 0.1);
            --shadow-medium: rgba(45, 90, 39, 0.15);
            --shadow-strong: rgba(45, 90, 39, 0.25);
            --accent-yellow:rgb(205, 192, 3);
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--warm-beige);
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: radial-gradient(circle at 20% 80%, var(--leaf-light) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, var(--light-green) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, var(--sky-blue) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        .sidebar {
            background: linear-gradient(to bottom, var(--primary-green) 50%, var(--accent-green) 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 24px;
            z-index: 100;
            box-shadow: 4px 0 20px var(--shadow-medium);
            overflow-y: auto;
        }
        .sidebar-logo img {
            width: 80px;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
            position: relative;
            z-index: 2;
        }
        .sidebar-logo img:hover {
            transform: scale(1.05);
        }
        .sidebar h2 {
            font-size: 1.4em;
            margin: 0 0 8px 0;
            font-weight: 700;
            text-align: center;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            line-height: 1.3;
            position: relative;
            z-index: 2;
        }
        .sidebar p {
            margin: 0 0 40px 0;
            font-size: 1em;
            opacity: 0.9;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }
        .dashboard-link {
            font-size: 1.1em;
            color: var(--primary-green);
            background: linear-gradient(90deg, var(--secondary-green) 5%, var(--pale-green) 5%);
            padding: 10px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 12px var(--shadow-soft);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
            width: 85%;
            height: 4%;
        }
        .dashboard-link:last-of-type { 
            margin-bottom: 24px; 
        }
        .dashboard-link:hover {
            transform: translateY(-2px);    
            box-shadow: 0 8px 20px var(--shadow-medium);
            background: linear-gradient(135deg, var(--pale-green) 50%, var(--leaf-light) 100%);
        }
        .dashboard-link .material-icons {
            margin-right: 12px;
            font-size: 1.2em;
        }
        
        /* Additional classes for sidebar styling */
        .dashboard-link .icon-lg {
            font-size: 1.2em !important;
        }
        .mr-2 { 
            margin-right: 8px !important; 
        }
        .mt-3 { 
            margin-top: 15px !important; 
        }
        .d-none { 
            display: none !important; 
        }
        .mb-0 { 
            margin-bottom: 0 !important; 
        }
        .mt-2 { 
            margin-top: 8px !important; 
        }
        
        .main-content {
            margin-left: 280px;
            padding: 0;
            min-height: 100vh;
            background: transparent;
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0;
            padding: 32px 48px 24px 48px;
            background: var(--warm-beige);
        }
        .header-title {
            font-size: 2.5em;
            font-weight: 700;
            color: var(--forest-dark);
            position: relative;
            margin: 0;
        }
        .header-title::after {
            content: '🌿';
            position: absolute;
            right: -40px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8em;
            opacity: 0.7;
        }
        .header-title .material-icons {
            color: var(--accent-green);
            font-size: 1.2em;
            margin-right: 10px;
        }
        .profile-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            border-radius: 20px;
            padding: 12px 20px;
            box-shadow: 0 4px 16px var(--shadow-soft);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--shadow-medium);
        }
        .profile-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--accent-green) 0%, var(--secondary-green) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8em;
            color: white;
            box-shadow: 0 4px 12px var(--shadow-soft);
        }
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        .profile-info span {
            font-weight: 600;
            color: var(--forest-dark);
            font-size: 1.1em;
        }
        .profile-info a {
            color: var(--accent-green);
            font-size: 0.95em;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .profile-info a:hover {
            color: var(--primary-green);
        }
        .profile-card a[title="Logout"] {
            font-size: 1.2em;
            color:rgb(255, 61, 61);
            text-decoration: none;
            margin-left: 8px;
            background: none;
            padding: 0;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dashboard-body {
            padding: 0 32px 48px 32px;
            margin: 0;
        }
        .dashboard-top-row {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 32px;
            margin-bottom: 32px;
            flex-wrap: wrap;
            max-width: 1100px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            overflow-x: visible;
        }
        .yearly-graph-card {
            flex: 2 1 0;
            min-width: 0;
            width: 100%;
            margin: 0;
        }
        .stats-row {
            flex: 1 1 220px;
            max-width: 260px;
            min-width: 180px;
            width: 100%;
            margin: 0;
            gap: 18px;
            display: flex;
            flex-direction: column;
        }
        .stat-card {
            width: 100%;
            min-width: 0;
            max-width: none;
            height: 90px;
            padding: 14px 18px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 2px 8px var(--shadow-soft);
            border: 4px solid transparent;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 14px;
        }
        .stat-card .icon {
            width: 44px;
            height: 44px;
            font-size: 1.5em;
            margin-right: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-green) 0%, var(--secondary-green) 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-card .count {
            font-size: 1.3em;
        }
        @media (max-width: 992px) {
            .dashboard-top-row {
                flex-direction: column;
                gap: 20px;
                max-width: 100%;
            }
            .yearly-graph-card, .stats-row {
                max-width: 100%;
                width: 100%;
                margin-left: 0;
                margin-right: 0;
            }
            .stats-row {
                max-width: 100%;
                min-width: 0;
            }
        }
        .admin-actions {
            display: flex;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        .action-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 8px 24px var(--shadow-soft);
            padding: 30px 40px 20px 40px;
            display: flex;
            flex-direction: column;
            position: relative;
            align-items: center;
            min-width: 220px;
            flex: 1;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-green), var(--light-green));
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            z-index: 1;
        }
        .action-card .icon {
            font-family: 'Noto Color Emoji', 'Apple Color Emoji', 'Segoe UI Emoji', sans-serif;
            font-size: 2.5em;
            color: var(--accent-green);
            margin-bottom: 10px;
            z-index: 2;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), color 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .action-card .label {
            font-size: 1.1em;
            color: var(--primary-green);
            font-weight: 700;
            margin-top: 12px;
            text-align: center;
            letter-spacing: 1px;
            text-transform: uppercase;
            z-index: 2;
            transition: color 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .action-card:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 16px 40px var(--shadow-medium);
            background: linear-gradient(135deg, var(--pale-green) 0%, #fff 100%);
        }
        .action-card:hover .icon {
            color: var(--secondary-green);
            transform: scale(1.12) rotate(-6deg);
        }
        .action-card:hover .label {
            color: var(--secondary-green);
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
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .stat-card {
                padding: 20px 30px;
                min-width: 180px;
            }
            .stats-row {
                gap: 15px;
            }
            .admin-actions {
                gap: 15px;
            }
            .action-card {
                padding: 20px 30px 15px 30px;
                min-width: 180px;
            }
        }
        
        @media (max-width: 992px) {
            .header-title {
                font-size: 1.8em;
            }
            .main-content {
                margin-left: 240px;
            }
            .header, .dashboard-body {
                padding: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
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
                min-height: unset;
            }
            .profile-card {
                align-self: flex-end;
            }
            .stats-row {
                flex-wrap: wrap;
            }
            .stat-card {
                min-width: calc(50% - 15px);
                flex: 0 0 calc(50% - 15px);
                padding: 15px;
            }
            
            .action-card {
                min-width: calc(50% - 15px);
                flex: 0 0 calc(50% - 15px);
                padding: 20px 15px 15px 15px;
            }
        }
        
        @media (max-width: 576px) {
            .header-title {
                font-size: 1.5em;
            }
        }
        
        /* Dark mode toggle button */
        .dark-mode-toggle {
            background: none;
            border: none;
            color: #333;
            font-size: 1.2em;
            cursor: pointer;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border-radius: 50%;
            background-color: #f0f0f0;
            transition: all 0.3s ease;
        }
        
        .dark-mode-toggle:hover {
            background-color: #e0e0e0;
        }
        
        /* Dark mode styles */
        body.dark-mode {
            background: #121212;
            color: #e0e0e0;
        }
        
        body.dark-mode .main-content {
            background: #121212;
        }
        
        body.dark-mode .header-title {
            color: #e0e0e0;
        }
        
        body.dark-mode .profile {
            background: #1e1e1e;
        }
        
        body.dark-mode .profile-info span {
            color: #e0e0e0;
        }
        
        body.dark-mode .stat-card {
            background: #1e1e1e;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        body.dark-mode .stat-card .count {
            color: #e0e0e0;
        }
        
        body.dark-mode .action-card {
            background: #0a5a2d;
        }
        
        body.dark-mode .action-card:hover {
            background: #083d1e;
        }
        
        body.dark-mode .dark-mode-toggle {
            color: #e0e0e0;
            background-color: #333;
        }
        
        body.dark-mode .dark-mode-toggle:hover {
            background-color: #444;
        }
        .falling-leaves {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .leaf {
            position: absolute;
            font-size: 50px;
            opacity: 0.13;
            animation: fall 12s linear infinite;
            animation-timing-function: ease-in-out;
            color: rgba(0, 0, 0, 0.8);
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
        }
        .leaf:nth-child(1) { 
            left: 20%; 
            animation-delay: 0s; 
            animation-duration: 15s; 
        }
        .leaf:nth-child(2) { 
            left: 40%; 
            animation-delay: 4s; 
            animation-duration: 18s; 
        }
        .leaf:nth-child(3) { 
            left: 60%; 
            animation-delay: 8s; 
            animation-duration: 16s; 
        }
        .leaf:nth-child(4) { 
            left: 80%; 
            animation-delay: 12s; 
            animation-duration: 14s; 
        }
        @keyframes fall {
            0% {
                transform: translateY(-100px) rotate(0deg) translateX(0);
                opacity: 0;
            }
            5% {
                opacity: 0.13;
            }
            25% {
                transform: translateY(25vh) rotate(45deg) translateX(20px);
                opacity: 0.13;
            }
            50% {
                transform: translateY(50vh) rotate(-90deg) translateX(-15px);
                opacity: 0.13;
            }
            75% {
                transform: translateY(75vh) rotate(135deg) translateX(10px);
                opacity: 0.13;
            }
            95% {
                opacity: 0.13;
            }
            100% {
                transform: translateY(100vh) rotate(-180deg) translateX(0);
                opacity: 0;
            }
        }
        .new-btn {
            background: linear-gradient(135deg, var(--accent-green) 0%, var(--secondary-green) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 16px var(--shadow-medium);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .new-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .new-btn:hover::before {
            left: 100%;
        }
        .new-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--shadow-strong);
        }
        .table-container {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 8px 24px var(--shadow-soft);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            position: relative;
        }
        .table-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-green), var(--light-green), var(--sky-blue));
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
        }
        th {
            background: linear-gradient(to right, #305d2b 0%, #658b2f 100%);
            color: white;
            padding: 20px 24px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }
        th:first-child {
            border-top-left-radius: 16px;
        }
        th:last-child {
            border-top-right-radius: 16px;
        }
        td {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(157, 193, 131, 0.2);
            transition: background-color 0.3s ease;
        }
        tr:hover td {
            background: rgba(157, 193, 131, 0.05);
        }
        tr:last-child td {
            border-bottom: none;
        }
        .icon-btn,
        .icon-btn .material-icons {
            text-decoration: none !important;
            border-bottom: none !important;
            box-shadow: none !important;
        }
        .icon-btn {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            margin-right: 8px;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            border: 1px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
        }
        .icon-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 4px 16px var(--shadow-medium);
        }
        .view-btn {
            font-size: 1.5em;
            color: var(--accent-green);
            margin: 10% 10% 10% 5%;
        }
        .print-btn {
            color: var(--secondary-green);
            font-size: 1.5em;
        }
        .icon-btn .material-icons {
            font-size: 20px;
        }
        /* Modal overlay and content styles for admin modals */
        #addEmployeeModal, #employeeListModal, #editEmployeeModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.25);
            z-index: 3000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        }
        #addEmployeeModal > div, #employeeListModal > div, #editEmployeeModal > div {
            background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(255,255,255,0.95) 100%);
            border-radius: 20px;
            box-shadow: 0 20px 40px var(--shadow-strong);
            padding: 20px 10px 10px 10px;
            width: min(98vw, 900px);
            max-width: 98vw;
            max-height: 92vh;
            overflow-y: auto;
            margin: auto;
            position: relative;
            overflow-x: visible;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.3);
            text-align: center;
        }
        #employeeListModal table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            min-width: unset;
        }
        #employeeListModal th, #employeeListModal td {
            white-space: normal;
            word-break: break-word;
            min-width: 80px;
            max-width: 220px;
        }
        @media (max-width: 700px) {
            #employeeListModal > div {
                width: 98vw;
                max-width: 98vw;
                padding: 10px 2px 2px 2px;
            }
            #employeeListModal .table-container, #employeeListModal table {
                overflow-x: auto;
                display: block;
            }
        }
        /* Modal close button */
        #employeeListModal button[onclick^="closeEmployeeListModal"],
        #editEmployeeModal button[onclick^="closeEditEmployeeModal"] {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 1.2em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            transition: background 0.2s;
        }
        #employeeListModal button[onclick^="closeEmployeeListModal"]:hover,
        #editEmployeeModal button[onclick^="closeEditEmployeeModal"]:hover {
            background: #c62828;
        }
        /* Unified modal button styles */
        #addEmployeeModal button,
        #editEmployeeModal button,
        #employeeListModal button:not([onclick^="closeEmployeeListModal"]) {
            border: none;
            border-radius: 8px;
            padding: 8px 22px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 2px 8px var(--shadow-soft);
            margin: 0 2px;
            outline: none;
        }
        #addEmployeeModal button[type="submit"],
        #editEmployeeModal button[type="submit"],
        #employeeListModal button[onclick^="searchEmployees"],
        #employeeListModal button[onclick^="sortEmployees"],
        #employeeListModal button#sortOrderBtn {
            background: linear-gradient(135deg, var(--accent-green) 0%, var(--secondary-green) 100%);
            color: #fff;
        }
        #addEmployeeModal button[type="button"],
        #editEmployeeModal button[type="button"],
        #employeeListModal button[onclick^="clearSearch"] {
            background: #e53935;
            color: #fff;
        }
        #addEmployeeModal button:hover,
        #editEmployeeModal button:hover,
        #employeeListModal button:not([onclick^="closeEmployeeListModal"]):hover {
            filter: brightness(1.08) saturate(1.1);
            box-shadow: 0 4px 16px var(--shadow-medium);
            transform: translateY(-2px) scale(1.03);
        }
        /* Yearly Requests Graph Card */
        .yearly-graph-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 8px 24px var(--shadow-soft);
            border: 1px solid rgba(61, 60, 60, 0.3);
            padding: 30px 40px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: 40px;
            margin-right: auto;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .yearly-graph-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, var(--accent-green), var(--pale-green));
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            z-index: 1;
        }
        .yearly-graph-card h3 {
            color: var(--primary-green);
            margin-bottom: 20px;
            text-align: center;
        }
        /* Employee List Table */
        #employeeListModal table {
            background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, var(--pale-green) 100%);
            border-radius: 16px;
            box-shadow: 0 4px 16px var(--shadow-soft);
            border: 1px solid rgba(255,255,255,0.3);
            overflow: hidden;
        }
        #employeeListModal th {
            background: linear-gradient(to right, var(--primary-green) 0%, var(--accent-green) 100%);
            color: #fff;
            padding: 18px 24px;
            text-align: left;
            font-weight: 600;
            font-size: 1em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }
        #employeeListModal td {
            padding: 18px 24px;
            border-bottom: 1px solid var(--light-green);
            color: var(--forest-dark);
            background: transparent;
            transition: background 0.2s;
        }
        #employeeListModal tr:hover td {
            background: var(--pale-green);
        }
        #employeeListModal tr:last-child td {
            border-bottom: none;
        }
        /* Add background color to modal h2 */
        #addEmployeeModal h2,
        #employeeListModal h2,
        #editEmployeeModal h2 {
            background: var(--pale-green, #e8f5e8);
            display: inline-block;
            padding: 8px 12px 8px 2px;
            border-radius: 5px;
            margin-bottom: 18px;
            font-weight: 700;
            box-shadow: 0 2px 8px var(--shadow-soft, rgba(45,90,39,0.1));
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    
    <div class="sidebar" id="sidebar">
        <!-- Falling leaves animation -->
        <div class="falling-leaves">
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
        </div>
        <div class="sidebar-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        </div>
        <h2 class="mb-0">Department of<br>Agriculture</h2>
        <p class="mt-2">1960</p>
        <a href="{{ route('admin.dashboard') }}" class="dashboard-link"><span class="icon-lg mr-2">🛡️</span>Admin Dashboard</a>
        <a href="#" id="changePasswordBtn" class="dashboard-link mt-3"><span class="icon-lg mr-2">🔐</span>Change Password</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-title"><span class="material-icons">admin_panel_settings</span> Admin</div>
            <div class="profile-card">
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name }}</span>
                    <a href="#">#{{ auth()->user()->id }}</a>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                    <span class="material-icons" style="color: red">logout</span>
                </a>
            </div>
        </div>
        
        <div style="height:5px;width:100%;background: linear-gradient(145deg, #396426 0%, #668a24 100% 100%);margin-bottom:18px;margin-top:18px;"></div>
        <div class="dashboard-top-row">
            <div class="yearly-graph-card">
                <h3>Yearly Leave Requests (Last 5 Years)</h3>
                <canvas id="yearlyRequestsChart" height="100"></canvas>
            </div>
            <div class="stats-row">
                <div class="stat-card">
                    <span class="icon">👥</span>
                    <div class="count" style="font-size: 2em; font-weight: 600;">{{ $employeeCount ?? 0 }}</div>
                    <div class="label" style="font-family: 'Inter', 'Roboto', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; font-weight:500;">Total Employees</div>
                </div>
                <div class="stat-card">
                    <span class="icon">📝</span>
                    <div class="count" style="font-size: 2em; font-weight: 600;">{{ $leaveCount ?? 0 }}</div>
                    <div class="label" style="font-family: 'Inter', 'Roboto', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; font-weight:500;">Leave Requests</div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('yearlyRequestsChart').getContext('2d');
                var yearlyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($yearlyRequestGraphData['years'] ?? []),
                        datasets: [{
                            label: 'Total Requests',
                            data: @json($yearlyRequestGraphData['counts'] ?? []),
                            backgroundColor: 'rgba(6, 166, 56, 0.7)',
                            borderColor: 'rgb(10, 161, 113)',
                            borderWidth: 2,
                            borderRadius: 6,    
                            maxBarThickness: 50,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: false }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                title: { display: true, text: 'Year' }
                            },
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Requests' },
                                ticks: { stepSize: 1 }
                            }
                        }
                    }
                });
            });
        </script>
        <div class="dashboard-body">
            <div class="admin-actions">
                <div class="action-card">
                    <span class="icon">➕</span>
                    <div class="label">ADD NEW EMPLOYEE</div>
                </div>
                <div class="action-card">
                    <span class="icon">✅</span>
                    <div class="label">MANAGE LEAVE REQUESTS</div>
                </div>
                <div class="action-card">
                    <span class="icon">👥</span>
                    <div class="label">LIST OF EMPLOYEES</div>
                </div>
                <div class="action-card">
                    <span class="icon">📊</span>
                    <div class="label">GENERATE REPORTS</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Change Password Modal -->
    <div id="changePasswordModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center; overflow-y:auto; -webkit-overflow-scrolling:touch;">
        <div style="background:#fff; border-radius:24px; max-width:420px; width:95%; max-height:90vh; overflow-y:auto; margin:32px auto; padding:36px 28px 28px 28px; box-shadow:0 8px 32px rgba(20,83,45,0.18); position:relative; font-family:'Roboto', Arial, sans-serif;">
            <h2 style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px; color:#14532d; font-weight:800;">
                <span class="material-icons" style="vertical-align:middle; margin-right:8px; font-size:1.2em; color:#e3d643;">lock</span>
                Change Password
            </h2>
            <form id="changePasswordForm">
                <div style="margin-bottom:18px;">
                    <label for="current_password" style="display:block; margin-bottom:6px; font-weight:600; color:#14532d;">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required style="width:100%; padding:12px; border-radius:12px; border:1.5px solid #e3d643; font-size:1em;">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="new_password" style="display:block; margin-bottom:6px; font-weight:600; color:#14532d;">New Password</label>
                    <input type="password" id="new_password" name="new_password" required style="width:100%; padding:12px; border-radius:12px; border:1.5px solid #e3d643; font-size:1em;">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="new_password_confirmation" style="display:block; margin-bottom:6px; font-weight:600; color:#14532d;">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required style="width:100%; padding:12px; border-radius:12px; border:1.5px solid #e3d643; font-size:1em;">
                </div>
                <div id="changePasswordMsg" style="margin-bottom:12px; color:#e53935; text-align:center; display:none;"></div>
                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:18px;">
                    <button type="button" onclick="closeChangePasswordModal()" class="btn btn-secondary" style="border-radius:999px; background:#6c757d; color:#fff; font-weight:600; padding:12px 28px; font-size:1em; box-shadow:0 2px 8px rgba(20,83,45,0.10); transition:all 0.2s;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:999px; background:linear-gradient(135deg,#166534 0%,#14532d 100%); color:#fff; font-weight:700; padding:12px 32px; font-size:1em; box-shadow:0 6px 24px 0 rgba(67,233,123,0.18); transition:all 0.2s;">Change</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add New Employee Modal -->
    <div id="addEmployeeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:420px; width:95vw; margin:auto; padding:32px 24px 24px 24px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; font-size:1.3em; letter-spacing:1px;">➕ Add New Employee</h2>
            <form id="addEmployeeForm">
                <div style="display:flex; gap:8px; margin-bottom:10px;">
                    <input type="text" name="first_name" placeholder="First Name" required style="flex: 1; padding:8px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="last_name" placeholder="Last Name" required style="flex:1; padding:8px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="middle_initial" placeholder="M.I." maxlength="2" style="width:30px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <input type="email" name="email" placeholder="Email" style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" name="position" placeholder="Position" required style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" name="offices" placeholder="Office/Department" required style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" name="password" placeholder="Password" required style="width:95%; margin-bottom:18px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeAddEmployeeModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">✖ Cancel</button>
                    
                    <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">✚ Add</button>
                </div>
            </form>
        </div>
        </div>
    
    <!-- Employee List Modal -->
    <div id="employeeListModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; width:min(98vw,1200px); max-height:92vh; overflow-y:auto; margin:auto; padding:20px 10px 10px 10px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <div style="position:relative;">
                <button onclick="closeEmployeeListModal()" style="position:absolute; top:-10px; right:-10px; background:#e53935; color:#fff; border:none; border-radius:50%; width:32px; height:32px; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.2);">×</button>
                <h2 style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px;">
                    <span class="material-icons" style="vertical-align:middle; margin-right:8px; font-size:1.2em; "></span>
                    👥 List of Employees
                </h2>
            </div>
            
            <!-- Search and Sort Controls -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <input type="text" id="employeeSearch" placeholder="Search by name..." style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; min-width:200px;">
                    <button onclick="searchEmployees()" style="background:#1ecb6b; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer;">🔍 Search</button>
                    <button onclick="clearSearch()" style="background:#e53935; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer;">✖ Clear</button>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <label style="font-weight:600; color:#333;">Sort by:</label>
                    <select id="sortField" onchange="sortEmployees()" style="padding:6px 10px; border:1px solid #ccc; border-radius:4px;">
                        <option value="id">ID#</option>
                        <option value="name">Name</option>
                        <option value="position">Position</option>
                        <option value="offices">Office</option>
                    </select>
                    <button onclick="toggleSortOrder()" id="sortOrderBtn" style="background:#2196F3; color:#fff; border:none; border-radius:4px; padding:6px 10px; cursor:pointer;">↑ Asc</button>
                </div>
            </div>
            
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; table-layout:auto;">
                    <thead>
                        <tr style="background:linear-gradient(to right,#43a047 0%,#1ecb6b 100%); color:#fff;">
                            <th style="padding:14px 18px; text-align:left;">ID#</th>
                            <th style="padding:14px 18px; text-align:left;">Name</th>
                            <th style="padding:14px 18px; text-align:left;">Position</th>
                            <th style="padding:14px 18px; text-align:left;">Office</th>
                            <th style="padding:14px 18px; text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody">
                        <!-- Employee rows will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
            <div style="display:flex; justify-content:center; align-items:center; margin-top:24px;">
                <div id="employeeCount" style="color:#666; font-size:0.9em;">Total: 0 employees</div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editEmployeeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3001; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:20px; max-width:470px; width:95vw; margin:auto; padding:32px 24px 24px 0px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative; display:flex; flex-direction:column; align-items:center;">
            <button type="button" onclick="closeEditEmployeeModal()" style="position:absolute; top:16px; right:16px; background:#e53935; color:#fff; border:none; border-radius:50%; width:32px; height:40px; font-size:1.3em; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.2);">×</button>
            <h2 style="background: var(--pale-green, #e8f5e8); display:inline-block; padding:8px 24px; border-radius:5px; margin-bottom:24px; font-weight:700; box-shadow:0 2px 8px var(--shadow-soft, rgba(45,90,39,0.1)); text-align:center; font-size:1.3em; letter-spacing:1px;">✏️Edit Employee Information</h2>
            <form id="editEmployeeForm" style="width:100%; max-width:370px; margin:0 auto;">
                <input type="hidden" id="editEmployeeId" name="id">
                <div style="display:flex; gap:8px; margin-bottom:14px;">
                    <input type="text" id="editFirstName" name="first_name" placeholder="First Name" required style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" id="editLastName" name="last_name" placeholder="Last Name" required style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" id="editMiddleInitial" name="middle_initial" placeholder="M.I." maxlength="2" style="width:20px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <input type="email" id="editEmail" name="email" placeholder="Email" style="width:100%; margin-bottom:14px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" id="editPosition" name="position" placeholder="Position" required style="width:100%; margin-bottom:14px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" id="editOffices" name="offices" placeholder="Office/Department" required style="width:100%; margin-bottom:22px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:12px 0; font-size:1em; font-weight:600; cursor:pointer; width:100%; margin-top:8px;">Update</button>
            </form>
        </div>
    </div>
<footer>
    
</footer>
    <script>
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Change password modal logic
        const changePasswordModal = document.getElementById('changePasswordModal');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        if (changePasswordBtn) {
            changePasswordBtn.addEventListener('click', function(e) {
                e.preventDefault();
                changePasswordModal.style.display = 'flex';
                setTimeout(() => changePasswordModal.classList.add('show'), 10);
                changePasswordModal.style.overflowY = 'auto';
                document.body.style.overflow = 'hidden';
            });
        }
        function closeChangePasswordModal() {
            changePasswordModal.classList.remove('show');
            setTimeout(() => {
                changePasswordModal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.onsubmit = function(e) {
                e.preventDefault();
                const msg = document.getElementById('changePasswordMsg');
                msg.style.display = 'none';
                msg.style.color = '#e53935';
                msg.textContent = '';
                const data = {
                    current_password: this.current_password.value,
                    password: this.new_password.value,
                    password_confirmation: this.new_password_confirmation.value,
                    _method: 'PUT',
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                fetch('/password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': data._token
                    },
                    body: JSON.stringify(data)
                })
                .then(async response => {
                    if (response.ok) {
                        msg.style.display = 'block';
                        msg.style.color = '#1ecb6b';
                        msg.textContent = 'Password changed successfully!';
                        setTimeout(() => {
                            closeChangePasswordModal();
                        }, 1200);
                    } else {
                        const res = await response.json();
                        let errorMsg = 'An error occurred.';
                        if (res && res.errors) {
                            errorMsg = Object.values(res.errors).map(arr => arr.join(' ')).join(' ');
                        } else if (res && res.message) {
                            errorMsg = res.message;
                        }
                        msg.style.display = 'block';
                        msg.textContent = errorMsg;
                    }
                })
                .catch(() => {
                    msg.style.display = 'block';
                    msg.textContent = 'An error occurred.';
                });
            };
        }
        
        // Dark mode toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            
            // Check for saved dark mode preference
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            
            // Apply saved preference on page load
            if (isDarkMode) {
                body.classList.add('dark-mode');
                darkModeToggle.querySelector('.material-icons').textContent = 'light_mode';
            }
            
            // Toggle dark mode on button click
            darkModeToggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                const isDark = body.classList.contains('dark-mode');
                
                // Save preference to localStorage
                localStorage.setItem('darkMode', isDark);
                
                // Update icon based on mode
                darkModeToggle.querySelector('.material-icons').textContent = 
                    isDark ? 'light_mode' : 'dark_mode';
            });
        });
        
        document.querySelectorAll('.action-card').forEach((card, idx) => {
            card.addEventListener('click', function() {
                switch(idx) {
                    case 0:
                        // Add New Employee: Show modal only, do NOT redirect
                        document.getElementById('addEmployeeModal').style.display = 'flex';
                        break;
                    case 1:
                        // Manage Leave Requests
                        window.location.href = '/admin/leave-requests';
                        break;
                    case 2:
                        // List of Employees: Show modal
                        loadEmployees();
                        document.getElementById('employeeListModal').style.display = 'flex';
                        break;
                    case 3:
                        // Generate Reports
                        window.location.href = '/admin/reports';
                        break;
                }
            });
        });
        
        function closeAddEmployeeModal() {
            document.getElementById('addEmployeeModal').style.display = 'none';
        }
        // Handle form submission
        const addEmployeeForm = document.getElementById('addEmployeeForm');
        if(addEmployeeForm) {
            addEmployeeForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = {};
                formData.forEach((value, key) => data[key] = value);
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                try {
                    const response = await fetch('/admin/employees', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            // Remove 'Content-Type': 'application/json' to let browser set correct boundary for FormData
                        },
                        body: formData // send FormData directly
                    });
                    if (response.ok) {
                        alert('Employee added successfully!');
                        closeAddEmployeeModal();
                        window.location.reload();
                    } else {
                        const error = await response.json();
                        alert('Failed to add employee. ' + (error.message || JSON.stringify(error)));
                    }
                } catch (err) {
                    alert('Failed to add employee. ' + err);
                }
            });
        }
        
        // Employee List Modal Functions
        let allEmployees = []; // Store all employees for search/sort
        let currentSortField = 'id';
        let currentSortOrder = 'asc';
        
        function closeEmployeeListModal() {
            document.getElementById('employeeListModal').style.display = 'none';
        }
        
        function closeEditEmployeeModal() {
            document.getElementById('editEmployeeModal').style.display = 'none';
        }
        
        function loadEmployees() {
            fetch('/admin/employees', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                allEmployees = data; // Store all employees
                // Sort by ID# by default
                const sortedEmployees = [...data].sort((a, b) => {
                    const aValue = parseInt(a.id) || 0;
                    const bValue = parseInt(b.id) || 0;
                    return aValue - bValue;
                });
                displayEmployees(sortedEmployees);
                updateEmployeeCount(data.length);
            })
            .catch(error => {
                console.error('Error loading employees:', error);
                document.getElementById('employeeTableBody').innerHTML = '<tr><td colspan="5" style="text-align:center; padding:30px; color:#e53935;">Error loading employees</td></tr>';
                updateEmployeeCount(0);
            });
        }
        
        function displayEmployees(employees) {
            const tbody = document.getElementById('employeeTableBody');
            if (employees.length > 0) {
                tbody.innerHTML = employees.map(employee => `
                    <tr>
                        <td style="padding:12px 18px;">${employee.id}</td>
                        <td style="padding:12px 18px;">${employee.name}</td>
                        <td style="padding:12px 18px;">${employee.position || '-'}</td>
                        <td style="padding:12px 18px;">${employee.offices || '-'}</td>
                        <td style="padding:12px 18px; text-align:center;">
                            <button onclick="editEmployee(${employee.id})" style="background:#1ecb6b; color:#fff; border:none; border-radius:4px; padding:4px 8px; font-size:0.9em; cursor:pointer;">✏️Edit</button>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:30px; color:#888;">No employees found</td></tr>';
            }
        }
        
        function updateEmployeeCount(count) {
            document.getElementById('employeeCount').textContent = `Total: ${count} employees`;
        }
        
        function searchEmployees() {
            const searchTerm = document.getElementById('employeeSearch').value.toLowerCase().trim();
            if (searchTerm === '') {
                displayEmployees(allEmployees);
                updateEmployeeCount(allEmployees.length);
                return;
            }
            
            const filteredEmployees = allEmployees.filter(employee => 
                employee.name.toLowerCase().includes(searchTerm)
            );
            
            displayEmployees(filteredEmployees);
            updateEmployeeCount(filteredEmployees.length);
        }
        
        function clearSearch() {
            document.getElementById('employeeSearch').value = '';
            displayEmployees(allEmployees);
            updateEmployeeCount(allEmployees.length);
        }
        
        function sortEmployees() {
            currentSortField = document.getElementById('sortField').value;
            const sortedEmployees = [...allEmployees].sort((a, b) => {
                let aValue = a[currentSortField] || '';
                let bValue = b[currentSortField] || '';
                
                // Special handling for ID field - sort numerically
                if (currentSortField === 'id') {
                    aValue = parseInt(aValue) || 0;
                    bValue = parseInt(bValue) || 0;
                    
                    if (currentSortOrder === 'asc') {
                        return aValue - bValue;
                    } else {
                        return bValue - aValue;
                    }
                } else {
                    // For other fields, convert to string for comparison
                    aValue = String(aValue).toLowerCase();
                    bValue = String(bValue).toLowerCase();
                    
                    if (currentSortOrder === 'asc') {
                        return aValue.localeCompare(bValue);
                    } else {
                        return bValue.localeCompare(aValue);
                    }
                }
            });
            
            displayEmployees(sortedEmployees);
        }
        
        function toggleSortOrder() {
            currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
            const btn = document.getElementById('sortOrderBtn');
            btn.textContent = currentSortOrder === 'asc' ? '↑ Asc' : '↓ Desc';
            btn.style.background = currentSortOrder === 'asc' ? '#2196F3' : '#FF9800';
            sortEmployees();
        }
        
        function editEmployee(id) {
            fetch(`/admin/employees/${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(employee => {
                // Parse the name format: "Last,First Middle" (only one comma)
                let lastName = '', firstName = '', middleInitial = '';
                if (employee.name) {
                    const commaIdx = employee.name.indexOf(',');
                    if (commaIdx !== -1) {
                        lastName = employee.name.substring(0, commaIdx).trim();
                        const right = employee.name.substring(commaIdx + 1).trim();
                        const rightParts = right.split(' ');
                        firstName = rightParts[0] ? rightParts[0].trim() : '';
                        middleInitial = rightParts.length > 1 ? rightParts.slice(1).join(' ').trim() : '';
                    } else {
                        lastName = employee.name.trim();
                    }
                }
                document.getElementById('editEmployeeId').value = employee.id;
                document.getElementById('editFirstName').value = firstName;
                document.getElementById('editLastName').value = lastName;
                document.getElementById('editMiddleInitial').value = middleInitial;
                document.getElementById('editEmail').value = employee.email || '';
                document.getElementById('editPosition').value = employee.position || '';
                document.getElementById('editOffices').value = employee.offices || '';
                document.getElementById('editEmployeeModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error loading employee:', error);
                alert('Error loading employee data');
            });
        }
        
        // Search input event listener for real-time search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('employeeSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Debounce the search to avoid too many calls
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        searchEmployees();
                    }, 300);
                });
            }
        });
        
        // Edit Employee Form Submission
        const editEmployeeForm = document.getElementById('editEmployeeForm');
        if (editEmployeeForm) {
            editEmployeeForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = {};
                formData.forEach((value, key) => data[key] = value);
                
                // Format name as: LAST NAME, FIRST NAME MIDDLE INITIAL (all caps)
                const firstName = data.first_name.toUpperCase().trim();
                const lastName = data.last_name.toUpperCase().trim();
                const middleInitial = data.middle_initial.toUpperCase().trim();
                
                data.name = lastName + ', ' + firstName;
                if (middleInitial) {
                    data.name += ' ' + middleInitial;
                }
                
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                try {
                    const response = await fetch(`/admin/employees/${data.id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });
                    if (response.ok) {
                        alert('Employee updated successfully!');
                        closeEditEmployeeModal();
                        loadEmployees(); // Refresh the list
                    } else {
                        const error = await response.json();
                        alert('Failed to update employee. ' + (error.message || JSON.stringify(error)));
                    }
                } catch (err) {
                    alert('Failed to update employee. ' + err);
                }
            });
        }
    </script>
</body>
</html>
