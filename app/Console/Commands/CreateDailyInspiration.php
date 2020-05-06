<?php

namespace App\Console\Commands;

use App\Http\Controllers\InspirationDisplayController;
use App\Inspiration;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateDailyInspiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:inspiration';

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
     * @return mixed
     */
    public function handle()
    {
        // insert a new inspiration

        // get all inspiration
        $inspirations = Inspiration::all();

        // get length of inspiration
        $inspirationLength = $inspirations->count();

        // if length is not less than zero do insert
        if ( $inspirationLength != 0) {
            // get length of month if 30, 31, 29, 28
            // get first day of the month
            $firstDay = new Carbon('first day of this month');
            $lastDay  = new Carbon('last day of this month');

            $dayDiff = $firstDay->diffInDays($lastDay) + 1;

            if ( $inspirationLength < $dayDiff) {
                $i = 0;
                while( $i < $dayDiff ) {
                    $randomId = rand(1, $inspirationLength);
                    $checkInpiration = InspirationDisplayController::where('date_added',
                        Carbon::today()->toDateString())
                        ->where('inspiration_id', $randomId)
                        ->first();

                    if ( $checkInpiration == null ) {
                        // insert
                        InspirationDisplayController::create([
                            'inspiration_id' => $randomId,
                            'date_added' => Carbon::now()->toDateString()
                        ]);
                        break;
                    }
                    $i++;
                }
            } else {
                $insertIntoDB = false;
                while( !$insertIntoDB) {
                    $randomId = rand(1, $inspirationLength);
                    $checkInpiration = InspirationDisplayController::where('date_added',
                        Carbon::today()->toDateString())
                        ->where('inspiration_id', $randomId)
                        ->first();

                    if ( $checkInpiration == null ) {
                        // insert
                        InspirationDisplayController::create([
                            'inspiration_id' => $randomId,
                            'date_added' => Carbon::now()->toDateString()
                        ]);
                        $insertIntoDB = true;
                        break;
                    }
                }
            }
        }

        // insert if id does not exists
        // if id exist, check month,
        // if month match, skip, if not insert
    }
}
