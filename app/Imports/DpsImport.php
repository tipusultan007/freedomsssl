<?php

namespace App\Imports;

use App\Models\Dps;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DpsImport implements ToModel, WithHeadingRow,WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        $dps = new Dps();
        $dps->id = $row['id'];
        $dps->user_id = $row['user_id'];
        $dps->dps_package_id = $row['dps_package_id'];
        $dps->introducer_id = $row['introducer_id'];
        $dps->account_no = $row['account_no'];
        $dps->receipt_book = $row['receipt_book'];
        $dps->package_amount = $row['package_amount'];
        $dps->opening_date = $this->transformDate($row['opening_date']);
        $dps->commencement = $this->transformDate($row['commencement']);
        $dps->created_by = $row['created_by'];
        $dps->status = $row['status'];
        $dps->save();

        return 'success';
    }

    public function batchSize(): int
    {
        return 2000;
    }

    public function chunkSize(): int
    {
        return 2000;
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
