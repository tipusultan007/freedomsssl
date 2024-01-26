<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaidInterestAccount extends Controller
{
    public static function create($data)
    {

        switch ($data['interest_type'])
        {
            case "daily":
                $paid = Account::find(32);
                $paid->balance += $data['interest'];
                $paid->save();

                $transaction = Transaction::create([
                    'account_id' => 32,
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
                $account = Account::find(33);
                $account->balance += $data['interest'];
                $account->save();
                $unpaid = Account::find(36);
                $unpaid->balance -= $data['interest'];
                $unpaid->save();
                $transaction = Transaction::create([
                    'account_id' => 33,
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
                $account = Account::find(34);
                $account->balance += $data['interest'];
                $account->save();
                $unpaid = Account::find(37);
                $unpaid->balance -= $data['interest'];
                $unpaid->save();
                $transaction = Transaction::create([
                    'account_id' => 34,
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
            default:

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
    }
    public static function delete($trxId,$type)
    {
        if($type=="daily") {
            $transaction = Transaction::where('account_id', 32)->where('trx_id', $trxId)->first();
            if ($transaction) {
                $paid = Account::find(32);
                $paid->balance -= $transaction->amount;
                $paid->save();
            }

        }elseif ($type=="dps"){
            $transaction = Transaction::where('account_id', 33)->where('trx_id', $trxId)->first();
            if ($transaction) {
                $account = Account::find(33);
                $account->balance -= $transaction->amount;
                $account->save();
                $unpaid = Account::find(36);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();
            }
        }else{
            $transaction = Transaction::where('account_id', 34)->where('trx_id', $trxId)->first();
            if ($transaction) {
                $account = Account::find(34);
                $account->balance -= $transaction->amount;
                $account->save();
                $unpaid = Account::find(37);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();
            }
        }

        if ($transaction) {
            switch ($transaction->type) {
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
            $transaction->delete();
        }
    }
    public static function update($trxId,$type,$amount)
    {
        if($type=="daily") {
            $transaction = Transaction::where('account_id', 32)->where('trx_id', $trxId)->first();
            if ($transaction) {
                $paid = Account::find(32);
                $paid->balance -= $transaction->amount;
                $paid->save();
                $paid->balance += $amount;
                $paid->save();
            }

        }elseif ($type=="dps"){
            $transaction = Transaction::where('account_id', 33)->where('trx_id', $trxId)->first();
            if ($transaction) {
                $account = Account::find(33);
                $account->balance -= $transaction->amount;
                $account->save();

                $unpaid = Account::find(36);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();

                $account->balance += $amount;
                $account->save();
                $unpaid->balance -= $amount;
                $unpaid->save();
            }
        }else if ($type=="special"){
            $transaction = Transaction::where('account_id', 34)->where('trx_id', $trxId)->first();
            if ($transaction) {
                $account = Account::find(34);
                $account->balance -= $transaction->amount;
                $account->save();
                $unpaid = Account::find(37);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();

                $account->balance += $amount;
                $account->save();
                $unpaid->balance -= $amount;
                $unpaid->save();
            }
        }

        if ($transaction) {
            switch ($transaction->type) {
                case "cash":
                    $account = Account::find(5);
                    $account->balance -= $transaction->amount;
                    $account->save();
                    $account->balance += $amount;
                    $account->save();
                    break;
                case "bank":
                    $account = Account::find(3);
                    $account->balance -= $transaction->amount;
                    $account->save();
                    $account->balance += $amount;
                    $account->save();
                    break;
                case "bkash":
                    $account = Account::find(4);
                    $account->balance -= $transaction->amount;
                    $account->save();
                    $account->balance += $amount;
                    $account->save();
                    break;
                case "nagad":
                    $account = Account::find(23);
                    $account->balance -= $transaction->amount;
                    $account->save();
                    $account->balance += $amount;
                    $account->save();
                    break;
                default:

            }
            $transaction->amount = $amount;
            $transaction->save();
        }
    }
}
