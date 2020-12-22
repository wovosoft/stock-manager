<div style="width:100%;font-size:small;transform: scale(1.8,0.9);text-align: center;margin: 0;padding: 0;">
    বিসমিল্লাহির রাহমানির রাহিম
</div>
<table style="width: 100%;font-size: small;">
    <tr>
        <td style="width: 50%;vertical-align: top;">
            {{$sale->customer->name}}<br>
            {{$sale->customer->village}}<br>
            মোবাইল নং: {{\App\Drivers\BanglaConverter::en2bn($sale->customer->phone)}}<br>
            @php
                $sale_date=\Carbon\Carbon::parse($sale->created_at)->locale('bn-BD');
            @endphp
        </td>
        <td style="text-align: right;vertical-align: top;">
            ID- {{\App\Drivers\BanglaConverter::en2bn($sale->id)}}<br>
            তারিখ : {{\App\Drivers\BanglaConverter::en2bn($sale_date->format('d-m-Y'))}},<br>
            {{$sale_date->dayName}}
        </td>
    </tr>
</table>

{{--@if($is_delivery)--}}
{{--    --}}
{{--@else--}}
{{--    <span style="position: absolute;top:0;">--}}
{{--    ক্রমিক নং- {{\App\Drivers\BanglaConverter::en2bn($sale->id)}}--}}
{{--</span>--}}
{{--    <div class="text-center">--}}
{{--        বিসমিল্লাহির রাহমানির রাহিম<br>--}}
{{--        <h3 style="margin: 0;padding: 0;"> বিসমিল্লাহ এন্টারপ্রাইজ</h3>--}}
{{--        প্রোঃ মোঃ আনোয়ার হোসেন<br>--}}
{{--        ঠাকুরগাঁও রোড, ঠাকুরগাঁও।--}}
{{--    </div>--}}
{{--    <br>--}}
{{--    <table style="width: 100%">--}}
{{--        <tr>--}}
{{--            <td>ক্রেতার নামঃ {{$sale->customer->name}}</td>--}}
{{--            <td class="text-center">মোবাইল নং: {{\App\Drivers\BanglaConverter::en2bn($sale->customer->phone)}}</td>--}}
{{--            <td class="text-right">--}}
{{--                @php--}}
{{--                    $sale_date=\Carbon\Carbon::parse($sale->created_at)->locale('bn-BD');--}}
{{--                @endphp--}}
{{--                তারিখ : {{\App\Drivers\BanglaConverter::en2bn($sale_date->format('d-m-Y'))}},--}}
{{--                {{$sale_date->dayName}}--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--@endif--}}
