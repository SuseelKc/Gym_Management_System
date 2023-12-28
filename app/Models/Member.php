<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;
    protected $table='members';

    protected $fillable=[
    'name',
    'photo',
    'user_id',
    'serial_no',
    'dob',
    'address',
    'contact_no',
    'email',
    'package'
    
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
