<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            width: 794px;
            margin: 0 auto;
            color: #4089e1;
            font-size: 12px;
        }

        body, input, select, button, submit, textarea {
            font-family: 'solaimanlipi', Vrinda;
        }

        p, div, h1, h2, h3, h4, h5, h6 {
            margin: 0;
        }

        .center {
            text-align: center;
        }

        .header {
            text-align: center !important;
        }

        .top {
            display: flex;
        }

        table, td, th {
            border: 1px solid #4089e1;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            text-align: left;
            font-size: 12px;
        }

.top-gradiant {
            background-image: linear-gradient(to top, rgba(64, 137, 225, 0.05) 0%, #FFFFFF 100%);
            height: 300px;
            width: 794px;
    z-index: 0;
        }
        .bottom-gradiant {
            background: linear-gradient(bottom, #CDE0F7, #ffffff);
            height: 200px;
            width: 794px;
            z-index: 2;
            position: fixed;
            bottom: 0;

        }
        .content{
            padding: 0 20px;
            margin-top: -300px;
            z-index: 12;
        }
    </style>

</head>
<body>
<div class="top-gradiant"></div>
<div class="content">
    <table style="width: 100%;border: none;">
        <tr>
            <td style="width: 20%; border: none;vertical-align: baseline;">
                <img style="margin-top: 0px;width: 135px;" src="{{asset('public/uploads/freedom-logo.png')}}" alt="">

            </td>
            <td style="width: 60%; border: none;text-align:center">

                <p style="text-align: center;">নিজে সঞ্চয় করুন, অন্যকে সঞ্চয়ে উৎসাহিত করুন ।।</p>
                <h1 style="text-align: center;font-family: 'monotype';font-size: 50px;letter-spacing: 10px;font-weight: 600;line-height: 50px;">
                    FREEDOM</h1>
                <h2 style="font-size: 35px;text-align: center;margin-top: -10px">শ্রমজীবি সমবায় সমিতি লিঃ</h2>

            </td>
            <td style="width: 20%; border: none;vertical-align: baseline; text-align: right;">
                <img style="margin-top: 10px;width: 120px;height: 135px;object-fit: cover;"
                     src="{{asset('storage/images/profile/'.$deposit->user->image??'')}}" alt="">
            </td>
        </tr>
    </table>
    <div style="text-align: center;font-size: 16px;font-weight: 600;border: 1px solid #4089e1;padding:5px 5px;border-radius: 1.5em;width: 200px ;margin:-20px auto 0px auto">
        সরকারি নিবন্ধন নং- ১২৪৪৮</div>
    <p style="text-align: center;">(গণপ্রজাতন্ত্রী বাংলাদেশ সরকার কর্তৃক অনুমোদিত ও <br> নিয়ন্ত্রিত একটি সমবায়
        আর্থিক প্রতিষ্ঠান)</p>
    <p style="text-align: center">দক্ষিণ মধ্যম হালিশহর, ৩৮ নং ওয়ার্ড, ১নং সাইট, হিন্দুপাড়া, বন্দর, চট্টগ্রাম।</p>

    <div style="font-size: 25px;font-weight: bold;width: 150px; margin: 0 auto;border-bottom:2px solid #4089e1;color: #4089e1;text-align: center">আবেদন পত্র</div>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 40%;border: none">
                <p>বরাবর,</p>
                <p>সভাপতি/সাধারণ সম্পাদক,</p>
                <p><b>ফ্রিডম শ্রমজীবি সমবায় সমিতি লিঃ ।</b></p>
                <p>দক্ষিণ মধ্যম হালিশহর, ৩৮ নং ওয়ার্ড, ১নং সাইট, হিন্দুপাড়া,</p>
                <p>বন্দর, চট্টগ্রাম।</p></td>
            <td style="width: 30%;border: none"></td>
            <td style="width: 20%;border: none">
                <p style="text-align: right;margin-top: -40px;margin-bottom: 20px;">
                    তারিখঃ {{ date('d/m/Y',strtotime($deposit->opening_date)) }} ইং</p>
                <p>হিসাব নম্বরঃ {{ $deposit->account_no }}</p>
                <p>মেয়াদঃ {{ $deposit->duration??''}}</p>
                <p>শেয়ার সংখ্যাঃ {{ $deposit->package_amount??'' }}</p>
                <p>হিসাবের ধরনঃ <b>মাসিক সঞ্চয়</b></p></td>
        </tr>
    </table>
    <div>
        <p style="font-size: 20px;"><b>বিষয়ঃ <u>মাসিক সঞ্চয়</u> হিসাব খোলার আবেদন।</b></p>
        <p>মহাত্মন,</p>
        <p>আমি আপনার সমিতির সঞ্চয় প্রকল্পে একটি <u>মাসিক সঞ্চয়</u> হিসাব খোলার আবেদন করছি। আমার বৃত্তান্ত নিম্নরূপ -</p>
    </div>
    <table style="width: 100%">
        <tr>
            <th style="width: 15%">নাম</th>
            <td colspan="5">{{ $deposit->user->name}}</td>
        </tr>
        <tr>
            <th style="width: 15%">পিতার নাম</th>
            <td colspan="5">{{ $deposit->user->father_name??''}}</td>
        </tr>
        <tr>
            <th style="width: 15%">মাতার নাম</th>
            <td colspan="5">{{ $deposit->user->mother_name??''}}</td>
        </tr>
        <tr>
            <th style="width: 15%">স্বামীর নাম</th>
            <td colspan="5">{{ $deposit->user->spouse_name??'' }}</td>
        </tr>
        @php
            $age = "";
            if($deposit->user->birthdate !=""){
                $toDate = \Carbon\Carbon::today();
                $fromDate = \Carbon\Carbon::parse($deposit->user->birthdate);
                $age = $toDate->diffInYears($fromDate);
            }

        if($deposit->user->gender=="male")
        {
            $gender = "পুরুষ";
        }else{
            $gender = "মহিলা";
        }

        @endphp
        <tr>
            <th style="width: 15%">জাতীয়তা</th>
            <td><span>বাংলাদেশী</span>
            <th>জন্ম তারিখ</th>
            <td>{{ $deposit->user->birthdate??'' }}</td>
            <th>লিঙ্গ</th>
            <td>{{$gender}}</td>
        </tr>
    </table>
    <table style="width: 100%;margin: 5px 0">
        <tr>
            <th style="width: 15%">বর্তমান ঠিকানা</th>
            <td colspan="3">{{ $deposit->user->present_address??'' }}</td>
        </tr>
        <tr>
            <th style="width: 15%">স্থায়ী ঠিকানা</th>
            <td colspan="3">{{ $deposit->user->permanent_address??'' }}</td>
        </tr>
        <tr>
            <th>পেশা</th>
            <td> {{ $deposit->user->occupation??'' }}</td>
            <th style="width: 15%">কর্মস্থল</th>
            <td> {{ $deposit->user->workplace }}</td>
        </tr>
        <tr>
            <th style="width: 15%">জাতীয় পরিচয়পত্র নং</th>
            <td>{{ $deposit->user->nid??'' }}</td>
            <th>জন্মসনদ নং</th>
            <td>{{ $deposit->user->birth_id }}</td>
        </tr>
        <tr>
            <th style="width: 15%">ব্যাংক হিসাব নং</th>
            <td colspan="3"> </td>
        </tr>
        <tr>
            <th style="width: 15%">মোবাইল নং</th>
            <td>{{ $deposit->user->phone_1??'' }}</td>
            <td colspan="2">{{ $deposit->user->phone_2??'' }} {{ $deposit->user->phone_3??'' }}</td>
        </tr>
    </table>

    <table style="width: 100%">
        <tr>
            <th style="width: 15%">পরিচয়দানকারী</th>
            <td> {{ $deposit->introducer?$deposit->introducer->name??'':"" }}</td>
            <th>পিতার নাম</th>
            <td> {{ $deposit->introducer?$deposit->introducer->father_name??'':'' }}</td>
        </tr>
        <tr>
            <th style="width: 15%">হিসাব নং</th>
            <td></td>
            <th>মোবাইল নং</th>
            <td>{{ $deposit->introducer?$deposit->introducer->phone1??'':'' }}</td>
        </tr>
    </table>
    <p style="padding: 5px; font-weight: 600">মনোনয়নঃ আমার মৃত্যুর পর এই হিসাবের সঞ্চিত অর্থ নিম্ন বর্ণিত
        ব্যক্তি/ব্যক্তিবর্গ প্রাপ্য হবেন-</p>
    <table style="width: 100%;border: none">
        <tr>
            <th style="border: none; width: 5%">ক)</th>
            <td style="border: none">
                <table style="width: 100%;">
                    <tr>
                        <th>নাম</th>
                        <td>{{ $deposit->nominee?$deposit->nominee->name??'':'' }}</td>
                        <th>জন্ম তারিখ</th>
                        <td> </td>
                        <th>সম্পর্ক</th>
                        <td>{{ $deposit->nominee?$deposit->nominee->relation??'':'' }}</td>
                        <th>অংশ</th>
                        <td>{{ $deposit->nominee?$deposit->nominee->part??'':'' }}</td>
                    </tr>
                    <tr>
                        <th>ঠিকানা</th>
                        <td colspan="7">{{ $deposit->nominee?$deposit->nominee->address??'':'' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%;border: none">
        <tr>
            <th style="border: none;width: 5%">খ)</th>
            <td style="border: none">
                <table style="width: 100%;">
                  <tr>
                    <th>নাম</th>
                    <td>{{ $deposit->nominee?$deposit->nominee->name1??'':'' }}</td>
                    <th>জন্ম তারিখ</th>
                    <td> </td>
                    <th>সম্পর্ক</th>
                    <td>{{ $deposit->nominee?$deposit->nominee->relation1??'':'' }}</td>
                    <th>অংশ</th>
                    <td>{{ $deposit->nominee?$deposit->nominee->part1??'':'' }}</td>
                  </tr>
                  <tr>
                    <th>ঠিকানা</th>
                    <td colspan="7">{{ $deposit->nominee?$deposit->nominee->address1??'':'' }}</td>
                  </tr>
                </table>
            </td>
        </tr>
    </table>
    <p style="padding: 5px;">
        আমি এই মর্মে ঘোষণা করছি যে, আমি স্বজ্ঞানে উক্ত <u>মাসিক সঞ্চয়</u> প্রকল্পের অপরপৃষ্ঠায় বর্ণিত নিয়মাবলী পড়েছি এবং উল্লেখিত
        নিয়ম কানুন মেনে চলতে বাধ্য থাকব।
    </p>

    <div class="bottom">
        <div style="width: 50%;float: left;margin-top: 20px">
            <p style="font-size: 12px;">আপনার বিশ্বস্ত</p>
            <br>
            ---------------------------
            <p style="font-size: 12px;">আমানতকারীর স্বাক্ষর</p>
        </div>
        <div style="width: 50%; float: left">
            <p>নমুনা স্বাক্ষর</p>
            <p style="margin-top: 5px;height: 38px; width: 98%; border: 1px solid #4089e1"></p>
            <p style="margin-top: 5px;height: 38px; width: 98%; border: 1px solid #4089e1"></p>
        </div>
    </div>
</div>

<div class="bottom-gradiant"></div>

</body>
</html>
