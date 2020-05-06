<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class InspirationDisplayController extends Controller
{
    //
    public function getTodaysInspiration() {
        // get inspiration
        $inspiration = InspirationDisplayController::with('inspiration')
            ->where('date_added', Carbon::today()->toDateString())
            ->first();

        return response()->json([
            'success' => true,
            'data' => $inspiration
        ], 200);
    }
}
