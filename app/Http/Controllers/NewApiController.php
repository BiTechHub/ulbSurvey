<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\SurveyStep1;
use Str;

class NewApiController extends Controller
{
    public function androidLogin(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
        'imei'     => 'nullable|string',
    ]);

    $user = DB::table('users')->where('username', $request->username)->first();

    if (!$user || $request->password != $user->password) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid username or password'
        ], 401);
    }

    $token = Str::random(60);

    DB::table('users')->where('id', $user->id)->update([
        'api_token' => $token,
        'imei' => $request->imei ?? $user->imei,
    ]);

    $userData = DB::table('users')->where('id', $user->id)->first();

    return response()->json([
        'success' => true,
        'message' => 'Login successful',
        'token_type' => 'Bearer',
        'token' => $token,
        'data' => [
            'id'        => $userData->id,
            'name'      => $userData->name,
            'username'  => $userData->username,
            'user_type' => $userData->user_type,
            'city'      => $userData->city,
            'ward_no'   => $userData->ward_no,
            'ward_name' => $userData->ward_name,
            'mohalla'   => $userData->mohalla,
            'imei'      => $userData->imei,
            'status'    => $userData->status,
        ]
    ], 200);
}

    


public function genHouseNumber(Request $request)
{
    // ---------------- VALIDATION ----------------
    $request->validate([
        'ward_no'    => 'required|integer',
        'lat'        => 'required|numeric',
        'long'       => 'required|numeric',
        'image_name' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
    ]);

    // ---------------- GET AUTH USER ----------------
    $user = $request->attributes->get('auth_user');
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ], 404);
    }

    DB::beginTransaction();

    try {
        // ---------------- LAST HOUSE NUMBER ----------------
        $lastHouse = DB::table('survey_personal_details')
            ->where('ward_number', $request->ward_no)
            ->where('city', $user->city)
            ->orderByDesc('id')
            ->value('house_number');

        $house_number = 0;
        if ($lastHouse) {
            preg_match('/\d+/', $lastHouse, $matches);
            $house_number = (int) ($matches[0] ?? 0) + 1;
        } else {
            $house_number = (10000 * $request->ward_no) + 1;
        }

        // ---------------- IMAGE UPLOAD ----------------
        $states_cities = DB::table('states_cities')
            ->where('city', $user->city)
            ->first();

        $destinationPath = public_path('gis_image/' . ($states_cities->ulb_name_url ?? 'default'));
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $imageFile = $request->file('image_name');
        if (!$imageFile->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image upload'
            ], 422);
        }

        $extension  = $imageFile->getClientOriginalExtension();
        $image_name = $house_number . '_' . time() . '.' . $extension;
        $tmpPath    = $imageFile->getRealPath();

        if (in_array($imageFile->getMimeType(), ['image/jpeg', 'image/jpg'])) {
            $image = imagecreatefromjpeg($tmpPath);
            imagejpeg($image, $destinationPath.'/'.$image_name, 60);
            imagedestroy($image);
        } else {
            $imageFile->move($destinationPath, $image_name);
        }

        // ---------------- INSERT HOUSE DATA ----------------
        $surv_id = DB::table('survey_personal_details')->insertGetId([
            'house_number'   => $house_number,
            'ward_number'    => $request->ward_no,
            'lat'            => $request->lat,
            'lng'            => $request->long,
            'city'           => $user->city,
            'user_name'      => $user->username,
            'user_id'        => $user->id,
            'imei'           => $user->imei,
            'image_name'     => $image_name,
            'ward_name'      => is_array($user->ward_name) ? implode(',', $user->ward_name) : $user->ward_name,
            'mohalla_name'   => is_array($user->mohalla) ? implode(',', $user->mohalla) : $user->mohalla,
            'step_1'         => 'Completed',
            'status'         => 'step_1',
            'step_1_veryfied'=> 'NotVerified',
            'DataVerified'=> 'NotVerified',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'status' => 'step_1',
            'surv_id' => $surv_id,
            'message' => 'House number generated successfully',
            'house_number' => $house_number,
            'image_name' => $image_name
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


public function getPendingPersonalDetails(Request $request)
{
    $request->validate([
        'search'  => 'nullable|string',
        'page'    => 'nullable|integer'
    ]);
$user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $city    = $user->city;
    $search  = $request->search;

    $query = DB::table('survey_personal_details')
        ->where('status', '!=', 'Completed')
        ->where('step_1_veryfied', '!=', 'Rejected')
        ->where('city', $city)
        ->where('user_id', $user_id);

    // 🔍 Search filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%$search%")
              ->orWhere('ward_number', 'like', "%$search%")
              ->orWhere('ward_name', 'like', "%$search%")
              ->orWhere('city', 'like', "%$search%");
        });
    }

    $houses = $query->orderBy('id','desc')->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Pending Personal Details list fetched successfully',
        'data' => $houses->items(),
        'pagination' => [
            'current_page' => $houses->currentPage(),
            'last_page' => $houses->lastPage(),
            'total' => $houses->total(),
            'per_page' => $houses->perPage()
        ]
    ]);
}

  public function rejected_new_house(Request $request)
{
    $request->validate([
        'search'  => 'nullable|string',
        'page'    => 'nullable|integer'
    ]);
  
$user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $city    = $user->city;
    $search  = $request->search;

    $query = DB::table('survey_personal_details')
        ->where('step_1', 'Completed')
        ->where('step_1_veryfied', 'Rejected')
        ->where('city', $city)
        ->where('user_id', $user_id);

    // 🔍 Search filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%$search%")
              ->orWhere('ward_number', 'like', "%$search%")
              ->orWhere('ward_name', 'like', "%$search%")
              ->orWhere('city', 'like', "%$search%");
        });
    }

    $houses = $query->orderBy('id','desc')->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Rejected New House list fetched successfully',
        'data' => $houses->items(),
        'pagination' => [
            'current_page' => $houses->currentPage(),
            'last_page' => $houses->lastPage(),
            'total' => $houses->total(),
            'per_page' => $houses->perPage()
        ]
    ]);
}

  public function rejected_personal_details(Request $request)
{
    $request->validate([
        'search'  => 'nullable|string',
        'page'    => 'nullable|integer'
    ]);
  
$user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $city    = $user->city;
    $search  = $request->search;

    $query = DB::table('survey_personal_details')
        ->where('status', 'Completed')
        ->where('DataVerified', 'Rejected')
        ->where('city', $city)
        ->where('user_id', $user_id);

    // 🔍 Search filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%$search%")
              ->orWhere('ward_number', 'like', "%$search%")
              ->orWhere('ward_name', 'like', "%$search%")
              ->orWhere('city', 'like', "%$search%");
        });
    }

    $houses = $query->orderBy('id','desc')->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Rejected Personal Details list fetched successfully',
        'data' => $houses->items(),
        'pagination' => [
            'current_page' => $houses->currentPage(),
            'last_page' => $houses->lastPage(),
            'total' => $houses->total(),
            'per_page' => $houses->perPage()
        ]
    ]);
}


  public function notVerified_personal_details(Request $request)
{
    $request->validate([
        'search'  => 'nullable|string',
        'page'    => 'nullable|integer'
    ]);
  
$user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $city    = $user->city;
    $search  = $request->search;

    $query = DB::table('survey_personal_details')
        ->where('status', 'Completed')
        ->where('DataVerified', 'NotVerified')
        ->where('city', $city)
        ->where('user_id', $user_id);

    // 🔍 Search filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%$search%")
              ->orWhere('ward_number', 'like', "%$search%")
              ->orWhere('ward_name', 'like', "%$search%")
              ->orWhere('city', 'like', "%$search%");
        });
    }

    $houses = $query->orderBy('id','desc')->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Survey Details list fetched successfully',
        'data' => $houses->items(),
        'pagination' => [
            'current_page' => $houses->currentPage(),
            'last_page' => $houses->lastPage(),
            'total' => $houses->total(),
            'per_page' => $houses->perPage()
        ]
    ]);
}

    public function verified_personal_details(Request $request)
{
    $request->validate([
        'search'  => 'nullable|string',
        'page'    => 'nullable|integer'
    ]);
  
$user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $city    = $user->city;
    $search  = $request->search;

    $query = DB::table('survey_personal_details')
        ->where('status', 'Completed')
        ->where('DataVerified', 'Verified')
        ->where('city', $city)
        ->where('user_id', $user_id);

    // 🔍 Search filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%$search%")
              ->orWhere('ward_number', 'like', "%$search%")
              ->orWhere('ward_name', 'like', "%$search%")
              ->orWhere('city', 'like', "%$search%");
        });
    }

    $houses = $query->orderBy('id','desc')->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Verified Personal Details list fetched successfully',
        'data' => $houses->items(),
        'pagination' => [
            'current_page' => $houses->currentPage(),
            'last_page' => $houses->lastPage(),
            'total' => $houses->total(),
            'per_page' => $houses->perPage()
        ]
    ]);
}

