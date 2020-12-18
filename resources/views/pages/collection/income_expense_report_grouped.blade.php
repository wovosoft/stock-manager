@php
    $income_types=[
        "cash_collection"=>"নগদ আদায়",
        "purchase_return"=>"ক্রয়কৃত মাল ফেরত",
        "sale_payment"=>"বকেয়া আদায়",
        "capital_deposit"=>"মূলধন জমা",
    ];
    $expense_types=[
         "expense"=>"দৈনিক খরচ",
         "purchase_payment"=>"বকেয়া পরিশোধ",
         "sale_return"=>"বিক্রিত মাল ফেরত",
         "capital_withdraw"=>"মূলধন উত্তোলন",
         "employee_salary"=>"কর্মকর্তা/কর্মচারী বেতন",
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
<div class="text-center">
    {!! _s('invoice_header') !!}
    তারিখ : {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
    {{$date->locale('bn-BD')->dayName}}
</div>
<hr>
<h2 style="text-align: center;">সংক্ষিপ্ত বিবরণ</h2>

<table style="border-collapse:collapse;margin:auto;width: 100%;">
    <tr style="background-color: #1b1b1b;">
        <th colspan="2" style="text-align: center;color: white;padding:5px 10px;">জমা</th>
    </tr>
    @foreach($income_types as $it_key=>$it_value)
        <tr>
            <td style="width: 50%;">{{$it_value}}</td>
            <td>
                @php
                    $incomes = $items->filter(fn($item)=>$item->title==$it_key)
                @endphp
                {{\App\Drivers\BanglaConverter::en2bn(number_format($incomes->sum('income'),2))}} টাকা
            </td>
        </tr>
    @endforeach
    <tr style="background-color: lightgray;">
        <td>মোট জমা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($items->sum('income'),2))}} টাকা</td>
    </tr>
    <tr style="background-color: #1b1b1b;">
        <th colspan="2" style="text-align: center;color: white;padding:5px 10px;">খরচ</th>
    </tr>
    @foreach($expense_types as $et_key=>$et_value)
        <tr>
            <td>{{$et_value}}</td>
            <td>
                @php
                    $expenses = $items->filter(fn($item)=>$item->title==$et_key)
                @endphp
                {{\App\Drivers\BanglaConverter::en2bn(number_format($expenses->sum('expense'),2))}} টাকা
            </td>
        </tr>
    @endforeach
    <tr style="background-color: lightgray;">
        <td>মোট খরচ</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($items->sum('expense'),2))}} টাকা</td>
    </tr>
    <tr>
        <td> পূর্বের জমা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($previous_balance,2))}} টাকা</td>
    </tr>
    <tr>
        <td> অবশিষ্ট</td>
        <td style="color: red;">
            {{\App\Drivers\BanglaConverter::en2bn(number_format(($previous_balance + $items->sum('income') - $items->sum('expense')),2))}}
            টাকা
        </td>
    </tr>
</table>
@if(!$html)
    <pagebreak></pagebreak>
@endif
<h2 style="text-align: center;">বিস্তারিত বিবরণ</h2>
@php
    $sources=[
        'income'=>[
            "title"=>'আয়',
            "types"=>$income_types
        ],
        'expense'=>[
            "title"=>'ব্যয়',
            "types"=>$expense_types
        ]
    ];
@endphp
@foreach($sources as $source_key=>$source)
    <h2 style="text-align: center;">{{$source['title']}}</h2>
    @foreach($source['types'] as $type_key=>$type_value)
        <h3 style="text-align: center;">{{$type_value}}</h3>
        @php
            $the_records= $items->filter(fn($item,$key)=>$item->title==$type_key);
        @endphp
        <table style="width: 100%;">
            <thead>
            <tr>
                <th>ক্রঃনং</th>
                <th>বিবরণ</th>
                <th>জমা</th>
                <th style="text-align: right;">সময়</th>
            </tr>
            </thead>
            <tbody>
            @php
                $index=1;
            @endphp
            @foreach($the_records as $the_record)
                @if($the_record->$source_key)
                    <tr>
                        <td style="text-align: center;">
                            {{\App\Drivers\BanglaConverter::en2bn($index++)}}
                        </td>
                        <td>
                            {{$the_record->description}}
                        </td>
                        <td style="text-align: right;">
                            {{$the_record->$source_key?\App\Drivers\BanglaConverter::en2bn(number_format($the_record->$source_key,2)).' টাকা':''}}
                        </td>
                        <td style="text-align: right;">
                            {{\App\Drivers\BanglaConverter::en2bn(\Carbon\Carbon::parse($the_record->date)->format('h:i A'))}}
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td style="text-align: right;" colspan="2">মোট</td>
                <td colspan="2" style="text-align: right;">
                    {{\App\Drivers\BanglaConverter::en2bn(number_format($the_records->sum($source_key),2))}} টাকা
                </td>
            </tr>
            </tfoot>
        </table>
    @endforeach
@endforeach
<br>


{!! _s('invoice_footer') !!}
<div style="margin-top: 3px;font-size: small;">
    আজকের তারিখঃ
    {{\App\Drivers\BanglaConverter::en2bn(\Carbon\Carbon::now()->locale(_s('locale'))->format('d-m-Y h:i A'))}}
</div>
</body>
</html>
