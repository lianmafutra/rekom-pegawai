<?php

namespace App\Utils;

use Throwable;
use Illuminate\Support\Str;

trait AutoUUID
{
   protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->uuid =  Str::uuid()->toString();;
            } catch (Throwable $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
