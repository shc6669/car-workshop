<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TJobs extends Model
{
    use HasFactory;

    protected $table = "t_jobs";

    protected $fillable = ['mechanic_id', 'order_id', 'status'];

    protected $guarded = [];

    public function mechanic()
    {
        return $this->belongsTo(MMechanics::class, 'mechanic_id');
    }

    public function order()
    {
        return $this->belongsTo(TOrders::class, 'order_id');
    }
}
