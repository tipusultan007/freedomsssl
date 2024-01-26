<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DpsWithdrawAccount extends Controller
{
    public static function create($data)
    {
        $account = Account::find(9);
        $account->balance += $data['amount'];
        $account->save();
        $account = Account::find(6);
        $account->balance -= $data['dps_amount'];
        $account->save();

        $transaction = Transaction::create([
            'account_id' => 9,
            'trx_id' => $data['trx_id'],
            'date' => $data['date'],
            'amount' => $data['amount'],
            'user_id' => $data['collector_id'],
            'account_no' => $data['account_no'],
            'name' => $data['name'],
            'type' => $data['trx_type']
        ]);
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
    public static function delete($trxId)
    {
        $transaction = Transaction::where('account_id',9)->where('trx_id',$trxId)->first();
        if ($transaction) {
            $account = Account::find(9);
            $account->balance -= $transaction->amount;
            $account->save();

            $account = Account::find(6);
            $account->balance += $transaction->amount;
            $account->save();
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
            $transaction->delete();
        }
    }
    public static function update($trxId, $amount)
    {
        $transaction = Transaction::where('account_id',9)->where('trx_id',$trxId)->first();
        if ($transaction) {
            $account = Account::find(9);
            $account->balance -= $transaction->amount;
            $account->save();
            $account->balance += $amount;
            $account->save();

            $account = Account::find(6);
            $account->balance += $transaction->amount;
            $account->save();
            $account->balance -= $amount;
            $account->save();

            switch ($transaction->type) {
                case "cash":
                    $account = Account::find(5);
                    $account->balance += $transaction->amount;
                    $account->save();
                    $account->balance -= $amount;
                    $account->save();
                    break;
                case "bank":
                    $account = Account::find(3);
                    $account/*************************************************************************
* ADOBE CONFIDENTIAL
* ___________________
*
*  Copyright 2013 Adobe Systems Incorporated
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Adobe Systems Incorporated and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Adobe Systems Incorporated and its
* suppliers and are protected by all applicable intellectual property laws,
* including trade secret and or copyright laws.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Adobe Systems Incorporated.
**************************************************************************/

define({SEARCH_RESULTS_LABEL:"Výsledky vyhledávání pro dotaz <b><%= searchQuery %></b>",SEARCH_RES