<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CashAccount extends Controller
{
    public static function create($data)
    {
        $account = Account::find(5);
        $account->balance += $data->amount;
        $account->save();

        Transaction::create([
            'account_id' => 5,
            'trx_id' => $data->trx_id,
            'date' => $data->date,
            'amount' => $data->amount,
            'user_id' => $data->collector_id,
            'account_no' => $data->account_no,
            'name' => $data->name,
            'type' => $data->trx_type
        ]);
    }
    public static function delete($trxId)
    {
        $transaction = Transaction::where('account_id',5)->where('trx_id',$trxId)->first();
        $account = Account::find(5);
        $account->balance -= $transaction->amount;
        $account->save();
        $transaction->delete();
    }
}
