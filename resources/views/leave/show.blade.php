@extends('leave.print')

@section('styles')
<style>
    body {
        background-color: #f5f5f5;
        padding: 20px 0;
    }
    
    .print-bg-container {
        margin: 20px auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    
    @media print {
        body {
            background-color: white;
            padding: 0;
        }
        
        .print-bg-container {
            margin: 0;
            box-shadow: none;
            border-radius: 0;
        }
    }
</style>
@endsection

@section('print_buttons')
    @if($leave->status === 'Certified')
    <div style="position:fixed; top:20px; right:30px; z-index:1000; display:flex; gap:10px;">
        <button id="downloadBtn" style="padding:10px 22px; font-size:16px; background:#2196F3; color:#fff; border:none; border-radius:5px; cursor:pointer;">
            Download PDF
        </button>
        <button id="printBtn" style="padding:10px 22px; font-size:16px; background:#4CAF50; color:#fff; border:none; border-radius:5px; cursor:pointer;">
            Print
        </button>
    </div>
    @endif
@endsection

@section('header_controls')
    <div style="position:fixed; top:20px; left:20px; z-index:1000;">
        <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; padding:8px 16px; background-color:#1ecb6b; color:#fff; border-radius:4px; text-decoration:none; font-weight:500;">
            <span style="margin-right:5px;">←</span>
            Back to Dashboard
        </a>
    </div>
@endsection

@section('rejection_notice')
    @if($leave->status === 'Rejected' && $leave->certification_data)
        @php
            $cert = is_string($leave->certification_data) ? json_decode($leave->certification_data, true) : ($leave->certification_data ?? []);
        @endphp
        <div style="position:fixed; top:80px; left:20px; right:20px; z-index:1000; padding:18px; background:#fff5f5; border:1.5px solid #e53935; border-radius:12px;">
            <span style="color:#e53935; font-weight:700; font-size:1.1em;">Rejected by HR</span><br>
            <strong>Reason:</strong> <span style="color:#c53030;">{{ $cert['rejection_comment'] ?? 'No comment provided.' }}</span><br>
            <span style="font-size:0.95em; color:#888;">{{ isset($cert['rejected_by']) ? 'By: ' . $cert['rejected_by'] : '' }} {{ isset($cert['rejected_at']) ? 'on ' . \Carbon\Carbon::parse($cert['rejected_at'])->format('F j, Y g:i A') : '' }}</span>
        </div>
    @endif
@endsection

@section('signatory_overlay')
    @if($leave->status === 'Pending')
    <!-- Hide signatory areas for pending requests -->
    <div style="position:absolute; bottom:177px; right:70px; width:200px; height:27px; background:#fff; z-index:10;"></div>
    @endif
@endsection 