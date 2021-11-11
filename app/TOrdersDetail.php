<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOrdersDetail extends Model
{
    use HasFactory;

    protected $table = "t_orders_detail";

    protected $fillable = ['order_id', 'service_id', 'notes', 'price', 'qty'];

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(TOrders::class, 'order_id');
    }

    public function service()
    {
        return $this->belongsTo(MServices::class, 'service_id');
    }
}
