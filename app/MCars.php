<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCars extends Model
{
    use HasFactory;

    protected $table = "m_cars";

    protected $fillable = ['licence_plate', 'name', 'status', 'user_id'];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
