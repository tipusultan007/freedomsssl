<?php

namespace App\Imports;

use App\Models\DpsLoan;
use App\Models\TakenLoan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DpsLoanImport implements ToModel, WithHeadingRow,WithBatchInserts, WithChunkReading
{
//id	user_id	account_no	loan_amount	remain	interest1	interest2	upto_amount	opening_date	commencement	created_by	status
    public function model(array $row)
    {
       /* $loan = new DpsLoan();
        $loan->id = $row['id'];
        $loan->user_id = $row['user_id'];
        $loan->account_no = $row['account_no'];
        $loan->loan_amount = $row['loan_amount'];
        $loan->remain_loan = $row['remain'];
        $loan->interest1 = $row['interest1'];
        if ($row['interest2']!='NULL')
        {
            $loan->interest2 = $row['interest2'];
        }
        if ($row['upto_amount']!='NULL')
        {
            $loan->upto_amount = $row['upto_amount'];
        }
        $loan->application_date = $row['opening_date'];
        $loan->opening_date = $row['opening_date'];
        $loan->commencement = $row['commencement'];
        $loan->created_by = $row['created_by'];
        $loan->status = $row['status'];
        $loan->save();*/
        $exist_loan = DpsLoan::where('account_no',$row['account_no'])->first();
        if ($exist_loan)
        {
            $exist_loan_amount = $exist_loan->loan_amount;
            $exist_remain_amount = $exist_loan->remain_loan;

            $taken_loan = new TakenLoan();
            $taken_loan->user_id = $row['user_id'];
            $taken_loan->account_no = $row['account_no'];
            $taken_loan->loan_amount = $row['loan_amount'];
            $taken_loan->remain = $row['remain'];
            $taken_loan->interest1 = $row['interest1'];
            if ($row['interest2']!='NULL')
            {
                $taken_loan->interest2 = $row['interest2'];
            }
            if ($row['upto_amount']!='NULL')
            {
                $taken_loan->upto_amount = $row['upto_amount'];
            }
            $taken_loan->dps_loan_id = $exist_loan->id;
            $taken_loan->date = $row['date'];
            $taken_loan->commencement = $row['commencement'];
            $taken_loan->created_by = Auth::id();

            $taken_loan->save();

            $exist_loan->loan_amount +=$row['loan_amount'];
            $exist_loan->remain_loan +=$row['loan_amount'];
            $exist_loan->save();
        }else{
            $loan = new DpsLoan();
            $loan->user_id = $row['user_id'];
            $loan->account_no = $row['account_no'];
            $loan->loan_amount = $row['loan_amount'];
            $loan->remain_loan = $row['loan_amount'];
            $loan->interest1 = $row['interest1'];
            if ($row['interest2']!='NULL')
            {
                $loan->interest2 = $row['interest2'];
            }
            if ($row['upto_amount']!='NULL')
            {
                $loan->upto_amount = $row['upto_amount'];
            }
            $loan->application_date = $row['date'];
            $loan->opening_date = $row['date'];
            $loan->commencement = $row['commencement'];
            $loan->created_by = Auth::id();
            $loan->status = $row['status'];
            $loan->save();

            $taken_loan = new TakenLoan();
            $taken_loan->user_id = $row['user_id'];
            $taken_loan->account_no = $row['account_no'];
            $taken_loan->loan_amount = $row['loan_amount'];
            $taken_loan->remain = $row['remain'];
            $taken_loan->interest1 = $row['interest1'];
            if ($row['interest2']!='NULL')
            {
                $taken_loan->interest2 = $row['interest2'];
            }
            if ($row['upto_amount']!='NULL')
            {
                $taken_loan->upto_amount = $row['upto_amount'];
            }
            $taken_loan->dps_loan_id = $loan->id;
            $taken_loan->date = $row['date'];
            $taken_loan->commencement = $row['commencement'];
            $taken_loan->created_by = Auth::id();
            $taken_loan->save();
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

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
