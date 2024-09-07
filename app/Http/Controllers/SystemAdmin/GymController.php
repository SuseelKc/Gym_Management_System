<?php

namespace App\Http\Controllers\SystemAdmin;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MemberRepository;

class GymController extends Controller
{
    //
    public function __construct(UserRepository $userRepository,UserService $userService,
    MemberRepository $memberRepository)
    {
        $this->userRepository = $userRepository;
        $this->userService=$userService;
        $this->memberRepository=$memberRepository;
    }


    public function index(){
        try{
            $gyms=$this->userRepository->getGymAdmin();         
            return view('systemadmin.gym.gym',compact('gyms'));
        }
        catch(Exception $e){


        }
    }

    public function listGymUser(Request $request) {
        try {
            // Pagination and sorting parameters from DataTables
            $length   = $request->input('length');  // How many records to display per page
            $start    = $request->input('start');   // Starting index for the records
            $columns  = $request->input('columns'); // Information about the columns
            $order    = $request->input('order');   // Sorting information
    
            // Sorting logic
            $orderBySql = '';
            if (isset($order[0]) && isset($columns[$order[0]['column']])) {
                if ($columns[$order[0]['column']]['data'] != 'Action' && $columns[$order[0]['column']]['data'] != 'sn') {
                    $orderBySql = "ORDER BY " . $columns[$order[0]['column']]['data'] . " " . $order[0]['dir'];
                }
            }
    
            // Get the current user ID to exclude from the query
            $userId = Auth::id();
    
            // WHERE clause to exclude the current user and filter active users
            $whereAllSql = "WHERE u.status='active' AND u.id != $userId";
    
            // Base query for fetching gym users and counting members per gym
            $basicQuery = "SELECT u.id, u.name, u.email, u.created_at, u.status, COUNT(m.gym_id) AS members
                           FROM users u
                           LEFT JOIN members m ON u.id = m.gym_id
                           $whereAllSql
                           GROUP BY u.id, u.name, u.email, u.created_at, u.status";
    
            // Apply LIMIT for pagination
            if ($length != -1) {
                $limitSql = " LIMIT $start, $length";
            } else {
                $limitSql = "";
            }
    
            // Final query including sorting and pagination
            $query = "$basicQuery $orderBySql $limitSql";
    
            // Execute the main query
            $gym = DB::select($query);
    
            // Prepare the result set for DataTables
            $count = $start + 1; // Start counting from the correct index
            $result = array();
            foreach ($gym as $user) {
                $row = (array) $user;
                $row['sn'] = $count;
                $row['action'] = "<a href='#' class='edit-user-btn' data-id='$user->id' title='Edit user'><i class='fas fa-edit fa-lg'></i></a>";
                $result[] = $row;
                $count++;
            }
    
            // Query to get the filtered record count (records after applying filters)
            $recordsFilteredQuery = "SELECT COUNT(DISTINCT u.id) AS records_filtered
                                     FROM users u
                                     LEFT JOIN members m ON u.id = m.gym_id
                                     $whereAllSql";
            $recordsFilteredResult = DB::select($recordsFilteredQuery);
            $recordsFiltered = $recordsFilteredResult[0]->records_filtered;
    
            // Query to get the total record count (all records without filtering)
            $recordsTotalQuery = "SELECT COUNT(*) AS records_total
                                  FROM users
                                  WHERE status='active' AND id != $userId";
            $recordsTotalResult = DB::select($recordsTotalQuery);
            $recordsTotal = $recordsTotalResult[0]->records_total;
    
            // Prepare the response in the format expected by DataTables
            $response = array(
                'draw'            => intval($request->input('draw')),
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $result,
            );
    
            // Return the JSON response
            return response()->json($response);
        } catch (Exception $e) {
            // Log any errors
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

    public function delete($id){
        try{
            $members=$this->memberRepository->gymMembers($id);
            foreach($members as $member){
            $memberUser = $this->userRepository->getGymMember($member->id);


            if ($memberUser->isNotEmpty()) {
                toast("Memeber exists as users remove them to remove this gym!",'error');
                // dd("Here");
                return redirect()->back();
              
            }
        }

            $gym=$this->userService->deleteGymAdmin($id);
            toast('Gym Deleted Successfully!','success');
            return redirect()->intended(route('gym.index')); 
        }
        catch(Exception $e){

        }
    }
}
