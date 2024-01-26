<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Controllers\Accounts\PaidProfitAccount;
use App\Models\Account;
use App\Models\Cashout;
use App\Models\Fdr;
use App\Models\FdrDeposit;
use App\Models\ProfitCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\FdrProfit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\FdrProfitStoreRequest;
use App\Http\Requests\FdrProfitUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FdrProfitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', FdrProfit::class);

        $search = $request->get('search', '');

        $fdrProfits = FdrProfit::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.fdr_profits.index', compact('fdrProfits', 'search'));
    }

    public function allFdrProfits(Request $request)
    {
        $columns = array(
            1 =>'name',
            2=> 'account',
            3=> 'amount',
        );

        $totalData = FdrProfit::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        //$order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = FdrProfit::with('user','manager')->offset($start)
                ->limit($limit)
                ->orderBy('id','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  FdrProfit::with('user','manager')->where('account_no','LIKE',"%{$search}%")
                ->orWhereHas('users', function ($query) use ($search){
                  $query->where('name', 'LIKE',"%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy('id','desc')
                ->get();

            $totalFiltered =  FdrProfit::with('user')->where('account_no','LIKE',"%{$search}%")
              ->orWhereHas('users', function ($query) use ($search){
                $query->where('name', 'LIKE',"%{$search}%");
              })->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $fdrDeposit = FdrDeposit::find($post->fdr_deposit_id);
                $show =  route('fdr-profits.show',$post->id);
                $edit =  route('fdr-profits.edit',$post->id);

                $date = new Carbon($post->date);
                $nestedData['id'] = $post->id;
                $nestedData['fdr_id'] = $post->fdr_id;
                $nestedData['user_id'] = $post->user_id;
                $nestedData['phone'] = $post->user->phone1??'';
                $nestedData['account_no'] = $post->account_no;
                $nestedData['name'] = $post->user->name;
                $nestedData['grace'] = $post->grace;
                $nestedData['other_fee'] = $post->other_fee;
                $nestedData['created_by'] = $post->manager->name;
                $nestedData['profit'] = $post->profit;
                $nestedData['date'] = $date->format('d/m/Y');
                $nestedData['balance'] = $post->balance;
                $nestedData['trx_id'] = $post->trx_id;
                $nestedData['image'] = $post->user->image;
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
        //$this->authorize('create', FdrProfit::class);

        $users = User::pluck('name', 'id');
        $fdrs = Fdr::pluck('account_no', 'id');

        return view(
            'app.fdr_profits.create',
            compact('users', 'fdrs', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\FdrProfitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', FdrProfit::class);

        $data = $request->all();
        $profit_rates = $data['profit_rate'];
        $installments = $data['installments'];
        $fdr_deposit_id = $data['fdr_deposit_id'];
        //$fdrProfit = FdrProfit::create($data);
        $fdr = Fdr::find($data['fdr_id']);
        $fdr->profit += $data['profit'];
        $fdr->save();
        $data['user_id'] = $fdr->user_id;
        $data['account_no'] = $fdr->account_no;
        $data['manager_id'] = Auth::id();
        $data['balance'] = $fdr->balance;
        $fdrProfit = FdrProfit::create($data);


        foreach ($fdr_deposit_id as $key => $t) {
            if ($installments[$key] >0) {
                $taken_loan        = FdrDeposit::find($t);
                $dpsLoanInterests  = ProfitCollection::where('fdr_deposit_id', $t)->get();
                $totalInstallments = $dpsLoanInterests->sum('installments');
                if ($dpsLoanInterests->count() == 0) {
                    $l_date = new Carbon($taken_loan->commencement);
                    if ($installments[$key] > 1) {
                        $l_date->addMonthsNoOverflow($installments[$key] - 1);
                    }
                    $dpsLoanInterest = ProfitCollection::create([
                        'fdr_deposit_id' => $t,
                        'fdr_id'         => $data['fdr_id'],
                        'fdr_profit_id'         => $fdrProfit->id,
                        'account_no'     => $taken_loan->account_no,
                        'installments'   => $installments[$key],
                        'profit'         => $profit_rates[$key],
                        'total'          => $profit_rates[$key] * $installments[$key],
                        'month'          => $l_date->format('F'),
                        'year'           => $l_date->format('Y'),
                        'date'           => $fdrProfit->date
                    ]);
                    $taken_loan->profit +=$dpsLoanInterest->total;
                    $taken_loan->save();
                } else {
                    $l_date    = new Carbon($taken_loan->commencement);
                    $date_diff = $totalInstallments + $installments[$key] - 1;
                    $l_date->addMonthsNoOverflow($date_diff);
                    $dpsLoanInterest = ProfitCollection::create([
                        'fdr_deposit_id' => $t,
                        'fdr_id'         => $data['fdr_id'],
                        'fdr_profit_id'         => $fdrProfit->id,
                        'account_no'     => $taken_loan->account_no,
                        'installments'   => $installments[$key],
                        'profit'         => $profit_rates[$key],
                        'total'          => $profit_rates[$key] * $installments[$key],
                        'month'          => $l_date->format('F'),
                        'year'           => $l_date->format('Y'),
                        'date'           => $fdrProfit->date
                    ]);

                    $taken_loan->profit +=$dpsLoanInterest->total;
                    $taken_loan->save();
                }
            }
        }
        //$transaction = $this->accountTransaction($fdrProfit);
        echo json_encode($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrProfit $fdrProfit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FdrProfit $fdrProfit)
    {
        //$this->authorize('view', $fdrProfit);

        return view('app.fdr_profits.show', compact('fdrProfit'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrProfit $fdrProfit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FdrProfit $fdrProfit)
    {
        //$this->authorize('update', $fdrProfit);

        $users = User::pluck('name', 'id');
        $fdrs = Fdr::pluck('account_no', 'id');

        return view(
            'app.fdr_profits.edit',
            compact('fdrProfit', 'users', 'fdrs', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\FdrProfitUpdateRequest $request
     * @param \App\Models\FdrProfit $fdrProfit
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        FdrProfit $fdrProfit
    ) {
        //$this->authorize('update', $fdrProfit);

        $validated = $request->validated();

        $fdrProfit->update($validated);

        return redirect()
            ->route('fdr-profits.edit', $fdrProfit)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FdrProfit $fdrProfit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fdrProfit = FdrProfit::find($id);
        //$this->authorize('delete', $fdrProfit);
        $profitCollection = ProfitCollection::where('fdr_profit_id',$id)->get();
        foreach ($profitCollection as $profit)
        {

            $fdrDeposit = FdrDeposit::find($profit->fdr_deposit_id);
            $fdrDeposit->profit -=$profit->total;
            $fdrDeposit->save();
            $profit->delete();
        }
        $fdr = Fdr::find($fdrProfit->fdr_id);
        $fdr->profit -=$fdrProfit->profit;
        $fdr->save();
        $fdrProfit->delete();
        return response()->json(['message'=>'FDR মুনাফা উত্তোলন ডিলেট করা হয়েছে!']);
    }

    public function profitInfo(Request $request)
    {
        $data['profit_list'] = Helpers::getProfit($request->fdr_id,$request->date,'');
        $data['fdr'] = Fdr::with('user')->find($request->fdr_id);


        echo json_encode($data);
    }

    public function trxId()
    {
        $record   = FdrProfit::latest()->first();
        $dateTime = Carbon::now('Asia/Dhaka');

        if ($record) {

            $expNum = explode('-', $record->trx_id);

            if ($dateTime->format('jny') == $expNum[1]) {
                $s            = str_pad($expNum[2] + 1, 4, "0", STR_PAD_LEFT);
                $nextTxNumber = 'TRX-' . $expNum[1] . '-' . $s;
            } else {
                //increase 1 with last invoice number
                $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-0001';
            }
        } else {

            $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-0001';

        }

        return $nextTxNumber;
    }

    public function getProfitList($fdrProfitId)
    {
        $profitCollection = ProfitCollection::where('fdr_profit_id',$fdrProfitId)->get();

        return json_encode($profitCollection);
    }

    public function accountTransaction(FdrProfit $profit)
    {
        $data = $profit;
        $data['trx_type'] = 'cash';
        $data['profit_type'] = 'fdr';
        $data['name'] = $profit->user->name;
        PaidProfitAccount::create($data);
    }
}
