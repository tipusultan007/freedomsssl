<?php

namespace App\Http\Controllers;

use App\Models\CashIn;
use App\Models\Cashout;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function cashbook()
    {
        return view('app.reports.cashbook');
    }
    public function dataCashbook(Request $request)
    {
        if (!empty($request->from) || !empty($request->to)) {
            $from = $request->from;
            $to = $request->to;
        }else{
            $from = date('y-m-d');
            $to = date('y-m-d');
        }
        $cashins = CashIn::with('cashinCategory')->whereBetween('date',[$from,$to]);
        $cashouts = Cashout::with('cashoutCategory')->whereBetween('date',[$from,$to]);

        $totalCashin = $cashins->sum('amount');
        $totalCashout = $cashouts->sum('amount');

        $groupedCashin = $cashins->whereNotNull('cashin_category_id')->get()->groupBy('cashin_category_id');
        $groupedCashout = $cashouts->whereNotNull('cashout_category_id')->get()->groupBy('cashout_category_id');

        $cashinSummary = [];
        foreach ($groupedCashin as $row) {
            foreach ($row as $line) {
                if (!isset($cashinSummary[$line->cashinCategory->name])) {
                    $cashinSummary[$line->cashinCategory->name] = [
                        'name'   => $line->cashinCategory->name,
                        'id'   => $line->cashinCategory->id,
                        'amount' => 0,
                    ];
                }
                $cashinSummary[$line->cashinCategory->name]['amount'] += $line->amount;
            }
        }

        $cashoutSummary = [];
        foreach ($groupedCashout as $row) {
            foreach ($row as $line) {
                if (!isset($cashoutSummary[$line->cashoutCategory->name])) {
                    $cashoutSummary[$line->cashoutCategory->name] = [
                        'name'   => $line->cashoutCategory->name,
                        'id'   => $line->cashoutCategory->id,
                        'amount' => 0,
                    ];
                }
                $cashoutSummary[$line->cashoutCategory->name]['amount'] += $line->amount;
            }
        }
        $data = array();
        $data['totalCashin'] = $totalCashin;
        $data['totalCashout'] = $totalCashout;
        $data['cashinSummary'] = $cashinSummary;
        $data['cashoutSummary'] = $cashoutSummary;
        return json_encode($data);
        //return view('app.reports.cashbook',compact('totalCashin','totalCashout','cashinSummary','cashoutSummary'));
    }
}
