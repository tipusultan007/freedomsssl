<?php

namespace App\Imports;

use App\Models\CashIn;
use App\Models\Cashout;
use App\Models\DailyCollection;
use App\Models\DailySavings;
use App\Models\SavingsCollection;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Collection;
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

    public function model(array $row)
    {
        $dailySavings = DailySavings::where('account_no',$row['account_no'])->first();

        $late_fee = $row['late_fee'];
        $other_fee = $row['other_fee'];
        $collection = DailyCollection::create([
            'account_no' => $row['account_no'],
            'user_id' => $dailySavings->user_id,
            'collector_id' => $row['collector_id'],
            'created_by' => $row['created_by'],
            'saving_amount' => $row['saving_amount'],
            'saving_type' => $row['saving_type'],
            'late_fee' => $row['late_fee'],
            'other_fee' => $row['other_fee'],
            'daily_savings_id' => $dailySavings->id,
            'savings_balance' => 0,
            'date' => $this->transformDate($row['date']),
            'collection_date' => $this->transformDate($row['collection_date'])
        ]);

        if ($row['saving_type']=='deposit') {
            $dailySavings->deposit += $collection->saving_amount;
            $dailySavings->total += $collection->saving_amount;
            $dailySavings->save();

            $cashin = CashIn::create([
                'user_id' => $collection->user_id,
                'cashin_category_id' => 1,
                'account_no' => $collection->account_no,
                'daily_collection_id' => $collection->id,
                'amount' => $collection->saving_amount + $late_fee + $other_fee,
                'date' => $collection->date,
                'created_by' => $collection->created_by,
            ]);
        }elseif($row['saving_type']=='withdraw') {
            $dailySavings->withdraw += $collection->saving_amount;
            $dailySavings->total -= $collection->saving_amount;
            $dailySavings->save();

            $cashout = Cashout::create([
                'cashout_category_id' => 1,
                'account_no' => $collection->account_no,
                'daily_collection_id' => $collection->id,
                'amount' => $collection->saving_amount - ($late_fee + $other_fee),
                'date' => $collection->date,
                'created_by' => $collection->created_by,
                'user_id' => $collection->user_id,
            ]);
        }
        $savingsCollection = SavingsCollection::create([
            'account_no' => $collection->account_no,
            'daily_savings_id' => $collection->daily_savings_id,
            'saving_amount' => $collection->saving_amount,
            'type' => $collection->saving_type,
            'collector_id' => $collection->collector_id,
            'date' => $collection->date,
            'late_fee' => $collection->late_fee ,
            'other_fee' => $collection->other_fee ,
            'balance' => $dailySavings->total,
            'user_id' => $collection->user_id,
            'collection_id' => $collection->id,
            'created_by' => $collection->created_by
        ]);

        $collection->savings_balance = $dailySavings->total;
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
