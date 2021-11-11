<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMechanics extends Model
{
    use HasFactory;

    protected $table = "m_mechanics";

    protected $fillable = ['name', 'email', 'password'];

    protected $guarded = [];
}
