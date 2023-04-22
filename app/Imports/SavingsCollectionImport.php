<?php

namespace App\Imports;

use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\DailyWithdrawAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Http\Controllers\Accounts\SavingsAccount;
use App\Http\Controllers\TransactionController;
use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\DailySavings;
use App\Models\SavingsCollection;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class SavingsCollectionImport implements ToModel,WithHeadingRow,WithBatchInserts, WithChunkReading
{
    use Importable;
    public $number = 1;

    public function model(array $row)
    {
        $dailySavings = DailySavings::where('account_no',$row['account_no'])->first();
        $trx_id = $this->trxId($row['date'], $this->number);
        $dailyCollection = DailyCollection::create([
            'account_no' => $row['account_no'],
            'user_id' => $dailySavings->user_id,
            'collector_id' => Auth::id(),
            'trx_id' => $trx_id,
            'created_by' => Auth::id(),
            'saving_amount' => $row['saving_amount'],
            'saving_type' => $row['type'],
            'daily_savings_id' => $dailySavings->id,
            'savings_balance' => 0,
            'date' => $row['date'],
            'collection_date' => $row['collection_date']
        ]);
        $trx = explode('-', $dailyCollection->trx_id);
        $this->number = $trx[3]+1;

        if ($dailyCollection->saving_amount>0)
        {
            $dailySavings = DailySavings::find($dailyCollection->daily_savings_id);
            $data = [];
            $data['date'] = $dailyCollection->date;
            $data['saving_amount'] = $dailyCollection->saving_amount;
            $data['created_by'] = $dailyCollection->created_by;
            $data['account_no'] = $dailyCollection->account_no;
            $data['name'] = $dailyCollection->user->name;
            $data['trx_type'] = 'cash';
            $data['trx_id'] = $dailyCollection->trx_id;

            if ($dailyCollection->saving_type == 'deposit') {
                $dailySavings->deposit += $dailyCollection->saving_amount;
                $dailySavings->total += $dailyCollection->saving_amount;
                $dailySavings->save();
                SavingsAccount::create($data);
                $cashin = CashIn::create([
                    'user_id' => $dailyCollection->user_id,
                    'cashin_category_id' => 3,
                    'account_no' => $dailyCollection->account_no,
                    'daily_collection_id' => $dailyCollection->id,
                    'amount' => $dailyCollection->saving_amount,
                    'date' => $dailyCollection->date,
                    'created_by' => $dailyCollection->created_by,
                    'trx_id' => $dailyCollection->trx_id,
                ]);
            } elseif ($dailyCollection->saving_type == 'withdraw') {
                $dailySavings->withdraw += $dailyCollection->saving_amount;
                $dailySavings->total -= $dailyCollection->saving_amount;
                $dailySavings->save();
                DailyWithdrawAccount::create($data);
                $cashout = Cashout::create([
                    'cashout_category_id' => 2,
                    'account_no' => $dailyCollection->account_no,
                    'daily_collection_id' => $dailyCollection->id,
                    'amount' => $dailyCollection->saving_amount,
                    'date' => $dailyCollection->date,
                    'created_by' => $dailyCollection->created_by,
                    'user_id' => $dailyCollection->user_id,
                    'trx_id' => $dailyCollection->trx_id,
                ]);

            }
            $savingsCollection = SavingsCollection::create([
                'account_no' => $dailyCollection->account_no,
                'daily_savings_id' => $dailyCollection->daily_savings_id,
                'saving_amount' => $dailyCollection->saving_amount,
                'type' => $dailyCollection->saving_type,
                'collector_id' => $dailyCollection->collector_id,
                'date' => $dailyCollection->date,
                'late_fee' => $dailyCollection->late_fee,
                'other_fee' => $dailyCollection->other_fee,
                'balance' => $dailySavings->total,
                'user_id' => $dailyCollection->user_id,
                'collection_id' => $dailyCollection->id,
                'created_by' => $dailyCollection->created_by,
                'trx_id' => $dailyCollection->trx_id,
            ]);
            $dailyCollection->savings_balance = $dailySavings->total;
            $dailyCollection->save();
        }
        if ($dailyCollection->loan_installment>0)
        {
            $dailyLoan = DailyLoan::find($dailyCollection->daily_loan_id);
            $data = $dailyCollection;
            $data['name'] = $dailyCollection->user->name;
            DailyLoanPaymentAccount::create($data);
            if ($dailyCollection->loan_late_fee>0)
            {
                $data['late_fee'] = $dailyCollection->loan_late_fee;
                LateFeeAccount::create($data);
            }
            if ($dailyCollection->loan_other_fee>0)
            {
                $data['other_fee'] = $dailyCollection->loan_other_fee;
                OtherFeeAccount::create($data);
            }
            $cashin = CashIn::create([
                'user_id' => $dailyCollection->user_id,
                'cashin_category_id' => 4,
                'account_no' => $dailyCollection->account_no,
                'daily_collection_id' => $dailyCollection->id,
                'amount' => $dailyCollection->loan_installment + $dailyCollection->loan_other_fee + $dailyCollection->loan_late_fee,
                'date' => $dailyCollection->date,
                'created_by' => $dailyCollection->created_by,
                'trx_id' => $dailyCollection->trx_id
            ]);
            $loanCollection = DailyLoanCollection::create([
                'account_no' => $dailyCollection->account_no,
                'daily_loan_id' => $dailyCollection->daily_loan_id,
                'loan_installment' => $dailyCollection->loan_installment,
                'collector_id' => $dailyCollection->collector_id,
                'date' => $dailyCollection->date,
                'loan_late_fee' => $dailyCollection->loan_late_fee ,
                'loan_other_fee' => $dailyCollection->loan_other_fee,
                'loan_balance' => 0,
                'user_id' => $dailyCollection->user_id,
                'collection_id' => $dailyCollection->id,
                'created_by' => $dailyCollection->created_by,
            ]);

            $dailyCollection->loan_balance = $dailyLoan->balance;
            $dailyCollection->save();

        }

    }
    public function trxId($date,$number)
    {
        $record = Transaction::latest('id')->first();
        $dateTime = new Carbon($date);
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uid = substr(str_shuffle($permitted_chars), 0, 6);
        if ($record) {

            $expNum = explode('-', $record->trx_id);
            //$expNum[3] = $expNum[3] + 1;
            if ($dateTime->format('jny') == $expNum[1]) {
                $s = str_pad($number, 4, "0", STR_PAD_LEFT);
                $nextTxNumber = 'TRX-' . $expNum[1] .'-'.$uid. '-' . $s;
            } else {
                //increase 1 with last invoice number
                $nextTxNumber = 'TRX-' . $dateTime->format('jny') .'-'.$uid. '-0001';
            }
        } else {

            $nextTxNumber = 'TRX-' . $dateTime->format('jny') .'-'.$uid. '-0001';

        }

        return $nextTxNumber;
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }


}
