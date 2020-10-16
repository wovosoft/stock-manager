<h3 style="text-align: center;margin: 0;padding: 0;">
    বিসমিল্লাহির রাহমানির রাহিম<br>
</h3>
<table style="width: 100%">
    <tr>
        <td style="width: 50%;vertical-align: top;">
            ক্রমিক নং- {{\App\Drivers\BanglaConverter::en2bn($sale->id)}}<br>
            ক্রেতার নামঃ {{$sale->customer->name}}<br>
            মোবাইল নং: {{\App\Drivers\BanglaConverter::en2bn($sale->customer->phone)}}<br>

            @php
                $sale_date=\Carbon\Carbon::parse($sale->created_at)->locale('bn-BD');
            @endphp
            তারিখ : {{\App\Drivers\BanglaConverter::en2bn($sale_date->format('d-m-Y'))}},
            {{$sale_date->dayName}}
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
