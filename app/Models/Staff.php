<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table='staffs';

    protected $fillable=[
        'name',
        'photo',
        'gym_id',
        'serial_no',
        'dob',
        'address',
        'contact_no',
        'email'               
        ];


}
