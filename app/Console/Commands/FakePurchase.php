<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FakePurchase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:purchase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dates = [
            Carbon::parse("2020-10-16")
        ];
//        for ($x = -5; $x <= 5; $x++) {
//            $dates[] = Carbon::now()->addDays($x);
//        }
        foreach ($dates as $date) {
            $purchase = new Purchase();
            $purchase->forceFill([
                "supplier_id" => random_int(1, 5),
                "total" => 0,
                "tax" => 0,
                "discount" => 0,
                "payable" => 0,
                "returned" => 0,
                "date" => $date->format('Y-m-d'),
                "status" => "Processed",
                "paid" => 0,
                "created_at" => $date,
                "updated_at" => $date,
            ]);
            $purchase->saveOrFail();
            $total = 0;
            for ($x = 1; $x <= 3; $x++) {
                $purchase_item = new PurchaseItem();
                $quantity = random_int(1, 3);
                $product = Product::query()->findOrFail(random_int(1, 10));
                $total += $quantity * $product->price;
                $purchase_item->forceFill([
                    "sale_id" => $purchase->id,
                    "product_id" => $product->id,
                    "supplier_id" => $purchase->supplier_id,
                    "quantity" => $quantity,
                    "price" => $product->price,
                    "total" => $quantity * $product->price,
                    "returned_quantity" => 0,
                    "returned_total" => 0,
                    "created_at" => $date,
                    "updated_at" => $date,
                ]);
                $purchase_item->saveOrFail();
            }
            $purchase->payable = $total;
            $purchase->total = $total;
            $purchase->saveOrFail();
            return 0;
        }
    }
}
