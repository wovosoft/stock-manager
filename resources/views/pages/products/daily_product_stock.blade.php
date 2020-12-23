<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Stock Report</title>
    <style>

        html, body {
            font-family: 'bangla', sans-serif;
        }

        table.invoice tbody tr, table.invoice td, table.invoice th {
            border: 1px solid gray;
        }

        table.invoice th, table.invoice td {
            padding: 2px 3px;
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

        @media print {
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
            box-shadow: 0 0 5px gray;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="text-center">
    {!! _s('invoice_header') !!}
    গোডাউনের মজুদ এবং খরচের পর মোট মজুদ মালের তালিকা
</div>
<div style="text-align: center;">
    তারিখঃ {{\App\Drivers\BanglaConverter::en2bn(\Carbon\Carbon::parse($date)->format('d-m-Y'))}}
</div>
<br>
@if(isset($html) && $html)
    <button id="print" onclick="window.print()">প্রিন্ট করুন</button>
@endif
<div style="column-count: 2;column-fill: auto;">
    <table style="width: 100%;" class="invoice">
        <thead>
        <tr>
            <th>ক্রঃ নং</th>
            <th>মালামালের বিবরণ</th>
            <th>বর্তমান মজুদ</th>
            <th>জমা</th>
            <th>খরচ</th>
            <th>অবশিষ্ট</th>
            <th>মোট মজুদ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{\App\Drivers\BanglaConverter::en2bn($item->id)}}</td>
                <td>{{$item->name}}</td>
                <td>{{\App\Drivers\BanglaConverter::en2bn($item->current_stock)}}</td>
                <td>{{\App\Drivers\BanglaConverter::en2bn(($item->addition))}}</td>
                <td>{{\App\Drivers\BanglaConverter::en2bn(($item->subtraction))}}</td>
                <td>{{\App\Drivers\BanglaConverter::en2bn($item->remains)}}</td>
                <td>{{\App\Drivers\BanglaConverter::en2bn($item->stock)}}</td>
            </tr>
        @endforeach
        <tr>
            <td>মোট</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($items->count())}}টি পণ্য</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('current_stock'))}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('addition'))}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('subtraction'))}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('remains'))}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($items->sum('stock'))}}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
