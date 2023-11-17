<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function generateMonthlyReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $report = Transaction::selectRaw('
                MONTH(transactions.due_on) as month,
                YEAR(transactions.due_on) as year,
                SUM(CASE WHEN NOW() > transactions.due_on AND payments.amount >= transactions.amount THEN transactions.amount ELSE 0 END) as paid,
                SUM(CASE WHEN NOW() <= transactions.due_on AND payments.amount < transactions.amount THEN transactions.amount ELSE 0 END) as outstanding,
                SUM(CASE WHEN NOW() > transactions.due_on AND payments.amount < transactions.amount THEN transactions.amount ELSE 0 END) as overdue
            ')
            ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
//            ->whereBetween('transactions.due_on', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(transactions.due_on)'), DB::raw('MONTH(transactions.due_on)'))
            ->orderBy(DB::raw('YEAR(transactions.due_on)'), 'ASC')
            ->orderBy(DB::raw('MONTH(transactions.due_on)'), 'ASC')
            ->get();


        return response()->json($report);
    }
}
