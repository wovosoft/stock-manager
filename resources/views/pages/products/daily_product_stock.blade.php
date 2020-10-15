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
<div class="text-center">
    বিসমিল্লাহির রাহমানির রাহিম<br>
    <h3 style="margin: 0;padding: 0;"> বিসমিল্লাহ এন্টারপ্রাইজ</h3>
    প্রোঃ মোঃ আনোয়ার হোসেন<br>
    ঠাকুরগাঁও রোড, ঠাকুরগাঁও।<br>
    গোডাউনের মজুদ এবং খরচের পর মোট মজুদ মালের তালিকা
</div>
<div style="position: absolute;top:100px;right:60px;">
    তারিখঃ {{\App\Drivers\BanglaConverter::en2bn(\Carbon\Carbon::parse($date)->format('d-m-Y'))}}
</div>
<br>
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
        @php
            $previous_stock =(($item->prev_purchased_items - $item->prev_purchase_returned_items)-($item->prev_sold_items - $item->prev_sold_returned_items));
            $todays_stock=(($item->purchased_items - $item->purchase_returned_items)-($item->sold_items - $item->sold_returned_items));
        @endphp
        <tr>
            <td>{{\App\Drivers\BanglaConverter::en2bn($item->id)}}</td>
            <td>{{$item->name}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($previous_stock)}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(($item->purchased_items - $item->purchase_returned_items))}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(($item->sold_items - $item->sold_returned_items))}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn($todays_stock)}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(($previous_stock + $todays_stock))}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
