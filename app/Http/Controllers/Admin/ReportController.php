<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MonthlyReportExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportMonthly(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);


        $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020|max:2100',
        ]);


        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        $filename = "Laporan_Bulanan_{$monthName}_{$year}.xlsx";

        return Excel::download(new MonthlyReportExport($month, $year), $filename);
    }
}
