<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = new User();
       /* $user->id              = $row['id'];*/
        $user->name              = $row['name'];
        $user->email             = $row['email'];
        $user->password          = $row['password'];
        $user->phone1            = $row['phone1'];
        $user->phone2            = $row['phone2'];
        $user->present_address   = $row['present_address'];
        $user->permanent_address = $row['permanent_address'];
        $user->gender            = $row['gender'];
        $user->workplace         = $row['workplace'];
        $user->occupation        = $row['occupation'];
        $user->father_name       = $row['father_name'];
        $user->mother_name       = $row['mother_name'];
        $user->spouse_name       = $row['spouse_name'];
        if($row['join_date'] !='NULL')
        {
            $user->join_date         = $this->transformDate($row['join_date']);
        }
        if($row['birthdate'] !='NULL')
        {
            $user->birthdate         = $this->transformDate($row['birthdate']);
        }

        $user->status            = 'active';
        $user->save();


       return $user->assignRole('user');
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
