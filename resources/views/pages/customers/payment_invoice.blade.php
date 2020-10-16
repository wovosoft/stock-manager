<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Payment Invoice # {{$payment->customer->id}}</title>
    <style>

        html, body {
            font-family: 'bangla', sans-serif;
        }

        table.invoice tbody tr
        table.invoice th, table.invoice td {
            border: 1px solid gray;
            padding: 5px 10px;
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
    @if(!$pdf)
        <style>
            body {
                max-width: 1024px;
                margin: auto;
            }

            @media print {
                .printable {
                    display: none;
                }
            }
        </style>
    @endif
</head>
<body>
<h3 style="text-align: center;margin: 0;padding: 0;">
    বিসমিল্লাহির রাহমানির রাহিম<br>
</h3>
<table style="width: 100%">
    <tr>
        <td style="width: 50%;vertical-align: top;">
            ক্রমিক নং- {{\App\Drivers\BanglaConverter::en2bn($payment->id)}}<br>
            ক্রেতার নামঃ {{$payment->customer->name}}<br>
            মোবাইল নং: {{\App\Drivers\BanglaConverter::en2bn($payment->customer->phone)}}<br>

            @php
                $payment_date=\Carbon\Carbon::parse($payment->created_at)->locale(_s('locale'));
            @endphp
            তারিখ : {{\App\Drivers\BanglaConverter::en2bn($payment_date->format('d-m-Y h:i A'))}},
            {{$payment_date->dayName}}
        </td>
        <td style="text-align: right;vertical-align: top;">
            @if(_s('invoice_header'))
                {!! _s('invoice_header') !!}
            @else
                <h3 style="margin: 0;padding: 0;"> বিসমিল্লাহ এন্টারপ্রাইজ</h3>
                প্রোঃ মোঃ আনোয়ার হোসেন<br>
                ঠাকুরগাঁও রোড, ঠাকুরগাঁও<br>
                মোবাইল নং: {{\App\Drivers\BanglaConverter::en2bn("01728316509")}}
            @endif
        </td>
    </tr>
</table>
<div style="text-align: center;">
    <small>বকেয়া পরিশোধ মেমো</small>
</div>
<table style="width: 100%" class="invoice table table-sm table-striped table-bordered">
    <tbody>
    <tr>
        <td>পূর্বের জের</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($payment->previous_balance,2))}} টাকা</td>
    </tr>
    <tr>
        <td>জমা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($payment->payment_amount,2))}} টাকা</td>
    </tr>
    <tr>
        <td>বর্তমান জের</td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format(($payment->previous_balance - $payment->payment_amount),2))}}
            টাকা
        </td>
    </tr>
    </tbody>
</table>
<br>
@php
    $today=\Carbon\Carbon::now()->locale(_s('locale'));
@endphp
<small>আজকের তারিখঃ {{\App\Drivers\BanglaConverter::en2bn($today->format('d-m-Y h:i A'))}} , {{$today->dayName}}</small>
{!! _s('invoice_footer') !!}
@if(!$pdf)
    <div style="text-align: right;" class="printable">
        <button style="padding: 8px 15px;cursor: pointer;" onclick="window.print()">Print</button>
    </div>
@endif
</body>
</html>
