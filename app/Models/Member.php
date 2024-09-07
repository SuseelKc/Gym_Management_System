<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pricing;
use App\Models\PackageAdmissionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Member extends Model
{
    use HasFactory;
    protected $table='members';

    protected $fillable=[
    'name',
    'photo',
    'gym_id',
    'serial_no',
    'dob',
    'address',
    'contact_no',
    'email',
    'shifts',
    'pricing_id',
    'start_date',
    'end_date',
    'status'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'gym_id');
    }
    public function pricing()
    {
        return $this->belongsTo(Pricing::class, 'pricing_id');
    }

    public function renew($requestData)
    {
        DB::beginTransaction(); 
    
        try {
            $renew = new PackageAdmissionLog();
            $renew->member_id = $requestData['member_id'];
            $renew->gym_id = auth()->id();
            $renew->package_id = $requestData['pricing_renew'];
            $renew->start_date = $requestData['renew_start_date'];
            $renew->end_date = $requestData['renew_end_date'];
            $renew->save();
    
            $member = Member::findOrFail($requestData['member_id']);
            $member->pricing_id = $requestData['pricing_renew'];
            $member->start_date = $requestData['renew_start_date'];
            $member->end_date = $requestData['renew_end_date'];
            $member->save();
    
            DB::commit(); 
    
            return true;
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
    
            return false;
        }
    }
}
