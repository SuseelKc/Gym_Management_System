<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table='equipments';

    protected $fillable=[
        'name',
        'image',
        'serial_no',
        'maintenance_period',
        'upcoming_date',
        'gym_id'
    ];
}
