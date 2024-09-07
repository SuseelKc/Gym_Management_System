<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Member;
use App\Models\Pricing;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\LedgerService;
use App\Services\MemberService;
use App\Services\PricingService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class MemberController extends Controller
{
    //
    public function __construct(MemberService $memberService,MemberRepository $memberRepository,PricingService $pricingService,UserRepository $userRepository,
    LedgerService $ledgerService,LedgerRepository $ledgerRepository,UserService $userService)
    {
        $this->memberService = $memberService;
        $this->memberRepository = $memberRepository;
        $this->ledgerRepository = $ledgerRepository;
        $this->userRepository = $userRepository;
        $this->pricingService =$pricingService;
        $this->ledgerService =$ledgerService;
        $this->userService =$userService;
    }

    public function index(Request $request){
        try{
            $member=$this->memberService->all();          
            return view('admin.member.index',compact('member'));
        }
        catch(Exception $e){

        }

    }

    public function create(){
        try{
            
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            $pricing = $this->pricingService->all();             
            return view('admin.member.create',compact('gym','pricing'));
           
        }
        catch(Exception $e){

        }
    }

    public function store(Request $request){
        try{
            $gymId=auth()->id();      
            $oldMembers=$this->memberRepository->gymMembers($gymId);
            // dd($request->all());
            foreach($oldMembers as $oldMember){
                if(($request->email)==($oldMember->email)){
                    toast('Email Arleady Exists!','error');
                    return redirect()->back();
                }
                if(($request->contact_no)==($oldMember->contact_no)){
                    toast('Contact No. Arleady Exists!','error');
                    return redirect()->back();
                }
            }

           $member= new Member();        
           $member= $this->memberService->add($member,$request);
           toast('New Member Added Successfully!','success');
           return redirect()->intended(route('member.index'));
           
        }
        catch(Exception $e){

        }
    }

    public function edit($id){
        try{            
            $member=Member::FindOrFail($id);
            $pricing = $this->pricingService->all(); 
            $user=$this->userRepository->getGymMember($id);
            // dd($user);
            return view('admin.member.edit',compact('member','pricing','user'));          
        }
        catch(Exception $e){

        }
    }

    public function update(Request $request,$id){
        try{            
            $member=Member::FindOrFail($id);
            $member=$this->memberService->update($member,$id,$request);
            toast('Member Updated Successfully!','success');
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }

    public function delete($id){
        try{            
            $member=Member::FindOrFail($id);
            
            $memberId=$id;
           
            $ledgers= $this->ledgerRepository->getMember($memberId);
           
            if(!$ledgers ->isEmpty()){ //if ledger is not empty
                
                foreach($ledgers as $ledger){
                   
                $ledgerId=$ledger->id;   
              
                $ledger=$this->ledgerService->deleteMemberLedger($ledgerId);
                }
                // 
                $user=$this->userRepository->getGymMember($id);
                if(!$user->isEmpty()){
                   
                    // $user->member_id= null;
                    $user=$this->userService->deleteGymMember($user);
                }
                // 
                $member=$this->memberService->delete($id);
                toast('Member & Other Details Deleted Successfully!','success');
                return redirect()->intended(route('member.index'));  
            }
            // 
            $user=$this->userRepository->getGymMember($id);
            if(!$user->isEmpty()){
               
                // $user->member_id= null;
                $user=$this->userService->deleteGymMember($user);
            }
            // 
            $member=$this->memberService->delete($id);
            toast('Member Deleted Successfully!','success');
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }

    public function toggle($id){
        try{            
            $member=Member::FindOrFail($id);
            $member=$this->memberService->toggle($id);
            toast('Member Shift Changed Successfully!','success');
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }

    public function renwewmembership(){
        try{
            $member=$this->memberService->all()->where('pricing_id',null)->where('pricing_type',null)->where('pricing_date',null);   
            return view('admin.member.renew',compact('member')); 
        }
        catch(Exception $e){

        }
    }

    public function createAccount($id){
        try{
            $member= $this->memberRepository->getById($id);
            $member=$this->memberService->createMemberAccount($member);
            toast('Member Account Created Successfully!','success');
            return redirect()->intended(route('member.index'));
        }
        catch(Exception $e){

        }
    }

    public function listMember(Request $request)
    {
        try
        {
            $length   = $request->input('length');
            $start    = $request->input('start');
            $columns  = $request->input('columns');
            $order    = $request->input('order');

            $orderBySql = '';
        
            if (isset($order[0]) && isset($columns[$order[0]['column']]))
            {
                if ($columns[$order[0]['column']]['data'] != 'Action' && $columns[$order[0]['column']]['data'] != 'sn')
                {
                    $orderBySql = "ORDER BY " . $columns[$order[0]['column']]['data'] . " " . $order[0]['dir'];
                }
            }

            $userId = Auth::id();
            $whereAllSql = "WHERE m.status='active' AND m.gym_id = $userId ";

            foreach ($columns as $key => $value)
            {
                if (!empty($value['search']['value']))
                {
                    if ($value['data'] == 'package_name') 
                    {
                        $sqlString = " AND p.name LIKE '%" . $value['search']['value'] . "%' ";
                    } 
                    else 
                    {
                        $sqlString = " AND m." . $value['data'] . " LIKE '%" . $value['search']['value'] . "%' ";
                    }
                    $whereAllSql .= $sqlString;
                }
            }
            
            $basicQuery = "SELECT m.id, m.serial_no, m.name, m.email, m.dob, m.contact_no, m.shifts, m.pricing_id, m.status, m.photo, p.name as package_name, m.gym_id, m.end_date
                FROM members m
                LEFT JOIN pricing p ON m.pricing_id = p.id";

            if ($length != -1) 
            {
                $limitSql = " LIMIT $start, $length";
            } 
            else 
            {
                $limitSql = "";
            }

            $query = "$basicQuery $whereAllSql $orderBySql $limitSql";
            
            $members = DB::select($query);

            $count = 1;
            $result = array();
            
            foreach ($members as $member) 
            {
                $row = (array) $member;

                $row['sn'] = $count;
                
                $dob = $row['dob'];
                
                $age = Carbon::parse($dob)->age;
                $row['age'] = $age;

                if ($member->shifts == "Morning") 
                {
                    $shiftHtml = '<a id="shifts" class="badge p-2 rounded" style="background-color: #ceefd1;color:#53b15b">Morning</a>';
                } 
                elseif ($member->shifts == "Day") 
                {
                    $shiftHtml = '<a id="shifts" class="badge p-2 rounded" style="background-color: #e1c32c;color:#3685d3">Day</a>';
                } 
                else 
                {
                    $shiftHtml = '<a id="shifts" class="badge p-2 rounded" style="background-color: #303030;color:#dedcd9">Evening</a>';
                }

                $row['shifts'] = $shiftHtml;

                $photoHtml = $member->photo == null ?
                '<img src="/images/defaultimage.jpg" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">' :
                '<img src="/images/members/' . $member->photo . '" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">';
                $row['photo'] = $photoHtml;

                // Generate the edit and delete links
                $editUrl = route('member.edit', $member->id);
           
                $row['package_name'] = $member->package_name;
              
                $row['status'] = "
                    <a href='#' class='edit-member-btn' data-id='$member->id' title='Edit Member'>
                        <i class='fas fa-edit fa-lg'></i>
                    </a>
                    <a href='#' class='delete-member-btn' data-id='$member->id' data-name='$member->name' title='Delete Member'>
                        <i class='fas fa-times-circle fa-lg' style='color: red;'></i>
                    </a>
                    <a href='#' class='renew-member-btn' data-id='$member->id' data-name='$member->name' data-renew='$member->end_date' title='Renew Member'>
                        <i class='fas fa-sync-alt fa-lg' style='color: green;'></i>
                    </a>
                ";
                
                $result[] = $row;
                
                $count++;
            }

            $recordsFilteredQuery = "SELECT count(*) AS records_filtered FROM ($basicQuery $whereAllSql) a";
            $recordsFilteredResult = DB::select($recordsFilteredQuery);

            $recordsFiltered = $recordsFilteredResult[0]->records_filtered;

            $response = array(
                'draw'            => intval($request->input('draw')) + 1,
                'recordsTotal'    => $recordsFiltered,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $result,
            );

            print(json_encode($response));
            exit();
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function displayCreateModal()
    {
        $gym_id=auth()->id();
        $gym=User::FindOrFail($gym_id);
        $pricing = $this->pricingService->all();  

        return view('admin.member.create_member_modal', compact('pricing', 'gym'));
    }

    public function saveMember(Request $request)
    {
        try
        {   
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'dob' => 'required|date',
                'address' => 'required|string|max:255',
                'contact_no' => 'required|max:10',
                'email' => 'required|email|max:255',
                // 'pricing' => 'required',
            ]);

            if ($validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }

           $member= new Member();
           $member= $this->memberService->add($member,$request);
           
           return response()->json(['success' => 'Member saved successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDataForMemberEdit($id)
    {
        try
        {       
            $member=Member::FindOrFail($id);
            $userName = $member->user->name;
            
            $package_name = "N/A";
            if(!empty($member->pricing))
            {
                $package_name = $member->pricing->name;
            }
            
            return response()->json(['success' => true, 'member' => $member, 'package_name' => $package_name, 'userName' => $userName], 200);      
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateMember(Request $request)
    {
        try
        { 
            $validator = Validator::make($request->all(), [
                'member_id' => 'required',
                'name' => 'required|string|max:255',
                'dob' => 'required|date',
                'address' => 'required|string|max:255',
                'contact_no' => 'required|max:10',
                'email' => 'required|email|max:255',
                'shift' => 'required',
            ]);

            if ($validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $id = $request->member_id;
            $member=Member::FindOrFail($id);
            $member = $this->memberService->update($member, $id, $request);
         
            return response()->json(['success' => 'Member saved successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteMember($id)
    {
        try
        { 
            $member = Member::findOrFail($id);

            $member->status = 'deleted';
            $member->save();
            
            return response()->json(['success' => 'Member Deleted Successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPackageDuration(Request $request)
    {
        $packageId = $request->input('package_id');
        $package = Pricing::find($packageId);
    
        if ($package) 
        {
            $startDate = Carbon::now();
            $endDate = $startDate; 
    
            if ($package->costs_type === 'Days') 
            {
                $endDate = $startDate->copy()->addDays($package->duration);
            } 
            elseif ($package->costs_type === 'Month') 
            {
                $endDate = $startDate->copy()->addMonths($package->duration);
            } 
            elseif ($package->costs_type === 'Year') 
            {
                $endDate = $startDate->copy()->addYears($package->duration);
            } else 
            {
                return response()->json(['error' => 'Invalid costs type'], 400);
            }
    
            $totalDays = $startDate->diffInDays($endDate);
            
            return response()->json([
                'duration' => $totalDays,
            ], 200);
        } 
        else 
        {
            return response()->json(['error' => 'Package not found'], 404);
        }
    }

    public function displayRenewModal()
    {
        $pricing = $this->pricingService->all();  

        return view('admin.member.renew_member_modal', compact('pricing'));
    }

    public function renewMember(Request $request)
    {
        try
        {   
            $validator = Validator::make($request->all(), [
                'pricing_renew' => 'required',
                'shift' => 'required',
                'member_id' => 'required',
                'renew_start_date' => 'required|date',
                'renew_end_date' => 'required|date',
            ]);

            if ($validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $member = Member::findOrFail($request->member_id);

            if ($member->renew($request->all())) 
            {
                return response()->json(['success' => 'Member renewed successfully.'], 200);
            } 
            else 
            {
                return response()->json(['error' => 'Failed to renew member.'], 500);
            }
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
