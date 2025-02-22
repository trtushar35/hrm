<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemErrorLog extends Model
{
    use HasFactory;

    protected $appends = ['date_time'];

    protected $fillable=[
        'namespace',
        'controller',
        'function',
        'log',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();


        static::creating(function ($model) {
            $model->created_at = now();
        });


        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    public function getDateTimeAttribute()
    {
        return dateTime($this->attributes['created_at']);
    }
}
