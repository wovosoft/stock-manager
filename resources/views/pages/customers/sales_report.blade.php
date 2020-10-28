<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Report</title>
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
    {!! _s('invoice_header') !!}
    @php
        $date= \Carbon\Carbon::now()->locale('bn-BD');
    @endphp
    তারিখ : {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
    {{$date->dayName}}

</div>

<br>
<table style="width: 100%">
    <thead>
    <tr>
        <td colspan="6" style="text-align: center;background-color: #1b1b1b;color: white;">
            পণ্য বিক্রয় ও অর্থ আদায় প্রতিবেদন<br>
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
        <td>আইডি</td>
        <td>ক্রেতার নাম</td>
        <td>বিক্রয়য়ের পরিমাণ</td>
        <td>জমা</td>
        <td>ফেরত</td>
        <td>জের</td>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{\App\Drivers\BanglaConverter::en2bn($item->id)}}</td>
            <td>{{$item->name}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($item->payable,2))}} টাকা</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($item->paid,2))}} টাকা</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($item->returned,2))}} টাকা</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($item->balance,2))}} টাকা</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2">মোট</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('payable'))}} টাকা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('paid'))}} টাকা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('returned'))}} টাকা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('balance'))}} টাকা</td>
    </tr>
    </tbody>
</table>

{!! _s('invoice_footer') !!}

</body>
</html>
