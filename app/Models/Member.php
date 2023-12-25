<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table='members';

    protected $fillable=[
    'name',
    'gym_name',
    'serial_no',
    'dob',
    'address',
    'contact_no',
    'email',
    'package'
    ];
    
}
