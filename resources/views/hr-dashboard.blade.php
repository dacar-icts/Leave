<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HR Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f9f9e6;
            min-height: 100vh;
            position: relative;
        }
        /* SVG background pattern */
        .svg-bg {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: 0;
            pointer-events: none;
            opacity: 0.08;
        }
        .main-content {
            margin-left: 260px;
            padding: 0;
            min-height: 100vh;
            background: #f9f9e6;
            transition: margin-left 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 48px 0 48px !important; 
            min-height: 90px;
            flex-wrap: wrap;
            background: rgba(255,255,255,0.97);
            border-radius: 0 0 22px 22px;
            box-shadow: 0 6px 30x 0ba(20,83,45,0.10);
            position: relative;
        }
        .header-logo {
            display: flex;
            align-items: center;
            gap: 22px;
        }
        .header-logo img {
            height: 60px;
            width: 60px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 8px rgba(20,83,45,0.10);
            object-fit: contain;
        }
        .header-title {
            font-size: 2.5em;
            font-weight: 800;
            color: #14532d;
            line-height: 1.1;
            margin-bottom: 0;
            letter-spacing: 1.5px;
        }
        /* Decorative vine/leaf in header */
        .header-vine {
            position: absolute;
            left: 130px;
            top: 12px;
            width: 220px;
            height: 40px;
            z-index: 2;
        }
        /* Sidebar logo and vine */
        .sidebar {
            width: 260px;
            background: linear-gradient(to bottom, #166534 0%, #e3d643 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 28px;
            z-index: 100;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 32px rgba(20,83,45,0.13);
            border-radius: 0 0px 0px 0;
            backdrop-filter: blur(8px);
            background-blend-mode: overlay;
            overflow: hidden;
        }
        .sidebar-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 8px rgba(20,83,45,0.10);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-logo img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .sidebar-vine {
            width: 110px;
            height: 34px;
            margin-bottom: 12px;
        }
        /* Falling leaves in sidebar */
        .sidebar-leaf {
            position: absolute;
            left: 0;
            width: 28px;
            height: 28px;
            z-index: 10;
            opacity: 0.7;
            pointer-events: none;
            animation: sidebarLeafFall 7s linear infinite;
        }
        .sidebar-leaf:nth-child(1) { top: -30px; left: 30px; animation-delay: 0s; }
        .sidebar-leaf:nth-child(2) { top: -60px; left: 80px; animation-delay: 2s; }
        .sidebar-leaf:nth-child(3) { top: -90px; left: 160px; animation-delay: 4s; }
        .sidebar-leaf:nth-child(4) { top: -120px; left: 200px; animation-delay: 1.5s; }
        .sidebar-leaf:nth-child(5) { top: -150px; left: 60px; animation-delay: 3.5s; }
        @keyframes sidebarLeafFall {
            0% { transform: translateY(0) rotate(0deg) scale(1); opacity: 0.7; }
            80% { opacity: 0.7; }
            100% { transform: translateY(600px) rotate(360deg) scale(1.1); opacity: 0; }
        }
        /* Card/table enhancements */
        .stat-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 6px 32px rgba(20,83,45,0.13);
            padding: 36px 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 220px;
            flex: 1;
            transition: box-shadow 0.2s, transform 0.2s;
            border: 1.5px solid #e3d64322;
        }
        .stat-card:hover {
            box-shadow: 0 12px 40px rgba(20,83,45,0.18);
            transform: translateY(-6px) scale(1.04);
        }
        .stat-card .icon {
            font-size: 2.7em;
            margin-bottom: 12px;
            color: #14532d;
        }
        .stat-card .count {
            font-size: 2.2em;
            font-weight: 800;
            color: #14532d;
        }
        .stat-card .label {
            font-size: 1.08em;
            color: #166534;
            margin-top: 6px;
            text-align: center;
            font-weight: 600;
        }
        .table-container {
            background: #fff;
            box-shadow: 0 6px 32px rgba(20,83,45,0.13);
            overflow: hidden;
            border-radius: 22px;
            border: 1.5px solid #e3d64322;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.08em;
        }
        thead {
            background: linear-gradient(to right,#14532d 0%,#166534 100%);
            color: white;
        }
        th {
            padding: 17px;
            text-align: left;
            font-weight: 700;
            letter-spacing: 0.7px;
        }
        td {
            padding: 17px;
            border-bottom: 1px solid #e3e3c3;
        }
        tr:hover td {
            background: #e6f4ea;
        }
        .dashboard-link {
            margin: 40px 0 0 0;
            font-size: 1.13em;
            color: #fff;
            background: transparent;
            padding: 12px 24px;
            border-radius: 0 24px 24px 0;
            display: flex;
            align-items: center;
            font-weight: 700;
            text-decoration: none;
            justify-content: flex-start;
            box-shadow: none;
            border: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        
        .dashboard-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #f9f9e6 0%, #f0f0d0 100%);
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }
        
        .dashboard-link::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 100%;
            background: linear-gradient(90deg, transparent, #f9f9e6);
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }
        
        .dashboard-link span {
            position: relative;
            z-index: 2;
            transition: color 0.4s ease;
        }
        
        .dashboard-link.active, .dashboard-link:focus {
            color: #14532d;
            transform: translateX(10px);
        }
        
        .dashboard-link.active::before, .dashboard-link:focus::before {
            transform: translateX(0);
        }
        
        .dashboard-link.active::after, .dashboard-link:focus::after {
            transform: translateX(0);
        }
        
        .dashboard-link:hover {
            color: #14532d;
            transform: translateX(8px);
        }
        
        .dashboard-link:hover::before {
            transform: translateX(0);
        }
        
        .dashboard-link:hover::after {
            transform: translateX(0);
        }
        
        .sidebar {
            width: 240px;
            background: linear-gradient(to bottom, #355E3B 0%, #228B22 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 24px;
            z-index: 100;
            transition: transform 0.3s ease;
            border-radius: 0 0px 0px 0;
            overflow: hidden;
        }
        
        .sidebar img {
            width: 70px;
            margin: 0 0 10px 0;
            display: block;
        }
        
        .sidebar h2, .sidebar p {
            margin: 0;
            text-align: center;
            width: 100%;
        }
        
        .sidebar .dashboard-link {
            margin: 40px 0 0 0;
            font-size: 1.1em;
            color: #fff;
            background: #08bd72;
            padding: 10px 28px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            font-weight: 500;
            text-decoration: none;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(20,83,45,0.10);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .sidebar .dashboard-link:hover, .sidebar .dashboard-link:focus {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: #14532d;
            border-radius: 999px;
            box-shadow: 0 6px 24px 0 rgba(67,233,123,0.18);
            transform: scale(1.07);
        }
        
        .sidebar .dashboard-link i {
            margin-right: 8px;
        }
        
        .logout-icon-btn {
            background: none;
            border: none;
            color: #e53935;
            font-size: 1.7em;
            cursor: pointer;
            margin-left: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        
        .logout-icon-btn:hover {
            background: #ffeaea;
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
            padding: 24px 40px 0 40px !important; 
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
        
        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f5f5f5;
            border-radius: 30px;
            padding: 8px 18px;
            min-height: 54px;
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
            justify-content: center;
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
            flex-wrap: wrap;
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
            flex: 1;
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
        
        .filters-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .date-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .date-range input[type="date"] {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
        }
        
        .filter-group {
            display: flex;
            gap: 8px;
        }
        
        .filter-btn {
            background: #fff;
            border: 1px solid #00a651;
            color: #00a651;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .filter-btn.active {
            background: #00a651;
            color: #fff;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 20px;
            padding: 5px 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .search-bar input {
            border: none;
            padding: 8px;
            font-size: 0.9em;
            outline: none;
            width: 200px;
        }
        
        .table-container {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: linear-gradient(to right,#43a047 0%,#1ecb6b 100%);
            color: white;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .status-pending {
            color: #f44336;
            font-weight: 600;
        }
        
        .status-certified {
            color: #00a651;
            font-weight: 600;
        }
        
        .status-rejected { color:rgb(14, 12, 125); font-weight: 700; }
        
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #2196F3;
            margin-right: 5px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        
        .icon-btn:hover {
            background-color: rgba(33, 150, 243, 0.1);
        }
        
        @media (max-width: 1200px) {
            .stat-card {
                padding: 20px 30px;
                min-width: 180px;
            }
            .stats-row {
                gap: 15px;
            }
        }
        
        @media (max-width: 992px) {
            .header-title {
                font-size: 1.8em;
            }
            .header, .dashboard-body {
                padding: 20px !important;
            }
            .sidebar {
                width: 180px;
            }
            .main-content {
                margin-left: 180px;
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
                min-height: unset;
            }
            .profile {
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
            .filters-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-bar {
                width: 100%;
            }
            .search-bar input {
                width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .header-title {
                font-size: 1.5em;
            }
        }
        .animated-border {
            border: 2px solid #e53935;
            animation: borderPulse 5s infinite;
            }

            @keyframes borderPulse {
            0% {
                border-color: #e53935;
            }
            50% {
                border-color:rgb(255, 255, 255);
            }
            100% {
                border-color: #e53935;
            }
        }

        /* Enhanced Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-container {
            background: #fff;
            border-radius: 24px;
            max-width: 900px;
            width: 95%;
            max-height: 90vh;
            overflow: hidden;
            margin: 20px auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes modalSlideIn {
            from { 
                transform: translateY(-50px) scale(0.95);
                opacity: 0;
            }
            to { 
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 32px;
            background: linear-gradient(135deg, #14532d 0%, #166534 100%);
            color: white;
            border-radius: 24px 24px 0 0;
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-title h2 {
            margin: 0;
            font-size: 1.5em;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .modal-title .material-icons {
            font-size: 1.8em;
            color: #e3d643;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .modal-content {
            padding: 32px;
            max-height: calc(90vh - 120px);
            overflow-y: auto;
        }

        .preview-content {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border-left: 4px solid #14532d;
        }

        .preview-content div {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .preview-content strong {
            color: #14532d;
            font-weight: 600;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
        }

        .preview-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }

        .preview-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .preview-item .material-icons {
            color: #166534;
            font-size: 1.2em;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .preview-item div {
            flex: 1;
            line-height: 1.5;
        }

        /* Certification Preview Styles */
        .certification-preview {
            margin-top: 24px;
            display: grid;
            gap: 20px;
        }

        .cert-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e9ecef;
        }

        .cert-section h3 {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 16px 0;
            color: #14532d;
            font-size: 1.1em;
            font-weight: 600;
        }

        .cert-section h3 .material-icons {
            color: #166534;
            font-size: 1.2em;
        }

        .cert-date {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            color: #495057;
        }

        .cert-date .material-icons {
            color: #166534;
            font-size: 1.1em;
        }

        .cert-table {
            margin-bottom: 16px;
        }

        .cert-table table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .cert-table th {
            background: #14532d;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-weight: 600;
            font-size: 0.9em;
        }

        .cert-table td {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .cert-table .label-cell {
            font-style: italic;
            color: #6c757d;
            font-weight: 500;
        }

        .cert-table .text-center {
            text-align: center;
            font-weight: 500;
        }

        .signature-preview {
            text-align: center;
            padding: 12px;
            background: white;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }

        .signature-preview.director {
            background: linear-gradient(135deg, #14532d 0%, #166534 100%);
            color: white;
            border-color: #14532d;
        }

        .signature-preview.director .signature-name {
            color: white;
        }

        .signature-preview.director .signature-title {
            color: #e3d643;
        }

        .recommendation-preview {
            margin-bottom: 16px;
        }

        .checkbox-preview {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            padding: 8px;
            border-radius: 6px;
            background: white;
            border: 1px solid #e9ecef;
        }

        .checkbox-preview.checked {
            background: #e8f5e8;
            border-color: #166534;
        }

        .checkbox-preview .material-icons {
            color: #166534;
            font-size: 1.1em;
        }

        .checkbox-preview.checked .material-icons {
            color: #166534;
        }

        .remark-preview {
            background: white;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            margin-bottom: 8px;
            font-style: italic;
            color: #495057;
        }

        .approval-preview {
            margin-bottom: 16px;
        }

        .approval-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            padding: 8px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .approval-item .material-icons {
            color: #166534;
            font-size: 1.1em;
        }

        .disapproval-preview {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            padding: 8px;
            background: #fff5f5;
            border-radius: 6px;
            border: 1px solid #fed7d7;
            color: #c53030;
        }

        .disapproval-preview .material-icons {
            color: #e53e3e;
            font-size: 1.1em;
        }

        .certify-form {
            display: none;
        }

        .form-section {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e9ecef;
        }

        .section-header h3 {
            margin: 0;
            color: #14532d;
            font-size: 1.3em;
            font-weight: 700;
        }

        .section-header .material-icons {
            color: #166534;
            font-size: 1.5em;
        }

        .certification-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .credits-section, .recommendation-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e9ecef;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            color: #14532d;
        }

        .section-title h4 {
            margin: 0;
            font-size: 1.1em;
            font-weight: 600;
        }

        .section-title .material-icons {
            font-size: 1.2em;
            color: #166534;
        }

        .date-input {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .date-input label {
            font-weight: 600;
            color: #495057;
        }

        .date-input input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.95em;
            transition: border-color 0.3s ease;
        }

        .date-input input:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
        }

        .credits-table {
            margin-bottom: 20px;
        }

        .credits-table table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .credits-table th {
            background: #14532d;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
            font-size: 0.9em;
        }

        .credits-table td {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .credits-table .label-cell {
            font-style: italic;
            color: #6c757d;
            font-weight: 500;
        }

        .credits-table input {
            width: 100%;
            border: none;
            text-align: center;
            padding: 6px;
            font-size: 0.9em;
            background: transparent;
        }

        .credits-table input:focus {
            outline: none;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .signature-box {
            text-align: center;
            padding: 16px;
            background: white;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            margin-top: 16px;
        }

        .signature-name {
            color: #14532d;
            font-weight: 700;
            font-size: 1.1em;
            margin-bottom: 4px;
        }

        .signature-title {
            color: #6c757d;
            font-size: 0.9em;
        }

        .recommendation-options {
            margin-bottom: 16px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .checkbox-container:hover {
            background: #f8f9fa;
        }

        .checkbox-container input[type="checkbox"] {
            display: none;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            border: 2px solid #dee2e6;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s ease;
        }

        .checkbox-container input[type="checkbox"]:checked + .checkmark {
            background: #166534;
            border-color: #166534;
        }

        .checkbox-container input[type="checkbox"]:checked + .checkmark::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .disapproval-reason {
            width: 100%;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 12px;
            margin-top: 8px;
            font-size: 0.9em;
            transition: border-color 0.3s ease;
        }

        .disapproval-reason:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
        }

        .remarks-section {
            margin-bottom: 16px;
        }

        .remark-input {
            width: 100%;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
            font-size: 0.9em;
            transition: border-color 0.3s ease;
        }

        .remark-input:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
        }

        .approval-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e9ecef;
            margin-bottom: 24px;
        }

        .approval-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .approval-left, .approval-right {
            background: white;
            border-radius: 8px;
            padding: 16px;
            border: 1px solid #e9ecef;
        }

        .approval-inputs {
            margin-top: 12px;
        }

        .input-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .input-group input {
            width: 60px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 6px 8px;
            text-align: center;
            font-size: 0.9em;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
        }

        .input-group label {
            font-size: 0.9em;
            color: #495057;
        }

        .disapproval-inputs input {
            width: 100%;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
            font-size: 0.9em;
            transition: border-color 0.3s ease;
        }

        .disapproval-inputs input:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
        }

        .director-signature {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #14532d 0%, #166534 100%);
            color: white;
            border-radius: 12px;
            margin-top: 20px;
        }

        .director-signature .signature-name {
            color: white;
            font-size: 1.2em;
            margin-bottom: 4px;
        }

        .director-signature .signature-title {
            color: #e3d643;
            font-size: 0.95em;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #166534 0%, #14532d 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(22, 101, 52, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modal-container {
                width: 98%;
                margin: 10px auto;
                border-radius: 16px;
            }

            .modal-header {
                padding: 16px 20px;
                border-radius: 16px 16px 0 0;
            }

            .modal-content {
                padding: 20px;
            }

            .certification-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .approval-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .modal-actions {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }
        }

    </style>
    
    <!-- Mobile fixes -->
    <script src="{{ asset('js/mobile-fix.js') }}"></script>
</head>
<body ontouchstart="">
    <svg class="svg-bg" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="wheatPattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                <path d="M20,80 Q30,60 40,80 Q50,60 60,80 Q70,60 80,80" stroke="#DAA520" stroke-width="2" fill="none" opacity="0.12"/>
                <circle cx="30" cy="70" r="2" fill="#DAA520" opacity="0.12"/>
                <circle cx="50" cy="70" r="2" fill="#DAA520" opacity="0.12"/>
                <circle cx="70" cy="70" r="2" fill="#DAA520" opacity="0.12"/>
            </pattern>
            <pattern id="leafPattern" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                <path d="M20,40 Q30,20 40,40 Q30,60 20,40 Z" fill="#228B22" opacity="0.06"/>
                <path d="M60,40 Q70,20 80,40 Q70,60 60,40 Z" fill="#32CD32" opacity="0.06"/>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#wheatPattern)"/>
        <rect width="100%" height="100%" fill="url(#leafPattern)"/>
    </svg>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        </div>
        <svg class="sidebar-vine" viewBox="0 0 100 30">
            <path d="M5,25 Q20,5 35,25 T65,25 T95,25 T130,25 T190,25 T210,25" stroke="#DAA520" stroke-width="2" fill="none"/>
            <ellipse cx="20" cy="15" rx="4" ry="7" fill="#43a047" opacity="0.5"/>
            <ellipse cx="50" cy="15" rx="4" ry="7" fill="#43a047" opacity="0.5"/>
            <ellipse cx="80" cy="15" rx="4" ry="7" fill="#43a047" opacity="0.5"/>
        </svg>
        <h2 style="margin-bottom: 0;">Department of<br>Agriculture</h2>
        <p style="margin-top: 2px;">1960</p>
        <a href="{{ route('hr.dashboard') }}" class="dashboard-link">
            <span class="material-icons">account_circle</span>
            <span>HR Dashboard</span>
        </a>
        <a href="#" id="changePasswordBtn" class="dashboard-link" style="margin-top: 15px;">
            <span class="material-icons">lock</span>
            <span>Change Password</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <!-- Falling leaves -->
        <svg class="sidebar-leaf" viewBox="0 0 28 28"><path d="M14 2 Q18 10 26 14 Q18 18 14 26 Q10 18 2 14 Q10 10 14 2 Z" fill="#14532d"/></svg>
        <svg class="sidebar-leaf" viewBox="0 0 28 28"><path d="M14 2 Q18 10 26 14 Q18 18 14 26 Q10 18 2 14 Q10 10 14 2 Z" fill="#166534"/></svg>
        <svg class="sidebar-leaf" viewBox="0 0 28 28"><path d="M14 2 Q18 10 26 14 Q18 18 14 26 Q10 18 2 14 Q10 10 14 2 Z" fill="#065f46"/></svg>
        <svg class="sidebar-leaf" viewBox="0 0 28 28"><path d="M14 2 Q18 10 26 14 Q18 18 14 26 Q10 18 2 14 Q10 10 14 2 Z" fill="#064e3b"/></svg>
        <svg class="sidebar-leaf" viewBox="0 0 28 28"><path d="M14 2 Q18 10 26 14 Q18 18 14 26 Q10 18 2 14 Q10 10 14 2 Z" fill="#0f3a0f"/></svg>
    </div>
    
    <div class="main-content">
        <div class="header">
            <div class="header-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
                <span class="header-title">Leave Request Logs</span>
            </div>
            <svg class="header-vine" viewBox="0 0 220 40">
                <path d="M10,30 Q40,5 70,30 T130,30 T190,30 T210,30" stroke="#DAA520" stroke-width="2" fill="none"/>
                <ellipse cx="40" cy="18" rx="7" ry="12" fill="#43a047" opacity="0.4"/>
                <ellipse cx="100" cy="18" rx="7" ry="12" fill="#43a047" opacity="0.4"/>
                <ellipse cx="160" cy="18" rx="7" ry="12" fill="#43a047" opacity="0.4"/>
            </svg>
            <div class="profile">
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name }}</span>
                    <a href="#">#{{ auth()->user()->id }}</a>
                </div>
                <button class="logout-icon-btn" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="material-icons">exit_to_app</span>
                </button>
            </div>
        </div>
        
        <div style="height:5px;width:100%;background:linear-gradient(145deg,#00d082 0%,#fcb900 100%);margin-bottom:18px;margin-top:18px;"></div>
        
        <div class="dashboard-body">
            <div class="stats-row">
                <div class="stat-card animated-border">
                    <span class="material-icons icon" style="color:#e53935;">schedule</span>
                    <div class="count" style="color:#e53935;">{{ $pendingCount }}</div>
                    <div class="label">Pending Certification</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#00a651;">check_circle</span>
                    <div class="count" style="color:#00a651;">{{ $certifiedCount }}</div>
                    <div class="label">HR Certified</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#2196f3;">insights</span>
                    <div class="count" style="color:#2196f3;">{{ $totalRequests }}</div>
                    <div class="label">Total Requests</div>
                </div>
            </div>
            
            <div class="filters-container">
                <div class="date-range">
                    <form id="dateFilterForm" style="display:flex; gap:10px; align-items:center;">
                        <label style="font-weight:500;">Date Range:</label>
                        <input type="date" name="start_date" id="startDate" value="{{ request('start_date') }}">
                        <span>to</span>
                        <input type="date" name="end_date" id="endDate" value="{{ request('end_date') }}">
                        <button type="submit" class="filter-btn" style="background:#00a651; color:#fff;">Apply</button>
                        <button type="button" class="filter-btn" onclick="clearDateFilter()">Clear</button>
                    </form>
                </div>
                
                <div style="display:flex; align-items:center; gap:12px; flex-wrap: wrap;">
                    <div class="filter-group">
                        <button class="filter-btn active" data-status="all" onclick="filterStatus(event, 'all')">All</button>
                        <button class="filter-btn" data-status="Pending" onclick="filterStatus(event, 'Pending')">Pending</button>
                        <button class="filter-btn" data-status="Certified" onclick="filterStatus(event, 'Certified')">Certified</button>
                    </div>
                    <div class="search-bar">
                        <span class="material-icons">search</span>
                        <input type="text" id="searchInput" placeholder="Search Name or ID #">
                        <span class="material-icons" style="color:#888;cursor:pointer;" onclick="clearSearch()">close</span>
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)" style="cursor:pointer;">DATE <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th onclick="sortTable(1)" style="cursor:pointer;">ID # <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th onclick="sortTable(2)" style="cursor:pointer;">NAME <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th onclick="sortTable(3)" style="cursor:pointer;">STATUS <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="leaveTableBody">
                        @foreach($leaveRequests as $leave)
                        <tr data-id="{{ $leave->id }}" data-date="{{ $leave->created_at }}" data-status="{{ $leave->status }}">
                            <td>
                                {{ \Carbon\Carbon::parse($leave->created_at)->format('n/j/Y') }}<br>
                                <span style="font-size:0.95em; color:#888;">
                                    {{ \Carbon\Carbon::parse($leave->created_at)->format('g:i A') }}
                                </span>
                            </td>
                            <td>#{{ $leave->user->id }}</td>
                            <td>{{ strtoupper($leave->user->name) }}</td>
                            <td class="{{ $leave->status === 'Pending' ? 'status-pending' : ($leave->status === 'Certified' ? 'status-certified' : ($leave->status === 'Rejected' ? 'status-rejected' : '')) }}">
                                {{ $leave->status === 'Certified' ? 'HR CERTIFIED' : ($leave->status === 'Rejected' ? 'REJECTED' : strtoupper($leave->status)) }}
                            </td>
                            <td>
                                <button class="icon-btn" title="View" onclick="showPreviewModal({{ $leave->id }})">
                                    <span class="material-icons">visibility</span>
                                </button>
                                @if($leave->status === 'Pending')
                                    <button class="icon-btn edit" title="Edit" onclick="showEditModal({{ $leave->id }})" style="color: #2196F3;">
                                        <span class="material-icons">edit</span>
                                    </button>
                                @endif
                                <button class="icon-btn delete-btn" title="Delete" onclick="deleteTableRow(this, {{ $leave->id }})" style="color: #e53935;">
                                    <span class="material-icons">delete</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($leaveRequests) === 0)
                        <tr>
                            <td colspan="5" style="text-align:center; padding:30px;">
                                <div style="color:#888; font-size:1.1em;">No leave requests found</div>
                                @if(request('start_date') || request('end_date'))
                                    <button class="filter-btn" onclick="clearDateFilter()" style="margin-top:10px;">Clear Filters</button>
                                @endif
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Enhanced Leave Request Preview/Certification Modal -->
    <div id="previewModal" class="modal-overlay">
        <div class="modal-container">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="modal-title">
                    <span class="material-icons">description</span>
                    <h2>Leave Request Preview</h2>
                </div>
                <button class="modal-close" onclick="closePreviewModal()">
                    <span class="material-icons">close</span>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="modal-content">
                <div id="previewContent" class="preview-content"></div>
                
                <!-- Enhanced Certification Form -->
                <form id="certifyForm" class="certify-form">
                    <div class="form-section">
                        <div class="section-header">
                            <span class="material-icons">verified</span>
                            <h3>Leave Certification & Recommendation</h3>
                        </div>
                        
                        <div class="certification-grid">
                            <!-- Leave Credits Section -->
                            <div class="credits-section">
                                <div class="section-title">
                                    <span class="material-icons">schedule</span>
                                    <h4>7.A CERTIFICATION OF LEAVE CREDITS</h4>
                                </div>
                                
                                <div class="date-input">
                                    <label>As of:</label>
                                    <input type="date" name="as_of_date" required>
                                </div>
                                
                                <div class="credits-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Vacation Leave</th>
                                                <th>Sick Leave</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="label-cell">Total Earned</td>
                                                <td><input type="text" name="vl_earned" placeholder="0"></td>
                                                <td><input type="text" name="sl_earned" placeholder="0"></td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell">Less this application</td>
                                                <td><input type="text" name="vl_less" placeholder="0"></td>
                                                <td><input type="text" name="sl_less" placeholder="0"></td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell">Balance</td>
                                                <td><input type="text" name="vl_balance" placeholder="0"></td>
                                                <td><input type="text" name="sl_balance" placeholder="0"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="signature-box">
                                    <div class="signature-name">JOY ROSE C. BAWAYAN</div>
                                    <div class="signature-title">Administrative Officer V (HRMO III)</div>
                                    <input type="hidden" name="hr_signatory" value="JOY ROSE C. BAWAYAN|Administrative Officer V (HRMO III)">
                                </div>
                            </div>
                            
                            <!-- Recommendation Section -->
                            <div class="recommendation-section">
                                <div class="section-title">
                                    <span class="material-icons">recommend</span>
                                    <h4>7.B RECOMMENDATION</h4>
                                </div>
                                
                                <div class="recommendation-options">
                                    <label class="checkbox-container">
                                        <input type="checkbox" id="recommendation_approval" name="recommendation" value="approval">
                                        <span class="checkmark"></span>
                                        For approval
                                    </label>
                                    
                                    <label class="checkbox-container">
                                        <input type="checkbox" id="recommendation_disapproval" name="recommendation" value="disapproval">
                                        <span class="checkmark"></span>
                                        For disapproval due to
                                    </label>
                                    
                                    <input type="text" name="disapproval_reason" placeholder="Reason for disapproval" class="disapproval-reason">
                                </div>
                                
                                <div class="remarks-section">
                                    <input type="text" name="other_remarks" placeholder="Additional remarks" class="remark-input">
                                    <input type="text" name="other_remarks2" placeholder="Additional remarks" class="remark-input">
                                    <input type="text" name="other_remarks3" placeholder="Additional remarks" class="remark-input">
                                </div>
                                
                                <div class="signature-box">
                                    <div class="signature-name" id="adminNameDisplay">AIDA Y. PAGTAN</div>
                                    <div class="signature-title" id="adminPositionDisplay">Chief, Administrative and Finance Division</div>
                                    <input type="hidden" name="admin_signatory" id="adminSignatoryInput" value="AIDA Y. PAGTAN|Chief, Administrative and Finance Division">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Approval Section -->
                        <div class="approval-section">
                            <div class="approval-grid">
                                <div class="approval-left">
                                    <div class="section-title">
                                        <span class="material-icons">check_circle</span>
                                        <h4>7.C APPROVED FOR:</h4>
                                    </div>
                                    <div class="approval-inputs">
                                        <div class="input-group">
                                            <input type="text" name="days_with_pay" placeholder="0">
                                            <label>days with pay</label>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="days_without_pay" placeholder="0">
                                            <label>days without pay</label>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="others_specify" placeholder="0">
                                            <label>others (Specify)</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="approval-right">
                                    <div class="section-title">
                                        <span class="material-icons">cancel</span>
                                        <h4>7.D DISAPPROVED DUE TO:</h4>
                                    </div>
                                    <div class="disapproval-inputs">
                                        <input type="text" name="disapproval_reason1" placeholder="Reason for disapproval">
                                        <input type="text" name="disapproval_reason2" placeholder="Additional reason">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Director Signature -->
                        <div class="director-signature">
                            <div class="signature-name">Atty. JENNILYN M. DAWAYAN, CESO IV</div>
                            <div class="signature-title">Regional Executive Director</div>
                            <input type="hidden" name="director_signatory" value="Atty. JENNILYN M. DAWAYAN, CESO IV|Regional Executive Director">
                        </div>
                    </div>
                    
                    <input type="hidden" name="leave_id" id="leave_id">
                    
                    <!-- Action Buttons -->
                    <div class="modal-actions">
                        <button type="button" onclick="discardEdit()" class="btn btn-secondary">
                            <span class="material-icons">cancel</span>
                            Discard
                        </button>
                        <button type="button" id="rejectBtn" class="btn btn-secondary" style="background:#e53935; color:white;">
                            <span class="material-icons">block</span>
                            Reject
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="material-icons">save</span>
                            Save Certification
                        </button>
                    </div>
                </form>
                
                <!-- Close Only Button -->
                <div id="closeOnly" class="modal-actions">
                    <button type="button" onclick="closePreviewModal()" class="btn btn-secondary">
                        <span class="material-icons">close</span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal (hidden by default) -->
    <div id="rejectModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:420px; width:95%; max-height:90vh; overflow-y:auto; margin:20px auto; padding:28px 22px 20px 22px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; color:#e53935; font-size:1.2em;">
                <span class="material-icons" style="vertical-align:middle; margin-right:8px;">block</span>
                Reject Leave Request
            </h2>
            <textarea id="rejectionComment" rows="4" style="width:100%; border-radius:8px; border:1.5px solid #e53935; margin-bottom:18px; font-size:1em;" placeholder="Enter reason for rejection (required)"></textarea>
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeRejectModal()" class="btn btn-secondary">Cancel</button>
                <button type="button" onclick="confirmReject()" class="btn btn-primary" style="background:#e53935; color:white;">Reject</button>
            </div>
        </div>
    </div>

    <!-- Add/replace the change password modal markup at the end of the body -->
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

    <script>
        const leaveRequests = @json($leaveRequests);
        let editingLeaveId = null;
        let currentSort = { column: -1, direction: 'asc' };
        let currentPreviewData = null;
        
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        function showPreviewModal(id) {
            renderPreviewModal(id);
        }

        function showEditModal(id) {
            // Always hide the reject modal if open
            const rejectModal = document.getElementById('rejectModal');
            if (rejectModal) rejectModal.style.display = 'none';
            // Reset any previous editing state first
            editingLeaveId = null;
            currentPreviewData = null;
            // Get the form and reset it
            const certifyForm = document.getElementById('certifyForm');
            if (certifyForm) {
                certifyForm.reset();
                certifyForm.style.display = 'block';
                certifyForm.classList.remove('hidden');
            }
            // Set the new editing state
            editingLeaveId = id;
            const leave = leaveRequests.find(l => l.id === id);
            if (!leave) return;
            // Store the current leave data for preview updates
            currentPreviewData = leave;
            // Fill the preview content
            fillPreviewContent(leave);
            // Set the leave ID in the hidden field
            const leaveIdField = document.getElementById('leave_id');
            if (leaveIdField) {
                leaveIdField.value = id;
            }
            // Update admin signatory if available in the leave request
            if (leave.admin_signatory) {
                const adminParts = leave.admin_signatory.split('|');
                const adminName = adminParts[0] || '';
                const adminPosition = adminParts[1] || 'Division Chief';
                document.getElementById('adminNameDisplay').textContent = adminName;
                document.getElementById('adminPositionDisplay').textContent = adminPosition;
                document.getElementById('adminSignatoryInput').value = leave.admin_signatory;
            }
            // Show the edit form and hide the close-only button
            if (certifyForm) {
                certifyForm.style.display = 'block';
                certifyForm.classList.remove('hidden');
            }
            const closeOnly = document.getElementById('closeOnly');
            if (closeOnly) {
                closeOnly.style.display = 'none';
            }
            const previewModal = document.getElementById('previewModal');
            if (previewModal) {
                previewModal.style.display = 'flex';
                previewModal.style.zIndex = 4000;
                document.body.style.overflow = 'hidden';
            }
            // Add event listeners to update the preview in real-time
            setupSignatoryListeners();
        }
        
        function setupSignatoryListeners() {
            // Add event listeners to update preview when form fields change
            const recommendationApproval = document.getElementById('recommendation_approval');
            const recommendationDisapproval = document.getElementById('recommendation_disapproval');
            const disapprovalReason = document.getElementById('disapproval_reason');
            const otherRemarks = document.getElementById('other_remarks');
            const otherRemarks2 = document.getElementById('other_remarks2');
            const otherRemarks3 = document.getElementById('other_remarks3');
            
            // Only add event listeners if elements exist
            if (recommendationApproval) recommendationApproval.addEventListener('change', updatePreviewSignatories);
            if (recommendationDisapproval) recommendationDisapproval.addEventListener('change', updatePreviewSignatories);
            if (disapprovalReason) disapprovalReason.addEventListener('input', updatePreviewSignatories);
            if (otherRemarks) otherRemarks.addEventListener('input', updatePreviewSignatories);
            if (otherRemarks2) otherRemarks2.addEventListener('input', updatePreviewSignatories);
            if (otherRemarks3) otherRemarks3.addEventListener('input', updatePreviewSignatories);
        }
        
        function updatePreviewSignatories() {
            if (!currentPreviewData) return;
            
            // Create a temporary certification data object with the current form values
            const tempCertData = {
                hr_signatory: document.querySelector('input[name="hr_signatory"]')?.value || 'JOY ROSE C. BAWAYAN|Administrative Officer V (HRMO III)',
                admin_signatory: document.querySelector('input[name="admin_signatory"]')?.value || 'AIDA Y. PAGTAN|Chief, Administrative and Finance Division',
                director_signatory: document.querySelector('input[name="director_signatory"]')?.value || 'Atty. JENNILYN M. DAWAYAN, CESO IV|Regional Executive Director',
                recommendation: document.getElementById('recommendation_approval')?.checked ? 'approval' : 'disapproval',
                disapproval_reason: document.getElementById('disapproval_reason')?.value || '',
                other_remarks: document.getElementById('other_remarks')?.value || '',
                other_remarks2: document.getElementById('other_remarks2')?.value || '',
                other_remarks3: document.getElementById('other_remarks3')?.value || ''
            };
            
            // Create a temporary leave object with the current certification data
            const tempLeave = {...currentPreviewData};
            
            // If there's existing certification data, merge it with our temporary data
            if (tempLeave.certification_data) {
                let existingData = {};
                try {
                    existingData = typeof tempLeave.certification_data === 'string' 
                        ? JSON.parse(tempLeave.certification_data) 
                        : tempLeave.certification_data;
                } catch (e) {}
                
                tempLeave.certification_data = JSON.stringify({...existingData, ...tempCertData});
            } else {
                tempLeave.certification_data = JSON.stringify(tempCertData);
            }
            
            // Re-render the preview content with updated signatories
            fillPreviewContent(tempLeave);
        }

        function fillPreviewContent(leave) {
            // Check if leave has admin_signatory
            let adminSignatoryInfo = '';
            if (leave.admin_signatory) {
                const parts = leave.admin_signatory.split('|');
                if (parts.length > 1) {
                    adminSignatoryInfo = `<div><strong>Division Chief:</strong> ${parts[0]} (${parts[1]})</div>`;
                } else {
                    adminSignatoryInfo = `<div><strong>Division Chief:</strong> ${leave.admin_signatory}</div>`;
                }
            }
            
            let html = `
                <div class="preview-grid">
                    <div class="preview-item">
                        <span class="material-icons">event</span>
                        <div>
                            <strong>Date Filed:</strong> ${leave.created_at ? new Date(leave.created_at).toLocaleDateString() : ''}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">badge</span>
                        <div>
                            <strong>ID #:</strong> #${leave.user ? leave.user.id : ''}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">person</span>
                        <div>
                            <strong>Name:</strong> ${leave.user ? leave.user.name.toUpperCase() : ''}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">business</span>
                        <div>
                            <strong>Office:</strong> ${leave.office || (leave.user ? leave.user.offices : '') || 'Department of Agriculture'}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">${leave.status === 'Pending' ? 'schedule' : leave.status === 'Rejected' ? 'block' : 'check_circle'}</span>
                        <div>
                            <strong>Status:</strong> <span style="color:${leave.status === 'Rejected' ? '#e53935' : leave.status === 'Certified' ? '#00a651' : '#222'}">${leave.status === 'Rejected' ? 'REJECTED' : (leave.status === 'Certified' ? 'HR CERTIFIED' : leave.status)}</span>
                        </div>
                    </div>
                    ${adminSignatoryInfo ? `<div class="preview-item">
                        <span class="material-icons">admin_panel_settings</span>
                        <div>${adminSignatoryInfo.replace('<div>', '').replace('</div>', '')}</div>
                    </div>` : ''}
                    <div class="preview-item">
                        <span class="material-icons">category</span>
                        <div>
                            <strong>Type of Leave:</strong> ${(Array.isArray(leave.leave_type) ? leave.leave_type.join(', ') : (leave.leave_type ? JSON.parse(leave.leave_type).join(', ') : ''))}
                        </div>
                    </div>
                    ${leave.leave_type_other ? `<div class="preview-item">
                        <span class="material-icons">more_horiz</span>
                        <div><strong>Other Type:</strong> ${leave.leave_type_other}</div>
                    </div>` : ''}
                    ${leave.within_ph ? `<div class="preview-item">
                        <span class="material-icons">location_on</span>
                        <div><strong>Within PH:</strong> ${leave.within_ph}</div>
                    </div>` : ''}
                    ${leave.abroad ? `<div class="preview-item">
                        <span class="material-icons">flight</span>
                        <div><strong>Abroad:</strong> ${leave.abroad}</div>
                    </div>` : ''}
                    ${leave.in_hospital ? `<div class="preview-item">
                        <span class="material-icons">local_hospital</span>
                        <div><strong>In Hospital:</strong> ${leave.in_hospital}</div>
                    </div>` : ''}
                    ${leave.out_patient ? `<div class="preview-item">
                        <span class="material-icons">medical_services</span>
                        <div><strong>Out Patient:</strong> ${leave.out_patient}</div>
                    </div>` : ''}
                    ${leave.special_leave ? `<div class="preview-item">
                        <span class="material-icons">star</span>
                        <div><strong>Special Leave:</strong> ${leave.special_leave}</div>
                    </div>` : ''}
                    
                    <!-- Study Leave Options -->
                    ${leave.study_leave ? `<div class="preview-item">
                        <span class="material-icons">school</span>
                        <div><strong>Study Leave:</strong> ${leave.study_leave}</div>
                    </div>` : ''}
                    ${leave.completion_masters === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">graduation_cap</span>
                        <div><strong>Completion of Master's Degree:</strong> Yes</div>
                    </div>` : ''}
                    ${leave.bar_exam === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">gavel</span>
                        <div><strong>BAR/Board Examination Review:</strong> Yes</div>
                    </div>` : ''}
                    
                    <!-- Other Purpose Options -->
                    ${leave.other_purpose ? `<div class="preview-item">
                        <span class="material-icons">help</span>
                        <div><strong>Other Purpose:</strong> ${leave.other_purpose}</div>
                    </div>` : ''}
                    ${leave.monetization === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">attach_money</span>
                        <div><strong>Monetization of Leave Credits:</strong> Yes</div>
                    </div>` : ''}
                    ${leave.terminal_leave === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">exit_to_app</span>
                        <div><strong>Terminal Leave:</strong> Yes</div>
                    </div>` : ''}
                    
                    ${leave.num_days ? `<div class="preview-item">
                        <span class="material-icons">calendar_today</span>
                        <div><strong>Number of Days:</strong> ${leave.num_days}</div>
                    </div>` : ''}
                    ${leave.inclusive_dates ? `<div class="preview-item">
                        <span class="material-icons">date_range</span>
                        <div><strong>Inclusive Dates:</strong> ${leave.inclusive_dates}</div>
                    </div>` : ''}
                    ${leave.commutation ? `<div class="preview-item">
                        <span class="material-icons">swap_horiz</span>
                        <div><strong>Commutation:</strong> ${leave.commutation}</div>
                    </div>` : ''}
                </div>
            `;
            // Show rejection comment if rejected
            if (leave.status === 'Rejected' && leave.certification_data) {
                let cert = {};
                try {
                    cert = typeof leave.certification_data === 'string' ? JSON.parse(leave.certification_data) : leave.certification_data;
                } catch (e) {}
                html += `<div style="margin:24px 0 0 0; padding:18px; background:#fff5f5; border:1.5px solid #e53935; border-radius:12px;">
                    <span class="material-icons" style="color:#e53935; vertical-align:middle;">block</span>
                    <span style="color:#e53935; font-weight:700; font-size:1.1em;">Rejected by HR</span><br>
                    <strong>Reason:</strong> <span style="color:#c53030;">${cert.rejection_comment || 'No comment provided.'}</span><br>
                    <span style="font-size:0.95em; color:#888;">${cert.rejected_by ? 'By: ' + cert.rejected_by : ''} ${cert.rejected_at ? 'on ' + new Date(cert.rejected_at).toLocaleString() : ''}</span>
                </div>`;
            }

            // If certified or we're in edit mode, show certification data
            if ((leave.status === 'Certified' && leave.certification_data) || (editingLeaveId && document.getElementById('certifyForm').style.display !== 'none')) {
                let cert = {};
                try {
                    cert = typeof leave.certification_data === 'string'
                        ? JSON.parse(leave.certification_data)
                        : leave.certification_data;
                    if (!cert || typeof cert !== 'object') cert = {};
                } catch (e) { cert = {}; }
                // If we're in edit mode, get values from the form for signatory fields if they exist
                if (editingLeaveId && document.getElementById('certifyForm').style.display !== 'none') {
                    // Ensure cert is always an object
                    if (!cert || typeof cert !== 'object') cert = {};
                    const hrSignatory = document.getElementById('hr_signatory');
                    const adminSignatory = document.getElementById('admin_signatory');
                    const directorSignatory = document.getElementById('director_signatory');
                    if (hrSignatory) cert.hr_signatory = hrSignatory.value;
                    if (adminSignatory) cert.admin_signatory = adminSignatory.value;
                    if (directorSignatory) cert.director_signatory = directorSignatory.value;
                    // Get other form values
                    cert.recommendation = document.getElementById('recommendation_approval')?.checked ? 'approval' : 
                                         (document.getElementById('recommendation_disapproval')?.checked ? 'disapproval' : '');
                    cert.disapproval_reason = document.getElementById('disapproval_reason')?.value || '';
                    cert.other_remarks = document.getElementById('other_remarks')?.value || '';
                    cert.other_remarks2 = document.getElementById('other_remarks2')?.value || '';
                    cert.other_remarks3 = document.getElementById('other_remarks3')?.value || '';
                }

                // Process signatory data (split name and position)
                let hrName = 'JOY ROSE C. BAWAYAN';
                let hrPosition = 'Administrative Officer V (HRMO III)';
                if (cert.hr_signatory) {
                    const hrParts = cert.hr_signatory.split('|');
                    if (hrParts.length > 1) {
                        hrName = hrParts[0];
                        hrPosition = hrParts[1];
                    } else {
                        hrName = cert.hr_signatory;
                    }
                }
                
                let adminName = 'AIDA Y. PAGTAN';
                let adminPosition = 'Chief, Administrative and Finance Division';
                
                // First try to get from leave.admin_signatory
                if (leave.admin_signatory) {
                    const adminParts = leave.admin_signatory.split('|');
                    if (adminParts.length > 1) {
                        adminName = adminParts[0];
                        adminPosition = adminParts[1] || 'Division Chief';
                    } else {
                        adminName = leave.admin_signatory;
                        adminPosition = 'Division Chief';
                    }
                }
                // If not found, try from certification data
                else if (cert.admin_signatory) {
                    const adminParts = cert.admin_signatory.split('|');
                    if (adminParts.length > 1) {
                        adminName = adminParts[0];
                        adminPosition = adminParts[1];
                    } else {
                        adminName = cert.admin_signatory;
                    }
                }
                
                let directorName = 'Atty. JENNILYN M. DAWAYAN, CESO IV';
                let directorPosition = 'Regional Executive Director';
                if (cert.director_signatory) {
                    const directorParts = cert.director_signatory.split('|');
                    if (directorParts.length > 1) {
                        directorName = directorParts[0];
                        directorPosition = directorParts[1];
                    } else {
                        directorName = cert.director_signatory;
                    }
                }

                html += `
                    <div class="certification-preview">
                        <div class="cert-section">
                            <h3><span class="material-icons">schedule</span> CERTIFICATION OF LEAVE CREDITS</h3>
                            <div class="cert-date">
                                <span class="material-icons">event</span>
                                <span><strong>As of:</strong> ${cert.as_of_date ? new Date(cert.as_of_date).toLocaleDateString() : '-'}</span>
                            </div>
                            <div class="cert-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Vacation Leave</th>
                                            <th>Sick Leave</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="label-cell">Total Earned</td>
                                            <td class="text-center">${cert.vl_earned ?? '-'}</td>
                                            <td class="text-center">${cert.sl_earned ?? '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="label-cell">Less this application</td>
                                            <td class="text-center">${cert.vl_less ?? '-'}</td>
                                            <td class="text-center">${cert.sl_less ?? '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="label-cell">Balance</td>
                                            <td class="text-center">${cert.vl_balance ?? '-'}</td>
                                            <td class="text-center">${cert.sl_balance ?? '-'}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="signature-preview">
                                <div class="signature-name">${hrName}</div>
                                <div class="signature-title">${hrPosition}</div>
                            </div>
                        </div>
                        
                        <div class="cert-section">
                            <h3><span class="material-icons">recommend</span> RECOMMENDATION</h3>
                            <div class="recommendation-preview">
                                <div class="checkbox-preview ${cert.recommendation === 'approval' ? 'checked' : ''}">
                                    <span class="material-icons">${cert.recommendation === 'approval' ? 'check_circle' : 'radio_button_unchecked'}</span>
                                    <span>For approval</span>
                                </div>
                                <div class="checkbox-preview ${cert.recommendation === 'disapproval' ? 'checked' : ''}">
                                    <span class="material-icons">${cert.recommendation === 'disapproval' ? 'check_circle' : 'radio_button_unchecked'}</span>
                                    <span>For disapproval due to: ${cert.disapproval_reason || ''}</span>
                                </div>
                            </div>
                            
                            ${cert.other_remarks ? `<div class="remark-preview">${cert.other_remarks}</div>` : ''}
                            ${cert.other_remarks2 ? `<div class="remark-preview">${cert.other_remarks2}</div>` : ''}
                            ${cert.other_remarks3 ? `<div class="remark-preview">${cert.other_remarks3}</div>` : ''}
                            
                            <div class="signature-preview">
                                <div class="signature-name">${adminName}</div>
                                <div class="signature-title">${adminPosition}</div>
                            </div>
                        </div>
                        
                        <div class="cert-section">
                            <h3><span class="material-icons">check_circle</span> APPROVAL DETAILS</h3>
                            <div class="approval-preview">
                                <div class="approval-item">
                                    <span class="material-icons">calendar_today</span>
                                    <span><strong>Days with pay:</strong> ${cert.days_with_pay || '___'}</span>
                                </div>
                                <div class="approval-item">
                                    <span class="material-icons">event_busy</span>
                                    <span><strong>Days without pay:</strong> ${cert.days_without_pay || '___'}</span>
                                </div>
                                <div class="approval-item">
                                    <span class="material-icons">more_horiz</span>
                                    <span><strong>Others:</strong> ${cert.others_specify || '___'}</span>
                                </div>
                            </div>
                            
                            ${cert.disapproval_reason1 ? `<div class="disapproval-preview">
                                <span class="material-icons">cancel</span>
                                <span><strong>Disapproved due to:</strong> ${cert.disapproval_reason1}</span>
                            </div>` : ''}
                            ${cert.disapproval_reason2 ? `<div class="disapproval-preview">${cert.disapproval_reason2}</div>` : ''}
                            
                            <div class="signature-preview director">
                                <div class="signature-name">${directorName}</div>
                                <div class="signature-title">${directorPosition}</div>
                            </div>
                        </div>
                    </div>
                `;
            }

            document.getElementById('previewContent').innerHTML = html;
        }

        function renderPreviewModal(id) {
            // Reset any editing state
            editingLeaveId = null;
            currentPreviewData = null;
            
            // Reset the form if it exists
            const certifyForm = document.getElementById('certifyForm');
            if (certifyForm) {
                certifyForm.reset();
                certifyForm.style.display = 'none';
            }
            
            // Find the leave request
            const leave = leaveRequests.find(l => l.id === id);
            if (!leave) return;
            
            // Fill the preview content
            fillPreviewContent(leave);
            
            // Show the close-only button and hide the edit form
            const closeOnly = document.getElementById('closeOnly');
            if (closeOnly) {
                closeOnly.style.display = 'flex';
            }
            
            const previewModal = document.getElementById('previewModal');
            if (previewModal) {
                previewModal.style.display = 'flex';
                
                // Add body overflow control for better mobile experience
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.style.display = 'none';
            
            // Reset editing state to allow future edits
            editingLeaveId = null;
            currentPreviewData = null;
            
            // Restore body scrolling
            document.body.style.overflow = '';
        }

        // Handle certification form submission
        document.getElementById('certifyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            let hasEmpty = false;
            ['vl_earned','sl_earned','vl_less','sl_less','vl_balance','sl_balance'].forEach(name => {
                if (!formData.get(name)) hasEmpty = true;
            });

            if (hasEmpty) {
                const proceed = confirm('Some fields are empty. Do you want to proceed and save anyway?');
                if (!proceed) return;
            }

            const data = {};
            formData.forEach((value, key) => data[key] = value);
            data.leave_id = editingLeaveId;

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            try {
                const response = await fetch('/hr/certify-leave', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                if (response.ok) {
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success';
                    successMessage.style.position = 'fixed';
                    successMessage.style.top = '20px';
                    successMessage.style.right = '20px';
                    successMessage.style.padding = '15px 20px';
                    successMessage.style.borderRadius = '8px';
                    successMessage.style.backgroundColor = '#d4edda';
                    successMessage.style.color = '#155724';
                    successMessage.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                    successMessage.style.zIndex = '9999';
                    successMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">check_circle</span> Leave request certified successfully!';
                    document.body.appendChild(successMessage);
                    
                    // Remove the message after 3 seconds
                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                    
                    closePreviewModal();
                    
                    // Update the table and stats without full page reload
                    refreshDashboardData();
                } else {
                    const error = await response.json();
                    alert('Certification failed: ' + (error.message || JSON.stringify(error.errors)));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });

        // Function to refresh dashboard data
        function refreshDashboardData() {
            // First update the stats
            fetch('/hr/leave-stats', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update the count elements
                document.querySelector('.stat-card:nth-child(1) .count').textContent = data.pending;
                document.querySelector('.stat-card:nth-child(2) .count').textContent = data.certified;
                document.querySelector('.stat-card:nth-child(3) .count').textContent = data.total;
            })
            .catch(error => console.error('Error fetching stats:', error));
            
            // Then refresh the table content
            fetch(window.location.href + '?_=' + new Date().getTime(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Create a temporary DOM element to parse the HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update the table content
                const newTableBody = doc.getElementById('leaveTableBody');
                if (newTableBody) {
                    document.getElementById('leaveTableBody').innerHTML = newTableBody.innerHTML;
                }
                
                // Update the leaveRequests variable for the modal
                const scriptContent = Array.from(doc.scripts).find(script => script.textContent.includes('leaveRequests = '));
                if (scriptContent) {
                    const match = scriptContent.textContent.match(/leaveRequests = (.*?);/);
                    if (match && match[1]) {
                        leaveRequests = JSON.parse(match[1]);
                    }
                }
                
                // Reapply any active filters
                const activeFilterBtn = document.querySelector('.filter-btn.active');
                if (activeFilterBtn) {
                    filterStatus({target: activeFilterBtn}, activeFilterBtn.getAttribute('data-status'));
                }
            })
            .catch(error => console.error('Error refreshing table data:', error));
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const filter = this.value.trim().toLowerCase();
            const rows = document.querySelectorAll('#leaveTableBody tr');
            rows.forEach(row => {
                if (!row.hasAttribute('data-id')) return; // Skip "no results" row
                
                const idCell = row.children[1]?.textContent.replace('#', '').toLowerCase() || '';
                const nameCell = row.children[2]?.textContent.toLowerCase() || '';
                if (idCell.includes(filter) || nameCell.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            const activeBtn = document.querySelector('.filter-btn.active');
            filterStatus({target: activeBtn}, activeBtn.getAttribute('data-status'));
        }

        function filterStatus(e, status) {
            // Set active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.getAttribute('data-status') === status) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Get search filter
            const searchFilter = document.getElementById('searchInput').value.trim().toLowerCase();

            // Filter rows
            const rows = document.querySelectorAll('#leaveTableBody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                if (!row.hasAttribute('data-id')) return; // Skip "no results" row
                
                const rowStatus = row.getAttribute('data-status') || '';
                const idCell = row.children[1]?.textContent.replace('#', '').toLowerCase() || '';
                const nameCell = row.children[2]?.textContent.toLowerCase() || '';
                const matchesStatus = (status === 'all') || (rowStatus === status);
                const matchesSearch = idCell.includes(searchFilter) || nameCell.includes(searchFilter);

                if (matchesStatus && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show "no results" message if needed
            let noResultsRow = document.querySelector('#noResultsRow');
            if (visibleCount === 0) {
                if (!noResultsRow) {
                    noResultsRow = document.createElement('tr');
                    noResultsRow.id = 'noResultsRow';
                    noResultsRow.innerHTML = `
                        <td colspan="5" style="text-align:center; padding:30px;">
                            <div style="color:#888; font-size:1.1em;">No matching leave requests found</div>
                            <button class="filter-btn" onclick="clearAllFilters()" style="margin-top:10px;">Clear All Filters</button>
                        </td>
                    `;
                    document.getElementById('leaveTableBody').appendChild(noResultsRow);
                }
            } else if (noResultsRow) {
                noResultsRow.remove();
            }
        }

        // Date filter functions
        function clearDateFilter() {
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            document.getElementById('dateFilterForm').submit();
        }
        
        function clearAllFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            
            const allButton = document.querySelector('.filter-btn[data-status="all"]');
            if (allButton) {
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                allButton.classList.add('active');
                filterStatus({target: allButton}, 'all');
            }
            
            document.getElementById('dateFilterForm').submit();
        }
        
        // Table sorting
        function sortTable(columnIndex) {
            const table = document.querySelector('#leaveTableBody');
            const rows = Array.from(table.querySelectorAll('tr[data-id]'));
            
            // Determine sort direction
            if (currentSort.column === columnIndex) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.column = columnIndex;
                currentSort.direction = 'asc';
            }
            
            // Sort the rows
            rows.sort((a, b) => {
                let valueA, valueB;
                
                if (columnIndex === 0) { // Date column
                    valueA = new Date(a.getAttribute('data-date'));
                    valueB = new Date(b.getAttribute('data-date'));
                } else {
                    valueA = a.children[columnIndex].textContent.trim().toLowerCase();
                    valueB = b.children[columnIndex].textContent.trim().toLowerCase();
                    
                    // If column 1 (ID), strip the # and convert to number
                    if (columnIndex === 1) {
                        valueA = parseInt(valueA.replace('#', ''));
                        valueB = parseInt(valueB.replace('#', ''));
                    }
                }
                
                if (valueA < valueB) return currentSort.direction === 'asc' ? -1 : 1;
                if (valueA > valueB) return currentSort.direction === 'asc' ? 1 : -1;
                return 0;
            });
            
            // Reorder the rows in the table
            rows.forEach(row => table.appendChild(row));
            
            // Update header indicators
            const headers = document.querySelectorAll('th');
            headers.forEach((header, index) => {
                const icon = header.querySelector('.material-icons');
                if (icon) {
                    if (index === columnIndex) {
                        icon.textContent = currentSort.direction === 'asc' ? 'arrow_downward' : 'arrow_upward';
                    } else {
                        icon.textContent = 'unfold_more';
                    }
                }
            });
        }

        function discardEdit() {
            // Reset editing state completely
            editingLeaveId = null;
            currentPreviewData = null;
            
            // Hide the modal
            const modal = document.getElementById('previewModal');
            modal.style.display = 'none';
            
            // Restore body scrolling
            document.body.style.overflow = '';
            
            // Reset the form
            const form = document.getElementById('certifyForm');
            if (form) {
                form.reset();
                form.style.display = 'none';
            }
            
            // Show the close-only button
            const closeOnly = document.getElementById('closeOnly');
            if (closeOnly) {
                closeOnly.style.display = 'flex';
            }
        }

        function deleteTableRow(btn, rowId) {
            if (confirm('Are you sure you want to hide this request? This action will only hide it from your view.')) {
                // Find the row and remove it from the DOM
                const row = btn.closest('tr');
                if (row) row.remove();
                // Store the deleted row ID in localStorage
                let deleted = JSON.parse(localStorage.getItem('deletedHRRows') || '[]');
                if (!deleted.includes(rowId)) {
                    deleted.push(rowId);
                    localStorage.setItem('deletedHRRows', JSON.stringify(deleted));
                }
            }
        }

        // On page load, hide rows that are in localStorage
        window.addEventListener('DOMContentLoaded', function() {
            let deleted = JSON.parse(localStorage.getItem('deletedHRRows') || '[]');
            deleted.forEach(function(rowId) {
                const row = document.querySelector('tr[data-id="' + rowId + '"]');
                if (row) row.style.display = 'none';
            });
        });

        // Add reject button logic
        const rejectBtn = document.getElementById('rejectBtn');
        const rejectModal = document.getElementById('rejectModal');
        function closeRejectModal() {
            rejectModal.style.display = 'none';
        }
        if (rejectBtn) {
            rejectBtn.onclick = function() {
                // Always set editingLeaveId to the current leave being previewed if not set
                if (!editingLeaveId && currentPreviewData && currentPreviewData.id) {
                    editingLeaveId = currentPreviewData.id;
                }
                document.getElementById('rejectionComment').value = '';
                // Hide the preview modal
                const previewModal = document.getElementById('previewModal');
                if (previewModal) previewModal.style.display = 'none';
                // Show the reject modal
                rejectModal.style.display = 'flex';
            };
        }
        async function confirmReject() {
            const comment = document.getElementById('rejectionComment').value.trim();
            if (!comment) {
                alert('Please enter a reason for rejection.');
                return;
            }
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Send all required fields for validation
            const data = {
                leave_id: editingLeaveId,
                action: 'reject',
                rejection_comment: comment,
                as_of_date: '2000-01-01', // dummy value to satisfy required_if
                vl_earned: '',
                sl_earned: '',
                vl_less: '',
                sl_less: '',
                vl_balance: '',
                sl_balance: '',
                recommendation: '',
                disapproval_reason: '',
                other_remarks: '',
                other_remarks2: '',
                other_remarks3: '',
                days_with_pay: '',
                days_without_pay: '',
                others_specify: '',
                disapproval_reason1: '',
                disapproval_reason2: '',
                hr_signatory: '',
                admin_signatory: '',
                director_signatory: ''
            };
            try {
                const response = await fetch('/hr/certify-leave', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                if (response.ok) {
                    closeRejectModal();
                    closePreviewModal();
                    refreshDashboardData();
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success';
                    successMessage.style.position = 'fixed';
                    successMessage.style.top = '20px';
                    successMessage.style.right = '20px';
                    successMessage.style.padding = '15px 20px';
                    successMessage.style.borderRadius = '8px';
                    successMessage.style.backgroundColor = '#d4edda';
                    successMessage.style.color = '#155724';
                    successMessage.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                    successMessage.style.zIndex = '9999';
                    successMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">check_circle</span> Leave request rejected.';
                    document.body.appendChild(successMessage);
                    setTimeout(() => { successMessage.remove(); }, 3000);
                } else {
                    const error = await response.json();
                    alert('Rejection failed: ' + (error.message || JSON.stringify(error.errors)));
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
            }
        }

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
        // Logout button logic
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit();
            });
        }
    </script>
</body>
</html>


