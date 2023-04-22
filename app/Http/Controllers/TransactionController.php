<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.transactions.index');
    }

    public function dataTransactions(Request $request)
    {
        //$totalData = Transaction::count();
        if (!empty($request->account_id) && !empty($request->from) && !empty($request->to))
        {
            $totalData = Transaction::whereBetween('date',[$request->from, $request->to])->where('account_id',$request->account_id)->count();
        }elseif (!empty($request->from) && !empty($request->to))
        {
            $totalData = Transaction::whereBetween('date',[$request->from, $request->to])->count();
        }elseif(!empty($request->account_id))
        {
            $totalData = Transaction::where('account_id',$request->account_id)->count();
        }else{
            $totalData = Transaction::count();
        }
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value')))
        {
            /*$posts = Transaction::with('account')->offset($start)
                ->limit($limit)
                ->orderBy('trx_id','desc')
                ->get();*/

            if (!empty($request->account_id) && !empty($request->from) && !empty($request->to))
            {
                $posts = Transaction::with('account')
                    ->whereBetween('date',[$request->from, $request->to])
                    ->where('account_id',$request->account_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('trx_id','desc')
                    ->get();

            }elseif (!empty($request->from) && !empty($request->to))
            {
                $posts = Transaction::with('account')
                    ->whereBetween('date',[$request->from, $request->to])
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('trx_id','desc')
                    ->get();
            }elseif(!empty($request->account_id))
            {
                $posts = Transaction::with('account')
                    ->where('account_id',$request->account_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('trx_id','desc')
                    ->get();
            }else{
                $posts = Transaction::with('account')->offset($start)
                    ->limit($limit)
                    ->orderBy('trx_id','desc')
                    ->get();
            }
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $trx = $post->trx_id??'';
                $nestedData['id'] = $post->id;
                $nestedData['account'] = '<strong>'.$post->account->name.'</strong><br>'.$post->description;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['name'] = $post->name;
                $nestedData['amount'] = $post->amount;
                $nestedData['trx_id'] = $post->trx_id;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function trxId($date)
    {
        $record = Transaction::latest('id')->first();
        $dateTime = new Carbon($date);
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uid = substr(str_shuffle($permitted_chars), 0, 6);
        if ($record) {
            $expNum = explode('-', $record->trx_id);
            if ($dateTime->format('jny') == $expNum[1]) {
                $s = str_pad($expNum[3]+1, 4, "0", STR_PAD_LEFT);
                $nextTxNumber = 'TRX-' . $expNum[1] .'-'.$uid. '-' . $s;
            } else {
                //increase 1 with last invoice number
                $nextTxNumber = 'TRX-' . $dateTime->format('jny') .'-'.$uid. '-0001';
            }
        } else {

            $nextTxNumber = 'TRX-' . $dateTime->format('jny') .'-'.$uid. '-0001';

        }

        return $nextTxNumber;
    }
}
