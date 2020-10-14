<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Invoice # {{$sale->id}}</title>
    <style>

        html, body {
            font-family: 'bangla', sans-serif;
        }

        table.invoice tbody tr
            /*table.invoice th, table.invoice td */
        {
            border: 1px solid lightgray;
        }

        table.invoice th, table.invoice td {
            padding: 5px 10px;
        }

        table.invoice tbody tr:nth-child(odd) {
            background-color: lightgray;
        }

        table.invoice thead tr {
            background-color: black;
        }

        table.invoice thead tr th, table.invoice thead tr td {
            color: white;
        }

        table.invoice {
            border-collapse: collapse;
            width: 100%;
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
<span style="position: absolute;top:0;">
    ক্রমিক নং- {{\App\Drivers\BanglaConverter::en2bn($sale->id)}}
</span>
<div class="text-center">
    বিসমিল্লাহির রাহমানির রাহিম<br>
    <h3 style="margin: 0;padding: 0;"> বিসমিল্লাহ এন্টারপ্রাইজ</h3>
    প্রোঃ মোঃ আনোয়ার হোসেন<br>
    ঠাকুরগাঁও রোড, ঠাকুরগাঁও।
</div>
<br>
<table style="width: 100%">
    <tr>
        <td>ক্রেতার নামঃ {{$sale->customer->name}}</td>
        <td class="text-center">মোবাইল নং: {{\App\Drivers\BanglaConverter::en2bn($sale->customer->phone)}}</td>
        <td class="text-right">
            @php
                $sale_date=\Carbon\Carbon::parse($sale->created_at)->locale('bn-BD');
            @endphp
            তারিখ : {{\App\Drivers\BanglaConverter::en2bn($sale_date->format('d-m-Y'))}},
            {{$sale_date->dayName}}
        </td>
    </tr>
</table>

<table style="width: 100%" class="invoice table table-sm table-striped table-bordered">
    <thead class="bg-dark text-white">
    <tr>
        <td>বর্ণনা</td>
        <td>দর</td>
        <td>পরিমাণ</td>
        <td>মোট</td>
    </tr>
    </thead>
    <tbody>
    @foreach($sale->items as $sale_item)
        <tr>
            <td>
                {{$sale_item->product->name}}
            </td>
            <td>
                {{\App\Drivers\BanglaConverter::en2bn(number_format($sale_item->price,2))}} টাকা
            </td>
            <td>
                {{\App\Drivers\BanglaConverter::en2bn($sale_item->quantity)}} টি
            </td>
            <td>
                {{\App\Drivers\BanglaConverter::en2bn(number_format($sale_item->total,2))}} টাকা
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" class="text-right">
            মোট পণ্যঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($sale->items->sum('quantity'))}} টি
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            মোট বিক্রয়মূল্যঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($sale->payable)}} টাকা
        </td>
    </tr>

    <tr>
        <td colspan="3" class="text-right">
            পূর্বের জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->previous_balance ,2))}}
            টাকা
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            জমাঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->paid,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            বর্তমান জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->current_balance - $sale->paid,2))}}
            টাকা
        </td>
    </tr>


    <tr>
        <td>
            @php($date=\Carbon\Carbon::now()->locale('bn-BD'))
            আজকের তারিখঃ {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
            {{$date->dayName}}
        </td>

    </tr>

    </tfoot>
</table>
{!! _s('invoice_footer') !!}
{{--<pre>{{print_r($previous_balance->toArray())}}</pre>--}}
</body>
</html>
