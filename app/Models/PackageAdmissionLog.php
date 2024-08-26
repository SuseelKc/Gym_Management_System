<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageAdmissionLog extends Model
{
    use HasFactory;
    protected $table='package_admission_log';

    protected $fillable=[
        'member_id',
        'gym_id',
        'package_id',
        'admission_price',
        'start_date',
        'end_date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