public function dashboard_data(Request $request)
{
    $user = $request->attributes->get('auth_user');

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ]);
    }

    $user_id = $user->id;
    $city    = $user->city;

    $data = DB::table('survey_personal_details')
        ->selectRaw("
            COUNT(*) as total_house,
            COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as today_new_house,
            COUNT(CASE WHEN status != 'Completed' THEN 1 END) as pending_personal_details,

            COUNT(CASE WHEN DataVerified = 'Verified' THEN 1 END) as verified_personal_details,

            COUNT(CASE WHEN DataVerified = 'NotVerified' OR DataVerified IS NULL THEN 1 END) as survey_details,

            COUNT(CASE WHEN DataVerified = 'Rejected' THEN 1 END) as rejected_personal_details,

            COUNT(CASE WHEN step_1_veryfied = 'Rejected' THEN 1 END) as rejected_new_house
        ")
        ->where('city', $city)
        ->where('user_id', $user_id)
       ->where('isDeleted', 'N')
        ->first();

    return response()->json([
        'success' => true,
        'message' => 'Dashboard data fetched successfully',
        'data' => $data
    ]);
}

public function houseFormData(Request $request, $type)
{
    try {

        $user = $request->attributes->get('auth_user');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

      // $construction_age = DB::table('construction_age')
    //     ->where('nagarpalika', $personal->city)
    //     ->get();

        switch ($type) {

            case 'ward':
                $data = DB::table('ward_details')
                    ->where('ward_number', $user->ward_no)
                    ->where('ward_name', $user->ward_name)
                    ->where('nagarpalika', $user->city)
                    ->select('ward_number', 'ward_name')
                    ->distinct()
                    ->get();
                break;

            case 'mohalla':
                $data = DB::table('ward_details')
                    ->where('ward_number', $user->ward_no)
                    ->where('ward_name', $user->ward_name)
                    ->where('nagarpalika', $user->city)
                    ->select('mohalla_name')
                    ->distinct()
                    ->get();
                break;

            case 'sampattiPrakar':
                $data = DB::table('property_type')
                    ->where('isdeleted', 'N')
                    ->get();
                break;

            case 'house_type':
                $data = DB::table('house_types')
                    ->select('id','house_type_name')
                    ->where('status','N')
                    ->get();
                break;

            case 'sadakKichoudai':
                $data = DB::table('road_width')
                    ->where('nagarpalika', $user->city)
                    ->get();
                break;

            case 'house_parts':
                $data = range(1, 10);
                break;

            case 'floors':
                $data = range(1, 10);
                break;

            case 'basement':
                $data = ["Yes","No"];
                break;

            case 'nirmanVarsh':
                $data = range(2001, date('Y'));
                break;

          case 'no_of_floor':
                $data = [1,2,3,4,5,6,7,8,9,10];
                break;
          case 'NirmanPrakriti':
                $data = ["Pakka", "Ardh Pakka", "Kachcha","Plot"];
                break;

          case 'malik':
                $data = ["Yes","No"];
                break;
          case 'kirayedaar':
                $data = ["Yes","No"];
                break;
          case 'Jalapurti':
                $data = ["Yes","No"];
                break;

          case 'NirmanPrakar':
                $data = ["Already Registered", "New Registration", "Name Change"];
                break;
          
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid type'
                ], 400);
        }

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'user_city' => $user->city,
            'type' => $type,
            'data' => $data
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function getPersonalDetails(Request $request, $id)
{
    // personal details
    $personal = DB::table('survey_personal_details')
        ->where('id', $id)
        ->first();

    // floors
    $floorCount = $personal->no_of_floor ?? 0;
    $floors = [];
    $floors_com = [];

    for ($i = 1; $i <= $floorCount; $i++) {

        $floors[] = [

            'floor' => $i,
            'length' => $personal->{"floor_{$i}_length"} ?? '',
            'width' => $personal->{"floor_{$i}_width"} ?? ''

        ];

        $floors_com[] = [

            'floor' => $i,
            'length' => $personal->{"floor_com_{$i}_length"} ?? '',
            'width' => $personal->{"floor_com_{$i}_width"} ?? ''

        ];

    }

    return response()->json([
        'personal_details' => $personal,
        'floors' => $floors,
        'floors_com' => $floors_com,
    ]);

}


