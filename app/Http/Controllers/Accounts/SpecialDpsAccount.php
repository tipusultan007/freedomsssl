<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SpecialDpsAccount extends Controller
{
  public static function create($data)
  {
    $account = Account::find(26);
    $account->balance += $data['dps_amount'];
    $account->save();

    $transaction = Transaction::create([
      'account_id' => 26,
      'trx_id' => $data['trx_id'],
      'date' => $data['date'],
      'amount' => $data['dps_amount'],
      'user_id' => $data['collector_id'],
      'account_no' => $data['account_no'],
      'name' => $data['name'],
      'type' => $data['trx_type']
    ]);
    switch ($transaction->type) {
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
    $transaction = Transaction::where('account_id', 26)->where('trx_id', $trxId)->first();
    if ($transaction) {
      $account = Account::find(26);
      $account->balance -= $transaction->amount;
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
}
