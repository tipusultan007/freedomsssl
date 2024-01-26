<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\User;
use App\Models\CashIn;
use Illuminate\Http\Request;
use App\Models\CashinCategory;
use App\Http\Requests\CashInStoreRequest;
use App\Http\Requests\CashInUpdateRequest;

class CashInController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // //$this->authorize('view-any', CashIn::class);

       /* DailyCollection::chunk(1000, function ($installments) {
            foreach ($installments as $dailyCollection) {
                switch ($dailyCollection->saving_type)
                {
                    case 'deposit':
                        $cashin = CashIn::create([
                            'user_id' => $dailyCollection->user_id,
                            'cashin_category_id' => 3,
                            'account_no' => $dailyCollection->account_no,
                            'daily_collection_id' => $dailyCollection->id,
                            'amount' => $dailyCollection->saving_amount,
                            'date' => $dailyCollection->date,
                            'created_by' => $dailyCollection->created_by,
                            'trx_id' => $dailyCollection->trx_id,
                        ]);
                        break;
                    case 'withdraw':
                        $cashout = Cashout::create([
                            'cashout_category_id' => 2,
                            'account_no' => $dailyCollection->account_no,
                            'daily_collection_id' => $dailyCollection->id,
                            'amount' => $dailyCollection->saving_amount,
                            'date' => $dailyCollection->date,
                            'created_by' => $dailyCollection->created_by,
                            'user_id' => $dailyCollection->user_id,
                            'trx_id' => $dailyCollection->trx_id,
                        ]);
                        break;

                    default:
                }
            }
        });*/

        $breadcrumbs = [
            ['name' => 'List']
        ];
        return view('app.cash_ins.index', compact('breadcrumbs'));
    }

    public function dataCashins(Request $request)
    {
        $totalData = CashIn::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value')))
        {
            $posts = CashIn::with('cashinCategory')->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  CashIn::with('cashinCategory')->where('account_no','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered = CashIn::where('account_no','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $trx = $post->trx_id??'';
                $nestedData['id'] = $post->id;
                $nestedData['category'] = $post->cashinCategory->name;
                $nestedData['account_no'] = '<strong>'.$post->account_no.'</strong><br>'.$post->user->name;
                $nestedData['amount'] = $post->amount;
                $nestedData['trx_id'] = $post->trx_id??'';
                $nestedData['date'] = date('d M Y',strtotime($post->date));
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

    public function cashinByCategory(Request $request)
    {
        if (!empty($request->cashin_category_id) && !empty($request->from) && !empty($request->to))
        {
            $totalData = CashIn::whereBetween('date',[$request->from, $request->to])->where('cashin_category_id',$request->cashin_category_id)->count();
        }elseif (!empty($request->from) && !empty($request->to))
        {
            $totalData = CashIn::whereBetween('date',[$request->from, $request->to])->count();
        }elseif(!empty($request->cashin_category_id))
        {
            $totalData = CashIn::where('cashin_category_id',$request->cashin_category_id)->count();
        }else{
            $totalData = CashIn::count();
        }
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value')))
        {
            /*$posts = CashIn::with('cashinCategory')
                ->whereBetween('date',[$request->from, $request->to])
                ->where('cashin_category_id',$request->cashin_category_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();*/
            if (!empty($request->cashin_category_id) && !empty($request->from) && !empty($request->to))
            {

                $posts = CashIn::with('cashinCategory')
                    ->whereBetween('date',[$request->from, $request->to])
                    ->where('cashin_category_id',$request->cashin_category_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();

            }elseif (!empty($request->from) && !empty($request->to))
            {
                $posts = CashIn::with('cashinCategory')
                    ->whereBetween('date',[$request->from, $request->to])
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();

            }elseif(!empty($request->cashin_category_id))
            {
                $posts = CashIn::with('cashinCategory')
                    ->where('cashin_category_id',$request->cashin_category_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();
            }else{
                $posts = CashIn::with('cashinCategory')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();
            }
        }
        else {
            $search = $request->input('search.value');

            $posts =  CashIn::with('cashinCategory')
                ->where('account_no','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered = CashIn::where('account_no','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $trx = $post->trx_id??'';
                $nestedData['id'] = $post->id;
                $nestedData['category'] = $post->cashinCategory->name;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['name'] = $post->user->name;
                $nestedData['amount'] = $post->amount;
                $nestedData['trx_id'] = $post->trx_id??'';
                $nestedData['date'] = date('d M Y',strtotime($post->date));
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
     //  //$this->authorize('create', CashIn::class);

        $users = User::pluck('name', 'id');
        $cashinCategories = CashinCategory::pluck('name', 'id');

        return view(
            'app.cash_ins.create',
            compact('users', 'cashinCategories', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\CashInStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashInStoreRequest $request)
    {
       // //$this->authorize('create', CashIn::class);

        $validated = $request->validated();

        $cashIn = CashIn::create($validated);

        return redirect()
            ->route('cash-ins.edit', $cashIn)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashIn $cashIn
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashIn $cashIn)
    {
        ////$this->authorize('view', $cashIn);

        return view('app.cash_ins.show', compact('cashIn'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashIn $cashIn
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CashIn $cashIn)
    {
       // //$this->authorize('update', $cashIn);

        $users = User::pluck('name', 'id');
        $cashinCategories = CashinCategory::pluck('name', 'id');

        return view(
            'app.cash_ins.edit',
            compact('cashIn', 'users', 'cashinCategories', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\CashInUpdateRequest $request
     * @param \App\Models\CashIn $cashIn
     * @return \Illuminate\Http\Response
     */
    public function update(CashInUpdateRequest $request, CashIn $cashIn)
    {
       // //$this->authorize('update', $cashIn);

        $validated = $request->validated();

        $cashIn->update($validated);

        return redirect()
            ->route('cash-ins.edit', $cashIn)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashIn $cashIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CashIn $cashIn)
    {
       // //$this->authorize('delete', $cashIn);

        $cashIn->delete();

        return redirect()
            ->route('cash-ins.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
