<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave Requests</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f9f9e6;
            min-height: 100vh;
        }
        .main-content {
            max-width: 1100px;
            margin: 40px auto 0 auto;
            padding: 0 20px;
        }
        .leave-table-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            background: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Roboto', Arial, sans-serif;
        }
        thead tr {
            background: linear-gradient(90deg,#0cc25a 0%,#1ecb6b 100%);
            color: #fff;
            font-size: 1.08em;
        }
        th, td {
            padding: 16px 8px;
            text-align: left;
        }
        tbody tr {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        .icon-cell {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .icon-green {
            color: #1ecb6b;
            font-size: 1.2em;
            vertical-align: middle;
        }
        .save-btn {
            background: #e3f3fb;
            border: none;
            border-radius: 8px;
            padding: 6px 10px;
            display: inline-block;
            cursor: pointer;
        }
        .save-btn .material-icons {
            color: #4fc3f7;
            font-size: 1.5em;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 0 5px;
            }
            th, td {
                padding: 10px 4px;
                font-size: 0.98em;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2 style="margin: 0 0 24px 0; font-size: 1.5em; color: #226d1b; font-weight: 700; letter-spacing: 1px;">Manage Leave Requests</h2>
        <div class="leave-table-container">
            <table>
                <thead>
                    <tr>
                        <th>DATE RECEIVED</th>
                        <th>LN CODE</th>
                        <th>LEAVE NUMBER</th>
                        <th>PARTICULAR</th>
                        <th>TYPE OF LEAVE</th>
                        <th>CODE</th>
                        <th>NAME</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveRequests as $leave)
                    <tr>
                        <td class="icon-cell">
                            <button onclick="editDateReceived({{ $leave->id }})" style="background:none;border:none;cursor:pointer;padding:0;">
                                <span class="material-icons icon-green">event</span>
                            </button>
                            <span id="date-received-{{ $leave->id }}">{{ $leave->date_received ?? ($leave->created_at ? $leave->created_at->format('j-M-y') : '-') }}</span>
                        </td>
                        <td>{{ $leave->ln_code ?? '-' }}</td>
                        <td>{{ $leave->leave_number ?? '-' }}</td>
                        <td>{{ $leave->particular ?? '-' }}</td>
                        <td class="icon-cell">
                            <button onclick="editTypeOfLeave({{ $leave->id }})" style="background:none;border:none;cursor:pointer;padding:0;">
                                <span class="material-icons icon-green">edit</span>
                            </button>
                            <span id="type-of-leave-{{ $leave->id }}">{{ $leave->type_of_leave ?? '-' }}</span>
                        </td>
                        <td>{{ $leave->code ?? '-' }}</td>
                        <td>{{ $leave->name ?? ($leave->user->name ?? '-') }}</td>
                        <td style="text-align:center;">
                            <button class="save-btn" onclick="alert('Save action for Leave #{{ $leave->leave_number ?? '-' }}')">
                                <span class="material-icons">save</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;padding:24px;">No leave requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function editDateReceived(id) {
            const span = document.getElementById('date-received-' + id);
            const current = span.textContent;
            const input = document.createElement('input');
            input.type = 'text';
            input.value = current;
            input.style.width = '90px';
            input.onblur = function() {
                span.textContent = input.value;
            };
            span.textContent = '';
            span.appendChild(input);
            input.focus();
        }
        function editTypeOfLeave(id) {
            const span = document.getElementById('type-of-leave-' + id);
            const current = span.textContent;
            const input = document.createElement('input');
            input.type = 'text';
            input.value = current;
            input.style.width = '160px';
            input.onblur = function() {
                span.textContent = input.value;
            };
            span.textContent = '';
            span.appendChild(input);
            input.focus();
        }
    </script>
</body>
</html>
