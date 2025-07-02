<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyEmployeeExport;

class EmployeeListController extends Controller
{
    public function index()
    {
        // Check if user is authorized (ID 2)
        if (Auth::id() != 2) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin dashboard.');
        }
        return view('admin.list-of-employees.index');
    }

    public function exportMonth(Request $request)
    {
        $month = $request->query('month');
        $year = date('Y');
        // Pass month and year to the export class
        $filename = 'employees_' . strtolower($month) . '_' . $year . '.xlsx';
        return Excel::download(new MonthlyEmployeeExport($month, $year), $filename);
    }
}
