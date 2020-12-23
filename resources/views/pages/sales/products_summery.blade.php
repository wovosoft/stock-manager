<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product wise sales</title>
    <style>
        table#items {
            width: 100%;
        }

        table#items,
        table#items tr,
        table#items th,
        table#items td {
            border: 1px solid lightgray;
            border-collapse: collapse;
            padding: 2px 3px;
        }

        table#items tr:nth-child(even) {
            background-color: #f2f2f2;
        }


        @if(isset($html) && $html)
            body {
            max-width: 1024px;
            margin: auto;
            padding-top: 70px;
            padding-bottom: 70px;
        }

        @else
            html, body {
            font-family: 'bangla', sans-serif;
        }

        @endif
        @media print {
            body {
                padding: 5px;
            }

            #print {
                display: none !important;
            }
        }

        #print {
            background-color: red;
            color: white;
            border: 1px solid red;
            padding: 5px 10px;
            margin: auto;
            cursor: pointer;
            box-shadow: 0 0  5px gray;
            font-weight: bold;
        }
    </style>
</head>
<body>
<button id="print" onclick="window.print()">প্রিন্ট করুন</button>
<header>
    <h3 style="text-align: center;margin: 0;">পণ্য অনুযায়ী বিক্রয় সামারি</h3>
    <div style="text-align: center;">
        @php
            $starting_date=\Carbon\Carbon::parse($starting_date);
            if ($ending_date){
                $ending_date=\Carbon\Carbon::parse($ending_date);
            }
        @endphp
        তারিখঃ {{\App\Drivers\BanglaConverter::en2bn($starting_date->format('d-m-Y'))}}
        @if($ending_date)
            থেকে {{\App\Drivers\BanglaConverter::en2bn($ending_date->format('d-m-Y'))}} পর্যন্ত
        @endif
    </div>
</header>
@php
    $border="border:1px solid lightgray;";
    $padding="padding:2px 3px;"
@endphp
<div style="column-count: 2;column-fill: auto;">
    <table id="items" style="border-collapse: collapse;border: 1px solid lightgray;width: 100%;">
        <thead>
        <tr style="background-color: #1b1b1b;">
            <th style="color: white;">ক্রঃনং</th>
            <th style="color: white;">নাম</th>
            <th style="color: white;">পরিমাণ</th>
        </tr>
        </thead>
        <tbody>
        @php($i=1)
        @foreach($items as $item)
            <tr style="{{$border}}">
                <td style="{{$border}}{{$padding}}">{{\App\Drivers\BanglaConverter::en2bn($i++)}}</td>
                <td style="{{$border}}{{$padding}}">{{$item->name}}</td>
                <td style="text-align: right;{{$border}}{{$padding}}">
                    {{\App\Drivers\BanglaConverter::en2bn($item->quantity)}}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align: right;">মোট</td>
            <td style="text-align: right">{{\App\Drivers\BanglaConverter::en2bn($items->sum('quantity'))}}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
