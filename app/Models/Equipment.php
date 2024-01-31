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
        'weight',
        'maintenance_period',
        'maintenance_type',
        'upcoming_date',
        'gym_id'
    ];
}
