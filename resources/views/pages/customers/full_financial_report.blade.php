<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer's Short Financial Report # {{$customer->id}}</title>
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
        <td colspan="2" style="text-align: center;background-color: #1b1b1b;color: white;"> গ্রাহক পরিচিতি</td>
    </tr>
    <tr>
        <td>গ্রাহক পরিচিতি নং</td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($customer->id)}}
        </td>
    </tr>
    <tr>
        <td>ক্রেতার নাম</td>
        <td>{{$customer->name}}</td>
    </tr>
    <tr>
        <td>মোবাইল নং</td>
        <td> {{\App\Drivers\BanglaConverter::en2bn($customer->phone)}}</td>
    </tr>
    <tr>
        <td>ইমেইল এড্রেস</td>
        <td> {{$customer->email}}</td>
    </tr>
    @if($customer->company)
        <tr>
            <td>কোম্পানি</td>
            <td> {{$customer->company}}</td>
        </tr>
    @endif
    @if($customer->shipping_address)
        <tr>
            <td>শিপিং এড্রেস</td>
            <td> {{$customer->shipping_address}}</td>
        </tr>
    @endif
    <tr>
        <td>ঠিকানা</td>
        <td> {{join(", ",$customer->only(['district','thana','post_office','village']))}}</td>
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
        <td>বিক্রিত পণ্য</td>
        <td>
            @php
                $total_sales = $records->filter(fn($ii) => $ii->title == 'sale')->sum('to_customer')
            @endphp
            {{\App\Drivers\BanglaConverter::en2bn(number_format($total_sales,2)) }} টাকা
        </td>
    </tr>
    <tr>
        <td>ফেরত</td>
        <td>
            @php
                $total_returns =$records->filter(fn($ii)=>$ii->title=='return')->sum('from_customer')
            @endphp
            {{\App\Drivers\BanglaConverter::en2bn(number_format($total_returns,2)) }} টাকা
        </td>
    </tr>
    <tr>
        <td>জমা</td>
        <td>
            @php
                $total_paid=$records->filter(fn($ii)=>$ii->title=='payment')->sum('from_customer');
            @endphp
            {{ \App\Drivers\BanglaConverter::en2bn(number_format($total_paid,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td>জের</td>
        <td>
            {{ \App\Drivers\BanglaConverter::en2bn(number_format($total_sales - $total_returns - $total_paid,2))}} টাকা
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
        if ($title == 'sale') {
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
            "sale" => "বিক্রয়",
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
                @if($record->to_customer)
                    {{\App\Drivers\BanglaConverter::en2bn(number_format($record->to_customer,2))}} টাকা
                @endif
            </td>
            <td style="color: {{$color}}">
                @if($record->from_customer)
                    {{\App\Drivers\BanglaConverter::en2bn(number_format($record->from_customer,2))}} টাকা
                @endif
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2">
            মোট
        </td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('to_customer'),2))}} টাকা</td>
        <td>{{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('from_customer'),2))}} টাকা</td>
    </tr>
    <tr style="background-color: #172a3a;">
        <td style="color: white;">
            জের
        </td>
        <td colspan="3" style="text-align: right;color: white;">
            {{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('to_customer'),2))}} -
            {{\App\Drivers\BanglaConverter::en2bn(number_format($records->sum('from_customer'),2))}} =
            {{ \App\Drivers\BanglaConverter::en2bn(number_format($total_sales - $total_returns - $total_paid,2))}} টাকা
        </td>
    </tr>
</table>

{!! _s('invoice_footer') !!}

</body>
</html>
