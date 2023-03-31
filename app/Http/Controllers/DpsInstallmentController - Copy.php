<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\CashIn;
use App\Models\DpsCollection;
use App\Models\DpsLoanCollection;
use App\Models\Dps;
use App\Models\DpsLoanInterest;
use App\Models\LoanPayment;
use App\Models\TakenLoan;
use App\Models\User;
use App\Models\DpsLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DpsInstallment;
use App\Http\Requests\DpsInstallmentStoreRequest;
use App\Http\Requests\DpsInstallmentUpdateRequest;
use Illuminate\Support\Facades\Auth;


class DpsInstallmentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DpsInstallment::class);
        return view('app.dps_installments.index');
    }

    public function dataDpsInstallment(Request $request)
    {
        if (!empty($request->account) && !empty($request->collector) && !empty($request->from) && !empty($request->to)) {
            $totalData = DpsInstallment::where('account_no', $request->account)
                ->where('collector_id', $request->collector)
                ->whereBetween('date', [$request->from, $request->to])
                ->count();
        } elseif (!empty($request->from) && !empty($request->to)) {
            $totalData = DpsInstallment::whereBetween('date', [$request->from, $request->to])
                ->count();
        } elseif (!empty($request->account) && !empty($request->collector)) {
            $totalData = DpsInstallment::where('account_no', $request->account)
                ->where('collector_id', $request->collector)
                ->count();
        } elseif (!empty($request->account) && !empty($request->from) && !empty($request->to)) {
            $totalData = DpsInstallment::where('account_no', $request->account)
                ->whereBetween('date', [$request->from, $request->to])
                ->count();
        } elseif (!empty($request->collector) && !empty($request->from) && !empty($request->to)) {
            $totalData = DpsInstallment::where('collector_id', $request->collector)
                ->whereBetween('date', [$request->from, $request->to])
                ->count();
        } elseif (!empty($request->account)) {
            $totalData = DpsInstallment::where('account_no', $request->account)->count();
        } elseif (!empty($request->collector)) {
            $totalData = DpsInstallment::where('collector_id', $request->collector)
                ->whereBetween('date', [$request->from, $request->to])
                ->count();
        } else {
            $totalData = DpsInstallment::count();
        }
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {
            if (!empty($request->account) && !empty($request->collector) && !empty($request->from) && !empty($request->to)) {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->where('dps_installments.account_no', $request->account)
                    ->where('dps_installments.collector_id', $request->collector)
                    ->whereBetween('dps_installments.date', [$request->from, $request->to])
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif (!empty($request->from) && !empty($request->to)) {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->whereBetween('dps_installments.date', [$request->from, $request->to])
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif (!empty($request->account) && !empty($request->collector)) {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->where('dps_installments.account_no', $request->account)
                    ->where('dps_installments.collector_id', $request->collector)
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif (!empty($request->account) && !empty($request->from) && !empty($request->to)) {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->where('dps_installments.account_no', $request->account)
                    ->whereBetween('dps_installments.date', [$request->from, $request->to])
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif (!empty($request->collector) && !empty($request->from) && !empty($request->to)) {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->where('dps_installments.collector_id', $request->collector)
                    ->whereBetween('dps_installments.date', [$request->from, $request->to])
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif (!empty($request->account)) {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->where('dps_installments.account_no', $request->account)
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            } elseif (!empty($request->collector)) {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->where('dps_installments.collector_id', $request->collector)
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                    ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                    ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('id', 'desc')
                    ->get();
            }
        } else {
            $search = $request->input('search.value');

            $posts = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                ->where('dps_installments.account_no', 'LIKE', "%{$search}%")
                ->join('users as collector', 'collector.id', '=', 'dps_installments.collector_id')
                ->select('dps_installments.*', 'users.name', 'collector.name as c_name')
                ->orWhere('users.name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();

            $totalFiltered = DpsInstallment::join('users', 'users.id', '=', 'dps_installments.user_id')
                ->where('dps_installments.account_no', 'LIKE', "%{$search}%")
                ->orWhere('users.name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show = route('dps-installments.show', $post->id);
                $edit = route('dps-installments.edit', $post->id);

                $date                           = new Carbon($post->date);
                $nestedData['id']               = $post->id;
                $nestedData['dps_id']           = $post->dps_id;
                $nestedData['trx_id']           = $post->trx_id;
                $nestedData['interest']         = $post->interest;
                $nestedData['total']            = $post->total;
                $nestedData['dps_loan_id']      = $post->dps_loan_id;
                $nestedData['name']             = $post->name;
                $nestedData['account_no']       = $post->account_no;
                $nestedData['dps_amount']       = $post->dps_amount;
                $nestedData['loan_installment'] = $post->loan_installment;
                $nestedData['date']             = $date->format('d/m/Y');
                $nestedData['loan_late_fee']    = $post->loan_late_fee;
                $nestedData['loan_other_fee']   = $post->loan_other_fee;
                $nestedData['late_fee']         = $post->late_fee;
                $nestedData['other_fee']        = $post->other_fee;
                $nestedData['dps_balance']      = $post->dps_balance;
                $nestedData['loan_balance']     = $post->loan_balance;
                $nestedData['dps_note']         = $post->dps_note;
                $nestedData['loan_note']        = $post->loan_note;
                $nestedData['collector']        = $post->c_name;
                $nestedData['collection_id']    = $post->collection_id;
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', DpsInstallment::class);

        $users    = User::pluck('name', 'id');
        $allDps   = Dps::pluck('account_no', 'id');
        $dpsLoans = DpsLoan::pluck('account_no', 'id');

        return view(
            'app.dps_installments.create',
            compact('users', 'allDps', 'users', 'dpsLoans')
        );
    }

    /**
     * @param \App\Http\Requests\DpsInstallmentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', DpsInstallment::class);
        $data                 = $request->all();
        $data['collector_id'] = Auth::user()->id;
        $data['trx_id']       = $this->trxId();
        $installment          = DpsInstallment::create($data);

        $loan_taken_id         = array_key_exists("loan_taken_id", $data) ? $data['loan_taken_id'] : '';
        $interest_installments = array_key_exists("interest_installment", $data) ? $data['interest_installment'] : '';
        $taken_interest        = array_key_exists("taken_interest", $data) ? $data['taken_interest'] : '';

        if ($installment->dps_amount > 0) {
            $dps = Dps::find($installment->dps_id);
            if ($installment->dps_installments == 1) {
                $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
                if ($dpsCollections > 0) {
                    $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
                    $date->addMonths($dpsCollections);
                    $dps->balance += $installment->dps_amount;
                    $dps->save();
                    $dpsCollection = DpsCollection::create([
                        'account_no'         => $installment->account_no,
                        'user_id'            => $installment->user_id,
                        'dps_id'             => $installment->dps_id,
                        'dps_amount'         => $installment->dps_amount,
                        'balance'            => $dps->balance,
                        'month'              => $date->format('F'),
                        'year'               => $date->format('Y'),
                        'date'               => $installment->date,
                        'collector_id'       => $installment->collector_id,
                        'dps_installment_id' => $installment->id,
                    ]);
                } else {
                    $date         = Carbon::createFromFormat("Y-m-d", $dps->commencement);
                    $dps->balance = $installment->dps_amount;
                    $dps->save();
                    $dpsCollection = DpsCollection::create([
                        'account_no'         => $installment->account_no,
                        'user_id'            => $installment->user_id,
                        'dps_id'             => $installment->dps_id,
                        'dps_amount'         => $installment->dps_amount,
                        'balance'            => $dps->balance,
                        'month'              => $date->format('F'),
                        'year'               => $date->format('Y'),
                        'date'               => $installment->date,
                        'collector_id'       => $installment->collector_id,
                        'dps_installment_id' => $installment->id,
                    ]);
                }
            } else {
                for ($i = 1; $i <= $installment->dps_installments; $i++) {
                    $date           = Carbon::createFromFormat("Y-m-d", $dps->commencement);
                    $dps            = Dps::find($installment->dps_id);
                    $dpsCollections = DpsCollection::where('dps_id', $dps->id)->count();
                    if ($dpsCollections == 0) {
                        $dps->balance = $dps->package_amount;
                        $dps->save();
                        $dpsCollection = DpsCollection::create([
                            'account_no'         => $installment->account_no,
                            'user_id'            => $installment->user_id,
                            'dps_id'             => $installment->dps_id,
                            'dps_amount'         => $dps->package_amount,
                            'balance'            => $dps->balance,
                            'month'              => $date->format('F'),
                            'year'               => $date->format('Y'),
                            'date'               => $installment->date,
                            'collector_id'       => $installment->collector_id,
                            'dps_installment_id' => $installment->id,
                        ]);
                    } else {
                        $date = Carbon::createFromFormat("Y-m-d", $dps->commencement);
                        $date->addMonths($dpsCollections);

                        $dps->balance += $dps->package_amount;
                        $dps->save();
                        $dpsCollection = DpsCollection::create([
                            'account_no'         => $installment->account_no,
                            'user_id'            => $installment->user_id,
                            'dps_id'             => $installment->dps_id,
                            'dps_amount'         => $dps->package_amount,
                            'balance'            => $dps->balance,
                            'month'              => $date->format('F'),
                            'year'               => $date->format('Y'),
                            'date'               => $installment->date,
                            'collector_id'       => $installment->collector_id,
                            'dps_installment_id' => $installment->id,
                        ]);

                    }
                }
            }

            $installment->dps_balance = $dps->balance;
            $installment->save();
        }

        if ($installment->loan_installment > 0 || $installment->interest > 0) {
            $loan = DpsLoan::find($installment->dps_loan_id);

            if ($installment->loan_installment > 0) {
                $interestOld       = 0;
                $interestNew       = 0;
                $loan->remain_loan -= $installment->loan_installment;
                $loan->save();

                if ($data['total_loan_interest'] > 0 && $installment->interest == 0) {
                    $interestOld = Helpers::getInterest($installment->account_no, $installment->date, 'interest');
                }/*elseif ($data['total_loan_interest'] > 0 && $installment->interest > 0)
                {

                }*/

                $loanTakens      = TakenLoan::where('dps_loan_id', $loan->id)->orderBy('date', 'asc')->get();
                $loanTakenRemain = 0;
                foreach ($loanTakens as $key => $loanTaken) {
                    if ($key == 0) {
                        $loanTaken->remain -= $installment->loan_installment;
                        $loanTaken->save();
                        if ($loanTaken->remain < 0) {
                            $loanTakenRemain   = abs($loanTaken->remain);
                            $loanTaken->remain = 0;
                            $loanTaken->save();
                            $loanPayment = LoanPayment::create([
                                'taken_loan_id' => $loanTaken->id,
                                'dps_installment_id' => $installment->id,
                                'amount' => $installment->loan_installment - $loanTakenRemain,
                                'balance' => $loanTaken->remain,
                                'date' => $installment->date
                            ]);
                        }
                    } elseif ($loanTakenRemain > 0) {
                        $loanTaken->remain -= $loanTakenRemain;
                        $loanTaken->save();
                        if ($loanTaken->remain < 0) {
                            $loanPayment = LoanPayment::create([
                                'taken_loan_id' => $loanTaken->id,
                                'dps_installment_id' => $installment->id,
                                'amount' => $loanTakenRemain - abs($loanTaken->remain),
                                'balance' => $loanTaken->remain,
                                'date' => $installment->date
                            ]);
                            $loanTakenRemain   = abs($loanTaken->remain);
                            $loanTaken->remain = 0;
                            $loanTaken->save();

                        }
                    }
                }
                if ($data['total_loan_interest'] > 0 && $installment->interest == 0) {
                    $interestNew = Helpers::getInterest($installment->account_no, $installment->date, 'interest');
                }
                if ($data['total_loan_interest'] > 0 && $installment->interest == 0) {
                    $loan->dueInterest += abs($interestOld - $interestNew);
                    $loan->save();
                } elseif ($data['total_loan_interest'] > 0 && $installment->interest > 0) {
                    $loan->dueInterest += abs(abs($interestOld - $interestNew) - $installment->interest);
                    $loan->save();
                }

            }
            if ($installment->interest > 0) {
                foreach ($loan_taken_id as $key => $t) {
                    $taken_loan        = TakenLoan::find($t);
                    $dpsLoanInterests  = DpsLoanInterest::where('taken_loan_id', $t)->get();
                    $totalInstallments = $dpsLoanInterests->sum('installments');
                    if ($dpsLoanInterests->count() == 0) {
                        $l_date = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
                        if ($interest_installments[$key] > 1) {
                            $l_date->addMonthsNoOverflow($interest_installments[$key] - 1);
                        }
                        $dpsLoanInterest = DpsLoanInterest::create([
                            'taken_loan_id'      => $t,
                            'account_no'         => $taken_loan->account_no,
                            'installments'       => $interest_installments[$key],
                            'dps_installment_id' => $installment->id,
                            'interest'           => $taken_interest[$key],
                            'total'              => $taken_interest[$key] * $interest_installments[$key],
                            'month'              => $l_date->format('F'),
                            'year'               => $l_date->format('Y'),
                            'date'               => $installment->date
                        ]);
                    } else {
                        $l_date    = Carbon::createFromFormat('Y-m-d', $taken_loan->commencement);
                        $date_diff = $totalInstallments + $interest_installments[$key] - 1;
                        $l_date->addMonthsNoOverflow($date_diff);
                        $dpsLoanInterest = DpsLoanInterest::create([
                            'taken_loan_id'      => $t,
                            'account_no'         => $taken_loan->account_no,
                            'installments'       => $interest_installments[$key],
                            'dps_installment_id' => $installment->id,
                            'interest'           => $taken_interest[$key],
                            'total'              => $taken_interest[$key] * $interest_installments[$key],
                            'month'              => $l_date->format('F'),
                            'year'               => $l_date->format('Y'),
                            'date'               => $installment->date
                        ]);
                    }
                }
            }

            if ($installment->due_interest > 0) {
                $loan->dueInterest -= $installment->due_interest;
                $loan->save();
            }

            $dpsLoanCollection         = DpsLoanCollection::create([
                'account_no'         => $installment->account_no,
                'user_id'            => $installment->user_id,
                'dps_loan_id'        => $installment->dps_loan_id,
                'collector_id'       => $installment->collector_id,
                'dps_installment_id' => $installment->id,
                'trx_id'             => $installment->trx_id,
                'loan_installment'   => $installment->loan_installment,
                'balance'            => $loan->remain_loan,
                'interest'           => $installment->interest,
                'date'               => $installment->date,
                'receipt_no'         => $installment->receipt_no,
            ]);
            $installment->loan_balance = $loan->remain_loan;
            $installment->save();
        }
        if ($installment->advance > 0) {
            $user         = User::find($installment->user_id);
            $user->wallet += $installment->advance;
            $user->save();
        }
        if ($installment->advance_return > 0) {
            $user         = User::find($installment->user_id);
            $user->wallet -= $installment->advance_return;
            $user->save();
        }

        //$total_extra = $installment->late_fee + $installment->other_fee + $installment->loan_late_fee + $installment->loan_other_fee;
        //$installment->total = $total_extra + $installment->dps_amount + $installment->loan_installment + $installment->interest + $installment->advance + $installment->due_return + $installment->due_interest - $installment->grace;
        $installment->save();
        return redirect()->back();

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DpsInstallment $dpsInstallment)
    {
        $this->authorize('view', $dpsInstallment);

        return view('app.dps_installments.show', compact('dpsInstallment'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DpsInstallment $dpsInstallment)
    {
        $this->authorize('update', $dpsInstallment);

        $users    = User::pluck('name', 'id');
        $allDps   = Dps::pluck('account_no', 'id');
        $dpsLoans = DpsLoan::pluck('account_no', 'id');

        return view(
            'app.dps_installments.edit',
            compact('dpsInstallment', 'users', 'allDps', 'users', 'dpsLoans')
        );
    }

    /**
     * @param \App\Http\Requests\DpsInstallmentUpdateRequest $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function update(
        DpsInstallmentUpdateRequest $request,
        DpsInstallment              $dpsInstallment
    )
    {
        $this->authorize('update', $dpsInstallment);

        $validated = $request->validated();

        $dpsInstallment->update($validated);

        return redirect()
            ->route('dps-installments.edit', $dpsInstallment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DpsInstallment $dpsInstallment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dpsInstallment = DpsInstallment::find($id);
        $this->authorize('delete', $dpsInstallment);
        $dps = Dps::find($dpsInstallment->dps_id);
        $dps->balance -=$dpsInstallment->dps_amount;
        $dps->save();
        DpsCollection::where('dps_installment_id',$dpsInstallment->id)->delete();
        if ($dpsInstallment->loan_installment>0 || $dpsInstallment->interest>0)
        {
            if ($dpsInstallment->loan_installment>0)
            {

            }
        }
        $dpsInstallment->delete();

        /* return redirect()
             ->route('dps-installments.index')
             ->withSuccess(__('crud.common.removed'));*/
    }

    public function dataByAccount(Request $request)
    {
        $dps            = Helpers::getDueDps($request->account, $request->date);
        $loan           = DpsLoan::where('account_no', $request->account)->first();
        $loanCollection = '';
        if ($loan) {
            $loanCollection = DpsLoanCollection::where('dps_loan_id', $loan->id)->orderBy('date', 'desc')->first();
        }

        $data['user']                = $dps['user'];
        $data['dpsInfo']             = $dps['dpsInfo'];
        $data['dpsDue']              = $dps['dpsDue'];
        $data['loanInfo']            = $loan ? Helpers::getInterest($request->account, $request->date, '') : "";
        $data['loan']                = $loan ? $loan : "";
        $data['lastLoanPayment']     = $loanCollection ? $loanCollection->whereNotNull('loan_installment') : "null";
        $data['lastInterestPayment'] = $loanCollection ? $loanCollection->whereNotNull('interest') : "null";

        return json_encode($data);

    }

    public function trxId()
    {
        $record   = DpsInstallment::latest()->first();
        $dateTime = Carbon::now('Asia/Dhaka');

        if ($record) {

            $expNum = explode('-', $record->trx_id);

            if ($dateTime->format('dmY') == $expNum[1]) {
                $s            = str_pad($expNum[2] + 1, 5, "0", STR_PAD_LEFT);
                $nextTxNumber = 'DPS-' . $expNum[1] . '-' . $s;
            } else {
                //increase 1 with last invoice number
                $nextTxNumber = 'DPS-' . $dateTime->format('dmY') . '-00001';
            }
        } else {

            $nextTxNumber = 'DPS-' . $dateTime->format('dmY') . '-00001';

        }

        return $nextTxNumber;
    }

    public function getDpsCollectionData($id)
    {

    }
}
