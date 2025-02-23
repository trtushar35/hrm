<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use  Notifiable, HasFactory, HasRoles;

    protected $table = 'admins';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role_id',
        'photo',
        'address',
        'sorting',
        'department_id',
        'designation_id',
        'salary',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['name'];
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getPhotoAttribute($value)
    {
        return (!is_null($value)) ? env('APP_URL') . '/storage/' . $value : null;
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
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
