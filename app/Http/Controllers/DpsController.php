<?php

namespace App\Http\Controllers;

use App\Models\DpsComplete;
use App\Models\DpsLoanCollection;
use App\Imports\DpsImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\ClosingAccount;
use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsCollection;
use App\Models\DpsInstallment;
use App\Models\DpsLoan;
use App\Models\DpsLoanInterest;
use App\Models\Due;
use App\Models\Fdr;
use App\Models\Guarantor;
use App\Models\LoanDocuments;
use App\Models\LoanPayment;
use App\Models\Nominees;
use App\Models\SpecialDps;
use App\Models\SpecialDpsLoan;
use App\Models\TakenLoan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DpsPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\DpsStoreRequest;
use App\Http\Requests\DpsUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DpsController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $breadcrumbs = [
      ['name' => 'List']
    ];

    return view('app.all_dps.index', compact('breadcrumbs'));
  }

  public function dpsData(Request $request)
  {
    $columns = array(
      0 => 'account_no',
    );

    $totalData = Dps::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');

    if (empty($request->input('search.value'))) {
      $posts = Dps::with('user', 'dpsPackage')->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = Dps::with('user', 'dpsPackage')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();

      $totalFiltered = Dps::with('user', 'dpsPackage')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('dps.show', $post->id);
        $edit = route('dps.edit', $post->id);

        $date = new Carbon($post->opening_date);
        $nestedData['id'] = $post->id;
        $nestedData['name'] = $post->user->name;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['date'] = $date->format('d/m/Y');
        $nestedData['balance'] = $post->balance;
        $nestedData['package'] = $post->dpsPackage->name;
        $nestedData['phone'] = $post->user->phone1;
        $nestedData['package_amount'] = $post->package_amount;
        $nestedData['image'] = $post->user->image;
        $nestedData['status'] = $post->status;

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

    $users = User::select('name', 'father_name', 'id')->get();
    $dpsPackages = DpsPackage::all();
    $accounts = Dps::orderBy('account_no', 'desc')->first();
    if ($accounts) {
      $new_account = $this->manipulateString($accounts->account_no);
    } else {
      $new_account = 'DPS0001';
    }
    return view(
      'app.all_dps.create',
      compact('users', 'dpsPackages', 'users', 'new_account')
    );
  }

  /**
   * @param \App\Http\Requests\DpsStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all();

    $validator = Validator::make($data, [
      'account_no' => 'required|unique:dps,account_no',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->with('error', 'হিসাব নং -' . $data['account_no'] . ' বিদ্যমান। ভিন্ন হিসাব নং প্রদান করুণ।');
    }

    $data['balance'] = 0;

    $data['created_by'] = Auth::id();
    $dps = Dps::create($data);
    //$data['user_id'] = $request->nominee_user_id;
    //Nominees::create($data);
    //echo 'success';
    // Upload and save nominee image
    if ($request->hasFile('image')) {
      $imageName = "nominee_" . $dps->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
      $request->file('image')->storeAs('public/nominee_images', $imageName);
      $data['image'] = $imageName;
    }

    if ($request->hasFile('image1')) {
      $imageName1 = "nominee_" . $dps->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
      $request->file('image1')->storeAs('public/nominee_images', $imageName1);
      $data['image1'] = $imageName1;
    }

    $nominee = Nominees::create($data);


    $accountNumber = $this->manipulateString($dps->account_no);
    return redirect()->back()->with('success', 'মাসিক সঞ্চয় হিসাব নং - ' . $dps->account_no . ' খোলা হয়েছে।');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Dps $dps
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $dps = Dps::with('loans')->find($id);

    $collections = DpsCollection::where('dps_id', $dps->id)->get();
    $breadcrumbs = [
      ['link' => "/dps", 'name' => "DPS"], ['link' => "javascript:void(0)", 'name' => "Details"], ['name' => $dps->account_no]
    ];

    return view('app.all_dps.show', compact('dps', 'collections', 'breadcrumbs'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Dps $dps
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, $id)
  {
    //$this->authorize('update', $dps);

    $dps = Dps::find($id);
    $users = User::select('name', 'father_name', 'id')->get();
    $dpsPackages = DpsPackage::all();

    return view(
      'app.all_dps.edit',
      compact('dps', 'users', 'dpsPackages', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\DpsUpdateRequest $request
   * @param \App\Models\Dps $dps
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //$this->authorize('update', $dps);

    $data = $request->except('image', 'image1');

    $dps = Dps::find($id);
    $dps->update($data);

    //$nominee = Nominees::firstOrCreate(['account_no'=> $dailySavings->account_no]);
    $data['user_id'] = $request->filled('nominee_user_id') ? $request->nominee_user_id : null;
    $data['user_id1'] = $request->filled('nominee_user_id1') ? $request->nominee_user_id1 : null;
    //$nominee->update($data);

    // Handle 'image' update
    if ($request->hasFile('image')) {
      // Delete the previous file
      Storage::disk('public')->delete('nominee_images/' . $dps->nominee->image);

      $imageName = "nominee_" . $dps->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
      $request->file('image')->storeAs('public/nominee_images', $imageName);
      $data['image'] = $imageName;
    } else {
      unset($data['image']);
    }

    // Handle 'image1' update
    if ($request->hasFile('image1')) {
      // Delete the previous file
      Storage::disk('public')->delete('nominee_images/' . $dps->nominee->image1);

      $imageName1 = "nominee_" . $dps->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
      $request->file('image1')->storeAs('public/nominee_images', $imageName1);
      $data['image1'] = $imageName1;
    } else {
      unset($data['image1']);
    }

    // Update or create nominee data
    $nominee = Nominees::updateOrCreate(['account_no' => $dps->account_no], $data);


    return redirect()
      ->route('dps.edit', $dps->id)
      ->with('success', 'মাসিক সঞ্চয় আপডেট সফল হয়েছে!');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Dps $dps
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dps = Dps::with('dpsInstallments')->find($id);
    $dpsInstallmentIds = $dps->dpsInstallments->pluck('id');
    Transaction::where('transactionable_type', DpsInstallment::class)
      ->whereIn('transactionable_id', $dpsInstallmentIds)
      ->delete();

    DpsCollection::where('dps_id',$dps->id)->delete();
    $completes = DpsComplete::where('dps_id',$dps->id)->get();
    foreach ($completes as $complete)
    {
      $complete->delete();
    }
    DpsInstallment::where('dps_id',$dps->id)->delete();
    $dpsLoan = DpsLoan::with('dpsInstallments','takenLoans')->where('account_no', $dps->account_no)->first();
    if ($dpsLoan)
    {
      $loanInstallmentIds = $dpsLoan->dpsInstallments->pluck('id');
      Transaction::where('transactionable_type', DpsInstallment::class)
        ->whereIn('transactionable_id', $loanInstallmentIds)
        ->delete();

      foreach ($dpsLoan->takenLoans as $loan)
      {
        DpsLoanInterest::where('taken_loan_id',$loan->id)->delete();
        LoanPayment::where('taken_loan_id',$loan->id)->delete();
        $loan->delete();
      }
      DpsLoanCollection::where('dps_loan_id',$dpsLoan->id)->delete();
      DpsInstallment::where('dps_loan_id',$dps->id)->delete();
      $dpsLoan->delete();
    }
    $dps->delete();

    return  response()->json(['status'=> true]);
  }

  public function deleteAll($account_no)
  {

    CashIn::where('account_no', $account_no)->delete();
    Cashout::where('account_no', $account_no)->delete();
    Due::where('account_no', $account_no)->delete();
    DpsLoan::where('account_no', $account_no)->delete();
    TakenLoan::where('account_no', $account_no)->delete();
    DpsLoanInterest::where('account_no', $account_no)->delete();
    Nominees::where('account_no', $account_no)->delete();
    Guarantor::where('account_no', $account_no)->delete();
    DpsLoan::where('account_no', $account_no)->delete();
    LoanDocuments::where('account_no', $account_no)->delete();
    DpsCollection::where('account_no', $account_no)->delete();
    DpsLoanCollection::where('account_no', $account_no)->delete();
    LoanPayment::where('account_no', $account_no)->delete();
    DpsInstallment::where('account_no', $account_no)->delete();
  }

  public function dpsInfoByAccount($account)
  {
    $savings = Dps::where('account_no', $account)->first();
    $user = User::find($savings->user_id);
    $dps = Dps::where('user_id', $user->id)->where('status', 'active')->sum('balance');
    $daily_savings = DailySavings::where('user_id', $user->id)->sum('total');
    $special_dps = SpecialDps::where('user_id', $user->id)->where('status', 'active')->sum('balance');
    $daily_loans = DailyLoan::where('user_id', $user->id)->where('status', 'active')->sum('balance');
    $fdr = Fdr::where('user_id', $user->id)->where('status', 'active')->sum('balance');
    $dps_loans = DpsLoan::where('user_id', $user->id)->where('status', 'active')->sum('remain_loan');
    $special_dps_loans = SpecialDpsLoan::where('user_id', $user->id)->where('status', 'active')->sum('remain_loan');

    $guarantors = array();
    $guarantorOff = Guarantor::where('user_id', $savings->user_id)->get();
    if ($guarantorOff) {
      foreach ($guarantorOff as $item) {
        $guarantors[] = $item->account_no;
      }
    }

    $data['guarantors'] = $guarantors;
    $data['user'] = $user;
    $data['dps'] = $dps . ' টাকা';
    $data['fdr'] = $fdr . ' টাকা';
    $data['daily_savings'] = $daily_savings . ' টাকা';
    $data['special_dps'] = $special_dps . ' টাকা';
    $data['daily_loans'] = $daily_loans . ' টাকা';
    $data['dps_loans'] = $dps_loans . ' টাকা';
    $data['special_dps_loans'] = $special_dps_loans . ' টাকা';
    return json_encode($data);
  }

  public function import(Request $request)
  {
    Excel::import(new DpsImport(),
      $request->file('file')->store('files'));
    return redirect()->back();
  }

  public function isExist($account)
  {
    $dps = Dps::where('account_no', $account)->count();
    if ($dps > 0) {
      return "yes";
    } else {
      return "no";
    }
    //return $dps;
  }


  public function resetDps($id)
  {
    $dps = Dps::find($id);
    $closing = ClosingAccount::where('dps_id', $dps->id)->first();

    $user = User::find($dps->user_id);
    $user->wallet = 0;
    $user->save();

    $withdrawAccount = Account::find(16);
    $depositAccount = Account::find(1);
    $cashAccount = Account::find(4);

    Transaction::where('account_no', $dps->account_no)
      ->whereIn('account_id', [16, 1])
      ->delete();

    Due::where('account_no', $dps->account_no)->delete();

    if ($closing) {
      $withdrawAccount->balance -= $closing->total;
      $withdrawAccount->save();
    } else {
      $depositAccount->balance -= $dps->balance;
      $depositAccount->save();

      $cashAccount->balance -= $dps->balance;
      $cashAccount->save();
    }
    $dps->balance = 0;
    $dps->save();
    $installments = DpsInstallment::where('account_no', $dps->account_no)->where('dps_amount', '>', 0)->get();
    foreach ($installments as $installment) {
      $cashin = CashIn::where('cashin_category_id', 1)->where('dps_installment_id', $installment->id)->first();
      $cashin->amount -= $installment->dps_amount;
      $cashin->save();

      $installment->dps_id = NULL;
      $installment->dps_balance = NULL;
      $installment->dps_installments = NULL;
      $installment->due = NULL;
      $installment->due_return = NULL;
      $installment->advance_return = NULL;
      $installment->dps_note = NULL;
      $installment->save();
      $installment->total -= $installment->dps_amount;
      $installment->dps_amount = NULL;
      $installment->save();

      if ($installment->late_fee > 0) {
        $installment->total -= $installment->late_fee;
        $installment->late_fee = NULL;
        $installment->save();
      }
      if ($installment->other_fee > 0) {
        $installment->total -= $installment->other_fee;
        $installment->other_fee = NULL;
        $installment->save();
      }
      if ($installment->advance > 0) {
        $installment->total -= $installment->advance;
        $installment->advance = NULL;
        $installment->save();
      }

      if ($installment->loan_installment == NULL && $installment->interest == NULL) {
        $installment->delete();
        $cashin->delete();
      }
    }
    DpsCollection::where('account_no', $dps->account_no)->delete();


    return 'success';
  }

  public function manipulateString($inputString)
  {
    // Extract the numeric part from the input string
    preg_match('/\d+/', $inputString, $matches);

    if (!empty($matches)) {
      // Increment the numeric part by 1
      $numericPart = intval($matches[0]) + 1;

      // Create the new string with incremented numeric part
      $newString = 'DPS' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);

      return $newString;
    }

    return $inputString; // Return the input string if no numeric part found
  }

  public function activeDps($id)
  {
    $dps = Dps::find($id);
    $completes = DpsComplete::where('dps_id', $id)->get();
    foreach ($completes as $item) {
      $dps->balance += $item->withdraw;
      $dps->profit += $item->profit;
      $dps->save();
      if ($item->dps_loan_id > 0) {
        $dpsLoan = DpsLoan::find($item->dps_loan_id);
        $dpsLoan->remain_loan += $item->loan_payment;
        $dpsLoan->paid_interest -= $item->interest;
        $dpsLoan->grace -= $item->grace;
        $dpsLoan->status = 'complete';
        $dpsLoan->save();
        $takenLoans = TakenLoan::where('dps_loan_id', $item->dps_loan_id)->get();
        foreach ($takenLoans as $loan) {
          $loanPayments = LoanPayment::where('taken_loan_id', $loan->id)->where('is_completed', 'yes')->get();
          foreach ($loanPayments as $payment) {
            $loan->remain += $payment->amount;
            $loan->save();
            $payment->delete();
          }
          DpsLoanInterest::where('taken_loan_id', $loan->id)->where('is_completed', 'yes')->delete();
        }
      }

      $item->delete();
    }

    $dps->status = 'active';
    $dps->save();

    return redirect()->back()->with('success', 'সঞ্চয় হিসাব চালু করা হয়েছে!');
  }
}
