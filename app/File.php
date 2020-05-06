<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    //
    protected $fillable = [
        'name', 'size', 'type', 'extension'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
