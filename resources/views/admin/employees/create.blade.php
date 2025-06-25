@extends('layouts.app')

@section('content')
<div style="max-width:500px;margin:40px auto;padding:32px 24px;background:#fff;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
    <h2 style="text-align:center;margin-bottom:24px;font-size:1.4em;">Add New Employee</h2>
    <form method="POST" action="{{ route('admin.employees.store') }}">
        @csrf
        <div style="margin-bottom:14px;">
            <input type="text" name="name" placeholder="Full Name" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;">
        </div>
        <div style="margin-bottom:14px;">
            <input type="email" name="email" placeholder="Email (optional)" style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;">
        </div>
        <div style="margin-bottom:14px;">
            <input type="text" name="position" placeholder="Position" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;">
        </div>
        <div style="margin-bottom:14px;">
            <input type="text" name="office" placeholder="Office/Department" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;">
        </div>
        <div style="margin-bottom:18px;">
            <input type="password" name="password" placeholder="Password" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;">
        </div>
        <div style="text-align:right;">
            <button type="submit" style="background:#1ecb6b;color:#fff;border:none;border-radius:8px;padding:8px 22px;font-size:1em;font-weight:600;cursor:pointer;">Save</button>
        </div>
    </form>
</div>
@endsection
