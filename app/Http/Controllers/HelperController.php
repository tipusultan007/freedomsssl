<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public static function getTotalMonths($start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $diff = $start->diff($end);

        $yearsInMonths = $diff->format('%y') * 12;
        $months = $diff->format('%m');
        $totalMonths = ($yearsInMonths + $months)+1;
        return $totalMonths;
    }
}
