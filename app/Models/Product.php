<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'prd_id';

    protected $fillable = [
        'prd_name',
        'description',
        'brand_id',
        'price',
        'quantity',
        'image',
        'is_active',
        'id_admin'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function admin()
    {
        return $this->belongsTo(AcAdmin::class, 'id_admin');
    }
}
