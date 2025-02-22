<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;
    protected $appends = ['date_time'];

    protected $fillable=[
        'data_id',
        'admin_id',
        'user_type',
        'reference_table',
        'note',
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

    public function adminInfo()
    {
        return $this->hasOne(Admin::class,'id','user_id');
    }

    public function getDateTimeAttribute()
    {
        return date('d F, Y h:i A',strtotime($this->attributes['created_at']));
    }
    public function setReferenceTableAttribute($value)
    {
        $this->attributes['reference_table'] = strtolower($value);
    }
}
