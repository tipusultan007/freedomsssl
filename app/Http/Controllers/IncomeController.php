<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Requests\IncomeStoreRequest;
use App\Http\Requests\IncomeUpdateRequest;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', Income::class);

        $search = $request->get('search', '');

        $incomes = Income::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.incomes.index', compact('incomes', 'search'));
    }

    public function allIncomes(Request $request)
    {
        $totalData = Income::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if(empty($request->input('search.value')))
        {
            $posts = Income::with('incomeCategory')->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  Income::with('incomeCategory')->where('description','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered = Income::where('description','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('incomes.show',$post->id);
                $edit =  route('incomes.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['category'] = $post->incomeCategory->name??'-';
                $nestedData['description'] = $post->description??'';
                $nestedData['amount'] = $post->amount;
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
        //$this->authorize('create', Income::class);

        $incomeCategories = IncomeCategory::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('app.incomes.create', compact('incomeCategories', 'users'));
    }

    /**
     * @param \App\Http\Requests\IncomeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', Income::class);

        $data = $request->all();
        $data['manager_id'] = Auth::id();
        $income = Income::create($data);
        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Income $income)
    {
        //$this->authorize('view', $income);

        return view('app.incomes.show', compact('income'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Income $income)
    {
        //$this->authorize('update', $income);

        $incomeCategories = IncomeCategory::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.incomes.edit',
            compact('income', 'incomeCategories', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\IncomeUpdateRequest $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $income = Income::find($request->id);
        //$this->authorize('update', $income);

        $income->update($request->all());

        echo "sucess";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Income $income)
    {
        //$this->authorize('delete', $income);

        $income->delete();

        echo "success";
    }

    public function getIncomeById($id)
    {
        $income = Income::find($id);
        return json_encode($income);
    }
}
