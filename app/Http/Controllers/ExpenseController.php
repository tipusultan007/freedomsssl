<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('view-any', Expense::class);

        $search = $request->get('search', '');

        $expenses = Expense::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.expenses.index', compact('expenses', 'search'));
    }
    public function allExpenses(Request $request)
    {
        $totalData = Expense::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if(empty($request->input('search.value')))
        {
            $posts = Expense::with('expenseCategory')->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  Expense::with('expenseCategory')->where('description','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('date','desc')
                ->get();

            $totalFiltered = Expense::where('description','LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['category'] = $post->expenseCategory->name;
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
        //$this->authorize('create', Expense::class);

        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.expenses.create',
            compact('expenseCategories', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', Expense::class);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $income = Expense::create($data);
        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expense $expense)
    {
        //$this->authorize('view', $expense);

        return view('app.expenses.show', compact('expense'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Expense $expense)
    {
        //$this->authorize('update', $expense);

        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.expenses.edit',
            compact('expense', 'expenseCategories', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseUpdateRequest $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $expense = Expense::find($request->id);
        //$this->authorize('update', $expense);

        $expense->update($request->all());

        echo "success";
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Expense $expense)
    {
        //$this->authorize('delete', $expense);
        $expense->delete();
        echo "success";
    }

    public function getExpenseById($id)
    {
        $expense = Expense::find($id);
        return json_encode($expense);
    }
}
