<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'position',
        'email'               
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'gym_id');
    }
}
