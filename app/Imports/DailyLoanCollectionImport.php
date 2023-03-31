<?php

namespace App\Imports;

use App\Models\CashIn;
use App\Models\DailyCollection;
use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DailyLoanCollectionImport implements ToModel,WithHeadingRow,WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //$dailySavings = DailySavings::where('account_no',$row['account_no'])->first();
        $dailyLoan = DailyLoan::with('user')->where('account_no',$row['account_no'])->first();

        $late_fee = $row['loan_late_fee'];
        $other_fee = $row['loan_other_fee'];
        $collection = DailyCollection::create([
            'account_no' => $row['account_no'],
            'user_id' => $dailyLoan->user_id,
            'collector_id' => $row['collector_id'],
            'loan_installment' => $row['loan_installment'],
            'loan_late_fee' => $row['loan_late_fee'],
            'loan_other_fee' => $row['loan_other_fee'],
            'daily_loan_id' => $dailyLoan->id,
            'loan_balance' => 0,
            'created_by' => $row['created_by'],
            'date' => $this->transformDate($row['date']),
            'collection_date' => $this->transformDate($row['collection_date'])
        ]);


            $dailyLoan->balance -= $collection->loan_installment;
            $dailyLoan->save();

            $cashin = CashIn::create([
                'user_id' => $collection->user_id,
                'cashin_category_id' => 2,
                'account_no' => $collection->account_no,
                'daily_collection_id' => $collection->id,
                'amount' => $collection->loan_installment + $late_fee + $other_fee,
                'date' => $collection->date,
                'created_by' => $collection->created_by,
            ]);

        $loanCollection = DailyLoanCollection::create([
            'account_no' => $collection->account_no,
            'daily_loan_id' => $collection->daily_loan_id,
            'loan_installment' => $collection->loan_installment,
            'collector_id' => $collection->collector_id,
            'date' => $collection->date,
            'installment_no' => $row['installment_no'],
            'loan_late_fee' => $collection->loan_late_fee ,
            'loan_other_fee' => $collection->loan_other_fee ,
            'loan_balance' => $dailyLoan->balance,
            'user_id' => $collection->user_id,
            'collection_id' => $collection->id,
            'created_by' => $collection->created_by,
        ]);

        $collection->loan_balance = $dailyLoan->balance;
        $collection->save();
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
