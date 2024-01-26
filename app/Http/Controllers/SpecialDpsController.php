<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\SpecialDpsAccount;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\ClosingAccount;
use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsLoan;
use App\Models\Due;
use App\Models\Fdr;
use App\Models\Guarantor;
use App\Models\LoanDocuments;
use App\Models\Nominees;
use App\Models\SpecialDpsCollection;
use App\Models\SpecialDpsComplete;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use App\Models\Transaction;
use App\Models\User;
use App\Models\SpecialDps;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SpecialDpsPackage;
use App\Http\Requests\SpecialDpsStoreRequest;
use App\Http\Requests\SpecialDpsUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpecialDpsController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $search = $request->get('search', '');
    $packages = SpecialDpsPackage::all();

    $allSpecialDps = SpecialDps::search($search)
      ->latest()
      ->paginate(5)
      ->withQueryString();
    $savings = SpecialDps::all();
    /*foreach ($savings as $saving)
    {

        $saving->trx_id = Str::uuid();
        $saving->balance = $saving->initial_amount;
        $saving->save();
        $data = $saving;
        $data['dps_amount'] = $saving->initial_amount;
        $data['name'] = $saving->user->name;
        $data['trx_type'] = 'cash';
        $data['collector_id'] = $saving->created_by;
        $data['date'] = $saving->opening_date;
        SpecialDpsAccount::create($data);
        $cashin = CashIn::create([
            'user_id'                => $saving->user_id,
            'cashin_category_id'     => 2,
            'description'     => 'Special DPS initial deposit amount',
            'account_no'             => $saving->account_no,
            'special_dps_id' => $saving->id,
            'amount'                 => $saving->initial_amount,
            'trx_id'                 => $saving->trx_id,
            'date'                   => $saving->opening_date,
            'created_by'             => $saving->created_by
        ]);
    }*/
    return view(
      'app.all_special_dps.index',
      compact('allSpecialDps', 'search','packages')
    );
  }

  public function specialDpsData(Request $request)
  {
    $columns = array(
      0 => 'account_no',
    );

    $totalData = SpecialDps::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');

    if (empty($request->input('search.value'))) {
      $posts = SpecialDps::with('user','specialDpsPackage')->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = SpecialDps::with('user','specialDpsPackage')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user',function ($query) use ($search){
          $query->where('name','LIKE',"%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();

      $totalFiltered = SpecialDps::with('user','specialDpsPackage')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user',function ($query) use ($search){
          $query->where('name','LIKE',"%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {


        $nestedData['id'] = $post->id;
        $nestedData['name'] = $post->user->name;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['date'] = date('d/m/Y',strtotime($post->opening_date));
        $nestedData['balance'] = $post->balance;
        $nestedData['package'] = $post->specialDpsPackage->name??'';
        $nestedData['phone'] = $post->phone1;
        $nestedData['initial_deposit'] = $post->initial_amount;
        $nestedData['package_amount'] = $post->package_amount;
        $nestedData['image'] = $post->user->image;
        $nestedData['status'] = $post->status;

        $data[] = $nestedData;
      }
    }

    $json_data = array(
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $data
    );

    echo json_encode($json_data);
  }


  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    //$this->authorize('create', SpecialDps::class);

    $users = User::select('id', 'name', 'father_name')->get();
    $dpsPackages = SpecialDpsPackage::all();

    $accounts = SpecialDps::orderBy('account_no', 'desc')->first();
    if ($accounts){
      $new_account = $this->manipulateString($accounts->account_no);
    }else{
      $new_account = 'ML0001';
    }

    return view(
      'app.all_special_dps.create',
      compact('users', 'dpsPackages', 'users', 'new_account')
    );
  }

  public function manipulateString($inputString)
  {
    // Extract the numeric part from the input string
    preg_match('/\d+/', $inputString, $matches);

    if (!empty($matches)) {
      // Increment the numeric part by 1
      $numericPart = intval($matches[0]) + 1;

      // Create the new string with incremented numeric part
      $newString = 'ML' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);

      return $newString;
    }

    return $inputString; // Return the input string if no numeric part found
  }

  /**
   * @param \App\Http\Requests\SpecialDpsStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //$this->authorize('create', SpecialDps::class);
    $data = $request->except('image', 'image1');
    //$data['account_no'] = 'ML'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
    $data['balance'] = $request->initial_amount;
    $data['manager_id'] = Auth::id();
    $specialDps = SpecialDps::create($data);
    $data['user_id'] = $request->nominee_user_id;
    $data['user_id1'] = $request->nominee_user_id1;
    if ($request->hasFile('image')) {
      $imageName = "nominee_" . $specialDps->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
      $request->file('image')->storeAs('public/nominee_images', $imageName);
      $data['image'] = $imageName;
    }

    if ($request->hasFile('image1')) {
      $imageName1 = "nominee_" . $specialDps->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
      $request->file('image1')->storeAs('public/nominee_images', $imageName1);
      $data['image1'] = $imageName1;
    }

    $nominee = Nominees::create($data);


    return redirect()->back()->with('success', 'বিশেষ সঞ্চয় হিসাব খোলা হয়েছে!');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialDps $specialDps
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $dps = SpecialDps::with('givenLoans')->find($id);
    //$this->authorize('view', $dps);
    $collections = SpecialDpsCollection::where('special_dps_id', $dps->id)->get();
    return view('app.all_special_dps.show', compact('dps', 'collections'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialDps $specialDps
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //$this->authorize('update', $specialDps);

    $specialDps = SpecialDps::find($id);
    $users = User::select('name', 'id', 'father_name')->get();
    $specialDpsPackages = SpecialDpsPackage::all();

    return view(
      'app.all_special_dps.edit',
      compact('specialDps', 'users', 'specialDpsPackages', 'users', 'specialDps')
    );
  }

  /**
   * @param \App\Http\Requests\SpecialDpsUpdateRequest $request
   * @param \App\Models\SpecialDps $specialDps
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //dd($request->all());
    $specialDps = SpecialDps::find($id);
    $data = $request->except('image', 'image1');
    $specialDps->update($data);

    $data['user_id'] = $request->filled('nominee_user_id')?$request->nominee_user_id:null;
    $data['user_id1'] = $request->filled('nominee_user_id1')?$request->nominee_user_id1:null;
    //$nominee->update($data);

    // Handle 'image' update
    if ($request->hasFile('image')) {
      // Delete the previous file
      Storage::disk('public')->delete('nominee_images/' . $specialDps->nominee->image);

      $imageName = "nominee_" . $specialDps->account_no . "_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
      $request->file('image')->storeAs('public/nominee_images', $imageName);
      $data['image'] = $imageName;
    } else {
      unset($data['image']);
    }

    // Handle 'image1' update
    if ($request->hasFile('image1')) {
      // Delete the previous file
      Storage::disk('public')->delete('nominee_images/' . $specialDps->nominee->image1);

      $imageName1 = "nominee_" . $specialDps->account_no . "_" . time() . '.' . $request->file('image1')->getClientOriginalExtension();
      $request->file('image1')->storeAs('public/nominee_images', $imageName1);
      $data['image1'] = $imageName1;
    } else {
      unset($data['image1']);
    }

    // Update or create nominee data
    $nominee = Nominees::updateOrCreate(['account_no' => $specialDps->account_no], $data);

    return redirect()
      ->route('special-dps.edit', $specialDps)
      ->with('success', 'বিশেষ সঞ্চয় আপডেট সফল হয়েছে!');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SpecialDps $specialDps
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dps = SpecialDps::with('installments')->find($id);
    $dpsInstallmentIds = $dps->installments->pluck('id');
    Transaction::where('transactionable_type', SpecialInstallment::class)
      ->whereIn('transactionable_id', $dpsInstallmentIds)
      ->delete();

    SpecialDpsCollection::where('special_dps_id', $dps->id)->delete();
    $completes = SpecialDpsComplete::where('special_dps_id', $dps->id)->get();
    foreach ($completes as $complete) {
      $complete->delete();
    }
    SpecialInstallment::where('special_dps_id', $dps->id)->delete();
    $dpsLoan = SpecialDpsLoan::with('specialDpsInstallments', 'specialLoanTakens')->where('account_no', $dps->account_no)->first();
    if ($dpsLoan) {
      $loanInstallmentIds = $dpsLoan->specialDpsInstallments->pluck('id');
      Transaction::where('transactionable_type', SpecialInstallment::class)
        ->whereIn('transactionable_id', $loanInstallmentIds)
        ->delete();

      foreach ($dpsLoan->specialLoanTakens as $loan) {
        SpecialLoanInterest::where('special_loan_taken_id', $loan->id)->delete();
        SpecialLoanPayment::where('special_loan_taken_id', $loan->id)->delete();
        $loan->delete();
      }
      SpecialLoanCollection::where('special_dps_loan_id', $dpsLoan->id)->delete();
      SpecialInstallment::where('special_dps_loan_id', $dps->id)->delete();
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
    SpecialDpsLoan::where('account_no', $account_no)->delete();
    SpecialLoanTaken::where('account_no', $account_no)->delete();
    SpecialLoanInterest::where('account_no', $account_no)->delete();
    Nominees::where('account_no', $account_no)->delete();
    Guarantor::where('account_no', $account_no)->delete();
    LoanDocuments::where('account_no', $account_no)->delete();
    SpecialDpsCollection::where('account_no', $account_no)->delete();
    SpecialLoanCollection::where('account_no', $account_no)->delete();
    SpecialLoanPayment::where('account_no', $account_no)->delete();
    SpecialInstallment::where('account_no', $account_no)->delete();
  }

  public function specialDpsInfoByAccount($account)
  {
    $savings = SpecialDps::where('account_no', $account)->first();
    //$savings = Dps::where('account_no', $account)->first();
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
    $data['dps'] = $dps . ' Tk.';
    $data['fdr'] = $fdr . ' Tk.';
    $data['daily_savings'] = $daily_savings . ' Tk.';
    $data['special_dps'] = $special_dps . ' Tk.';
    $data['daily_loans'] = $daily_loans . ' Tk.';
    $data['dps_loans'] = $dps_loans . ' Tk.';
    $data['special_dps_loans'] = $special_dps_loans . ' Tk.';
    return json_encode($data);
  }

  public function isExist($account)
  {
    $dps = SpecialDps::where('account_no', $account)->count();

    if ($dps > 0) {
      return "yes";
    } else {
      return "no";
    }
  }

  public function resetDps($id)
  {
    $dps = SpecialDps::find($id);
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

    $dps->balance = $dps->initial_amount;
    $dps->save();
    $installments = SpecialInstallment::where('account_no', $dps->account_no)->where('dps_amount', '>', 0)->get();
    foreach ($installments as $installment) {
      $cashin = CashIn::where('cashin_category_id', 2)->where('special_installment_id', $installment->id)->first();
      $cashin->amount -= $installment->dps_amount;
      $cashin->save();

      $installment->special_dps_id = NULL;
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
      //CashIn::where('cashin_category_id',7)->where('special_installment_id	',$installment->id)->delete();
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
    SpecialDpsCollection::where('account_no', $dps->account_no)->delete();

    return 'success';
  }

  public function activeDps($id)
  {
    $dps = SpecialDps::find($id);
    $completes = SpecialDpsComplete::where('special_dps_id',$id)->get();
    foreach ($completes as $item)
    {
      $dps->balance += $item->withdraw;
      $dps->profit += $item->profit;
      $dps->save();
      if ($item->special_dps_loan_id>0)
      {
        $dpsLoan = SpecialDpsLoan::find($item->special_dps_loan_id);
        $dpsLoan->remain_loan += $item->loan_payment;
        $dpsLoan->paid_interest -= $item->interest;
        $dpsLoan->grace -= $item->grace;
        $dpsLoan->status= 'complete';
        $dpsLoan->save();
        $takenLoans = SpecialLoanTaken::where('special_dps_loan_id',$item->special_dps_loan_id)->get();
        foreach ($takenLoans as $loan)
        {
          $loanPayments = SpecialLoanPayment::where('special_loan_taken_id',$loan->id)->where('is_completed','yes')->get();
          foreach ($loanPayments as $payment)
          {
            $loan->remain += $payment->amount;
            $loan->save();
            $payment->delete();
          }
          SpecialLoanInterest::where('special_loan_taken_id',$loan->id)->where('is_completed','yes')->delete();
        }
      }

      $item->delete();
    }

    $dps->status = 'active';
    $dps->save();

    return redirect()->back()->with('success','সঞ্চয় হিসাব চালু করা হয়েছে!');
  }
}
