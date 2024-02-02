<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;
    protected $table='equipments';

    protected $fillable=[
        'name',
        'image',
        'serial_no',
        'weight',
        'qty',
        'maintenance_period',
        'maintenance_type',
        'upcoming_date',
        'gym_id'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

}
