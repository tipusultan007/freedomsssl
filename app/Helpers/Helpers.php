<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Dps;
use App\Models\DpsCollection;
use App\Models\DpsLoan;
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
use Config;
use DateTime;
use Illuminate\Support\Str;

class Helpers
{
    public static function applClasses()
    {

        $data = config('custom.custom');

        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'layoutWidth' => 'boxed',
            'showMenu' => true,
            'bodyClass' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'en',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, $data);

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'showMenu' => array(true, false),
            'layoutWidth' => array('full', 'boxed'),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage' => array('en' => 'en', 'bd' =>'bd'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
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

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
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
    public static function getDueDps($account, $date)
    {
        $due = 0;
        $dps = Dps::where('account_no',$account)->first();
        $user = User::find($dps->user_id);
        $dpsCollection = DpsCollection::where('account_no',$account)->get();
        $totalPaidInstallment = $dpsCollection->count();
        $totalMonths = self::getTotalMonths($dps->commencement,$date);
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
        $totalMonths = self::getTotalMonths($dps->commencement,$date);
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
        if ($loan->commencement>$date)
        {
            return 0;
        }else{
            $totalMonths = self::getTotalMonths($loan->commencement,$date);
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
        $totalMonths = self::getTotalMonths($loan->commencement,$date);
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
                    $monthlyInterest = ($takenLoan->remain * $takenLoan->interest1 * 1)/100;
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
        $totalMonths = self::getTotalMonths($fdrDeposit->commencement,$date);
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
}
