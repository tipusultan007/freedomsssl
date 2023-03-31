<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\ClosingAccount;
use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\Dps;
use App\Models\DpsLoan;
use App\Models\Due;
use App\Models\Guarantor;
use App\Models\LoanDocuments;
use App\Models\Nominees;
use App\Models\SpecialDpsCollection;
use App\Models\SpecialDpsLoan;
use App\Models\SpecialInstallment;
use App\Models\SpecialLoanCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanPayment;
use App\Models\SpecialLoanTaken;
use App\Models\Transaction;
use App\Models\User;
use App\Models\SpecialDps;
use Illuminate\Http\Request;
use App\Models\SpecialDpsPackage;
use App\Http\Requests\SpecialDpsStoreRequest;
use App\Http\Requests\SpecialDpsUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpecialDpsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SpecialDps::class);

        $search = $request->get('search', '');
        $packages = SpecialDpsPackage::all();

        $allSpecialDps = SpecialDps::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.all_special_dps.index',
            compact('allSpecialDps', 'search','packages')
        );
    }

    public function specialDpsData(Request $request)
    {
        $columns = array(
            0=> 'account_no',
        );

        $totalData = SpecialDps::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = DB::table('special_dps')
                ->leftJoin('users as u','u.id','=','special_dps.user_id')
                ->leftJoin('users as c','c.id','=','special_dps.created_by')
                ->leftJoin('users as i','i.id','=','special_dps.introducer_id')
                ->leftJoin('special_dps_packages as p','p.id','=','special_dps.special_dps_package_id')
                ->select('special_dps.*','p.name as package','p.amount as package_amount','u.name as name','u.phone1','u.profile_photo_path','c.name as createdBy','i.name as introducer')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts = DB::table('special_dps')
                ->leftJoin('users as u','u.id','=','special_dps.user_id')
                ->leftJoin('users as c','c.id','=','special_dps.created_by')
                ->leftJoin('users as i','i.id','=','special_dps.introducer_id')
                ->leftJoin('special_dps_packages as p','p.id','=','special_dps.special_dps_package_id')
                ->select('special_dps.*','p.name as package','p.amount as package_amount','u.name as name','u.phone1','u.profile_photo_path','c.name as createdBy','i.name as introducer')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = DB::table('special_dps')
                ->leftJoin('users as u','u.id','=','special_dps.user_id')
                ->leftJoin('users as c','c.id','=','special_dps.created_by')
                ->leftJoin('users as i','i.id','=','special_dps.introducer_id')
                ->leftJoin('special_dps_packages as p','p.id','=','special_dps.special_dps_package_id')
                ->where('special_dps.account_no','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('special-dps.show',$post->id);
                $edit =  route('special-dps.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['date'] = $post->opening_date;
                $nestedData['balance'] = $post->balance;
                $nestedData['initial_amount'] = $post->initial_amount;
                $nestedData['package'] = $post->package.'-'.$post->package_amount;
                $nestedData['phone'] = $post->phone1;
                $nestedData['introducer'] = $post->introducer;
                $nestedData['createdBy'] = $post->createdBy;
                $nestedData['photo'] = $post->profile_photo_path;
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
        $this->authorize('create', SpecialDps::class);

        $users = User::all();
        $dpsPackages = SpecialDpsPackage::all();

        return view(
            'app.all_special_dps.create',
            compact('users', 'dpsPackages', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\SpecialDpsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', SpecialDps::class);
        $data = $request->all();
        $data['account_no'] = 'ML'.str_pad($request->account_no,4,"0",STR_PAD_LEFT);
        $data['balance'] = $request->initial_amount;
        $data['created_by'] = Auth::id();
        $specialDps = SpecialDps::create($data);
        $data['user_id'] = $request->nominee_user_id;
        Nominees::create($data);

        $cashin = CashIn::create([
            'user_id'                => $specialDps->user_id,
            'cashin_category_id'     => 2,
            'description'     => 'Special DPS initial deposit amount',
            'account_no'             => $specialDps->account_no,
            'special_dps_id' => $specialDps->id,
            'amount'                 => $specialDps->initial_amount,
            'trx_id'                 => TransactionController::trxId(),
            'date'                   => $specialDps->opening_date,
            'created_by'             => $specialDps->created_by
        ]);

        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dps = SpecialDps::find($id);
        $this->authorize('view', $dps);
        $collections = SpecialDpsCollection::where('special_dps_id',$dps->id)->get();
        return view('app.all_special_dps.show', compact('dps','collections'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SpecialDps $specialDps)
    {
        $this->authorize('update', $specialDps);

        $users = User::pluck('name', 'id');
        $specialDpsPackages = SpecialDpsPackage::pluck('name', 'id');

        return view(
            'app.all_special_dps.edit',
            compact('specialDps', 'users', 'specialDpsPackages', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\SpecialDpsUpdateRequest $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function update(
        SpecialDpsUpdateRequest $request,
        SpecialDps $specialDps
    ) {
        $this->authorize('update', $specialDps);

        $validated = $request->validated();

        $specialDps->update($validated);

        return redirect()
            ->route('all-special-dps.edit', $specialDps)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SpecialDps $specialDps
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specialDps = SpecialDps::find($id);
        $this->authorize('delete', $specialDps);
        $closing = ClosingAccount::where('dps_id',$specialDps->id)->first();
        $loan = DpsLoan::where('account_no',$specialDps->account_no)->first();
        $user = User::find($specialDps->user_id);
        $user->wallet = 0;
        $user->save();
        $withdrawAccount = Account::find(16);
        $depositAccount = Account::find(1);
        $cashAccount = Account::find(4);
        $loanProvideAccount = Account::find(2);
        $loanPaymentAccount = Account::find(13);
        $interestUnpaidAccount = Account::find(5);
        $interestUnpaidAccount1 = Account::find(8);
        $interestPaidAccount = Account::find(7);
        if ($loan)
        {

            $unpaidInterest = Transaction::where('account_id',5)->where('account_no',$specialDps->account_no)->sum('amount');
            $paidInterest = $loan->paid_interest;

            $cashAccount->balance -= $paidInterest;
            $cashAccount->save();

            $interestPaidAccount->balance -= $paidInterest;
            $interestPaidAccount->save();

            $interestUnpaidAccount->balance -= ($unpaidInterest - $paidInterest);
            $interestUnpaidAccount->save();
            $interestUnpaidAccount1->balance -= ($unpaidInterest - $paidInterest);
            $interestUnpaidAccount1->save();

            $cashAccount->balance += $loan->remain_loan;
            $cashAccount->save();
            $loanProvideAccount->balance -= $loan->remain_loan;
            $loanProvideAccount->save();
            $loanPaymentAccount->balance -= $loan->total_paid;
            $loanPaymentAccount->save();
        }

        $advanceAccount = Account::find(3);
        $advanceAdjustAccount = Account::find(14);
        $dueReturnAccount = Account::find(15);

        $dueReturn = Transaction::where('account_id',15)->where('account_no',$specialDps->account_no)->sum('amount');


        $dueReturnAccount->balance -= $dueReturn;
        $dueReturnAccount->save();



        if ($closing){
            $withdrawAccount->balance -= $closing->total;
            $withdrawAccount->save();
        }else {
            $depositAccount->balance -= $specialDps->balance;
            $depositAccount->save();

            $cashAccount->balance -= $specialDps->balance;
            $cashAccount->save();
        }
        $this->deleteAll($specialDps->account_no);
        $specialDps->delete();

        echo "success";
    }

    public function deleteAll($account_no)
    {
        CashIn::where('account_no',$account_no)->delete();
        Cashout::where('account_no',$account_no)->delete();
        Due::where('account_no',$account_no)->delete();
        SpecialDpsLoan::where('account_no',$account_no)->delete();
        SpecialLoanTaken::where('account_no',$account_no)->delete();
        SpecialLoanInterest::where('account_no',$account_no)->delete();
        Nominees::where('account_no',$account_no)->delete();
        Guarantor::where('account_no',$account_no)->delete();
        LoanDocuments::where('account_no',$account_no)->delete();
        SpecialDpsCollection::where('account_no',$account_no)->delete();
        SpecialLoanCollection::where('account_no',$account_no)->delete();
        SpecialLoanPayment::where('account_no',$account_no)->delete();
        SpecialInstallment::where('account_no',$account_no)->delete();
    }

    public function specialDpsInfoByAccount($account)
    {
        $savings = SpecialDps::where('account_no',$account)->first();
        $user = User::find($savings->user_id);
        $dps = Dps::where('user_id',$user->id)->count();
        $daily_savings = DailySavings::where('user_id',$user->id)->count();
        $special_dps = SpecialDps::where('user_id',$user->id)->count();
        $daily_loans = DailyLoan::where('user_id',$user->id)->count();
        $dps_loans = DpsLoan::where('user_id',$user->id)->count();
        $special_dps_loans = SpecialDpsLoan::where('user_id',$user->id)->count();

        $data['user'] = $user;
        $data['dps'] = $dps;
        $data['daily_savings'] = $daily_savings;
        $data['special_dps'] = $special_dps;
        $data['daily_loans'] = $daily_loans;
        $data['dps_loans'] = $dps_loans;
        $data['special_dps_loans'] = $special_dps_loans;
        return json_encode($data);
    }

    public function isExist($account)
    {
        $dps = SpecialDps::where('account_no',$account)->count();

        if ($dps>0)
        {
            return "yes";
        }else{
            return "no";
        }
    }

    public function resetDps($id)
    {
        $dps = SpecialDps::find($id);
        $closing = ClosingAccount::where('dps_id',$dps->id)->first();

        $user = User::find($dps->user_id);
        $user->wallet = 0;
        $user->save();

        $withdrawAccount = Account::find(16);
        $depositAccount = Account::find(1);
        $cashAccount = Account::find(4);

        Transaction::where('account_no',$dps->account_no)
            ->whereIn('account_id',[16,1])
            ->delete();

        Due::where('account_no',$dps->account_no)->delete();
        if ($closing){
            $withdrawAccount->balance -= $closing->total;
            $withdrawAccount->save();
        }else {
            $depositAccount->balance -= $dps->balance;
            $depositAccount->save();

            $cashAccount->balance -= $dps->balance;
            $cashAccount->save();
        }

        $dps->balance = $dps->initial_amount;
        $dps->save();
        $installments = SpecialInstallment::where('account_no',$dps->account_no)->where('dps_amount','>',0)->get();
        foreach ($installments as $installment)
        {
            $cashin = CashIn::where('cashin_category_id',2)->where('special_installment_id',$installment->id)->first();
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
            if ($installment->late_fee>0)
            {
                $installment->total -= $installment->late_fee;
                $installment->late_fee = NULL;
                $installment->save();
            }
            if ($installment->other_fee>0)
            {
                $installment->total -= $installment->other_fee;
                $installment->other_fee = NULL;
                $installment->save();
            }
            if ($installment->advance>0)
            {
                $installment->total -= $installment->advance;
                $installment->advance = NULL;
                $installment->save();
            }

            if ($installment->loan_installment == NULL && $installment->interest == NULL)
            {
                $installment->delete();
                $cashin->delete();
            }
        }
        SpecialDpsCollection::where('account_no',$dps->account_no)->delete();

        return 'success';
    }
}
