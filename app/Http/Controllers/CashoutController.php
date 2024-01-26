<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cashout;
use Illuminate\Http\Request;
use App\Models\CashoutCategory;
use App\Http\Requests\CashoutStoreRequest;
use App\Http\Requests\CashoutUpdateRequest;

class CashoutController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', Cashout::class);

        $breadcrumbs = [
            ['name' => 'List']
        ];

        return view('app.cashouts.index', compact('breadcrumbs'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function dataCashouts(Request $request)
    {
        $totalData = Cashout::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value')))
        {
            $posts = Cashout::with('cashoutCategory')->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  Cashout::with('cashoutCategory')->where('account_no','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered = Cashout::where('account_no','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $trx = $post->trx_id??'';
                $nestedData['id'] = $post->id;
                $nestedData['category'] = $post->cashoutCategory->name;
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

    public function cashoutByCategory(Request $request)
    {
        if (!empty($request->cashout_category_id) && !empty($request->from) && !empty($request->to))
        {
            $totalData = Cashout::whereBetween('date',[$request->from, $request->to])->where('cashout_category_id',$request->cashout_category_id)->count();
        }elseif (!empty($request->from) && !empty($request->to))
        {
            $totalData = Cashout::whereBetween('date',[$request->from, $request->to])->count();
        }elseif(!empty($request->cashout_category_id))
        {
            $totalData = Cashout::where('cashout_category_id',$request->cashout_category_id)->count();
        }else{
            $totalData = Cashout::count();
        }

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value')))
        {
            /*$posts = Cashout::with('cashoutCategory')
                ->whereBetween('date',[$request->from, $request->to])
                ->where('cashout_category_id',$request->cashout_category_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();*/
            if (!empty($request->cashout_category_id) && !empty($request->from) && !empty($request->to))
            {

                $posts = Cashout::with('cashoutCategory')
                    ->whereBetween('date',[$request->from, $request->to])
                    ->where('cashout_category_id',$request->cashout_category_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();

            }elseif (!empty($request->from) && !empty($request->to))
            {
                $posts = Cashout::with('cashoutCategory')
                    ->whereBetween('date',[$request->from, $request->to])
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();

            }elseif(!empty($request->cashout_category_id))
            {
                $posts = Cashout::with('cashoutCategory')
                    ->where('cashout_category_id',$request->cashout_category_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();
            }else{
                $posts = Cashout::with('cashoutCategory')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('date','desc')
                    ->get();
            }
        }
        else {
            $search = $request->input('search.value');

            $posts =  Cashout::with('cashoutCategory')
                ->whereBetween('date',[$request->from, $request->to])
                ->where('cashout_category_id',$request->cashout_category_id)
                ->where('account_no','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered = Cashout::where('cashin_category_id',$request->cashout_category_id)
                ->whereBetween('date',[$request->from, $request->to])
                ->where('account_no','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $trx = $post->trx_id??'';
                $nestedData['id'] = $post->id;
                $nestedData['category'] = $post->cashoutCategory->name;
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
    public function create(Request $request)
    {
        //$this->authorize('create', Cashout::class);

        $cashoutCategories = CashoutCategory::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.cashouts.create',
            compact('cashoutCategories', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\CashoutStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashoutStoreRequest $request)
    {
        //$this->authorize('create', Cashout::class);

        $validated = $request->validated();

        $cashout = Cashout::create($validated);

        return redirect()
            ->route('cashouts.edit', $cashout)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cashout $cashout
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Cashout $cashout)
    {
        //$this->authorize('view', $cashout);

        return view('app.cashouts.show', compact('cashout'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cashout $cashout
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Cashout $cashout)
    {
        //$this->authorize('update', $cashout);

        $cashoutCategories = CashoutCategory::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.cashouts.edit',
            compact('cashout', 'cashoutCategories', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\CashoutUpdateRequest $request
     * @param \App\Models\Cashout $cashout
     * @return \Illuminate\Http\Response
     */
    public function update(CashoutUpdateRequest $request, Cashout $cashout)
    {
        //$this->authorize('update', $cashout);

        $validated = $request->validated();

        $cashout->update($validated);

        return redirect()
            ->route('cashouts.edit', $cashout)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cashout $cashout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cashout $cashout)
    {
        //$this->authorize('delete', $cashout);

        $cashout->delete();

        return redirect()
            ->route('cashouts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
