<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCars extends Model
{
    use HasFactory;

    protected $table = "m_cars";

    protected $fillable = ['name', 'email', 'password'];

    protected $guarded = [];
}
