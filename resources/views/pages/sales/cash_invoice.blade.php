<div style="text-align: center;font-size: small;">
    ক্যাশ মেমো
</div>
<table style="width: 100%;font-size: small;" class="invoice table table-sm table-striped table-bordered">
    <thead class="bg-dark text-white">
    <tr>
        <td style="min-width: 30%;">বর্ণনা</td>
        <td>দর</td>
        <td>পরিমাণ</td>
        <td>মোট</td>
    </tr>
    </thead>
    <tbody>
    @foreach($sale->items as $sale_item)
        <tr>
            <td>
                {{$sale_item->product->name}}
            </td>

            <td>
                {{\App\Drivers\BanglaConverter::en2bn(number_format($sale_item->price,2))}}
            </td>

            <td>
                @php
                    $unit =$sale_item->unit;
                @endphp
                {{\App\Drivers\BanglaConverter::en2bn($sale_item->quantity)}} {{$unit?$unit->name:''}}
            </td>

            <td>
                {{\App\Drivers\BanglaConverter::en2bn(number_format($sale_item->total,2))}}
            </td>

        </tr>
    @endforeach
    </tbody>
    <tfoot>
    {{--    <tr>--}}
    {{--        <td colspan="{{$is_delivery?1:3}}" class="text-right">--}}
    {{--            মোট পণ্যঃ--}}
    {{--        </td>--}}
    {{--        <td>--}}
    {{--            {{\App\Drivers\BanglaConverter::en2bn($sale->items->sum('quantity'))}} টি--}}
    {{--        </td>--}}
    {{--    </tr>--}}

    <tr>
        <td colspan="3" class="text-right">
            মোটঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($sale->payable)}}
        </td>
    </tr>

    <tr>
        <td colspan="3" class="text-right">
            পূর্বের জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->previous_balance ,2))}}
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="2" style="border-top: 1px solid lightgray;"></td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            সর্বমোটঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format(($sale->previous_balance + $sale->payable),2))}}
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            জমাঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->paid,2))}}
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="2" style="border-top: 1px solid lightgray;"></td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            বর্তমান জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->current_balance,2))}}
        </td>
    </tr>
    </tfoot>
</table>
<div style="text-align: center;position: absolute;margin-top: -50px;margin-left: 10px;">
    .............................<br>
    স্বাক্ষর ও তারিখ
</div>
{{--<div style="font-size: smaller;">--}}
{{--    @php($date=\Carbon\Carbon::now()->locale('bn-BD'))--}}
{{--    আজকের তারিখঃ {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},--}}
{{--    {{$date->dayName}} । <span style="color: lightgray;">Developed by - WovoSoft</span>--}}
{{--</div>--}}
