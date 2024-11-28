<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AcUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'ac_users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'us_name',
        'username',
        'password',
        'Sdt',
        'email',
        'dc_nhanhang',
        'thanhpho',
        'id_admin'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(AcAdmin::class, 'id_admin');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
