<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Http;
class EmployeeController extends Controller
{
   
 
    public function fetchData()
{
    $apiUrl = 'https://backend.grabdata.org/api/pf'; 

    try {
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            $resultArray = [];
           

           // Map the data
            $filteredData = collect($data)->map(function ($item) {
                
                $checkedInAt = strtotime($item['checked_in_at']);
                $checkedOutAt = strtotime($item['checked_out_at']);
                $workTimeInSecond =  $checkedInAt -  $checkedOutAt;
                return [
                    'checked_in_at' => $item['checked_in_at'],
                    'checked_out_at' => $item['checked_out_at'],
                    'work_time' => gmdate("H:i:s",$workTimeInSecond),
                ];
            });
            foreach ($data as $item) {
                $checkedInAt = strtotime($item['checked_in_at']);
                $checkedOutAt = strtotime($item['checked_out_at']);
                $workTime =  $checkedInAt -  $checkedOutAt;
                 $resultArray[] = [
                     'user_id' => $item['user_id'],
                     'ip_address' => $item['ip_address'],
                     'checked_in_at' => $item['checked_in_at'],
                     'checked_out_at' => $item['checked_out_at'],
                    'work_time' => gmdate("H:i:s",$workTime),
                 ];
              
            }
            $filteredData = array_map(function ($item) {
                return [
                    'user_id' => $item['user_id'],
                    'ip_address' => $item['ip_address'],
                    'checked_in_at' => $item['checked_in_at'],
                    'checked_out_at' => $item['checked_out_at'],
                    'work_time' => gmdate("H:i:s",$workTime),

                ];
            }, $resultArray);

            return response()->json($resultArray);
        } else {
            return response()->json(['error' => 'Failed to fetch data from the API'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}



