<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    protected $table='pricing';

    protected $fillable=[
        'name',
        'costs',
        'costs_type',
        'start_date',
        'end_date',
        'gym_id'
    ];
}
