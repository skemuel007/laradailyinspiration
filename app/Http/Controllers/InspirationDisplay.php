<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class InspirationDisplay extends Controller
{
    //
    public function getTodaysInspiration() {
        // get inspiration
        $inspiration = InspirationDisplay::with('inspiration')
            ->where('date_added', Carbon::today()->toDateString())
            ->first();

        return response()->json([
            'success' => true,
            'data' => $inspiration
        ], 200);
    }
}
