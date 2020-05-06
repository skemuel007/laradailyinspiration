<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspirationDisplay extends Model
{
    //
    protected $fillable = [
        'inspiration_id',
        'date_added'
    ];

    public function inspiration() {
        return $this->belongsTo(Inspiration::class );
    }
}
