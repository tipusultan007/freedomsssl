<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use App\Http\Requests\DpsStoreRequest;
use App\Http\Requests\DpsUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DpsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Dps::class);

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
        //$order = $columns[$request->input('order.0.column')];
        //$dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = Dps::leftJoin('users as u', 'u.id', '=', 'dps.user_id')
                ->leftJoin('users as c', 'c.id', '=', 'dps.created_by')
                ->leftJoin('users as i', 'i.id', '=', 'dps.introducer_id')
                ->leftJoin('dps_packages as p', 'p.id', '=', 'dps.dps_package_id')
                ->select('dps.*', 'p.name as package', 'u.name as name', 'u.phone1', 'u.profile_photo_path', 'c.name as createdBy', 'i.name as introducer')
                ->offset($start)
                ->limit($limit)
                ->orderBy('dps.account_no', 'asc')
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = Dps::leftJoin('users as u', 'u.id', '=', 'dps.user_id')
                ->leftJoin('users as c', 'c.id', '=', 'dps.created_by')
                ->leftJoin('users as i', 'i.id', '=', 'dps.introducer_id')
                ->leftJoin('dps_packages as p', 'p.id', '=', 'dps.dps_package_id')->select('dps.*', 'p.name as package', 'u.name as name', 'u.phone1', 'u.profile_photo_path', 'c.name as createdBy', 'i.name as introducer')
                ->where('dps.account_no', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('dps.account_no', 'asc')
                ->get();

            $totalFiltered = Dps::leftJoin('users as u', 'u.id', '=', 'dps.user_id')
                ->leftJoin('users as c', 'c.id', '=', 'dps.created_by')
                ->leftJoin('users as i', 'i.id', '=', 'dps.introducer_id')
                ->leftJoin('dps_packages as p', 'p.id', '=', 'dps.dps_package_id')
                ->where('dps.account_no', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show = route('all-dps.show', $post->id);
                $edit = route('all-dps.edit', $post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['user_id'] = $post->user_id;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['date'] = $post->opening_date;
                $nestedData['balance'] = $post->balance;
                $nestedData['package'] = $post->package;
                $nestedData['phone'] = $post->phone1;
                $nestedData['introducer'] = $post->introducer;
                $nestedData['createdBy'] = $post->createdBy;
                $nestedData['photo'] = $post->profile_photo_path;
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
        $this->authorize('create', Dps::class);

        $users = User::all();
        $dpsPackages = DpsPackage::all();

        return view(
            'app.all_dps.create',
            compact('users', 'dpsPackages', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\DpsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Dps::class);
        $data = $request->all();
        $data['account_no'] = 'DPS' . str_pad($request->account_no, 4, "0", STR_PAD_LEFT);
        $data['balance'] = 0;

        $data['created_by'] = Auth::id();
        $dps = Dps::create($data);
        $data['user_id'] = $request->nominee_user_id;
        Nominees::create($data);
        echo 'success';

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dps = Dps::find($id);
        $this->authorize('view', $dps);

        $collections = DpsCollection::where('dps_id', $dps->id)->get();
        $breadcrumbs = [
            ['link' => "/all-dps", 'name' => "DPS"], ['link' => "javascript:void(0)", 'name' => "Details"], ['name' => $dps->account_no]
        ];

        return view('app.all_dps.show', compact('dps', 'collections', 'breadcrumbs'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Dps $dps)
    {
        $this->authorize('update', $dps);

        $users = User::pluck('name', 'id');
        $dpsPackages = DpsPackage::pluck('name', 'id');

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
    public function update(DpsUpdateRequest $request, Dps $dps)
    {
        $this->authorize('update', $dps);

        $validated = $request->validated();

        $dps->update($validated);

        return redirect()
            ->route('all-dps.edit', $dps)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dps $dps
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dps = Dps::find($id);
        $this->authorize('delete', $dps);

        $closing = ClosingAccount::where('dps_id', $dps->id)->first();
        $loan = DpsLoan::where('account_no', $dps->account_no)->first();
        $user = User::find($dps->user_id);
        $user->wallet = 0;
        $user->save();

        $depositAccount = Account::find(1);
        $loanProvideAccount = Account::find(2);
        $advanceAccount = Account::find(3);
        $cashAccount = Account::find(4);
        $interestUnpaidAccount = Account::find(5);
        $interestPaidAccount = Account::find(7);
        $interestUnpaidAccount1 = Account::find(8);
        $loanPaymentAccount = Account::find(13);
        $advanceAdjustAccount = Account::find(14);
        $dueReturnAccount = Account::find(15);
        $withdrawAccount = Account::find(16);

        $dueReturn = Transaction::where('account_id', 15)->where('account_no', $dps->account_no)->sum('amount');
        if ($loan) {
            $unpaidInterest = Transaction::where('account_id', 5)->where('account_no', $dps->account_no)->sum('amount');
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

        $dueReturnAccount->balance -= $dueReturn;
        $dueReturnAccount->save();


        if ($closing) {
            $withdrawAccount->balance -= $closing->total;
            $withdrawAccount->save();
        } else {
            $depositAccount->balance -= $dps->balance;
            $depositAccount->save();

            $cashAccount->balance -= $dps->balance;
            $cashAccount->save();
        }
        $this->deleteAll($dps->account_no);
        Transaction::whereIn('account_id',[1,2,3,4,5,7,8,13,14,15,16,18,19,20])->where('account_no',$dps->account_no)->delete();
        $dps->delete();
        echo "success";
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
        $dps = Dps::where('user_id', $user->id)->count();
        $daily_savings = DailySavings::where('user_id', $user->id)->count();
        $special_dps = SpecialDps::where('user_id', $user->id)->count();
        $daily_loans = DailyLoan::where('user_id', $user->id)->count();
        $dps_loans = DpsLoan::where('user_id', $user->id)->count();
        $special_dps_loans = SpecialDpsLoan::where('user_id', $user->id)->count();

        $data['user'] = $user;
        $data['dps'] = $dps;
        $data['daily_savings'] = $daily_savings;
        $data['special_dps'] = $special_dps;
        $data['daily_loans'] = $daily_loans;
        $data['dps_loans'] = $dps_loans;
        $data['special_dps_loans'] = $special_dps_loans;
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
}
