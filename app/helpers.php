<?php

if (!function_exists('getBengaliGreeting')) {
  function getBengaliGreeting()
  {
    $currentTime = now();
    $hour = $currentTime->hour;

    if ($hour >= 5 && $hour < 12) {
      return 'শুভ সকাল';
    } elseif ($hour >= 12 && $hour < 17) {
      return 'শুভ অপরাহ্ণ';
    } else {
      return 'শুভ সন্ধ্যা';
    }
  }
}

if (!function_exists('getDailyTransactionByManager')) {
  function getDailyTransactionByManager($authId, $date)
  {
    $cashinTotal = \App\Models\Transaction::where('manager_id',$authId)->where('date', $date)->where('type','cashin')->sum('amount');
    $cashoutTotal = \App\Models\Transaction::where('manager_id',$authId)->where('date', $date)->where('type','cashout')->sum('amount');
    $data = [];

    $data['cashin'] = $cashinTotal;
    $data['cashout'] = $cashoutTotal;

    return $data;
  }
}