public function personalDetails_step_1(Request $request)
{
    // ✅ Validate required inputs
    $request->validate([
        'surv_id' => 'required|integer',
        'ward_number' => 'required',
        'mohalla_name' => 'required',
        'old_house_number' => 'nullable',
        'name' => 'required',
        'father_name' => 'required',
        'mobile_number' => 'required',
        'basement' => 'required',
        'house_type' => 'required',
        'no_of_floor' => 'required|integer',
        'no_of_room' => 'required',
        'rented_person' => 'required',

    ]);
   $user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $id = $request->surv_id;

    // ✅ Fetch existing records
    $temp_survey_personal_details = DB::table('survey_personal_details')
        ->where('id', $id)
        ->first();

    if (!$temp_survey_personal_details) {
        return response()->json([
            'success' => false,
            'message' => 'Survey details not found'
        ], 404);
    }


    /*
    |--------------------------------------------------------------------------
    | Old House Details Lookup
    |--------------------------------------------------------------------------
    */

    $old_house_details = DB::table('old_house_details')
        ->where('house_number', $request->old_house_number)
        ->where('ward_number', $request->ward_number)
        ->where('mohalla_name', $request->mohalla_name)
        ->where('city', $temp_survey_personal_details->city)
        ->first();

    /*
    |--------------------------------------------------------------------------
    | Update Survey Personal Details
    |--------------------------------------------------------------------------
    */

    $arr = [
        'old_house_number' => $request->old_house_number,
        'old_house_owner_name' => $old_house_details->owner_name ?? '',
        'old_house_father_name' => $old_house_details->father_name ?? '',
        'name' => $request->name,
        'father_name' => $request->father_name,
        'mobile_number' => $request->mobile_number,
        'basement' => $request->basement,
        'house_type' => $request->house_type,
        'no_of_floor' => $request->no_of_floor,
        'rented_person' => $request->rented_person,
        'no_of_room' => $request->no_of_room,
        'status' => 'step_2',
        'updated_id' => $user_id,
        'updated_at'   => now(),
        'DataVerified' => 'No'
    ];

   $update = DB::table('survey_personal_details')
        ->where('id', $id)
        ->update($arr);

        
    /*
    |--------------------------------------------------------------------------
    | Update House Details
    |--------------------------------------------------------------------------
    */

    DB::table('tax_details')
        ->where('house_id', $id)
        ->delete();
    if($update){
        return response()->json([
            'success' => true,
            'status' => 'step_2',
            'surv_id' => $id,
            'message' => 'Personal details updated successfully'
        ]);
    }else{
        return response()->json([
            'success' => false,
            'message' => 'Data update nahi hua ya same data already hai'
        ]);
    }
}


