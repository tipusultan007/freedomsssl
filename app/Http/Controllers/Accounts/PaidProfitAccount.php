<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaidProfitAccount extends Controller
{
    public static function create($data)
    {
        switch ($data['profit_type'])
        {
            case "daily":
                $paid = Account::find(38);
                $paid->balance += $data['interest'];
                $paid->save();
                $unpaid = Account::find(43);
                $unpaid->balance -= $data['interest'];
                $unpaid->save();
                $transaction = Transaction::create([
                    'account_id' => 38,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['interest'],
                    'user_id' => $data['collector_id'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            case "dps":
                $account = Account::find(39);
                $account->balance += $data['interest'];
                $account->save();
                $transaction = Transaction::create([
                    'account_id' => 39,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['interest'],
                    'user_id' => $data['collector_id'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            case "special":
                $account = Account::find(40);
                $account->balance += $data['interest'];
                $account->save();
                $transaction = Transaction::create([
                    'account_id' => 40,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['interest'],
                    'user_id' => $data['collector_id'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            case "fdr":
                $account = Account::find(41);
                $account->balance += $data['profit'];
                $account->save();
                $unpaid = Account::find(42);
                $unpaid->balance -= $data['profit'];
                $unpaid->save();
                $transaction = Transaction::create([
                    'account_id' => 41,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['profit'],
                    'user_id' => $data['created_by'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            default:

        }


        switch ($transaction->type)
        {
            case "cash":
                $account = Account::find(5);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "bank":
                $account = Account::find(3);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "bkash":
                $account = Account::find(4);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "nagad":
                $account = Account::find(23);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            default:

        }
    }
    public static function delete($trxId,$type)
    {
        if($type=="daily") {
            $transaction = Transaction::where('account_id', 38)->where('trx_id', $trxId)->first();
            $paid = Account::find(38);
            $paid->balance -= $transaction->amount;
            $paid->save();
            $unpaid = Account::find(43);
            $unpaid->balance += $transaction->amount;
            $unpaid->save();
        }elseif ($type=="dps"){
            $transaction = Transaction::where('account_id', 39)->where('trx_id', $trxId)->first();
            $account = Account::find(39);
            $account->balance -= $transaction->amount;
            $account->save();
        }elseif($type=="special"){
            $transaction = Transaction::where('account_id', 40)->where('trx_id', $trxId)->first();
            $account = Account::find(40);
            $account->balance -= $transaction->amount;
            $account->save();
        }elseif ($type=="fdr"){
            $transaction = Transaction::where('account_id', 41)->where('trx_id', $trxId)->first();
            $paid = Account::find(41);
            $paid->balance -= $transaction->amount;
            $paid->save();
            $unpaid = Account::find(42);
            $unpaid->balance += $transaction->amount;
            $unpaid->save();
        }
        switch ($transaction->type)
        {
            case "cash":
                $account = Account::find(5);
                $account->balance += $transaction->amount;
                $account->save();
                break;
            case "bank":
                $account = Account::find(3);
                $account->balance += $transaction->amount;
                $account->save();
                break;
            case "bkash":
                $account = Account::find(4);
                $account->balance += $transaction->amount;
                $account->save();
                break;
            case "nagad":
                $account = Account::find(23);
                $account->balance += $transaction->amount;
                $account->save();
                break;
            default:

        }
        $transaction->delete();
    }
}
