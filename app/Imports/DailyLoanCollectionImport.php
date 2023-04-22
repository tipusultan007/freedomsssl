<?php

namespace App\Imports;

use App\Http\Controllers\Accounts\DailyLoanPaymentAccount;
use App\Http\Controllers\Accounts\LateFeeAccount;
use App\Http\Controllers\Accounts\OtherFeeAccount;
use App\Models\CashIn;
use App\Models\DailyCollection;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DailyLoanCollectionImport implements ToModel,WithHeadingRow,WithBatchInserts, WithChunkReading
{
    public $number = 1;
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //$dailySavings = DailySavings::where('account_no',$row['account_no'])->first();
        $dailyLoan = DailyLoan::find($row['daily_loan_id']);
        $trx_id = $this->trxId($row['date'], $this->number);
        $late_fee = $row['loan_late_fee'];
        $other_fee = $row['loan_other_fee'];
        $dailyCollection = DailyCollection::create([
            'account_no' => $row['account_no'],
            'user_id' => $dailyLoan->user_id,
            'collector_id' => Auth::id(),
            'loan_installment' => $row['loan_installment'],
            'loan_late_fee' => $row['loan_late_fee'],
            'loan_other_fee' => $row['loan_other_fee'],
            'daily_loan_id' => $row['daily_loan_id'],
            'loan_balance' => 0,
            'created_by' => Auth::id(),
            'date' => $row['date'],
            'trx_id' => $trx_id,
            'collection_date' => $row['date']
        ]);
        $trxId = Transaction::latest('id')->first();
        $trx = explode('-', $trxId->trx_id);
        $this->number = $trx[3]+1;


        if ($dailyCollection->loan_installment>0)
        {
            $dailyLoan = DailyLoan::find($dailyCollection->daily_loan_id);
            $dailyLoan->balance -= $dailyCollection->loan_installment;
            $dailyLoan->save();
            $dailyCollection->loan_balance = $dailyLoan->balance;
            $dailyCollection->save();
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
                'loan_balance' => $dailyLoan->balance,
                'user_id' => $dailyCollection->user_id,
                'collection_id' => $dailyCollection->id,
                'created_by' => $dailyCollection->created_by,
            ]);


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
