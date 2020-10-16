@include("pages.sales.invoice_header")
<div style="text-align: center;">
    ডেলিভারি স্লিপ
</div>
<table style="width: 100%" class="invoice table table-sm table-striped table-bordered">
    <thead class="bg-dark text-white">
    <tr>
        <td>বর্ণনা</td>
        <td>পরিমাণ</td>
    </tr>
    </thead>
    <tbody>
    @foreach($sale->items as $sale_item)
        <tr>
            <td>
                {{$sale_item->product->name}}
            </td>
            <td>
                {{\App\Drivers\BanglaConverter::en2bn($sale_item->quantity)}} টি
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td  class="text-right">
            মোট পণ্যঃ
        </td>
        <td>
            {{\App\Drivers\BanglaConverter::en2bn($sale->items->sum('quantity'))}} টি
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
