<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_code',
        'user_id',
        'customer_name',
        'customer_note',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'status',
        'product_name',
        'product_price',
        'quantity',
        'total_price',
        'prd_id',
        'id_admin'
    ];



    public function user()
    {
        return $this->belongsTo(AcUser::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(AcAdmin::class, 'id_admin');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'prd_id');
    }
}
