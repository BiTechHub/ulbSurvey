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
    $request->validate([
        'house_type' => 'required|string|max:50',
        'ward_no'    => 'required|integer',
        'house_no'   => 'required|integer|min:1|max:10',
        'lat'        => 'required|numeric',
        'long'       => 'required|numeric',
        'basement'   => 'nullable|string|max:50',
        'floor'      => 'nullable|string|max:50',
        'city'       => 'required|string|max:100',
        'username'   => 'required|string|max:100',
        'id'         => 'required|integer',
        'imei'       => 'nullable|string|max:50',
        'image_name' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
    ]);

    DB::beginTransaction();

    try {

        $array_house = ["", "/A", "/B", "/C", "/D", "/E", "/F", "/G", "/H", "/I"];

        // ---------------- IMAGE UPLOAD ----------------

        $destinationPath = public_path('uploads/gis_image');

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
        $image_name = 'image_' . time() . '.' . $extension;
        $tmpPath    = $imageFile->getRealPath();

        if (in_array($imageFile->getMimeType(), ['image/jpeg', 'image/jpg'])) {

            $image = imagecreatefromjpeg($tmpPath);
            imagejpeg($image, $destinationPath.'/'.$image_name, 60);
            imagedestroy($image);

        } else {
            $imageFile->move($destinationPath, $image_name);
        }

        // ---------------- USER DETAILS ----------------

        $users_details = DB::table('users')->where('id', $request->id)->first();

        if (!$users_details) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // ---------------- LAST HOUSE NUMBER ----------------

        $lastHouse = SurveyStep1::where('ward_number', $request->ward_no)
            ->where('city', $request->city)
            ->orderByDesc('id')
            ->value('house_number');

        $lastNumeric = 0;

        if ($lastHouse) {
            preg_match('/\d+/', $lastHouse, $matches);
            $lastNumeric = (int) ($matches[0] ?? 0);
        }

        if ($lastNumeric === 0) {
            $lastNumeric = (10000 * $request->ward_no) + 1;
        } else {
            $lastNumeric += 1;
        }

        // ---------------- GENERATE HOUSE NUMBERS ----------------

        $temp_house_numbers = [];
        $house_data = [];

        for ($i = 0; $i < $request->house_no; $i++) {

            if (!isset($array_house[$i])) break;

            $temp_house_number = $lastNumeric . $array_house[$i];

            $temp_house_numbers[] = $temp_house_number;

            $house_data[] = [
                'house_number' => $temp_house_number,
                'ward_number'  => $request->ward_no,
                'lat'          => $request->lat,
                'lng'          => $request->long,
                'basement'     => $request->basement,
                'no_of_floor'  => $request->floor,
                'house_type'   => $request->house_type,
                'city'         => $request->city,
                'username'     => $request->username,
                'user_id'      => $request->id,
                'imei'         => $request->imei,
                'image_name'   => $image_name,
                'ward_name'    => $users_details->ward_name ?? null,
                'mohalla'      => $users_details->mohalla ?? null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('survey_step_1')->insert($house_data);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'House number generated successfully',
            'generated_house_numbers' => $temp_house_numbers,
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
        'user_id' => 'required|integer',
        'city'    => 'required|string',
        'search'  => 'nullable|string',
        'page'    => 'nullable|integer'
    ]);

    $user_id = $request->user_id;
    $city    = $request->city;
    $search  = $request->search;

    $query = DB::table('survey_step_1')
        ->where('status', 'Pending')
        ->where('DataVerfied', '!=', 'Rejected')
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
        'message' => 'Pending house list fetched successfully',
        'data' => $houses->items(),
        'pagination' => [
            'current_page' => $houses->currentPage(),
            'last_page' => $houses->lastPage(),
            'total' => $houses->total(),
            'per_page' => $houses->perPage()
        ]
    ]);
}
public function getPersonalDetails(Request $request, $id)
{
    // Get logged user from token middleware
    $authUser = $request->get('auth_user');

    if (!$authUser) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    // Fetch survey data
    $surveydata = DB::table('survey_step_1')->where('id', $id)->first();

    if (!$surveydata) {
        return response()->json([
            'success' => false,
            'message' => 'Survey not found'
        ], 404);
    }

    // Personal + House details
    $personal = DB::table('survey_personal_details')
        ->where('survey_id', $id)
        ->first();

    $house = DB::table('house_details')
        ->where('personal_details_id', $id)
        ->get();

    $propertyType = DB::table('property_type')
        ->where('isdeleted', 'N')
        ->get();

    // Floors calculation
    $floorCount = $surveydata->no_of_floor ?? 0;

    $floorLabels = [
        1 => 'तल मंजिल',
        2 => 'पहली मंजिल',
        3 => 'दूसरी मंजिल',
        4 => 'तीसरी मंजिल',
        5 => 'चौथी मंजिल',
        6 => 'पांचवी मंजिल',
        7 => 'छठी मंजिल',
        8 => 'सातवीं मंजिल'
    ];

    $floors = [];
    $floors_com = [];

    for ($i = 1; $i <= $floorCount; $i++) {
        $floors[] = [
            'label'  => $floorLabels[$i] ?? ($i . 'वीं मंजिल'),
            'key'    => $i,
            'length' => $personal->{"floor_{$i}_length"} ?? null,
            'width'  => $personal->{"floor_{$i}_width"} ?? null,
        ];

        $floors_com[] = [
            'label'  => $floorLabels[$i] ?? ($i . 'वीं मंजिल'),
            'key'    => $i,
            'length' => $personal->{"floor_com_{$i}_length"} ?? null,
            'width'  => $personal->{"floor_com_{$i}_width"} ?? null,
        ];
    }

    return response()->json([
        'success' => true,
        'message' => 'Personal details fetched successfully',

        'data' => [
            'survey_data' => $surveydata,
            'personal_details' => $personal,
            'house_details' => $house,
            'property_types' => $propertyType,
            'floors_residential' => $floors,
            'floors_commercial' => $floors_com
        ]
    ]);
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

    if ($temp_survey_step_1->basement == 'Yes') {

        if ($temp_survey_step_1->house_type == 'Commercial') {
            $basement_area = 0;
            $basement_area_width = 0;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($temp_survey_step_1->house_type == 'Mix') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        }
        elseif ($temp_survey_step_1->house_type == 'Residential') {
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


}
