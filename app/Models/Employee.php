<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'photo',
        'address',
        'sorting',
        'hiring_date',
        'joining_date',
        'department_id',
        'designation_id',
        'salary',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_at = date('Y-m-d H:i:s');
        });

        static::updating(function ($model) {
            $model->updated_at = date('Y-m-d H:i:s');
        });
    }

    public function getPhotoAttribute($value)
    {
        return (!is_null($value)) ? env('APP_URL') . '/storage/' . $value : null;
    }
    
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
}
