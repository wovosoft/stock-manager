<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Invoice # {{$purchase->id}}</title>
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
    ক্রমিক নং- {{\App\Drivers\BanglaConverter::en2bn($purchase->id)}}
</span>
<div class="text-center">
    {!! _s('invoice_header') !!}
</div>
<br>
<table style="width: 100%">
    <tr>
        <td>সরবরাহকারীর নামঃ {{$purchase->supplier->name}}</td>
        <td class="text-center">মোবাইল নং: {{\App\Drivers\BanglaConverter::en2bn($purchase->supplier->phone)}}</td>
        <td class="text-right">
            @php
                $purchase_date=\Carbon\Carbon::parse($purchase->created_at)->locale('bn-BD');
            @endphp
            তারিখ : {{\App\Drivers\BanglaConverter::en2bn($purchase_date->format('d-m-Y'))}},
            {{$purchase_date->dayName}}
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
    @foreach($purchase->items as $purchase_item)
        <tr>
            <td>
                {{$purchase_item->product->name}}
            </td>
            <td>
                {{\App\Drivers\BanglaConverter::en2bn(number_format($purchase_item->price,2))}} টাকা
            </td>
            <td>
                @php
                    $unit=$purchase_item->unit;
                @endphp
                {{\App\Drivers\BanglaConverter::en2bn($purchase_item->quantity)}} {{$unit?$unit->name:''}}
            </td>
            <td>
                {{\App\Drivers\BanglaConverter::en2bn(number_format($purchase_item->total,2))}} টাকা
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" class="text-right">
            মোট ক্রয়মূল্যঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($purchase->payable)}} টাকা
        </td>
    </tr>

    <tr>
        <td colspan="3" class="text-right">
            পূর্বের জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($purchase->previous_balance ,2))}}
            টাকা
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            জমাঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($purchase->paid,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td>
            @php($date=\Carbon\Carbon::now()->locale('bn-BD'))
            আজকের তারিখঃ {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
            {{$date->dayName}}
        </td>
        <td colspan="2" class="text-right">
            বর্তমান জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($purchase->current_balance - $purchase->paid,2))}}
            টাকা
        </td>
    </tr>

    </tfoot>
</table>
{!! _s('invoice_footer') !!}
{{--<pre>{{print_r($previous_balance->toArray())}}</pre>--}}
</body>
</html>
