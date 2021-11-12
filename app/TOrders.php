<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOrders extends Model
{
    use HasFactory;

    protected $table = "t_orders";

    protected $fillable = ['car_id', 'finished_at', 'notes', 'status', 'start_at', 'total_payment'];

    protected $guarded = [];

    public function car()
    {
        return $this->belongsTo(MCars::class, 'car_id');
    }
}
