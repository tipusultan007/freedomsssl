<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DpsLoanAccount;
use App\Http\Controllers\Accounts\DpsLoanPaymentAccount;
use App\Http\Controllers\Accounts\GraceAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\PaidInterestAccount;
use App\Imports\DpsLoanImport;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsInstallment;
use App\Models\DpsLoanCollection;
use App\Models\DpsLoanInterest;
use App\Models\Guarantor;
use App\Models\LoanDocuments;
use App\Models\LoanPayment;
use App\Models\SpecialDps;
use App\Models\SpecialDpsLoan;
use App\Models\TakenLoan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\DpsLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\DpsLoanStoreRequest;
use App\Http\Requests\DpsLoanUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class DpsLoanController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //$this->authorize('view-any', DpsLoan::class);

    /*$takenLoans = TakenLoan::where('account_no','DPS1199')->get();
    $data = [];
    foreach ($takenLoans as  $loan)
    {
        $dpsLoan = DpsLoan::where('account_no',$loan->account_no)->first();
        if ($dpsLoan) {
            $dpsLoan->loan_amount += $loan->loan_amount;
            $dpsLoan->save();
            $loan->dps_loan_id = $dpsLoan->id;
            $loan->trx_id = Str::uuid();
            $loan->save();
        }else{
            $data[] = $loan->account_no;
        }
    }*/
    //dd($data);
    /* $loans = DpsLoan::all();
     foreach ($loans as $loan) {
         $expNum = explode(' ', $loan->account_no);
         if (count($expNum) > 0) {
             $str = $loan->account_no;
             $trim = str_replace(' ', '', $str);
             $loan->account_no = $trim;
             $loan->save();

             $expNum = explode('-', $loan->account_no);
             $s = str_pad($expNum[1], 4, "0", STR_PAD_LEFT);
             $loan->account_no = 'DPS' . $s;
             $loan->save();
         } else {
             $expNum = explode('-', $loan->account_no);
             $s = str_pad($expNum[1], 4, "0", STR_PAD_LEFT);
             $loan->account_no = 'DPS' . $s;
             $loan->save();
         }

     }*/
    /*$installments = DpsLoan::all();
    foreach ($installments as $installment)
    {
        $expNum = explode(' ', $installment->account_no);
        if (count($expNum)>0) {
            $trim = str_replace(' ', '', $installment->account_no);
            //$installment->account_no = $trim;
            //$installment->save();

            $expNum = explode('-', $trim);
            $s = str_pad($expNum[1], 4, "0", STR_PAD_LEFT);
            $installment->account_no = 'DPS'.$s;
            $installment->save();
        }else{
            $expNum = explode('-', $installment->account_no);
            $s = str_pad($expNum[1], 4, "0", STR_PAD_LEFT);
            $installment->account_no = 'DPS'.$s;
            $installment->save();
        }
    }*/

    return view('app.dps_loans.index');
  }

  public function dataDpsLoans(Request $request)
  {
    $totalData = DpsLoan::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');

    if (empty($request->input('search.value'))) {
      $posts = DpsLoan::with('user', 'manager')->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = DpsLoan::with('user', 'manager')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();

      $totalFiltered = DpsLoan::with('user', 'manager')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $show = route('dps-loans.show', $post->id);
        $edit = route('dps-loans.edit', $post->id);

        $date = new Carbon($post->opening_date);
        $commencement = new Carbon($post->commencement);
        $nestedData['id'] = $post->id;
        $nestedData['name'] = $post->user->name;
        $nestedData['account_no'] = $post->account_no;
        $nestedData['date'] = $commencement->format('d/m/Y');
        //$nestedData['commencement'] = $post->commencement;
        $nestedData['loan_amount'] = $post->loan_amount;
        $nestedData['remain_loan'] = $post->remain_loan;
        $nestedData['phone'] = $post->phone1;
        $nestedData['image'] = $post->image;
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
    //$this->authorize('create', DpsLoan::class);

    $users = User::select('id', 'name', 'father_name')->get();

    return view('app.dps_loans.create', compact('users'));
  }

  /**
   * @param \App\Http\Requests\DpsLoanStoreRequest $request
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {
    //$this->authorize('create', DpsLoan::class);
    $data = $request->except('documents');
    $data['trx_id'] = Str::uuid();
    $loan = DpsLoan::where('account_no', $request->account_no)->first();
    if ($loan) {
      $data['before_loan'] = $loan->remain_loan;
      $loan->loan_amount += $request->loan_amount;
      $loan->remain_loan += $request->loan_amount;
      $loan->save();
      $data['after_loan'] = $loan->remain_loan;
      $data['manager_id'] = Auth::id();
      $data['dps_loan_id'] = $loan->id;
      $data['date'] = $request->opening_date;
      $data['remain'] = $request->loan_amount;

    } else {
      $data['manager_id'] = Auth::id();
      $data['remain_loan'] = $request->loan_amount;
      $dpsLoan = DpsLoan::create($data);
      $data['dps_loan_id'] = $dpsLoan->id;
      $data['date'] = $request->opening_date;
      $data['remain'] = $request->loan_amount;
      $data['before_loan'] = 0;
      $data['after_loan'] = $request->loan_amount;

    }
    $takenLoan = TakenLoan::create($data);
    // Upload documents and save file paths as JSON
    $filePaths = [];

    if ($request->hasFile('documents')) {
      foreach ($request->file('documents') as $file) {
        $path = $file->store('documents'); // 'documents' is a directory inside the storage/app folder
        $filePaths[] = $path;
      }

      $takenLoan->documents = json_encode($filePaths);
      $takenLoan->save();
    }

    $data['taken_loan_id'] = $takenLoan->id;

    //LoanDocuments::create($data);
    $data['user_id'] = $request->guarantor_user_id;
    Guarantor::create($data);
    //$transaction = $this->accountTransaction($takenLoan);
    return redirect()->back()->with('success', 'ঋণ বিতরণ সফল হয়েছে।');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DpsLoan $dpsLoan
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, DpsLoan $dpsLoan)
  {
    //$this->authorize('view', $dpsLoan);

    return view('app.dps_loans.show', compact('dpsLoan'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DpsLoan $dpsLoan
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, DpsLoan $dpsLoan)
  {
    //$this->authorize('update', $dpsLoan);

    $users = User::pluck('name', 'id');

    return view(
      'app.dps_loans.edit',
      compact('dpsLoan', 'users', 'users', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\DpsLoanUpdateRequest $request
   * @param \App\Models\DpsLoan $dpsLoan
   * @return \Illuminate\Http\Response
   */
  public function update(DpsLoanUpdateRequest $request, DpsLoan $dpsLoan)
  {
    //$this->authorize('update', $dpsLoan);

    $validated = $request->validated();

    $dpsLoan->update($validated);

    return redirect()
      ->route('dps-loans.edit', $dpsLoan)
      ->withSuccess(__('crud.common.saved'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\DpsLoan $dpsLoan
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dpsLoan = DpsLoan::find($id);
    $takenLoans = TakenLoan::where('dps_loan_id', $id)->get();


    foreach ($takenLoans as $takenLoan) {
      LoanPayment::where('taken_loan_id', $takenLoan->id)->delete();
      DpsLoanInterest::where('taken_loan_id', $takenLoan->id)->delete();
      $takenLoan->delete();
    }
    ////$this->authorize('delete', $dpsLoan);
    $dpsInstallments = DpsInstallment::where('dps_loan_id', $id)->get();
    foreach ($dpsInstallments as $dpsInstallment) {
      if ($dpsInstallment->dps_id !=""){
        $total = 0;
        if ($dpsInstallment->loan_installment > 0) {
          $total += $dpsInstallment->loan_installment;
        }
        if ($dpsInstallment->interest > 0) {
          $total += $dpsInstallment->interest;
        }
        if ($dpsInstallment->due_interest > 0) {
          $total += $dpsInstallment->due_interest;
        }
        $dpsInstallment->total -= $total;
        $dpsInstallment->loan_grace = NULL;
        $dpsInstallment->loan_installment = NULL;
        $dpsInstallment->interest = NULL;
        $dpsInstallment->loan_balance = NULL;
        $dpsInstallment->due_interest = NULL;
        $dpsInstallment->loan_note = NULL;
        $dpsInstallment->dps_loan_id = NULL;
        $dpsInstallment->save();
      }else{
        $dpsInstallment->delete();
      }
    }
    DpsLoanCollection::where('dps_loan_id', $dpsLoan->id)->delete();
    $dpsLoan->delete();
    return "success";
  }

  public function import(Request $request)
  {
    Excel::import(new DpsLoanImport(),
      $request->file('file')->store('files'));
    return redirect()->back();
  }

  public function loanList($id)
  {
    $loans = TakenLoan::where('dps_loan_id', $id)
      ->select('id', 'date', 'loan_amount', 'interest1', 'interest2', 'upto_amount', 'remain', 'commencement')->get();

    echo json_encode($loans);
  }

  public function loansById(Request $request)
  {

  }

  public function resetLoan($id)
  {
    $loan = DpsLoan::find($id);
    $loan->remain_loan = $loan->loan_amount;
    $loan->paid_interest = 0;
    $loan->dueInterest = 0;
    $loan->grace = 0;
    $loan->save();

    $installments = DpsInstallment::where('account_no', $loan->account_no)
      ->where('loan_installment', '>', 0)
      ->orWhere('interest', '>', 0)
      ->get();
    $takenLoans = TakenLoan::where('account_no', $loan->account_no)->get();

    foreach ($installments as $installment) {
      DpsLoanCollection::where('dps_installment_id', $installment->id)->delete();
      DpsLoanInterest::where('dps_installment_id', $installment->id)->delete();
      LoanPayment::where('dps_installment_id', $installment->id)->delete();
      CashIn::where('cashin_category_id', 4)->where('dps_installment_id', $installment->id)->delete();
      if ($installment->dps_amount == 0 && $installment->dps_amount == NULL) {
        $installment->delete();
      } else {

        if ($installment->loan_installment > 0) {
          $installment->total -= $installment->loan_installment;
          $installment->loan_installment = NULL;
          $installment->save();
          DpsLoanPaymentAccount::delete($installment->trx_id);
        }

        if ($installment->interest > 0) {
          $installment->total -= $installment->interest;
          $installment->interest = NULL;
          $installment->save();
          PaidInterestAccount::delete($installment->trx_id, 'dps');
        }

        if ($installment->loan_late_fee > 0) {
          $installment->total -= $installment->loan_late_fee;
          $installment->loan_late_fee = NULL;
          $installment->save();
          LateFeeAccount::delete($installment->trx_id);
        }
        if ($installment->loan_other_fee > 0) {
          $installment->total -= $installment->loan_other_fee;
          $installment->loan_other_fee = NULL;
          $installment->save();
          OtherFeeAccount::delete($installment->trx_id);
        }
        if ($installment->loan_grace > 0) {
          GraceAccount::delete($installment->trx_id);
        }

        $installment->dps_loan_id = NULL;
        $installment->loan_balance = NULL;
        $installment->due_interest = NULL;
        $installment->loan_note = NULL;
        $installment->save();
      }
    }

    foreach ($takenLoans as $takenLoan) {
      $takenLoan->remain = $takenLoan->loan_amount;
      $takenLoan->save();
    }


  }

  public function accountTransaction(TakenLoan $loan)
  {
    $data = $loan;
    $data['trx_type'] = 'cash';
    $data['name'] = $loan->user->name;
    DpsLoanAccount::create($data);

  }
}
