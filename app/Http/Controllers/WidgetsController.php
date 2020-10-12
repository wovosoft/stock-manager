<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\CheckOut;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class WidgetsController extends Controller
{
    public static function routes()
    {
        Route::post("widgets/overview/check_in_check_out", '\\' . __CLASS__ . '@checkInOut')->name('Widgets.CheckInOuts');
    }

    public function checkInOut(Request $request)
    {
        return response()->json([
            "check_in"=>CheckIn::query()
                ->whereDate('datetime', 'LIKE', $request->post('month') . "%")
                ->select(DB::raw('DATE(datetime) as date'), DB::raw('count(*) as views'))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->pluck('views','date'),
            "check_out"=>CheckOut::query()
                ->whereDate('datetime', 'LIKE', $request->post('month') . "%")
                ->select(DB::raw('DATE(datetime) as date'), DB::raw('count(*) as views'))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->pluck('views','date')
        ]);
    }
}


//        ->groupBy(fn($data) => Carbon::parse($data->datetime)->format('d'));
