<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
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

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }


     public function getPermissionNameAttribute($value)
     {
         return str_replace(' ', '-', strtolower($value));
     }


     public function setPermissionNameAttribute($value)
     {
         $this->attributes['permission_name'] = str_replace(' ', '-', strtolower($value));
     }
}
