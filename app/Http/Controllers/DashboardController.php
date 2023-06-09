<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard - Analytics
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboardAnalytics()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
    }

    // Dashboard - Ecommerce
    public function dashboardEcommerce()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
    }

    public function send_sms($ac , $dps,$deposited, $mobile, $loan,$due)
    {
        /*$url  = "http://portal.greenheritageit.com/smspanel/smsapi";
        $data = [
            "api_key"  => "2y10idNcUXn2CcHWl2XPcmIUoOS6Pk3x2sWssk3d8CZn6jUiiO7nYgnVG750",
            "type"     => "text",
            "contacts" => "$mobile",
            "senderid" => "8809612440620",
            "msg"      => "Ur payment ".$dps." has been received. Balance: A/c no : ".$ac.",Deposit ".$deposited.",Loan ".$loan.",Due ".$due.".Thanks for staying with us. visit: www.freedomsssl.com",
        ];
        $ch   = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;*/
    }
    public function installment()
    {
        return view('app.installment');
    }
}
