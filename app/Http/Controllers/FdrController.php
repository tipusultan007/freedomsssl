<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\FdrDepositAccount;
use App\Http\Controllers\Accounts\FdrWithdrawAccount;
use App\Http\Controllers\Accounts\PaidProfitAccount;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\Fdr;
use App\Models\FdrDeposit;
use App\Models\FdrProfit;
use App\Models\FdrWithdraw;
use App\Models\Nominees;
use App\Models\ProfitCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\FdrPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\FdrStoreRequest;
use App\Http\Requests\FdrUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FdrController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    return view('app.fdrs.index');
  }

  public function allFdrs(Request $request)
  {

    $columns = array(
      1 => 'name',
      2 => 'account',
      3 => 'amount',
    );

    $totalData = Fdr::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    //$order = $columns[$request->input('order.0.column')];
    // $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $posts = Fdr::with('user')
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = Fdr::with('user')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();

      $totalFiltered = Fdr::with('user')->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('fdrs.show', $post->id);
        $edit = route('fdrs.edit', $post->id);

        $date = new Carbon($post->date);
        $nestedData['id'] = $post->id;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['phone'] = $post->user->phone1 ?? '';
        $nestedData['account_no'] = $post->account_no;
        $nestedData['name'] = $post->user->name;
        $nestedData['package'] = $post->package;
        $nestedData['amount'] = $post->amount;
        $nestedData['date'] = $date->format('d/m/Y');
        $nestedData['note'] = $post->note;
        $nestedData['balance'] = $post->balance;
        $nestedData['profit'] = $post->profit;
        $nestedData['image'] = $post->user->image;

        $data[] = $nestedData;

      }
    }

    $json_data = array(
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );

    echo json_encode($json_data);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    //$this->authorize('create', Fdr::class);

    $users = User::all();
    $fdrPackages = FdrPackage::all();
    $accounts = Fdr::orderBy('account_no', 'desc')->first();
    $new_account = $accounts ? $this->manipulateString($accounts->account_no) : 'FDR0001';
    return view('app.fdrs.create', compact('users', 'fdrPackages', 'new_account'));
  }


  public function manipulateString($inputString)
  {
    // Extract the numeric part from the input string
    preg_match('/\d+/', $inputString, $matches);

    if (!empty($matches)) {
      // Increment the numeric part by 1
      $numericPart = intval($matches[0]) + 1;

      // Create the new string with incremented numeric part
      $newString = 'FDR' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);

      return $newString;
    }

    return $inputString; // Return the input string if no numeric part found
  }

  /**
   * @param \App\Http\Requests\FdrStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //$this->authorize('create', Fdr::class);
    $request->validate(Fdr::$rules);

    $data = $request->all();
    $fdr = Fdr::create($data);
    $data['fdr_id'] = $fdr->id;
    $data['balance'] = $fdr->amount;
    $data['trx_id'] = Str::uuid();
    $fdr->balance += $request->amount;
    $fdr->save();

    $data['user_id'] = $request->nominee_user_id;
    $data['user_id1'] = $request->nominee_user_id1;

    $deposit = FdrDeposit::create($data);

    if ($request->hasFile('image')) {
      $imageName = "nominee_" . $fdr->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
      $request->file('image')->storeAs('public/nominee_images', $imageName);
      $data['image'] = $imageName;
    }

    if ($request->hasFile('image1')) {
      $imageName1 = "nominee_" . $fdr->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
      $request->file('image1')->storeAs('public/nominee_images', $imageName1);
      $data['image1'] = $imageName1;
    }

    $nominee = Nominees::create($data);

    $cashin = CashIn::create([
      'user_id' => $fdr->user_id,
      'cashin_category_id' => 5,
      'account_no' => $fdr->account_no,
      'frd_deposit_id' => $deposit->id,
      'amount' => $deposit->amount,
      'date' => $deposit->date,
      'created_by' => $deposit->created_by
    ]);

    return redirect()
      ->route('fdrs.index')
      ->with('success', 'FDR সঞ্চয় হিসাব তৈরি হয়েছে! ');
  }

  public function trxId($date)
  {
    $record = Transaction::latest('id')->first();
    $dateTime = new Carbon($date);
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $uid = substr(str_shuffle($permitted_chars), 0, 6);
    if ($record) {
      $expNum = explode('-', $record->trx_id);
      if ($dateTime->format('jny') == $expNum[1]) {
        $s = str_pad($expNum[3] + 1, 4, "0", STR_PAD_LEFT);
        $nextTxNumber = 'TRX-' . $expNum[1] . '-' . $uid . '-' . $s;
      } else {
        //increase 1 with last invoice number
        $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';
      }
    } else {

      $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';

    }

    return $nextTxNumber;
  }

  public function accountTransaction(FdrDeposit $deposit)
  {
    $dps_transaction = Transaction::create([
      'account_id' => 1,
      'description' => 'FDR Deposit',
      'trx_id' => $deposit->trx_id,
      'date' => $deposit->date,
      'amount' => $deposit->amount,
      'user_id' => $deposit->created_by,
      'account_no' => $deposit->account_no,
      'name' => $deposit->user->name,
    ]);
    $depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
    $depositAccount->balance += $dps_transaction->amount;
    $depositAccount->save();

    $cashAccount = Account::find(4); //ASSET (CASH+)
    $cashAccount->balance += $dps_transaction->amount;
    $cashAccount->save();
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Fdr $fdr
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, Fdr $fdr)
  {
    //$this->authorize('view', $fdr);
    $fdrPackages = FdrPackage::all();
    return view('app.fdrs.show', compact('fdr', 'fdrPackages'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Fdr $fdr
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, Fdr $fdr)
  {
    //$this->authorize('update', $fdr);

    $users = User::pluck('name', 'id');
    $fdrPackages = FdrPackage::pluck('name', 'id');

    return view('app.fdrs.edit', compact('fdr', 'users', 'fdrPackages'));
  }

  /**
   * @param \App\Http\Requests\FdrUpdateRequest $request
   * @param \App\Models\Fdr $fdr
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Fdr $fdr)
  {
    //$this->authorize('update', $fdr);
    $data = $request->all();

    $fdr->update($data);
    //$nominee = Nominees::firstOrCreate(['account_no'=> $dailySavings->account_no]);
    $data['user_id'] = $request->filled('nominee_user_id') ? $request->nominee_user_id : null;
    $data['user_id1'] = $request->filled('nominee_user_id1') ? $request->nominee_user_id1 : null;
    //$nominee->update($data);

    // Handle 'image' update
    if ($request->hasFile('image')) {
      // Delete the previous file
      Storage::disk('public')->delete('nominee_images/' . $fdr->nominee->image);

      $imageName = "nominee_" . $fdr->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
      $request->file('image')->storeAs('public/nominee_images', $imageName);
      $data['image'] = $imageName;
    } else {
      unset($data['image']);
    }

    // Handle 'image1' update
    if ($request->hasFile('image1')) {
      // Delete the previous file
      Storage::disk('public')->delete('nominee_images/' . $fdr->nominee->image1);

      $imageName1 = "nominee_" . $fdr->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
      $request->file('image1')->storeAs('public/nominee_images', $imageName1);
      $data['image1'] = $imageName1;
    } else {
      unset($data['image1']);
    }

    // Update or create nominee data
    $nominee = Nominees::updateOrCreate(['account_no' => $fdr->account_no], $data);


    return redirect()
      ->route('fdrs.edit', $fdr)
      ->withSuccess(__('crud.common.saved'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Fdr $fdr
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $fdr = Fdr::find($id);
    $deposits = FdrDeposit::where('fdr_id', $id)->get();
    $withdraws = FdrWithdraw::where('fdr_id', $id)->get();
    $profits = FdrProfit::where('fdr_id', $id)->get();
    foreach ($profits as $profit) {
      ProfitCollection::where('fdr_profit_id', $profit->id)->delete();
      $profit->delete();
    }
    foreach ($withdraws as $withdraw) {
      $withdraw->delete();
    }

    foreach ($deposits as $deposit) {
      $deposit->delete();
    }
    Nominees::where('account_no', $fdr->account_no)->delete();
    $fdr->delete();

    return "success";
  }

  public function isExist($account)
  {
    $fdr = Fdr::where('account_no', $account)->first();
    if ($fdr) {
      return "yes";
    } else {
      return "no";
    }
  }

}
