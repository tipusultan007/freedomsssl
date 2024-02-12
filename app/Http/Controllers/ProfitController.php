<?php

namespace App\Http\Controllers;

use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\Profit;
use App\Models\ProfitItem;
use App\Models\SpecialDps;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    /*$query = ProfitItem::query();
    $profitType = '';

    if ($request->has('profit_type')) {
      $profitType = $request->input('profit_type');

      if ($profitType == 'dps') {
        $query->where('type', 'dps');
      } elseif ($profitType == 'special') {
        $query->where('type', 'special');
      } else {
        $query->where('type', 'daily');
      }
    }

    $profits = $query->paginate(30);

    return view('profits.index', compact('profits', 'profitType'));*/
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
    /*$data = $request->all();
    $profit = Profit::where('type',$data['type'])->where('account_no',$data['account_no'])->first();
    if ($profit){
      $data['profit_id'] = $profit->id;
      $profitItem = ProfitItem::create($data);
      $profit->total_profit += $profitItem->profit;
      $profit->remain_profit += $profitItem->profit;
      $profit->save();
    }else{
      $profit = Profit::create($data);
      $data['profit_id'] = $profit->id;
      $profitItem = ProfitItem::create($data);
      $profit->total_profit += $profitItem->profit;
      $profit->remain_profit += $profitItem->profit;
      $profit->save();
    }
    return redirect()->back()->with('success','মুনাফা যোগ করা হয়েছে!');*/
  }

  /**
   * Display the specified resource.
   */
  public function show(Profit $profit)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Profit $profit)
  {

  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Profit $profit)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Profit $profit)
  {
    //
  }

}
