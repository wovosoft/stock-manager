<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Invoice # {{$sale->id}}</title>
    <style>

        html, body {
            font-family: 'bangla', sans-serif;
        }


        table.invoice tbody tr
            /*table.invoice th, table.invoice td */
        {
            border: 1px solid lightgray;
        }

        table.invoice th, table.invoice td {
            padding: 3px 5px;
        }

        /*table.invoice tbody tr:nth-child(odd) {*/
        /*    background-color: lightgray;*/
        /*}*/
        table.invoice tbody tr {
            border: 1px solid lightgray;
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
<body style="width: 48%;">

@if($is_delivery)
    @include("pages.sales.invoice_header")
    @include("pages.sales.delivery_slip")
@elseif($invoice_both)
    @include("pages.sales.invoice_header")
    @include("pages.sales.cash_invoice")
    <div style="border-top:1px dotted gray;margin-top: 2in;margin-bottom: 40px;"></div>
    @include("pages.sales.invoice_header")
    @include("pages.sales.delivery_slip")
@else
    @include("pages.sales.invoice_header")
    @include("pages.sales.cash_invoice")
@endif
{!! _s('invoice_footer') !!}
@if(isset($auto_print) && $auto_print)
    <script>
        window.print();
    </script>
@endif
</body>
</html>
