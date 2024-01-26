<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AddProfit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DailySavings;
use App\Http\Requests\AddProfitStoreRequest;
use App\Http\Requests\AddProfitUpdateRequest;
use Illuminate\Support\Facades\Auth;

class AddProfitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $search = $request->get('search', '');

        $addProfits = AddProfit::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.add_profits.index', compact('addProfits', 'search'));
    }

    public function allProfits(Request $request)
    {
        $totalData = AddProfit::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if(empty($request->input('search.value')))
        {
            $posts = AddProfit::offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  AddProfit::where('account_no','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered = AddProfit::where('account_no','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['account_no'] = $post->account_no;
                $nestedData['profit'] = $post->profit;
                $nestedData['duration'] = $post->duration;
                $nestedData['before_profit'] = $post->before_profit;
                $nestedData['after_profit'] = $post->after_profit;
                $nestedData['date'] = date('d/m/Y',strtotime($post->date));
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

        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.add_profits.create',
            compact('allDailySavings', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\AddProfitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $from_date = date('d/m/Y',strtotime($request->from_date));
        $to_date = date('d/m/Y',strtotime($request->to_date));
        $data['duration'] = $from_date.' - '.$to_date;
        $data['manager_id'] = Auth::id();


        $savings = DailySavings::find($request->daily_savings_id);
        $data['user_id'] = $savings->user_id;
        $data['account_no'] = $savings->account_no;
        $data['before_profit'] = $savings->total;
        $addProfit = AddProfit::create($data);
        $savings->profit += $request->profit;
        $savings->total += $request->profit;
        $savings->save();
        $addProfit->after_profit = $savings->total;
        $addProfit->save();
        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AddProfit $addProfit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AddProfit $addProfit)
    {

        return view('app.add_profits.show', compact('addProfit'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AddProfit $addProfit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AddProfit $addProfit)
    {

        $allDailySavings = DailySavings::pluck('account_no', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.add_profits.edit',
            compact('addProfit', 'allDailySavings', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\AddProfitUpdateRequest $request
     * @param \App\Models\AddProfit $addProfit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $addProfit = AddProfit::find($request->id);

        $data = $request->all();
        $from_date = date('d/m/Y',strtotime($request->from_date));
        $to_date = date('d/m/Y',strtotime($request->to_date));
        $data['duration'] = $from_date.' - '.$to_date;
        $data['manager_id'] = Auth::id();

        $savings = DailySavings::find($request->daily_savings_id);
        $savings->profit -= $addProfit->profit;
        $savings->total -= $addProfit->profit;
        $savings->save();

        $data['user_id'] = $savings->user_id;
        $data['account_no'] = $savings->account_no;
        $data['before_profit'] = $savings->total;

        $savings->profit += $request->profit;
        $savings->total += $request->profit;
        $savings->save();
        $addProfit->update($data);
        $addProfit->after_profit = $savings->total;
        $addProfit->save();
        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AddProfit $addProfit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AddProfit $addProfit)
    {

        $savings = DailySavings::find($addProfit->daily_savings_id);
        $savings->profit -= $addProfit->profit;
        $savings->total -= $addProfit->profit;
        $savings->save();
        $addProfit->delete();

        echo "success";
       /* return redirect()
            ->route('add-profits.index')
            ->withSuccess(__('crud.common.removed'));*/
    }

    public function profitDetails($id)
    {
        $profit = AddProfit::where('daily_savings_id',$id)->latest()->first();
        $savings = DailySavings::find($id);
        $data = array();
        $data['profit'] = $profit;
        $data['savings'] = $savings;

        return json_encode($data);
    }

    public function getProfitById($id)
    {
        $profit = AddProfit::find($id);
        $durationText = str_replace(' ', '', $profit->duration);
        $duration = explode("-",$durationText);
        $from = Carbon::createFromFormat('d/m/Y',$duration[0]);
        $to = Carbon::createFromFormat('d/m/Y',$duration[1]);
        $from_date = $from->format('Y-m-d');
        $to_date = $to->format('Y-m-d');
        $date = new Carbon($profit->date);
        $data = array();

        $data['id'] = $profit->id;
        $data['daily_savings_id'] = $profit->daily_savings_id;
        $data['account_no'] = $profit->account_no;
        $data['profit'] = $profit->profit;
        $data['date'] = $date->format('Y-m-d');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        return json_encode($data);
    }
}
