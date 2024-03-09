<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $table='expenses';

    protected $fillable=[
        'name',
        'type',        
        'costs',
        'gym_id',
        'start_date',
        'end_date'
    ];
}
