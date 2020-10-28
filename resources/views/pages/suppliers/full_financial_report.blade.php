<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Supplier's Short Financial Report # {{$supplier->id}}</title>
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
    </style>
</head>
<body>

<div class="text-center">
    {!! _s('invoice_header') !!}
    @php
        $date= \Carbon\Carbon::now()->locale('bn-BD');
    @endphp
    তারিখ : {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
    {{$date->dayName}}

</div>

<table class="invoice" style="width: 100%;">
    <tr>
        <td colspan="2" style="text-align: center;background-color: #1b1b1b;color: white;"> সরবরাহকারী পরিচিতি</td>
    </tr>
    <tr>
        <td>সরবরাহকারী পরিচিতি নং</td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($supplier->id)}}
        </td>
    </tr>
    <tr>
        <td>সরবরাহকারীর নাম</td>
        <td>{{$supplier->name}}</td>
    </tr>
    <tr>
        <td>মোবাইল নং</td>
        <td> {{\App\Drivers\BanglaConverter::en2bn($supplier->phone)}}</td>
    </tr>
    <tr>
        <td>ইমেইল এড্রেস</td>
        <td> {{$supplier->email}}</td>
    </tr>
    @if($supplier->company)
        <tr>
            <td>কোম্পানি</td>
            <td> {{$supplier->company}}</td>
        </tr>
    @endif
    @if($supplier->shipping_address)
        <tr>
            <td>শিপিং এড্রেস</td>
            <td> {{$supplier->shipping_address}}</td>
        </tr>
    @endif
    <tr>
        <td>ঠিকানা</td>
        <td> {{join(", ",$supplier->only(['district','thana','post_office','village']))}}</td>
    </tr>
</table>
<br>

<table style="width: 100%">
    <tr>
        <td colspan="2" style="text-align: center;background-color: #1b1b1b;color: white;">
            আর্থিক সারমর্ম<br>
            @if($start_date && $end_date)
                {{\App\Drivers\BanglaConverter::en2bn($start_date->format('d-m-Y'))}}
                হতে  {{\App\Drivers\BanglaConverter::en2bn($end_date->format('d-m-Y'))}} পর্যন্ত
            @elseif($start_date && !$end_date)
                {{\App\Drivers\BanglaConverter::en2bn($start_date->format('d-m-Y'))}} হতে বর্তমান পর্যন্ত
            @elseif(!$start_date && $end_date)
                শুরু থেকে {{\App\Drivers\BanglaConverter::en2bn($end_date->format('d-m-Y'))}} পর্যন্ত
            @endif
        </td>
    </tr>
    <tr>
        <td>ক্রয়মূল্য</td>
        <td>
            @php
                $total_purchases = $records->filter(fn($ii) => $ii->title == 'purchase')->sum('to_supplier')
            @endphp
            {{\App\Drivers\BanglaConverter::en2bn(number_format($total_purchases,2)) }} টাকা
        </td>
    </tr>
    <tr>
        <td>ফেরত</td>
        <td>
            @php
                $total_returns =$records->filter(fn($ii)=>$ii->title=='return')->sum('from_supplier')
            @endphp
            {{\App\Drivers\BanglaConverter::en2bn(number_format($total_returns,2)) }} টাকা
        </td>
    </tr>
    <tr>
        <td>জমা</td>
        <td>
            @php
                $total_paid=$records->filter(fn($ii)=>$ii->title=='payment')->sum('from_supplier');
            @endphp
            {{ \App\Drivers\BanglaConverter::en2bn(number_format($total_paid,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td>জের</td>
        <td>
            {{ \App\Drivers\BanglaConverter::en2bn(number_format($total_purchases - $total_returns - $total_paid,2))}} টাকা
        </td>
    </tr>
</table>
<br>
<table style="width: 100%">
    <tr>
        <td colspan="4" style="text-align: center;background-color: #1b1b1b;color: white;">
            পরিপূর্ণ আর্থিক লেনদেন প্রতিবেদন<br>
            @if($start_date && $end_date)
                {{\App\Drivers\BanglaConverter::en2bn($start_date->format('d-m-Y'))}}
                হতে  {{\App\Drivers\BanglaConverter::en2bn($end_date->format('d-m-Y'))}} পর্যন্ত
            @elseif($start_date && !$end_date)
                {{\App\Drivers\BanglaConverter::en2bn($start_date->format('d-m-Y'))}} হতে বর্তমান পর্যন্ত
            @elseif(!$start_date && $end_date)
                শুরু থেকে {{\App\Drivers\BanglaConverter::en2bn($end_date->format('d-m-Y'))}} পর্যন্ত
            @endif
        </td>
    </tr>
    <tr>
        <td>তারিখ ও সময়</td>
        <td>শিরোনাম</td>
        <td>পাওনা অর্থ</td>
        <td>প্রাপ্ত অর্থ</td>
    </tr>
    <?php
    function getBg($title)
    {
        if ($title == 'purchase') {
            return ["#6B5B95", "white"];
        } elseif ($title == 'return') {
            return ["#9B2335", "white"];
        } else {
            return ["transparent", "black"];
        }
    }
    function getTitle($title)
    {
        return [
            "purchase" => "ক্রয়",
            "payment" => "জমা",
            "return" => "ফেরত",
        ][$title];
    }
    ?>
    @foreach($records as $record)
        @php
            $bg=getBg($record->title)[0];
            $color=getBg($record->title)[1];
        @endphp
        <tr style="background-color: {{$bg}};">

            <td style="color: {{$color}}">
                {{\App\Drivers\BanglaConverter::en2bn(
                    \Carbon\Carbon::parse($record->date)->locale('bn-BD')->format("d-m-Y,  h:i A")
                    )}}
            </td>
            <td style="color: {{$color}}">{{getTitle($record->title)}}</td>
            <td style="color: {{$color}}">
                @if($record->to_supplier)
                    {{\App\Drivers\BanglaConverter::en2bn(number_format($record->to_supplier,2))}} টাকা
                @endif
            </td>
            <td style="color: {{$color}}">
                @if($record->from_supplier)
                    {{\App\Drivers\BanglaConverter::en2bn(number_format($record->from_supplier,2))}} টাকা
                @endif
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2">
            মোট
        </td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('to_supplier'),2))}} টাকা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('from_supplier'),2))}} টাকা</td>
    </tr>
    <tr style="background-color: #172a3a;">
        <td style="color: white;">
            জের
        </td>
        <td colspan="3" style="text-align: right;color: white;">
            {{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('to_supplier'),2))}} -
            {{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('from_supplier'),2))}} =
            {{ \App\Drivers\BanglaConverter::en2bn(number_format($total_purchases - $total_returns - $total_paid,2))}} টাকা
        </td>
    </tr>
</table>

{!! _s('invoice_footer') !!}

</body>
</html>
