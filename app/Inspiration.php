<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspiration extends Model
{
    //
    protected $fillable = [
        'title', 'description'
    ];

    public function inspirationDisplays() {
        return $this->hasMany(InspirationDisplay::class, 'inspiration_id');
    }
}
