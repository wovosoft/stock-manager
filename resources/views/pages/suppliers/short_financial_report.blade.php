<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer's Short Financial Report # {{$supplier->id}}</title>
    <style>

        html, body {
            font-family: 'bangla', sans-serif;
        }

        table, tr, td {
            border: 1px solid gray;
            border-collapse: collapse;
        }

        td {
            padding: 5px 10px;
            width: 50%;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="text-center">
    বিসমিল্লাহির রাহমানির রাহিম<br>
    <h3 style="margin: 0;padding: 0;"> বিসমিল্লাহ এন্টারপ্রাইজ</h3>
    প্রোঃ মোঃ আনোয়ার হোসেন<br>
    ঠাকুরগাঁও রোড, ঠাকুরগাঁও।<br>
    @php
        $date= \Carbon\Carbon::now()->locale('bn-BD');
    @endphp
    তারিখ : {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
    {{$date->dayName}}

</div>

<table class="invoice" style="width: 100%;">
    <tr>
        <td colspan="2" style="text-align: center;background-color: #1b1b1b;color: white;"> সরবরাহকারী পরিচিতি</td>
    </tr>
    <tr>
        <td>সরবরাহকারী পরিচিতি নং</td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($supplier->id)}}
        </td>
    </tr>
    <tr>
        <td>সরবরাহকারীর নাম</td>
        <td>{{$supplier->name}}</td>
    </tr>
    <tr>
        <td>মোবাইল নং</td>
        <td> {{\App\Drivers\BanglaConverter::en2bn($supplier->phone)}}</td>
    </tr>
    <tr>
        <td>ইমেইল এড্রেস</td>
        <td> {{$supplier->email}}</td>
    </tr>
    @if($supplier->company)
        <tr>
            <td>কোম্পানি</td>
            <td> {{$supplier->company}}</td>
        </tr>
    @endif
    @if($supplier->shipping_address)
        <tr>
            <td>শিপিং এড্রেস</td>
            <td> {{$supplier->shipping_address}}</td>
        </tr>
    @endif
    <tr>
        <td>ঠিকানা</td>
        <td> {{join(", ",$supplier->only(['district','thana','post_office','village']))}}</td>
    </tr>
</table>
<br>
<table style="width: 100%">
    <tr>
        <td colspan="2" style="text-align: center;background-color: #1b1b1b;color: white;">
            আর্থিক প্রতিবেদন<br>
            @if($start_date && $end_date)
                {{\App\Drivers\BanglaConverter::en2bn($start_date->format('d-m-Y'))}}
                হতে  {{\App\Drivers\BanglaConverter::en2bn($end_date->format('d-m-Y'))}} পর্যন্ত
            @elseif($start_date && !$end_date)
                {{\App\Drivers\BanglaConverter::en2bn($start_date->format('d-m-Y'))}} হতে বর্তমান পর্যন্ত
            @elseif(!$start_date && $end_date)
                শুরু থেকে {{\App\Drivers\BanglaConverter::en2bn($end_date->format('d-m-Y'))}} পর্যন্ত
            @endif
        </td>
    </tr>
    <tr>
        <td>
            মোট ক্রয়মূল্য
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($supplier->payable,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td>
            মোট ফেরত
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($supplier->returned,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td>
            মোট জমা
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($supplier->paid,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td>
            জের
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($supplier->balance,2))}} টাকা
        </td>
    </tr>
</table>

{!! _s('invoice_footer') !!}

</body>
</html>
