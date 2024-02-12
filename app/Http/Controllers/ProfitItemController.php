<?php

namespace App\Http\Controllers;

use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\Profit;
use App\Models\ProfitItem;
use App\Models\SpecialDps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfitItemController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $query = ProfitItem::query();
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

    return view('profits.index', compact('profits', 'profitType'));
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
    $profit = Profit::where('type', $data['type'])->where('account_no', $data['account_no'])->first();
    if (!$profit) {
      $profit = Profit::create($data);
    }
    $data['profit_id'] = $profit->id;
    $data['manager_id'] = Auth::guard('manager')->user()->id;
    $profitItem = ProfitItem::create($data);
    $profit->total_profit += $profitItem->profit;
    $profit->remain_profit += $profitItem->profit;
    $profit->save();
    return redirect()->back()->with('success', 'মুনাফা যোগ করা হয়েছে!');
  }

  /**
   * Display the specified resource.
   */
  public function show(ProfitItem $profitItem)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(ProfitItem $profitItem)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    // Validate the form data (customize based on your form fields)
    $request->validate([
      'editProfit' => 'required',
    ]);

    $profitItem = ProfitItem::find($request->editId);

    $profit = Profit::find($request->editProfitId);
    $profit->total_profit -= $profitItem->profit;
    $profit->remain_profit -= $profitItem->profit;
    $profit->save();

    $profitItem->profit = $request->editProfit;
    $profitItem->date = $request->editDate;
    $profitItem->save();

    $profit->total_profit += $profitItem->profit;
    $profit->remain_profit += $profitItem->profit;
    $profit->save();

    // You can return a response if needed
    return response()->json(['message' => 'Profit updated successfully']);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, $id)
  {
    $profitItem = ProfitItem::find($id);

    $profit = Profit::find($profitItem->profit_id);
    $profit->total_profit -= $profitItem->profit;
    $profit->remain_profit -= $profitItem->profit;
    $profit->save();

    $profitItem->delete();

    return response()->json('মুনাফা ডিলেট সফল হয়েছে!');
  }

  /**
   * @throws \Exception
   */
  public function accountList($type)
  {
    $accounts = match ($type) {
      'daily' => DailySavings::where('status', 'active')->pluck('account_no'),
      'dps' => Dps::where('status', 'active')->pluck('account_no'),
      'special' => SpecialDps::where('status', 'active')->pluck('account_no'),
      default => throw new \Exception('Unexpected value'),
    };

    return response()->json($accounts);
  }
}
