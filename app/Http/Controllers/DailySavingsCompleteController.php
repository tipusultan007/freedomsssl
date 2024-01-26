<?php

namespace App\Http\Controllers;

use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\DailySavingsComplete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailySavingsCompleteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['manager_id'] = Auth::id();
        $savingsComplete = DailySavingsComplete::create($data);
        $dailySavings = DailySavings::find($data['daily_savings_id']);
        $dailySavings->withdraw += $savingsComplete->withdraw;
        $dailySavings->remain_profit -= $savingsComplete->profit;
        $dailySavings->total -= $savingsComplete->withdraw + $savingsComplete->profit;
        $dailySavings->save();
        $savingsComplete->remain = $dailySavings->total;
        $savingsComplete->save();
        if ($savingsComplete->loan_payment>0)
        {
          $loan = DailyLoan::find($savingsComplete->daily_loan_id);
          $loan->balance -= $savingsComplete->loan_payment;
          $loan->grace += $savingsComplete->grace;
          $loan->status= 'complete';
          $loan->save();
        }
        if ($dailySavings->total<= 0)
        {
          $dailySavings->status = 'complete';
          $dailySavings->save();
        }else{
          $dailySavings->status = 'active';
          $dailySavings->save();
        }

        return redirect()->back()->with('success','সঞ্চয় হিসাব প্রত্যাহার সফল হয়েছে!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailySavingsComplete $dailySavingsComplete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailySavingsComplete $dailySavingsComplete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailySavingsComplete $dailySavingsComplete)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailySavingsComplete $dailySavingsComplete)
    {
        //
    }
}
