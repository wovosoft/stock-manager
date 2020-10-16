@include("pages.sales.invoice_header")
<div style="text-align: center;">
    ক্যাশ মেমো
</div>
<table style="width: 100%" class="invoice table table-sm table-striped table-bordered">
    <thead class="bg-dark text-white">
    <tr>
        <td>বর্ণনা</td>
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
                {{\App\Drivers\BanglaConverter::en2bn(number_format($sale_item->price,2))}} টাকা
            </td>

            <td>
                {{\App\Drivers\BanglaConverter::en2bn($sale_item->quantity)}} টি
            </td>

            <td>
                {{\App\Drivers\BanglaConverter::en2bn(number_format($sale_item->total,2))}} টাকা
            </td>

        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="{{$is_delivery?1:3}}" class="text-right">
            মোট পণ্যঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($sale->items->sum('quantity'))}} টি
        </td>
    </tr>

    <tr>
        <td colspan="3" class="text-right">
            মোট বিক্রয়মূল্যঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($sale->payable)}} টাকা
        </td>
    </tr>

    <tr>
        <td colspan="3" class="text-right">
            পূর্বের জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->previous_balance ,2))}}
            টাকা
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            জমাঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->paid,2))}} টাকা
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">
            বর্তমান জেরঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn(number_format($sale->current_balance - $sale->paid,2))}}
            টাকা
        </td>
    </tr>

    <tr>
        <td>
            @php($date=\Carbon\Carbon::now()->locale('bn-BD'))
            আজকের তারিখঃ {{\App\Drivers\BanglaConverter::en2bn($date->format('d-m-Y'))}},
            {{$date->dayName}}
        </td>
    </tr>
    </tfoot>
</table>
