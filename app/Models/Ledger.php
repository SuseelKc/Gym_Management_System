<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ledger extends Model
{
    use HasFactory;
    protected $table='ledger';

    protected $fillable=[
        'date',//
        'debit',
        'credit',//
        'balance',//
        'member_id',//
        'gym_id',//
        'receipt_no',//
        'remarks'//
        
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    

}
