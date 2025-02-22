<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable=['name','guard_name','parent_id'];

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

    // public function getNameAttribute($value)
    // {
    //     return str_replace(' ', '-', strtolower($value));
    // }


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace(' ', '-', strtolower($value));
    }
    public function parent()
    {
        return $this->belongsTo(Permission::class,'parent_id','id');
    }
    public function child()
    {
        return $this->hasMany(Permission::class,'parent_id','id');
    }
}
