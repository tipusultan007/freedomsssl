<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DailyLoanPaymentAccount extends Controller
{
    public static function create($data)
    {
        $account = Account::find(11);
        $account->balance += $data['loan_installment'];
        $account->save();
        $account = Account::find(10);
        $account->balance -= $data['loan_installment'];
        $account->save();

        $transaction = Transaction::create([
            'account_id' => 11,
            'trx_id' => $data['trx_id'],
            'date' => $data['date'],
            'amount' => $data['loan_installment'],
            'user_id' => $data['created_by'],
            'account_no' => $data['account_no'],
            'name' => $data['name'],
            'type' => 'cash'
        ]);
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
    public static function delete($trxId)
    {
        $transaction = Transaction::where('account_id',11)->where('trx_id',$trxId)->first();
        if ($transaction) {
            $account = Account::find(11);
            $account->balance -= $transaction->amount;
            $account->save();

            $account = Account::find(10);
            $account->balance += $transaction->amount;
            $account->save();
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

    public static function update($trxId, $amount)
    {
        $transaction = Transaction::where('account_id',11)->where('trx_id',$trxId)->first();
        if ($transaction) {
            $account = Account::find(11);
            $account->balance -= $transaction->amount;
            $account->save();
            $account->balance += $amount;
            $account->save();

            $account = Account::find(10);
            $account->balance += $transaction->amount;
            $account->save();
            $account->balance -= $amount;
            $account->save();

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
