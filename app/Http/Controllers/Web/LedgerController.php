<?php

namespace App\Http\Controllers\Web;


use App\Models\Ledger;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\LedgerService;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LedgerController extends Controller
{
    //
    public function __construct(LedgerService $ledgerService,MemberService $memberService,MemberRepository $memberRepository,LedgerRepository $ledgerRepository)
    {
        $this->ledgerService = $ledgerService;
        $this->memberService= $memberService;
        $this->memberRepository=$memberRepository;
        $this->ledgerRepository=$ledgerRepository;
       
    }
    public function index(){
        try
        {
            $members= $this->memberService->all()->ToArray();                   
            return view('admin.ledger.index',compact('members'));
        }
        catch(Exception $e){

        }
    }
    public function search($id){
        try{           
            $ledger=$this->ledgerService->search($id);
            $selectedMember=$this->memberRepository->getById($id);          
            $members= $this->memberService->all()->ToArray();  
            return view('admin.ledger.search',compact('ledger','members','selectedMember'));
          
        }
        catch(Exception $e){

        }
    }

    public function storeMemberPayment($id, Request $request){
        try {                
            $selectedMember = $this->memberRepository->getById($id);  
            $recentBalance = $this->ledgerRepository->getAll()->where('member_id', $id)->sortByDesc('created_at')->first();
            
            if ($recentBalance == null) {
                toast("Member has not purchased any package!", 'warning');
                return redirect()->back();
            }
                                
            $ledger = $this->ledgerService->addMemberPayment($selectedMember, $request, $recentBalance);
        
            if ($ledger) {
                toast('Member Payment Added Successfully!', 'success');
                return redirect()->back();
            } else {
                toast('Failed to add member payment.', 'error');
                return redirect()->back();
            }
    
        } catch (Exception $e) {           
            Log::error('Error in storeMemberPayment: ' . $e->getMessage());
            toast('Failed to add member payment. Please try again later.', 'error');
            return redirect()->back();
        }
    }
    
    public function ledger()
    {
        try
        {  
            $condition = "";

            if(!empty(request()->input('employeeId')))
            {
                $employeeId = request()->input('employeeId');
                $condition = " AND member_id = '$employeeId'";
            }
            
            
            $gym_id = Auth::id();

            $basicQuery = " SELECT *, m.serial_no, m.name
                FROM ledger 
                JOIN members m on m.id=ledger.member_id
                WHERE ledger.gym_id = $gym_id $condition ORDER BY ledger.id desc";

            $ledger = DB::select($basicQuery);
        
            $count = 1;
            $result = array();
            
            foreach ($ledger as $led) 
            {
                $row = (array) $led;

                $row['sn'] = $count;

                $result[] = $row;
                
                $count++;
            }

            return response()->json([
                "draw" => intval(request()->input('draw')),
                "recordsTotal" => count($ledger),
                "recordsFiltered" => count($ledger),
                "data" => $result
            ]);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMembers(Request $request)
    {
        $gym_id = Auth::id();
        $searchTerm = $request->input('searchTerm');
    
        $members = Member::where('gym_id', $gym_id)
                            ->where('status', 'active')
                            ->where(function($query) use ($searchTerm) {
                                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                                      ->orWhere('serial_no', 'LIKE', '%' . $searchTerm . '%');
                            })
                            ->get(['id', 'name', 'serial_no']); 
    
        return response()->json($members);
    }
}
