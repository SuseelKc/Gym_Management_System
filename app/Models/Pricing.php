<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function members()
    {
        return $this->hasMany(Member::class, 'pricing_id');
    }
}
