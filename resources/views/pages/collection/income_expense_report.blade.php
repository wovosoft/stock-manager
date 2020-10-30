@php
    $types=[
      "expense"=>"দৈনিক খরচ",
      "purchase_payment"=>"বকেয়া পরিশোধ",
      "purchase_return"=>"ক্রয়কৃত মাল ফেরত",
      "employee_salary"=>"কর্মকর্তা/কর্মচারী বেতন",
      "sale_return"=>"বিক্রিত মাল ফেরত",
      "sale_payment"=>"বকেয়া আদায়",
      "capital_deposit"=>"মূলধন জমা",
      "capital_withdraw"=>"মূলধন উত্তোলন",
    ];
@endphp
    <!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Income/Expense Financial Report # {{$date->format('d-m-Y')}}</title>
    <style>

        html, body {
            font-family: 'bangla', sans-serif;
        }

        table, tr {
            border-collapse: collapse;
        }

        th, td {
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

        thead tr {
            background-color: lightgray;
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
<!--
বিসমিল্লাহির রাহমানির রাহিম<br>
    <h3 style="margin: 0;padding: 0;"> বিসমিল্লাহ এন্টারপ্রাইজ</h3>
    প্রোঃ মোঃ আনোয়ার হোসেন<br>
    ঠাকুরগাঁও রোড, ঠাকুরগাঁও।<br>
-->
<div class="text-center">
    {!! _s('invoice_header') !!}

    তারিখ : {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
    {{$date->locale('bn-BD')->dayName}}
</div>
<br>
<div style="position:relative;width: 100%;box-sizing: border-box;">
    <div style="width: 49%;display: inline-block;float: left;box-sizing: border-box;">
        <table style="width: 100%;">
            <thead>
            <tr>
                <th>ক্রঃনং</th>
                {{--                    <th>শিরোনাম</th>--}}
                <th>বিবরণ</th>
                <th>জমা</th>
                {{--        <th>সময়</th>--}}
            </tr>
            </thead>
            <tbody>
            @php
                $index=1;
            @endphp
            @foreach($items as $item)
                @if($item->income)
                    <tr>
                        <td>{{\App\Drivers\BanglaConverter::en2bn($index++)}}</td>
                        {{--                            <td>{{isset($types[$item->title])?$types[$item->title]:$item->title}}</td>--}}
                        <td>{{$item->description}}
                            ({{isset($types[$item->title])?$types[$item->title]:$item->title}})
                        </td>
                        <td style="text-align: right;">{{$item->income?\App\Drivers\BanglaConverter::en2bn(number_format($item->income,2)).' টাকা':''}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td style="text-align: right;">মোট</td>
                <td colspan="2"
                    style="text-align: right;">{{\App\Drivers\BanglaConverter::en2bn(number_format($items->sum('income'),2))}}
                    টাকা
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div style="width: 49%;display: inline-block;float: left;box-sizing: border-box;margin-left: 2%;">
        <table style="width: 100%;">
            <thead>
            <tr>
                <th>ক্রঃনং</th>
                {{--                    <th>শিরোনাম</th>--}}
                <th>বিবরণ</th>
                <th>খরচ</th>
                {{--        <th>সময়</th>--}}
            </tr>
            </thead>
            <tbody>
            @php
                $index=1;
            @endphp
            @foreach($items as $item)
                @if($item->expense)
                    <tr>
                        <td>{{\App\Drivers\BanglaConverter::en2bn($index++)}}</td>
                        {{--                            <td>{{isset($types[$item->title])?$types[$item->title]:$item->title}}</td>--}}
                        <td>{{$item->description}}
                            ({{isset($types[$item->title])?$types[$item->title]:$item->title}})
                        </td>
                        <td style="text-align: right;">{{$item->expense?\App\Drivers\BanglaConverter::en2bn(number_format($item->expense,2)).' টাকা':''}}</td>
                        {{--            <td>{{\App\Drivers\BanglaConverter::en2bn(\Carbon\Carbon::parse($item->date)->format('h:i A'))}}</td>--}}
                    </tr>
                @endif
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td style="text-align: right;">মোট</td>
                <td colspan="2"
                    style="text-align: right;">{{\App\Drivers\BanglaConverter::en2bn(number_format($items->sum('expense'),2))}}
                    টাকা
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<br>
<table style="border: 0;margin-left: 40%;">
    <tr>
        <td style="border: 0;"> পূর্বের জমাঃ</td>
        <td style="border: 0;">{{\App\Drivers\BanglaConverter::en2bn(number_format($previous_balance,2))}} টাকা</td>
    </tr>
    <tr>
        <td style="border: 0;">মোট জমাঃ</td>
        <td style="border: 0;">{{\App\Drivers\BanglaConverter::en2bn(number_format($items->sum('income'),2))}} টাকা</td>
    </tr>
    <tr>
        <td style="border: 0;">মোট খরচঃ</td>
        <td style="border: 0;">{{\App\Drivers\BanglaConverter::en2bn(number_format($items->sum('expense'),2))}}টাকা
        </td>
    </tr>
    <tr>
        <td style="border: 0;"> অবশিষ্টঃ</td>
        <td style="border: 0;">{{\App\Drivers\BanglaConverter::en2bn(number_format($previous_balance +$items->sum('income')- $items->sum('expense'),2))}}
            টাকা
        </td>
    </tr>
</table>

{!! _s('invoice_footer') !!}
<div style="margin-top: 3px;font-size: small;">
    আজকের তারিখঃ
    {{\App\Drivers\BanglaConverter::en2bn(\Carbon\Carbon::now()->locale(_s('locale'))->format('d-m-Y h:i A'))}}
</div>
</body>
</html>
