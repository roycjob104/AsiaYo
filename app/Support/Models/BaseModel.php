<?php

namespace App\Support\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
    }

    protected static function booted() {}
}
