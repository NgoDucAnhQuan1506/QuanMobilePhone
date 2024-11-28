<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AcAdmin extends Authenticatable
{
    use Notifiable;

    protected $table = 'ac_admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'ad_name',
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(AcUser::class, 'id_admin');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_admin');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_admin');
    }
}

