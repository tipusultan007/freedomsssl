<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Accounts\FdrWithdrawAccount;
use App\Models\Account;
use App\Models\Cashout;
use App\Models\Fdr;
use App\Models\Transaction;
use App\Models\User;
use App\Models\FdrDeposit;
use App\Models\FdrWithdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\FdrWithdrawStoreRequest;
use App\Http\Requests\FdrWithdrawUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FdrWithdrawController extends Controller
{
  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //$this->authorize('view-any', FdrWithdraw::class);

    $breadcrumbs = [
      ['name' => 'List']
    ];
    $withdraws = FdrWithdraw::orderBy('date', 'asc')->get();
    $blank = [];
    /*foreach ($withdraws as $withdraw)
    {
        $fdrDeposit          = FdrDeposit::find($withdraw->fdr_deposit_id);
        if ($fdrDeposit) {
            $fdrDeposit->balance -= $withdraw->amount;
            $fdrDeposit->save();
            $fdr                = Fdr::find($withdraw->fdr_id);
            $fdr->balance -= $withdraw->amount;
            $fdr->save();

//                $withdraw->user_id = $fdrDeposit->user_id;
//                $withdraw->account_no = $fdrDeposit->account_no;
//                $withdraw->trx_id = Str::uuid();
            $withdraw->save();
//                $data = $withdraw;
//                $cashout = Cashout::create([
//                    'cashout_category_id' => 5,
//                    'account_no'          => $withdraw->account_no,
//                    'fdr_withdraw_id'     => $withdraw->id,
//                    'fdr_deposit_id'      => $withdraw->fdr_deposit_id,
//                    'amount'              => $withdraw->amount,
//                    'date'                => $withdraw->date,
//                    'created_by'          => $withdraw->created_by,
//                    'user_id'             => $withdraw->user_id,
//                    'trx_id' => $withdraw->trx_id
//                ]);
//                $data['name'] = $withdraw->user->name??'';
//                $data['trx_type'] = 'cash';
//                FdrWithdrawAccount::create($data);
        }else{
            $blank[] = $withdraw->fdr_deposit_id;
        }


    }*/

    //dd($blank);
    return view(
      'app.fdr_withdraws.index',
      compact('breadcrumbs')
    );
  }

  public function allFdrWithdraws(Request $request)
  {
    $columns = array(
      1 => 'name',
      2 => 'account',
      3 => 'amount',
    );

    $totalData = FdrWithdraw::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    //$order = $columns[$request->input('order.0.column')];
    // $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $posts = FdrWithdraw::with('user', 'manager')
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();
    } else {
      $search = $request->input('search.value');

      $posts = FdrWithdraw::with('user', 'manager')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy('account_no', 'asc')
        ->get();

      $totalFiltered = FdrWithdraw::with('user', 'manager')
        ->where('account_no', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = array();
    if (!empty($posts)) {
      foreach ($posts as $post) {
        $fdrDeposit = FdrDeposit::find($post->fdr_deposit_id);
        $show = route('fdr-withdraws.show', $post->id);
        $edit = route('fdr-withdraws.edit', $post->id);

        $commencement = new Carbon($post->commencement);
        $nestedData['id'] = $post->id;
        $nestedData['user_id'] = $post->user_id;
        $nestedData['phone'] = $post->user->phone1 ?? '';
        $nestedData['account_no'] = $post->account_no;
        $nestedData['name'] = $post->user->name;
        $nestedData['package'] = $fdrDeposit->fdrPackage->name??'-';
        $nestedData['created_by'] = $post->manager->name;
        $nestedData['amount'] = $post->amount;
        $nestedData['date'] = date('d/m/Y', strtotime($post->date));
        $nestedData['note'] = $post->note;
        $nestedData['image'] = $post->user->image;
        $nestedData['balance'] = $post->balance;
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
    //$this->authorize('create', FdrWithdraw::class);

    $users = User::pluck('name', 'id');
    $fdrs = Fdr::pluck('account_no', 'id');
    $fdrDeposits = FdrDeposit::pluck('account_no', 'id');

    return view(
      'app.fdr_withdraws.create',
      compact('users', 'fdrs', 'fdrDeposits', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\FdrWithdrawStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //$this->authorize('create', FdrWithdraw::class);

    $data = $request->all();
    $fdr = Fdr::find($request->fdr_id);
    $data['account_no'] = $fdr->account_no;
    $data['user_id'] = $fdr->user_id;
    $data['trx_id'] = Str::uuid();
    $data['manager_id'] = Auth::id();

    $fdr->balance -= $request->amount;
    $fdr->save();
    $fdrDeposit = FdrDeposit::find($request->fdr_deposit_id);
    $fdrDeposit->balance -= $request->amount;
    $fdrDeposit->save();
    $data['balance'] = $fdrDeposit->balance;
    $data['fdr_package_id'] = $fdrDeposit->fdr_package_id;
    $fdrWithdraw = FdrWithdraw::create($data);

    return "success";

    /*return redirect()
        ->route('fdr-withdraws.edit', $fdrWithdraw)
        ->withSuccess(__('crud.common.created'));*/
  }

  public function trxId($date)
  {
    $record = Transaction::latest('id')->first();
    $dateTime = new Carbon($date);
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $uid = substr(str_shuffle($permitted_chars), 0, 6);
    if ($record) {
      $expNum = explode('-', $record->trx_id);
      if ($dateTime->format('jny') == $expNum[1]) {
        $s = str_pad($expNum[3] + 1, 4, "0", STR_PAD_LEFT);
        $nextTxNumber = 'TRX-' . $expNum[1] . '-' . $uid . '-' . $s;
      } else {
        //increase 1 with last invoice number
        $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';
      }
    } else {

      $nextTxNumber = 'TRX-' . $dateTime->format('jny') . '-' . $uid . '-0001';

    }

    return $nextTxNumber;
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\FdrWithdraw $fdrWithdraw
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, FdrWithdraw $fdrWithdraw)
  {
    //$this->authorize('view', $fdrWithdraw);

    return view('app.fdr_withdraws.show', compact('fdrWithdraw'));
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\FdrWithdraw $fdrWithdraw
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, FdrWithdraw $fdrWithdraw)
  {
    //$this->authorize('update', $fdrWithdraw);

    $users = User::pluck('name', 'id');
    $fdrs = Fdr::pluck('account_no', 'id');
    $fdrDeposits = FdrDeposit::pluck('account_no', 'id');

    return view(
      'app.fdr_withdraws.edit',
      compact('fdrWithdraw', 'users', 'fdrs', 'fdrDeposits', 'users')
    );
  }

  /**
   * @param \App\Http\Requests\FdrWithdrawUpdateRequest $request
   * @param \App\Models\FdrWithdraw $fdrWithdraw
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, FdrWithdraw $fdrWithdraw)
  {
    //$this->authorize('update', $fdrWithdraw);

    $data = $request->all();

    $fdrWithdraw->fdr->balance += $data['old_amount'];
    $fdrWithdraw->fdr->save();

    $fdrWithdraw->fdrDeposit->balance += $data['old_amount'];
    $fdrWithdraw->fdrDeposit->save();

    $fdrWithdraw->update($data);
    $fdrWithdraw->fdr->balance -= $data['amount'];
    $fdrWithdraw->fdr->save();

    $fdrWithdraw->fdrDeposit->balance -= $data['amount'];
    $fdrWithdraw->fdrDeposit->save();

    $fdrWithdraw->balance = $fdrWithdraw->fdrDeposit->balance;
    $fdrWithdraw->save();

    return json_encode("success");
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\FdrWithdraw $fdrWithdraw
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $fdrWithdraw = FdrWithdraw::find($id);
    ////$this->authorize('delete', $fdrWithdraw);

    $fdrDeposit = FdrDeposit::find($fdrWithdraw->fdr_deposit_id);
    $fdrDeposit->balance += $fdrWithdraw->amount;
    $fdrDeposit->save();

    $fdr = Fdr::find($fdrWithdraw->fdr_id);
    $fdr->balance += $fdrWithdraw->amount;
    $fdr->save();

    //FdrWithdrawAccount::delete($fdrWithdraw->trx_id);
    /*$withdrawAccount = Account::find(16);
    $withdrawAccount->balance -= $fdrWithdraw->amount;
    $withdrawAccount->save();*/

    //Transaction::where('trx_id',$fdrWithdraw->trx_id)->delete();

    /*$depositAccount = Account::find(1); //LIABILITY (DEPOSIT +)
    $depositAccount->balance += $fdrWithdraw->amount;
    $depositAccount->save();

    $cashAccount = Account::find(4); //ASSET (CASH+)
    $cashAccount->balance += $fdrWithdraw->amount;
    $cashAccount->save();

    $fdr_deposit          = FdrDeposit::find($fdrWithdraw->fdr_deposit_id);
    $fdr_deposit->balance += $fdrWithdraw->amount;
    $fdr_deposit->save();*/
    Cashout::where('fdr_withdraw_id', $id)->delete();
    $fdrWithdraw->delete();

    /*return redirect()
        ->route('fdr-withdraws.index')
        ->withSuccess(__('crud.common.removed'));*/
  }

  public function accountTransaction(FdrWithdraw $withdraw)
  {
    $transaction = Transaction::create([
      'account_id' => 16,
      'description' => 'FDR withdraw',
      'trx_id' => $withdraw->trx_id,
      'date' => $withdraw->date,
      'amount' => $withdraw->amount,
      'user_id' => $withdraw->created_by,
      'account_no' => $withdraw->account_no,
      'name' => $withdraw->user->name
    ]);
    $withdrawAccount = Account::find(16); //LIABILITY (DEPOSIT -)
    $withdrawAccount->balance += $transaction->amount;
    $withdrawAccount->save();

    $depositAccount = Account::find(1); //LIABILITY (DEPOSIT -)
    $depositAccount->balance -= $transaction->amount;
    $depositAccount->save();

    $cashAccount = Account::find(4); //ASSET (CASH-)
    $cashAccount->balance -= $transaction->amount;
    $cashAccount->save();
  }

  public function getFdrWithdrawData($id)
  {
    $withdraw = FdrWithdraw::with('user', 'fdrDeposit.fdrPackage')->find($id);

    return json_encode($withdraw);
  }
}
