<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DailyProductRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:products';

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
        $date = Carbon::now()->format('Y-m-d');
        $file = 'product_records/' . Carbon::now()->format('Y_m_d') . ".json";

        $items = Product::query()
            ->select([
                'id',
                'name',
                "purchased_items" => function (Builder $builder) use ($date) {
                    $builder
                        ->from("purchase_items")
                        ->whereDate("purchase_items.created_at", "=", $date)
                        ->where("purchase_items.product_id", "=", DB::raw("products.id"))
                        ->selectRaw("IFNULL(SUM(purchase_items.quantity),0)");
                },
                "purchase_returned_items" => function (Builder $builder) use ($date) {
                    $builder
                        ->from("purchase_returns")
                        ->whereDate("purchase_returns.created_at", "=", $date)
                        ->where("purchase_returns.product_id", "=", DB::raw("products.id"))
                        ->selectRaw("IFNULL(SUM(purchase_returns.quantity),0)");
                },
                "sold_items" => function (Builder $builder) use ($date) {
                    $builder
                        ->from("sale_items")
                        ->whereDate("sale_items.created_at", "=", $date)
                        ->where("sale_items.product_id", "=", DB::raw("products.id"))
                        ->selectRaw("IFNULL(SUM(sale_items.quantity),0)");
                },
                "sold_returned_items" => function (Builder $builder) use ($date) {
                    $builder
                        ->from("sale_returns")
                        ->whereDate("sale_returns.created_at", "=", $date)
                        ->where("sale_returns.product_id", "=", DB::raw("products.id"))
                        ->selectRaw("IFNULL(SUM(sale_returns.quantity),0)");
                },
                DB::raw('quantity as stock'),
            ])->get();

        Storage::put($file, $items->toJson());
        return 0;
    }
}
