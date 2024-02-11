<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;
    protected $table='ledger';

    protected $fillable=[
        'date',
        'debit',
        'credit',
        'balance',
        'member_id',
        'gym_id'
        
    ];
}
