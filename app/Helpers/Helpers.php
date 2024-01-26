<?php

namespace App\Helpers;

use Config;
use App\Models\Dps;
use App\Models\DpsCollection;
use App\Models\DpsLoanInterest;
use App\Models\FdrDeposit;
use App\Models\FdrPackage;
use App\Models\ProfitCollection;
use App\Models\SpecialDps;
use App\Models\SpecialDpsCollection;
use App\Models\SpecialLoanInterest;
use App\Models\SpecialLoanTaken;
use App\Models\TakenLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Helpers
{
  public static function appClasses()
  {

    $data = config('custom.custom');


    // default data array
    $DefaultData = [
      'myLayout' => 'vertical',
      'myTheme' => 'theme-default',
      'myStyle' => 'light',
      'myRTLSupport' => true,
      'myRTLMode' => true,
      'hasCustomizer' => true,
      'showDropdownOnHover' => true,
      'displayCustomizer' => true,
      'contentLayout' => 'compact',
      'headerType' => 'fixed',
      'navbarType' => 'fixed',
      'menuFixed' => true,
      'menuCollapsed' => false,
      'footerFixed' => false,
      'customizerControls' => [
        'rtl',
      'style',
      'headerType',
      'contentLayout',
      'layoutCollapsed',
      'showDropdownOnHover',
      'layoutNavbarOptions',
      'themes',
      ],
      //   'defaultLanguage'=>'en',
    ];

    // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
    $data = array_merge($DefaultData, $data);

    // All options available in the template
    $allOptions = [
      'myLayout' => ['vertical', 'horizontal', 'blank', 'front'],
      'menuCollapsed' => [true, false],
      'hasCustomizer' => [true, false],
      'showDropdownOnHover' => [true, false],
      'displayCustomizer' => [true, false],
      'contentLayout' => ['compact', 'wide'],
      'headerType' => ['fixed', 'static'],
      'navbarType' => ['fixed', 'static', 'hidden'],
      'myStyle' => ['light', 'dark', 'system'],
      'myTheme' => ['theme-default', 'theme-bordered', 'theme-semi-dark'],
      'myRTLSupport' => [true, false],
      'myRTLMode' => [true, false],
      'menuFixed' => [true, false],
      'footerFixed' => [true, false],
      'customizerControls' => [],
      // 'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','ar'=>'ar'),
    ];

    //if myLayout value empty or not match with default options in custom.php config file then set a default value
    foreach ($allOptions as $key => $value) {
      if (array_key_exists($key, $DefaultData)) {
        if (gettype($DefaultData[$key]) === gettype($data[$key])) {
          // data key should be string
          if (is_string($data[$key])) {
            // data key should not be empty
            if (isset($data[$key]) && $data[$key] !== null) {
              // data key should not be exist inside allOptions array's sub array
              if (!array_key_exists($data[$key], $value)) {
                // ensure that passed value should be match with any of allOptions array value
                $result = array_search($data[$key], $value, 'strict');
                if (empty($result) && $result !== 0) {
                  $data[$key] = $DefaultData[$key];
                }
              }
            } else {
              // if data key not set or
              $data[$key] = $DefaultData[$key];
            }
          }
        } else {
          $data[$key] = $DefaultData[$key];
        }
      }
    }
    $styleVal = $data['myStyle'] == "dark" ? "dark" : "light";
    if (isset($_COOKIE['style'])) {
      $styleVal = $_COOKIE['style'];
    }
    //layout classes
    $layoutClasses = [
      'layout' => $data['myLayout'],
      'theme' => $data['myTheme'],
      'style' => $styleVal,
      'styleOpt' => $data['myStyle'],
      'rtlSupport' => $data['myRTLSupport'],
      'rtlMode' => $data['myRTLMode'],
      'textDirection' => $data['myRTLMode'],
      'menuCollapsed' => $data['menuCollapsed'],
      'hasCustomizer' => $data['hasCustomizer'],
      'showDropdownOnHover' => $data['showDropdownOnHover'],
      'displayCustomizer' => $data['displayCustomizer'],
      'contentLayout' => $data['contentLayout'],
      'headerType' => $data['headerType'],
      'navbarType' => $data['navbarType'],
      'menuFixed' => $data['menuFixed'],
      'footerFixed' => $data['footerFixed'],
      'customizerControls' => $data['customizerControls'],
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
      $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Header Type
    if ($layoutClasses['headerType'] == 'fixed') {
      $layoutClasses['headerType'] = 'layout-menu-fixed';
    }
    // Navbar Type
    if ($layoutClasses['navbarType'] == 'fixed') {
      $layoutClasses['navbarType'] = 'layout-navbar-fixed';
    } elseif ($layoutClasses['navbarType'] == 'static') {
      $layoutClasses['navbarType'] = '';
    } else {
      $layoutClasses['navbarType'] = 'layout-navbar-hidden';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
      $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }


    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
      $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
      $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
      $layoutClasses['rtlMode'] = 'rtl';
      $layoutClasses['textDirection'] = 'rtl';
    } else {
      $layoutClasses['rtlMode'] = 'ltr';
      $layoutClasses['textDirection'] = 'ltr';
    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
      $layoutClasses['showDropdownOnHover'] = true;
    } else {
      $layoutClasses['showDropdownOnHover'] = false;
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
      $layoutClasses['displayCustomizer'] = true;
    } else {
      $layoutClasses['displayCustomizer'] = false;
    }

    return $layoutClasses;
  }

  public static function updatePageConfig($pageConfigs)
  {
    $demo = 'custom';
    if (isset($pageConfigs)) {
      if (count($pageConfigs) > 0) {
        foreach ($pageConfigs as $config => $val) {
          Config::set('custom.' . $demo . '.' . $config, $val);
        }
      }
    }
  }

  public static function dpsMonthsCount($start, $end)
  {
    $startDate = Carbon::createFromFormat('Y-m-d', $start);
    $endDate = Carbon::createFromFormat('Y-m-d', $end);

    $currentDate = $startDate->copy();
    $monthCounter = 0;
    while ($currentDate <= $endDate) {
      $firstDateOfMonth = $currentDate->copy()->firstOfMonth();
      $currentDate->addMonth(); // Move to the next month
      $monthCounter++;
    }
    return $monthCounter;
  }
  public static function getMonthsCount($start, $end)
  {
    $startDate = Carbon::createFromFormat('Y-m-d', $start);
    $endDate = Carbon::createFromFormat('Y-m-d', $end);

    $currentDate = $startDate->copy();
    $monthCounter = 0;
    while ($currentDate <= $endDate) {
      $firstDateOfMonth = $currentDate->copy()->firstOfMonth();
      $lastDateOfMonth = $currentDate->copy()->lastOfMonth();
      if ($lastDateOfMonth > $endDate) {
        break; // Exit the loop if last date is greater than $endDate
      }
      $currentDate->addMonth(); // Move to the next month
      $monthCounter++;

    }
    return $monthCounter;
  }
  public static function getTotalMonths($start, $end)
  {
    /* $start = new DateTime($start);
     $end = new DateTime($end);
     $diff = $start->diff($end);*/
    $start = Carbon::parse($start);
    $end = Carbon::parse($end);
    $diff = $start->diffInMonths($end);

    /*$yearsInMonths = $diff->format('%y') * 12;
    $months = $diff->format('%m');
    $totalMonths = ($yearsInMonths + $months)+1;*/
    return $diff;
  }

  public static function countMonths($start, $end)
  {
    $startDate = Carbon::createFromFormat('Y-m-d', $start);
    $endDate = Carbon::createFromFormat('Y-m-d', $end);

    if ($endDate >= $startDate) {
      return $startDate->diffInMonths($endDate);
    } else {
      return 0;
    }
  }
  public static function getDueDps($account, $date)
  {
    $due = 0;
    $dps = Dps::where('account_no',$account)->first();
    $user = User::find($dps->user_id);
    $dpsCollection = DpsCollection::where('account_no',$account)->get();
    $totalPaidInstallment = $dpsCollection->count();
    $totalMonths = self::dpsMonthsCount($dps->commencement,$date);
    if ($totalMonths > $totalPaidInstallment)
    {
      $due = $totalMonths - $totalPaidInstallment;
    }
    $data['user'] = $user;
    $data['dpsInfo'] = $dps;
    $data['dpsDue'] = $due;
    return $data;
  }

  public static function getDueSpecialDps($account, $date)
  {
    $due = 0;
    $dps = SpecialDps::where('account_no',$account)->first();
    $user = User::find($dps->user_id);
    $dpsCollection = SpecialDpsCollection::where('account_no',$account)->get();
    $totalPaidInstallment = $dpsCollection->count();
    $totalMonths = self::dpsMonthsCount($dps->commencement,$date);
    if ($totalMonths > $totalPaidInstallment)
    {
      $due = $totalMonths - $totalPaidInstallment;
    }
    $data['user'] = $user;
    $data['dpsInfo'] = $dps;
    $data['dpsDue'] = $due;
    return $data;
  }

  public static function getDueInterest($loanId, $date)
  {
    $due = 0;
    $loan = TakenLoan::find($loanId);
    $interestCount = DpsLoanInterest::where('taken_loan_id',$loan->id)->sum('installments');
    if ($loan->commencement > $date)
    {
      return 0;
    }else{
      $totalMonths = self::getMonthsCount($loan->commencement,$date);
      if ($totalMonths>$interestCount)
      {
        $due = $totalMonths - $interestCount;
      }
      return $due;
    }

  }

  public static function getSpecialDueInterest($loanId, $date)
  {
    $due = 0;
    $loan = SpecialLoanTaken::find($loanId);
    $interestCount = SpecialLoanInterest::where('special_loan_taken_id',$loan->id)->sum('installments');
    $totalMonths = self::getMonthsCount($loan->commencement,$date);
    if ($totalMonths>$interestCount)
    {
      $due = $totalMonths - $interestCount;
    }

    return $due;
  }

  public static function getInterest($account, $date, $type)
  {
    $takenLoans = TakenLoan::where('account_no',$account)->where('remain','>','0')->orderBy('date','asc')->get();
    $interest = [];
    $totalInterest = 0;
    foreach ($takenLoans as $key => $takenLoan)
    {
      if ( $takenLoan->interest2> 0)
      {
        if($takenLoan->upto_amount <= $takenLoan->remain)
        {
          $amount1 = $takenLoan->upto_amount;
          $amount2 = $takenLoan->remain - $amount1;
          $amountOneInterest = ($amount1 * $takenLoan->interest2 * 1)/100;
          $amountTwoInterest = ($amount2 * $takenLoan->interest1 * 1)/100;
          $monthlyInterest = $amountOneInterest + $amountTwoInterest;
        }elseif( $takenLoan->remain < $takenLoan->upto_amount)
        {
          $monthlyInterest = ($takenLoan->remain * $takenLoan->interest2 * 1)/100;
        }
      }else{
        $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1)/100;
      }
      $commencement = new Carbon($takenLoan->commencement);
      $interest[$key]['interest'] = ceil($monthlyInterest);
      $interest[$key]['dueInstallment'] = self::getDueInterest($takenLoan->id,$date);
      $interest[$key]['loanAmount'] = $takenLoan->loan_amount;
      $interest[$key]['loanRemain'] = $takenLoan->remain;
      $interest[$key]['commencement'] = $commencement->format('d/m/Y');
      $interest[$key]['taken_loan_id'] = $takenLoan->id;
      $totalInterest += ($interest[$key]['interest'] * $interest[$key]['dueInstallment']);
    }
    if ($type=='interest')
    {
      return  $totalInterest;
    }else{
      return $interest;
    }

  }
  public static function getSpecialInterest($account, $date, $type)
  {
    $takenLoans = SpecialLoanTaken::where('account_no',$account)->where('remain','>','0')->orderBy('date','asc')->get();
    $interest = [];
    $totalInterest = 0;
    foreach ($takenLoans as $key => $takenLoan)
    {
      if ( $takenLoan->interest2> 0)
      {
        if($takenLoan->upto_amount <= $takenLoan->remain)
        {
          $amount1 = $takenLoan->upto_amount;
          $amount2 = $takenLoan->remain - $amount1;
          $amountOneInterest = ($amount1 * $takenLoan->interest2 * 1)/100;
          $amountTwoInterest = ($amount2 * $takenLoan->interest1 * 1)/100;
          $monthlyInterest = $amountOneInterest + $amountTwoInterest;
        }elseif( $takenLoan->remain < $takenLoan->upto_amount)
        {
          $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1)/100;
        }
      }else{
        $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1)/100;
      }
      $commencement = new Carbon($takenLoan->commencement);
      $interest[$key]['interest'] = ceil($monthlyInterest);
      $interest[$key]['dueInstallment'] = self::getSpecialDueInterest($takenLoan->id,$date);
      $interest[$key]['loanAmount'] = $takenLoan->loan_amount;
      $interest[$key]['loanRemain'] = $takenLoan->remain;
      $interest[$key]['commencement'] = $commencement->format('d/m/Y');
      $interest[$key]['taken_loan_id'] = $takenLoan->id;
      $totalInterest += ($interest[$key]['interest'] * $interest[$key]['dueInstallment']);
    }
    if ($type=='interest')
    {
      return  $totalInterest;
    }else{
      return $interest;
    }

  }

  public static function getDueProfit($fdrDepositId, $date)
  {
    $due = 0;
    $fdrDeposit = FdrDeposit::find($fdrDepositId);
    $interestCount = ProfitCollection::where('fdr_deposit_id',$fdrDepositId)->sum('installments');
    $totalMonths = self::getMonthsCount($fdrDeposit->commencement,$date);
    if ($totalMonths>$interestCount)
    {
      $due = $totalMonths - $interestCount;
    }

    return $due;
  }

  public static function getProfit($fdrId, $date, $type)
  {
    $fdrDeposits = FdrDeposit::where('fdr_id',$fdrId)->where('balance','>','0')->orderBy('date','asc')->get();
    $profit = [];
    $totalProfit = 0;
    $profitRate = 0;

    foreach ($fdrDeposits as $key => $deposit)
    {
      $due = self::getDueProfit($deposit->id,$date);
      $package = FdrPackage::find($deposit->fdr_package_id);
      if ($due<12)
      {
        $profitRate = ($package->amount * $deposit->balance) / 100000;
      }elseif ($due>=12 && $due<24)
      {
        $profitRate = ($package->one * $deposit->balance) / 100000;

      }elseif ($due>=24 && $due<36)
      {
        $profitRate = ($package->two * $deposit->balance) / 100000;

      }elseif ($due>=36 && $due<48)
      {
        $profitRate = ($package->three * $deposit->balance) / 100000;

      }elseif ($due>=48 && $due<60)
      {
        $profitRate = ($package->four * $deposit->balance) / 100000;

      }elseif ($due>=60 && $due<66)
      {
        $profitRate = ($package->five * $deposit->balance) / 100000;
      }elseif ($due>=66 && $due<72)
      {
        $profitRate = ($package->five_half * $deposit->balance) / 100000;
      }elseif ($due>=72)
      {
        $profitRate = ($package->six * $deposit->balance) / 100000;
      }

      $commencement = new Carbon($deposit->commencement);
      $profit[$key]['profit'] = ceil($profitRate);
      $profit[$key]['dueInstallment'] = $due;
      $profit[$key]['fdr_deposit'] = $deposit->balance;
      $profit[$key]['commencement'] = $commencement->format('d-m-Y');
      $profit[$key]['fdr_deposit_id'] = $deposit->id;
      $totalProfit += ceil($profitRate) * $due;
    }

    if ($type=='profit')
    {
      return  $totalProfit;
    }else{
      return $profit;
    }
  }

  public static function newAccountNo($type, $inputString)
  {
    // Extract the numeric part from the input string
    preg_match('/\d+/', $inputString, $matches);

    if (!empty($matches)) {
      // Increment the numeric part by 1
      $numericPart = intval($matches[0]) + 1;
      $newString = '';
      switch ($type){
        case 'daily':
          $newString = 'DS' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);
          break;
        case 'monthly':
          $newString = 'DPS' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);
          break;
        case 'special':
          $newString = 'ML' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);
          break;
        case 'fdr':
          $newString = 'FDR' . str_pad($numericPart, strlen($matches[0]), '0', STR_PAD_LEFT);
          break;
      }

      return $newString;
    }

    return $inputString; // Return the input string if no numeric part found
  }
}
