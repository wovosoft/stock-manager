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

        @if($html)
            body {
            max-width: 1024px;
            margin: auto;
        }
        @endif
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

<br>
@php
    $entries=[
        "capital_deposit"=>"মূলধন জমা",
        "capital_withdraw"=>"মূলধন উত্তোলন",
        "capital_balance"=>"মূলধন অবশিষ্ট",
        "purchase_payment"=>"বকেয়া পরিশোধ",
        "purchase_return"=>"ক্রয়কৃত মাল ফেরত",
        "purchase_balance"=>"ক্রয় জের",
        "sale_payment"=>"বকেয়া আদায়",
        "sale_return"=>"বিক্রিত মাল ফেরত",
        "sale_balance"=>"বিক্রয় জের",
        "expense"=>"দৈনিক খরচ",
        "employee_salary"=>"কর্মকর্তা/কর্মচারী বেতন",
        "balance"=>"অবশিষ্ট আর্থিক পরিমাণ",
    ];
@endphp
<table style="width: 100%;">
    <tbody>
    @foreach($entries as $key=>$value)
        <tr>
            <td>{{$value}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($item->$key,2))}} টাকা</td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! _s('invoice_footer') !!}

</body>
</html>
