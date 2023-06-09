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
                $paid->balance += $data['profit'];
                $paid->save();
                $unpaid = Account::find(43);
                $unpaid->balance -= $data['profit'];
                $unpaid->save();
                $transaction = Transaction::create([
                    'account_id' => 38,
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
            case "dps":
                $account = Account::find(39);
                $account->balance += $data['profit'];
                $account->save();
                $transaction = Transaction::create([
                    'account_id' => 39,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['profit'],
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
            if ($transaction)
            {
                $paid = Account::find(38);
                $paid->balance -= $transaction->amount;
                $paid->save();
                $unpaid = Account::find(43);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();
            }

        }elseif ($type=="dps"){
            $transaction = Transaction::where('account_id', 39)->where('trx_id', $trxId)->first();

            if ($transaction)
            {
                $account = Account::find(39);
                $account->balance -= $transaction->amount;
                $account->save();
            }
        }elseif($type=="special"){
            $transaction = Transaction::where('account_id', 40)->where('trx_id', $trxId)->first();

            if ($transaction)
            {
                $account = Account::find(40);
                $account->balance -= $transaction->amount;
                $account->save();
            }
        }elseif ($type=="fdr"){
            $transaction = Transaction::where('account_id', 41)->where('trx_id', $trxId)->first();

            if ($transaction)
            {
                $paid = Account::find(41);
                $paid->balance -= $transaction->amount;
                $paid->save();
                $unpaid = Account::find(42);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();
            }
        }
        if ($transaction)
        {
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
    public static function update($trxId,$type, $amount)
    {
        if($type=="daily") {
            $transaction = Transaction::where('account_id', 38)->where('trx_id', $trxId)->first();
            if ($transaction)
            {
                $paid = Account::find(38);
                $paid->balance -= $transaction->amount;
                $paid->save();
                $paid->balance += $amount;
                $paid->save();
                $unpaid = Account::find(43);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();
                $unpaid->balance -= $amount;
                $unpaid->save();
            }

        }elseif ($type=="dps"){
            $transaction = Transaction::where('account_id', 39)->where('trx_id', $trxId)->first();

            if ($transaction)
            {
                $account = Account::find(39);
                $account->balance -= $transaction->amount;
                $account->save();
                $account->balance += $amount;
                $account->save();
            }
        }elseif($type=="special"){
            $transaction = Transaction::where('account_id', 40)->where('trx_id', $trxId)->first();

            if ($transaction)
            {
                $account = Account::find(40);
                $account->balance -= $transaction->amount;
                $account->save();
                $account->balance += $amount;
                $account->save();
            }
        }elseif ($type=="fdr"){
            $transaction = Transaction::where('account_id', 41)->where('trx_id', $trxId)->first();

            if ($transaction)
            {
                $paid = Account::find(41);
                $paid->balance -= $transaction->amount;
                $paid->save();
                $paid->balance += $amount;
                $paid->save();
                $unpaid = Account::find(42);
                $unpaid->balance += $transaction->amount;
                $unpaid->save();

                $unpaid->balance -= $amount;
                $unpaid->save();

            }
        }
        if ($transaction)
        {
            switch ($transaction->type)
            {
                case "cash":
                    $account = Account::find(5);
                    $account->balance += $transaction->amount;
                    $account->save();
                    $account->balance -= $amount;
                    $account->save();
                    break;
                case "bank":
                    $account = Account::find(3);
                    $account->balance += $transaction->amount;
                    $account->save();
                    $account->balance -= $amount;
                    $account->save();
                    break;
                case "bkash":
                    $account = Account::find(4);
                    $account->balance += $transaction->amount;
                    $account->save();
                    $account->balance -= $amount;
                    $account->save();
                    break;
                case "nagad":
                    $account = Account::find(23);
                    $account->balance += $transaction->amount;
                    $account->save();
                    $account->balance -= $amount;
                    $account->save();
                    break;
                default:

            }
            $transaction->amount = $amount;
            $transaction->save();
        }

    }
}
