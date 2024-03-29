<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pricing;
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
    'pricing_id'   
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pricing()
    {
        return $this->belongsTo(Pricing::class, 'pricing_id');
    }


}