public function personalDetails_step_2(Request $request)
{
    // ✅ Validate required inputs
    $request->validate([
        'surv_id' => 'required|integer',
        'area_all' => 'required',
        'area_all_width' => 'required',
        'area_constructed' => 'required',
        'area_constructed_width' => 'required',
        'open_area' => 'nullable',
        'open_area_width' => 'nullable',
        'basement_area' => 'nullable',
        'basement_area_width' => 'nullable',
        'basement_area_com' => 'nullable',
        'basement_area_width_com' => 'nullable',
    ]);
   $user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $id = $request->surv_id;

    // ✅ Fetch existing records
    $temp_survey_personal_details = DB::table('survey_personal_details')
        ->where('id', $id)
        ->first();

    if (!$temp_survey_personal_details) {
        return response()->json([
            'success' => false,
            'message' => 'Survey details not found'
        ], 404);
    }


    if ($temp_survey_personal_details->basement == 'Yes') {

        if ($temp_survey_personal_details->house_type == 'Commercial') {
            $basement_area = 0;
            $basement_area_width = 0;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($temp_survey_personal_details->house_type == 'Mix') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($temp_survey_personal_details->house_type == 'Residential') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = 0;
            $basement_area_width_com = 0;
        }
        else {
            $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = 0;
        }
    } else {
        $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Old House Details Lookup
    |--------------------------------------------------------------------------
    */

    


    $arr = [
        'area_all' => $request->area_all,
        'area_all_width' => $request->area_all_width,
        'area_constructed' => $request->area_constructed,
        'area_constructed_width' => $request->area_constructed_width,
        'open_area' => $request->open_area,
        'open_area_width' => $request->open_area_width,
        'basement_area' => $basement_area,
        'basement_area_width' => $basement_area_width,
        'basement_area_com' => $basement_area_com,
        'basement_area_width_com' => $basement_area_width_com,
        'status' => 'step_3',
        'updated_id' => $user_id,
        'updated_at'   => now(),
        'DataVerified' => 'No'
    ];

    /*
    |--------------------------------------------------------------------------
    | Dynamic Floors Update
    |--------------------------------------------------------------------------
    */

    $floorCount = (int) $temp_survey_personal_details->no_of_floor;

    for ($i = 1; $i <= $floorCount; $i++) {
        $arr["floor_{$i}_length"] = $request->input("length.$i", 0);
        $arr["floor_{$i}_width"] = $request->input("width.$i", 0);
        $arr["floor_com_{$i}_length"] = $request->input("length_com.$i", 0);
        $arr["floor_com_{$i}_width"] = $request->input("width_com.$i", 0);
    }

   $update = DB::table('survey_personal_details')
        ->where('id', $id)
        ->update($arr);

    /*
    |--------------------------------------------------------------------------
    | Update House Details
    |--------------------------------------------------------------------------
    */


 DB::table('tax_details')
        ->where('house_id', $id)
        ->delete();

    if($update){
        return response()->json([
            'success' => true,
            'status' => 'step_3',
            'surv_id' => $id,
            'message' => 'Personal details updated successfully'
        ]);
    }else{
        return response()->json([
            'success' => false,
            'message' => 'Data update nahi hua ya same data already hai'
        ]);
    }
}


public function personalDetails_step_3(Request $request)
{
    // ✅ Validate required inputs
    $request->validate([
        'surv_id' => 'required|integer',
        'nirmanVarsh' => 'required',
        'NirmanPrakriti' => 'required',
        'NirmanPrakar' => 'nullable',
        'sadakKichoudai' => 'required',
        'kirayedaar' => 'required',
        'malik' => 'required',
        'locality_east' => 'required',
        'locality_west' => 'required',
        'locality_north' => 'required',
        'locality_south' => 'required',
        'purab' => 'required',
        'paschim' => 'required',
        'uttar' => 'required',
        'dachhin' => 'required',
        'jalapurti' => 'required',
    ]);
    $user = $request->attributes->get('auth_user');
    $user_id = $user->id;
    $id = $request->surv_id;


    // ✅ Fetch existing records
    $temp_survey_personal_details = DB::table('survey_personal_details')
        ->where('id', $id)
        ->first();

    if (!$temp_survey_personal_details) {
        return response()->json([
            'success' => false,
            'message' => 'Survey details not found'
        ], 404);
    }

    $arr = [
        'nirmanVarsh' => $request->nirmanVarsh,
        'NirmanPrakriti' => $request->NirmanPrakriti,
        'sampattiPrakar' => $request->sampattiPrakar,
        'NirmanPrakar' => $request->NirmanPrakar,
        'sadakKichoudai' => $request->sadakKichoudai ?? '',
        'kirayedaar' => $request->kirayedaar,
        'malik' => $request->malik,
        'purab' => $request->purab,
        'paschim' => $request->paschim,
        'uttar' => $request->uttar,
        'dachhin' => $request->dachhin,
        'locality_east' => $request->locality_east,
        'locality_west' => $request->locality_west,
        'locality_north' => $request->locality_north,
        'locality_south' => $request->locality_south,
        'jalapurti' => $request->jalapurti,
        'sampattiPrakar' => $request->sampattiPrakar,
        'status' => 'Completed',
        'updated_id' => $user_id,
        'updated_at'   => now(),
        'DataVerified' => 'NotVerified'
    ];
    $update = DB::table('survey_personal_details')
        ->where('id', $id)
        ->update($arr);
    /*
    |--------------------------------------------------------------------------
    | Update House Details
    |--------------------------------------------------------------------------
    */

    DB::table('tax_details')
        ->where('house_id', $id)
        ->delete();
    
    if($update){
        return response()->json([
            'success' => true,
            'status' => 'Completed',
            'surv_id' => $id,
            'message' => 'Personal details updated successfully'
        ]);
    }else{
        return response()->json([
            'success' => false,
            'message' => 'Data update nahi hua ya same data already hai'
        ]);
    }
}

public function saveUpdatePersonalDetails(Request $request)
{
    // ✅ Validate required inputs
    $request->validate([
        'surv_id' => 'required|integer',
        'ward_number' => 'required',
        'mohallaName' => 'required',
        'manjilsankhya' => 'required|integer'
    ]);

    $id = $request->surv_id;

    // ✅ Fetch existing records
    $temp_survey_personal_details = DB::table('survey_personal_details')
        ->where('survey_id', $id)
        ->first();

    if (!$temp_survey_personal_details) {
        return response()->json([
            'success' => false,
            'message' => 'Survey details not found'
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Basement Logic
    |--------------------------------------------------------------------------
    */

    if ($request->basement == 'Yes') {

        if ($request->house_type == 'Commercial') {
            $basement_area = 0;
            $basement_area_width = 0;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($request->house_type == 'Mix') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($request->house_type == 'Residential') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = 0;
            $basement_area_width_com = 0;
        }
        else {
            $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = 0;
        }
    } else {
        $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Old House Details Lookup
    |--------------------------------------------------------------------------
    */

    $old_house_details = DB::table('old_house_details')
        ->where('house_number', $request->old_house_number)
        ->where('ward_number', $request->ward_number)
        ->where('mohalla_name', $request->mohallaName)
        ->where('city', $temp_survey_personal_details->city)
        ->first();

    /*
    |--------------------------------------------------------------------------
    | Update Survey Personal Details
    |--------------------------------------------------------------------------
    */

    $arr = [
        'old_house_number' => $request->old_house_number,
        'basement' => $request->basement,
        'house_type' => $request->house_type,
        'old_house_owner_name' => $old_house_details->owner_name ?? '',
        'old_house_father_name' => $old_house_details->father_name ?? '',
        'name' => $request->swami_ka_naam,
        'father_name' => $request->pita_ka_naam,
        'mobile_number' => $request->mobile_num,
        'rented_person' => $request->kirayrdadasankh,
        'area_all' => $request->lengthpura,
        'area_all_width' => $request->widthpura,
        'area_constructed' => $request->lengthnirmit,
        'area_constructed_width' => $request->widthnirmit,
        'open_area' => $request->lengthopen,
        'open_area_width' => $request->widthopen,
        'basement_area' => $basement_area,
        'basement_area_width' => $basement_area_width,
        'basement_area_com' => $basement_area_com,
        'basement_area_width_com' => $basement_area_width_com,
        'no_of_floor' => $request->manjilsankhya,
        'no_of_room' => $request->kamrokisankh,
        'ward_name' => $request->wardName,
        'mohalla_name' => $request->mohallaName,
        'status' => 'Completed',
        'DataVerified' => 'No'
    ];

    /*
    |--------------------------------------------------------------------------
    | Dynamic Floors Update
    |--------------------------------------------------------------------------
    */

    $floorCount = (int) $request->manjilsankhya;

    for ($i = 1; $i <= $floorCount; $i++) {
        $arr["floor_{$i}_length"] = $request->input("length.$i", 0);
        $arr["floor_{$i}_width"] = $request->input("width.$i", 0);
        $arr["floor_com_{$i}_length"] = $request->input("length_com.$i", 0);
        $arr["floor_com_{$i}_width"] = $request->input("width_com.$i", 0);
    }

    DB::table('survey_personal_details')
        ->where('survey_id', $id)
        ->update($arr);

    /*
    |--------------------------------------------------------------------------
    | Update House Details
    |--------------------------------------------------------------------------
    */


    DB::table('tax_details')
        ->where('house_id', $id)
        ->delete();

   

   

    return response()->json([
        'success' => true,
        'message' => 'Personal details updated successfully'
    ]);
}


public function saveUpdatePersonalDetails__5599(Request $request)
{
    // ✅ Validate required inputs
    $request->validate([
        'surv_id' => 'required|integer',
        'ward_number' => 'required',
        'mohallaName' => 'required',
        'manjilsankhya' => 'required|integer'
    ]);

    $id = $request->surv_id;

    // ✅ Fetch existing records
    $temp_survey_personal_details = DB::table('survey_personal_details')
        ->where('survey_id', $id)
        ->first();

    $temp_survey_step_1 = DB::table('survey_step_1')
        ->where('id', $id)
        ->first();

    if (!$temp_survey_personal_details) {
        return response()->json([
            'success' => false,
            'message' => 'Survey details not found'
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Basement Logic
    |--------------------------------------------------------------------------
    */

    if ($request->basement == 'Yes') {

        if ($temp_survey_step_1->house_type == 'Commercial') {
            $basement_area = 0;
            $basement_area_width = 0;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($request->house_type == 'Mix') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($request->house_type == 'Residential') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = 0;
            $basement_area_width_com = 0;
        }
        else {
            $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = 0;
        }
    } else {
        $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Old House Details Lookup
    |--------------------------------------------------------------------------
    */

    $old_house_details = DB::table('old_house_details')
        ->where('house_number', $request->old_house_number)
        ->where('ward_number', $request->ward_number)
        ->where('mohalla_name', $request->mohallaName)
        ->where('city', $temp_survey_personal_details->city)
        ->first();

    /*
    |--------------------------------------------------------------------------
    | Update Survey Personal Details
    |--------------------------------------------------------------------------
    */

    $arr = [
        'old_house_number' => $request->old_house_number,
        'basement' => $request->basement,
        'house_type' => $request->house_type,
        'old_house_owner_name' => $old_house_details->owner_name ?? '',
        'old_house_father_name' => $old_house_details->father_name ?? '',
        'name' => $request->swami_ka_naam,
        'father_name' => $request->pita_ka_naam,
        'mobile_number' => $request->mobile_num,
        'rented_person' => $request->kirayrdadasankh,
        'area_all' => $request->lengthpura,
        'area_all_width' => $request->widthpura,
        'area_constructed' => $request->lengthnirmit,
        'area_constructed_width' => $request->widthnirmit,
        'open_area' => $request->lengthopen,
        'open_area_width' => $request->widthopen,
        'basement_area' => $basement_area,
        'basement_area_width' => $basement_area_width,
        'basement_area_com' => $basement_area_com,
        'basement_area_width_com' => $basement_area_width_com,
        'no_of_floor' => $request->manjilsankhya,
        'no_of_room' => $request->kamrokisankh,
        'ward_name' => $request->wardName,
        'mohalla_name' => $request->mohallaName,
        'status' => 'Completed',
        'DataVerified' => 'No'
    ];

    /*
    |--------------------------------------------------------------------------
    | Dynamic Floors Update
    |--------------------------------------------------------------------------
    */

    $floorCount = (int) $request->manjilsankhya;

    for ($i = 1; $i <= $floorCount; $i++) {
        $arr["floor_{$i}_length"] = $request->input("length.$i", 0);
        $arr["floor_{$i}_width"] = $request->input("width.$i", 0);
        $arr["floor_com_{$i}_length"] = $request->input("length_com.$i", 0);
        $arr["floor_com_{$i}_width"] = $request->input("width_com.$i", 0);
    }

    DB::table('survey_personal_details')
        ->where('survey_id', $id)
        ->update($arr);

    /*
    |--------------------------------------------------------------------------
    | Update House Details
    |--------------------------------------------------------------------------
    */

    DB::table('house_details')
        ->where('personal_details_id', $id)
        ->update([
            'wardNumber' => $request->ward_number,
            'wardName' => $request->wardName,
            'mohallaName' => $request->mohallaName,
            'status' => 'Completed',
            'DataVarified' => 'No'
        ]);

    /*
    |--------------------------------------------------------------------------
    | Delete Old Tax Data
    |--------------------------------------------------------------------------
    */

    DB::table('tax_details')
        ->where('house_id', $id)
        ->delete();

    /*
    |--------------------------------------------------------------------------
    | Update Survey Step 1
    |--------------------------------------------------------------------------
    */

    DB::table('survey_step_1')
        ->where('id', $id)
        ->update([
            'status' => 'Completed',
            'ward_name' => $request->wardName,
            'mohalla' => $request->mohallaName
        ]);

    return response()->json([
        'success' => true,
        'message' => 'Personal details updated successfully'
    ]);
}


    public function dropdownHouseDetails(Request $request)
    {
        return response()->json([

            'malikhai' => [
                "मालिक इस घर में रहते है",
                "Yes",
                "No"
            ],

            'kitayedarhai' => [
                "किरायेदार हैं",
                "Yes",
                "No"
            ],

            'gasconnection' => [
                "गैस कनेक्शन",
                "Yes",
                "No"
            ],

            'electricity' => [
                "बिजली के मीटर",
                "Yes",
                "No"
            ],

            'NirmanPrakar' => [
                "निर्माण भवन का प्रकार",
                "Already Registered",
                "New Registration",
                "Name Change"
            ],

            'PanjikaranPrakar' => [
                "पंजीकरण का प्रकार",
                "Bainama",
                "Wasiyat",
                "Paitrik",
                "Ikrarnama"
            ],

            'SampatiShreni' => [
                "संपत्ति श्रेणी",
                "Government",
                "Non Government",
                "Parent",
                "Agreement"
            ],

            'SampatiPrakar' => [
                "संपत्ति प्रकार",
                "House",
                "House+Shop",
                "Hospital",
                "Factory",
                "Office",
                "Shop",
                "Other"
            ],

            'NirmanPrakriti' => [
                "भवन के निमार्ण की प्रकृति",
                "Pakka",
                "Ardh Pakka",
                "Kachcha",
                "Chhappar",
                "Plot"
            ],

            'FarshPrakriti' => [
                "भवन के फर्श की प्रकृति",
                "Tiles",
                "Pakka Farsh",
                "Kachcha Farsh"
            ],

            'Souchalaya' => [
                "शौचालय",
                "Safety tank",
                "Sewer",
                "Water flowing",
                "Collective",
                "None"
            ],

            'SadakKePrakar' => [
                "सड़क के प्रकार",
                "RCC",
                "Daamar",
                "Interlocking",
                "Khadanza",
                "Kachcha"
            ],

            'Dharm' => [
                "धर्म",
                "Hindu",
                "Muslim",
                "Sikh",
                "Isai",
                "Other"
            ],

            'Jati' => [
                "जाति",
                "General",
                "OBC",
                "S.C.",
                "S.T."
            ],

            'Jalapurti' => [
                "जलापूर्ति",
                "Nikay",
                "Handpump",
                "Self",
                "Water Collection"
            ],

            'RashanCard' => [
                "राशन कार्ड",
                "APL",
                "BPL",
                "Antodaya",
                "Other"
            ]

        ]);
    }


}
