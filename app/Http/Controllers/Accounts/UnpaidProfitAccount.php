<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class UnpaidProfitAccount extends Controller
{
    public static function create($data)
    {
        $account = Account::find(30);
        $account->balance += $data->amount;
        $account->save();

        $transaction = Transaction::create([
            'account_id' => 30,
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
        $transaction = Transaction::where('account_id',30)->where('trx_id',$trxId)->first();
        $account = Account::find(30);
        $account->balance -= $transaction->amount;
        $account->save();
        $transaction->delete();

        switch ($transaction->type)
        {
            case "cash":
                $cashAccount = Account::find(5);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "bank":
                $cashAccount = Account::find(3);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "bkash":
                $cashAccount = Account::find(4);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "nagad":
                $cashAccount = Account::find(23);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            default:

        }
    }
}
