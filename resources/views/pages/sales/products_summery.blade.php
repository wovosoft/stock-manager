<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product wise sales</title>
    <style>
        table.items {
            width: 100%;
        }

        table.items,
        table.items tr,
        table.items th,
        table.items td {
            border: 1px solid lightgray;
            border-collapse: collapse;
            padding: 2px 3px;
        }

        table.items tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table.items thead {
            background-color: #1b1b1b;
            color: white;
        }

        @if(isset($html) && $html)
            body {
            max-width: 1024px;
            margin: auto;
        }
        @endif
    </style>
</head>
<body>
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
<table class="items">
    <thead>
    <th>আইডি/কোড</th>
    <th>নাম</th>
    <th>পরিমাণ</th>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{join(' / ',$item->only(['id','code']))}}</td>
            <td>{{$item->name}}</td>
            <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($item->quantity,2))}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2" style="text-align: right;">মোট</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($items->sum('quantity'),2))}}</td>
    </tr>
    </tfoot>
</table>
</body>
</html>
