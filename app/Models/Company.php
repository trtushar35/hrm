<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_at=date('Y-m-d H:i:s');
        });

        static::updating( function ( $model ) {
            $model->updated_at=date('Y-m-d H:i:s');
        } );
    }
}
