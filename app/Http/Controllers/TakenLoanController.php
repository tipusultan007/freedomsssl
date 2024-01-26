<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\DpsLoanAccount;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DpsInstallment;
use App\Models\DpsLoanCollection;
use App\Models\DpsLoanInterest;
use App\Models\Guarantor;
use App\Models\LoanPayment;
use App\Models\User;
use App\Models\DpsLoan;
use App\Models\TakenLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TakenLoanStoreRequest;
use App\Http\Requests\TakenLoanUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TakenLoanController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', TakenLoan::class);

        $search = $request->get('search', '');

        $takenLoans = TakenLoan::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();
       /* $takenLoans = TakenLoan::all();
        foreach ($takenLoans as  $loan)
        {
            $dpsLoan = DpsLoan::where('account_no',$loan->account_no)->first();
            $dpsLoan->loan_amount += $loan->loan_amount;
            $dpsLoan->remain_loan += $loan->loan_amount;
            $dpsLoan->save();
        }*/
        /*$installments = DpsInstallment::where('loan_installment','>',0)->orWhere('interest','>',0)->get();
        $data = [];
        foreach ($installments as $row)
        {
            $loan = TakenLoan::where('account_no',$row->account_no)->count();
            if ($loan>1)
            {
                $row->delete();
            }
        }*/
        //dd($data);
        /*$loans = TakenLoan::orderBy('date','asc')->get();
        foreach ($loans as $loan)
        {
            $loan->trx_id = Str::uuid();
            $loan->save();
            $data = $loan;
            $data['trx_type'] = 'cash';
            $data['name'] = $loan->user->name;
            DpsLoanAccount::create($data);
            $cashout = Cashout::create([
                'cashout_category_id' => 3,
                'account_no'          => $loan->account_no,
                'dps_loan_id'         => $loan->id,
                'amount'              => $loan->loan_amount,
                'date'                => $loan->date,
                'created_by'          => $loan->created_by,
                'user_id'             => $loan->user_id,
                'trx_id'             => $loan->trx_id,
            ]);
        }*/
      /*  $installments = TakenLoan::all();
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

        return view('app.taken_loans.index', compact('takenLoans', 'search'));
    }

    public function dataTakenLoans(Request $request)
    {
        if (!empty($request->dps_loan_id)) {
            $totalData = TakenLoan::where('dps_loan_id', $request->dps_loan_id)->count();
        } elseif (!empty($request->account_no)) {
            $totalData = TakenLoan::where('account_no', $request->account_no)->count();
        } else {
            $totalData = TakenLoan::count();
        }


        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            if (!empty($request->dps_loan_id)) {
                $posts = TakenLoan::with('user','manager')
                  ->where('dps_loan_id',$request->dps_loan_id)
                  ->offset($start)
                    ->limit($limit)
                    ->orderBy('date', 'desc')
                    ->get();
            } elseif (!empty($request->account_no)) {
                $posts = TakenLoan::with('user','manager')
                    ->where('account_no',$request->account_no)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date', 'desc')
                    ->get();
            } else {
                $posts = TakenLoan::with('user','manager')->offset($start)
                    ->limit($limit)
                  ->orderBy('date', 'desc')
                    ->get();
            }
        } else {
            $search = $request->input('search.value');

            $posts = TakenLoan::with('user','manager')
              ->where('account_no', 'LIKE', "%{$search}%")
              ->orWhereHas('users', function ($query) use ($search){
                $query->where('name','LIKE', "%{$search}%");
              })
                ->offset($start)
                ->limit($limit)
                ->orderBy('date', 'desc')
                ->get();

            $totalFiltered = TakenLoan::with('user')
                ->where('account_no', 'LIKE', "%{$search}%")
                ->orWhereHas('users', function ($query) use ($search){
                  $query->where('name','LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show = route('taken-loans.show', $post->id);
                $edit = route('taken-loans.edit', $post->id);

                //$loan = DpsLoan::find($post->dps_loan_id);
                $date                     = new Carbon($post->date);
                $commencement             = new Carbon($post->commencement);
                $nestedData['id']         = $post->id;
                $nestedData['name']       = $post->user->name;
                $nestedData['history']    =  $post->before_loan??'-';
                $nestedData['account_no'] = $post->account_no;
                $nestedData['date']       = date('d-m-Y',strtotime($post->date));
                $nestedData['commencement'] = date('d-m-Y',strtotime($post->commencement));
                $nestedData['loan_amount'] = $post->loan_amount;
                //$nestedData['interest'] = $post->interest1.'%';
                if ($post->interest2 > 0) {
                    $nestedData['interest'] = $post->interest1 . '%' . ' | ' . $post->interest2 . '%';
                } else {
                    $nestedData['interest'] = $post->interest1 . '%';
                }
                $nestedData['upto_amount'] = $post->upto_amount ?? 'N/A';
                $nestedData['remain']      = $post->remain;
                $nestedData['phone']       = $post->phone1;
                $nestedData['createdBy']   = $post->manager->name;
                $nestedData['photo']       = $post->image;
                $data[]                    = $nestedData;

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
        //$this->authorize('create', TakenLoan::class);

        $users    = User::pluck('name', 'id');
        $dpsLoans = DpsLoan::pluck('account_no', 'id');

        return view(
            'app.taken_loans.create',
            compact('users', 'users', 'dpsLoans')
        );
    }

    /**
     * @param \App\Http\Requests\TakenLoanStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TakenLoanStoreRequest $request)
    {
        //$this->authorize('create', TakenLoan::class);

        $validated = $request->validated();

        $takenLoan = TakenLoan::create($validated);

        $cashout = Cashout::create([
            'cashout_category_id' => 3,
            'account_no'          => $takenLoan->account_no,
            'dps_loan_id'         => $takenLoan->id,
            'amount'              => $takenLoan->loan_amount,
            'date'                => $takenLoan->date,
            'created_by'          => $takenLoan->created_by,
            'user_id'             => $takenLoan->user_id,
        ]);

        return redirect()
            ->route('taken-loans.edit', $takenLoan)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TakenLoan $takenLoan)
    {
        //$this->authorize('view', $takenLoan);

        return view('app.taken_loans.show', compact('takenLoan'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $users = User::select('id','name','father_name')->get();

      $loan = TakenLoan::with('guarantor','user')->find($id);
        return view(
            'app.taken_loans.edit',
            compact('loan', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\TakenLoanUpdateRequest $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $takenLoan = TakenLoan::find($id);
        $data = $request->except('documents');
        //dd($data);
        $takenLoan->update($data);

        $filePaths = [];

        if ($request->hasFile('documents')) {
          foreach ($request->file('documents') as $file) {
            $path = $file->store('documents'); // 'documents' is a directory inside the storage/app folder
            $filePaths[] = $path;
          }

          $takenLoan->documents = json_encode($filePaths);
          $takenLoan->save();
        }

        /*$guarantor = Guarantor::where('taken_loan_id',$id)->first();
        $guarantor->update($data);*/

      if ($takenLoan->guarantor) {
        $takenLoan->guarantor->update($data);
      } else {
        // If no guarantor exists, create a new one
        $guarantorData = collect($data)->only([
          'user_id',
          'guarantor_user_id',
          'phone',
          'account_no',
          'name',
          'address',
          'exist_ac_no',
          'daily_loan_id',
          'taken_loan_id',
          'special_taken_loan_id',
        ])->toArray();

        $takenLoan->guarantor()->create($guarantorData);
      }
      $takenLoan->guarantor->user_id = $request->guarantor_user_id;
      $takenLoan->guarantor->save();
        return redirect()
            ->route('taken-loans.edit', $takenLoan)
            ->with('success','ঋণ আপডেট সফল হয়েছে!');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TakenLoan $takenLoan
     * @return \Illuminate\Http\Response
     */
  public function destroy(Request $request, $id)
  {
    $specialLoanTaken = TakenLoan::with('interests','dpsLoan','payments')->find($id);
    $dpsLoan = DpsLoan::find($specialLoanTaken->dps_loan_id);
    $dpsLoan->loan_amount -= $specialLoanTaken->loan_amount;
    $dpsLoan->remain_loan -= $specialLoanTaken->remain;
    $dpsLoan->paid_interest -= $specialLoanTaken->interests->sum('total');
    $dpsLoan->save();

    $loanPayments = $specialLoanTaken->payments;
    foreach ($loanPayments as $payment)
    {
      $installment = DpsInstallment::find($payment->dps_installment_id);
      $installment->loan_installment -= $payment->amount;
      $installment->loan_balance -= $payment->amount;
      $installment->total -= $payment->amount;
      $installment->save();

      $loanCollection = DpsLoanCollection::where('dps_installment_id',$payment->dps_installment_id)->first();
      $loanCollection->loan_installment -= $payment->amount;
      $loanCollection->balance -= $payment->amount;
      $loanCollection->save();

      $payment->delete();
    }

    $loanInterests = $specialLoanTaken->interests;
    foreach ($loanInterests as $interest)
    {
      $installment = DpsInstallment::find($interest->dps_installment_id);
      $installment->interest -= $interest->amount;
      $installment->total -= $interest->amount;
      $installment->save();

      $loanCollection = DpsLoanCollection::where('dps_installment_id',$interest->dps_installment_id)->first();
      $loanCollection->interest -= $interest->total;
      $loanCollection->save();

      if ($loanCollection->loan_installment<1 && $loanCollection->interest <1)
      {
        $loanCollection->delete();
      }

      $interest->delete();
    }
    $specialLoanTaken->delete();

    return response()->json('ঋণ ডিলেট করা হয়েছে!');
  }

    public function dataTakenLoanTransaction(Request $request)
    {
        $q_date         = 'dps_installments.date';
        $q_loan         = 'loan_payments.amount';
        $q_remain       = 'loan_payments.balance';
        $q_interest     = 'dps_loan_interests.total as totalInterest';
        $q_installments = 'dps_loan_interests.installments';
        $q_rate         = 'dps_loan_interests.interest';
        $totalData      = DB::table('dps_installments')
            ->leftJoin('dps_loan_interests', 'dps_loan_interests.dps_installment_id', '=', 'dps_installments.id')
            ->leftJoin('loan_payments', 'loan_payments.dps_installment_id', '=', 'dps_installments.id')
            ->where('dps_loan_interests.taken_loan_id', $request->loanId)
            ->orWhere('loan_payments.taken_loan_id', $request->loanId)
            ->count();

        $totalFiltered = $totalData;
        $limit         = $request->input('length');
        $start         = $request->input('start');
        if (empty($request->input('search.value'))) {

            $posts = DB::table('dps_installments')
                ->leftJoin('dps_loan_interests', 'dps_loan_interests.dps_installment_id', '=', 'dps_installments.id')
                ->leftJoin('loan_payments', 'loan_payments.dps_installment_id', '=', 'dps_installments.id')
                ->select($q_date, $q_loan, $q_remain, $q_interest, $q_installments, $q_rate, 'dps_loan_interests.id as interestId', 'loan_payments.id as paymentId')
                ->where('dps_loan_interests.taken_loan_id', $request->loanId)
                ->orWhere('loan_payments.taken_loan_id', $request->loanId)
                ->offset($start)
                ->limit($limit)
                ->orderBy('dps_installments.id', 'desc')
                ->get();

        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                //$show = route('dps-collections.show', $post->id);
                //$edit = route('dps-collections.edit', $post->id);

                $date                           = new Carbon($post->date);
                $nestedData['paymentId']        = $post->paymentId;
                $nestedData['interestId']       = $post->interestId;
                $nestedData['date']             = $date->format('d/m/Y');
                $nestedData['loan_installment'] = $post->amount;
                $nestedData['remain']           = $post->balance;
                $nestedData['interest']         = $post->totalInterest;
                $nestedData['installments']     = $post->installments;
                $nestedData['rate']             = $post->interest;
                $data[]                         = $nestedData;

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

    public function deleteInterestByLoanId($id)
    {
        $loanInterest    = DpsLoanInterest::find($id);
        $dps_installment = DpsInstallment::find($loanInterest->dps_installment_id);
        $loanCollection  = DpsLoanCollection::where('dps_installment_id', $loanInterest->dps_installment_id)->first();
        $loan            = DpsLoan::find($dps_installment->dps_loan_id);
        if ($loan->paid_interest > 0) {
            $loan->paid_interest -= $loanInterest->total;
        }
        $loan->save();

        $dps_installment->interest -= $loanInterest->total;
        $dps_installment->total    -= $loanInterest->total;
        $loanCollection->interest  -= $loanInterest->total;
        $loanCollection->save();
        $cashin         = CashIn::where('cashin_category_id', 4)->where('dps_installment_id', $dps_installment->id)->latest()->first();
        $cashin->amount -= $loanInterest->total;
        $cashin->save();
        $dps_installment->save();
        $loanInterest->delete();
        echo "success";

    }

    public function deleteLoanPaymentByLoanId($id)
    {
        $loanPayment                         = LoanPayment::find($id);
        $loanTaken                           = TakenLoan::find($loanPayment->taken_loan_id);
        $loan                                = DpsLoan::find($loanTaken->dps_loan_id);
        $dpsInstallment                      = DpsInstallment::find($loanPayment->dps_installment_id);
        $dpsLoanCollection                   = DpsLoanCollection::where('dps_installment_id', $loanPayment->dps_installment_id)->first();
        $dpsLoanCollection->loan_installment -= $loanPayment->amount;
        $dpsInstallment->loan_installment    -= $loanPayment->amount;
        $loan->remain_loan                   += $loanPayment->amount;
        $loanTaken->remain                   += $loanPayment->amount;
        $loan->save();
        $loanTaken->save();
        $dpsInstallment->save();
        $dpsLoanCollection->save();
        $cashin         = CashIn::where('cashin_category_id', 4)->where('dps_installment_id', $dpsInstallment->id)->latest()->first();
        $cashin->amount -= $loanPayment->amount;
        $cashin->save();
        $loanPayment->delete();

        echo "success";
    }
}
