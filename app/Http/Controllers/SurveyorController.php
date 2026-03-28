<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\SurveyStep1;
use Illuminate\Support\Facades\Storage;
use Image;
use Redirect;

class SurveyorController extends Controller
{
	public function RegisterNewHouse()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Surveyor Section'],
								['user_access_type.sub_menu','Register New House']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
	
		$master=DB::table('master')->first();
		return View('register_new_house')->with('master',$master)->with('menu',$menuData)->with('user_access',$user_access);
	}

	
	public function genHouseNumber(Request $request)
{
    $array_house = ["", "/A", "/B", "/C", "/D", "/E", "/F", "/G", "/H", "/I"];

    $house_type = $request->input('house_type');
    $wardnumber = $request->input('ward_no');
    $houseqty = $request->input('house_no');
    $lat = $request->input('lat');
    $lng = $request->input('long');
    $basement = $request->input('basement');
    $no_of_floor = $request->input('floor');
    $city = $request->input('city');
    $username = $request->input('username');
    $id = $request->input('id');
    
    date_default_timezone_set("Asia/Kolkata");

    $destinationPath = public_path("/uploads/gis_image");
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $image_name = null;
   // dd($request->all(), $_FILES);
   
        // Handle file upload
        $imageFile = $request->file('image_name');
        $extension = $imageFile->getClientOriginalExtension();
        $image_name = 'image_' . date('Ymd_His') . '.' . $extension;

        $tmpPath = $imageFile->getRealPath();
        if (in_array($imageFile->getMimeType(), ['image/jpeg', 'image/jpg'])) {
            $image = imagecreatefromjpeg($tmpPath);
            imagejpeg($image, $destinationPath . '/' . $image_name, 60);
            imagedestroy($image);
        } else {
            $imageFile->move($destinationPath, $image_name);
        }

    

    $users_details = DB::table('users')->where('id', $id)->first();

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

    $temp_house_numbers = [];
    $house_data = [];

    for ($i = 0; $i < $houseqty; $i++) {
        $temp_house_number = $lastNumeric . $array_house[$i];
        $temp_house_numbers[] = $temp_house_number;

        $house_data[] = [
            'house_number' => $temp_house_number,
            'ward_number' => $wardnumber,
            'lat' => $lat,
            'lng' => $lng,
            'basement' => $basement,
            'no_of_floor' => $no_of_floor,
            'house_type' => $house_type,
            'city' => $city,
            'user_name' => $username,
            'user_id' => $id,
            'imei' => $request->input('imei'),
            'image_name' => $image_name,
            'ward_name' => $users_details->ward_name ?? null,
            'mohalla_name' => $users_details->mohalla ?? null,
            'step_1'         => 'Completed',
            'status'         => 'step_1',
            'step_1_veryfied'=> 'NotVerified',
            'DataVerified'=> 'NotVerified',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    DB::table('survey_personal_details')->insert($house_data);

    $hn = implode(",", $temp_house_numbers);
    return redirect()->back()->with(['message' => 'House number generated. House numbers '. $hn]);
}
public function EditNewHouse($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Surveyor Section'],
								['user_access_type.sub_menu','Register New House']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
        $surveyHouse = SurveyStep1::where('id', $id)
        ->first();
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
	
		$master=DB::table('master')->first();
		return View('EditNewHouse')->with('master',$master)->with('surveyHouse',$surveyHouse)->with('menu',$menuData)->with('user_access',$user_access);
	}
public function RejectedNewHouse(Request $request)
{
    if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Surveyor Section'],
								['user_access_type.sub_menu','Rejected New House']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

    $city = session('city');
    $ward_no = session('ward_no'); // optional
    $username = session('id');
    $search = $request->input('search');

    $query = DB::table('survey_personal_details')
        ->where('DataVerified', 'Rejected')
        ->where('city', $city)
        ->where('user_id', $username);
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%{$search}%")
              ->orWhere('ward_number', 'like', "%{$search}%")
              ->orWhere('ward_name', 'like', "%{$search}%")
              ->orWhere('city', 'like', "%{$search}%");
        });
    }

    $houses = $query->paginate(10)->appends($request->all());
    
    return view('RejectedNewHouse', [
        'houses' => $houses,
        'city' => $city,
        'ward_no' => $ward_no,
        'search' => $search
    ])->with('menu',$menuData)->with('user_access',$user_access);
}
public function UpdatePersonalDetailsSurvey(Request $request)
{
    if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Surveyor Section'],
								['user_access_type.sub_menu','Update Personal Details']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

    $city = session('city');
    $ward_no = session('ward_no'); // optional
    $username = session('id');
    $search = $request->input('search');

    $query = DB::table('survey_personal_details')
       ->where('status', '!=', 'Completed')
        ->where('DataVerified','!=', 'Rejected')
        ->where('city', $city)
        ->where('user_id', $username);
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%{$search}%")
              ->orWhere('ward_number', 'like', "%{$search}%")
              ->orWhere('ward_name', 'like', "%{$search}%")
              ->orWhere('city', 'like', "%{$search}%");
        });
    }

    $houses = $query->paginate(10)->appends($request->all());
    
    return view('PendingNewHouse', [
        'houses' => $houses,
        'city' => $city,
        'ward_no' => $ward_no,
        'search' => $search
    ])->with('menu',$menuData)->with('user_access',$user_access);
}	
public function UpdatePersonalDetails($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Surveyor Section'],
								['user_access_type.sub_menu','Update Personal Details']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
        $get_personal_details=DB::table('survey_personal_details')->where('id',$id)->get();
		$get_house_details=DB::table('survey_personal_details')->where('id',$id)->get();
	    $surveydata=DB::table('survey_personal_details')->where('id',$id)->get();
        $property_type=DB::table('property_type')->where('isdeleted','N')->get();

        $floorCount = $surveydata[0]->no_of_floor ?? 0;

        $floorLabels = [
            1 => 'तल मंजिल',
            2 => 'पहली मंजिल',
            3 => 'दूसरी मंजिल',
            4 => 'तीसरी मंजिल',
            5 => 'चौथी मंजिल',
            6 => 'पांचवी मंजिल',
            7 => 'छठी मंजिल',
            8 => 'सातवीं मंजिल'
            // Add more as needed
        ];
        $floors = [];
        $floors_com = [];

        for ($i = 1; $i <= $floorCount; $i++) {
            $floors[] = [
                'label'  => $floorLabels[$i] ?? ($i . 'वीं मंजिल'),
                'key'    => $i, // useful for unique input names
                'length' => $get_personal_details[0]->{"floor_{$i}_length"} ?? '',
                'width'  => $get_personal_details[0]->{"floor_{$i}_width"} ?? '',
            ];
        }
        for ($i = 1; $i <= $floorCount; $i++) {
            $floors_com[] = [
                'label'  => $floorLabels[$i] ?? ($i . 'वीं मंजिल'),
                'key'    => $i, // useful for unique input names
                'length' => $get_personal_details[0]->{"floor_com_{$i}_length"} ?? '',
                'width'  => $get_personal_details[0]->{"floor_com_{$i}_width"} ?? '',
            ];
        }

		$master=DB::table('master')->first();
		return View('update_personal_detail')->with('master',$master)->with('floors',$floors)->with('floors_com',$floors_com)->with('property_type',$property_type)->with('get_personal_details',$get_personal_details)->with('get_house_details',$get_house_details)->with('surveydata',$surveydata)->with('menu',$menuData)->with('user_access',$user_access);
	}



public function RejectedPersonalDetails(Request $request)
{
    if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Surveyor Section'],
								['user_access_type.sub_menu','Rejected Personal Details']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

    $city = session('city');
    $ward_no = session('ward_no'); // optional
    $username = session('id');
    $search = $request->input('search');

    $query = DB::table('survey_personal_details')
        ->where('DataVerified', 'Rejected')
        ->where('city', $city)
        ->where('user_id', $username);
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('house_number', 'like', "%{$search}%")
              ->orWhere('ward_number', 'like', "%{$search}%")
              ->orWhere('ward_name', 'like', "%{$search}%")
              ->orWhere('city', 'like', "%{$search}%");
        });
    }

    $houses = $query->paginate(10)->appends($request->all());
    
    return view('RejectedPersonalDetail', [
        'houses' => $houses,
        'city' => $city,
        'ward_no' => $ward_no,
        'search' => $search
    ])->with('menu',$menuData)->with('user_access',$user_access);
}
public function SaveUpdatePersonalDetails(Request $request)
{
    if (!session()->has('id')) {
        return redirect('login');
    }

    $user_access = DB::table('user_access_type')
        ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
        ->where([
            ['user_access.user_type', session()->get('id')],
            ['user_access_type.menu_name','Surveyor Section'],
            ['user_access_type.sub_menu','Update Personal Details']
        ])
        ->first();

    if (!$user_access || $user_access->fn_update == 'N') {
        return redirect('login');
    }

    $id = $request->input('surv_id');
    $temp_survey_personal_details = DB::table('survey_personal_details')->where('survey_id', $id)->first();
    $temp_survey_step_1 = DB::table('survey_personal_details')->where('id', $id)->first();

    if (!$temp_survey_personal_details) {
        return back()->withErrors(['error' => 'Survey details not found.']);
    }

    // 🔹 Basement logic
    if ($temp_survey_step_1->basement == 'Yes') {
        if ($temp_survey_step_1->house_type == 'Commercial') {
            $basement_area = '0.00';
            $basement_area_width = '0.00';
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        } elseif ($temp_survey_step_1->house_type == 'Mix') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = $request->lengthbasement_com;
            $basement_area_width_com = $request->widthbasement_com;
        } elseif ($temp_survey_step_1->house_type == 'Residential') {
            $basement_area = $request->lengthbasement;
            $basement_area_width = $request->widthbasement;
            $basement_area_com = '0.00';
            $basement_area_width_com = '0.00';
        } else {
            $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = '0.00';
        }
    } else {
        $basement_area = $basement_area_width = $basement_area_com = $basement_area_width_com = '0.00';
    }

    $old_house_number = $request->input('old_house_number');
    $ward_number = $request->input('ward_number');
    $mohallaName = $request->input('mohallaName');

    // 🔹 Old house details lookup
    $old_house_details = null;
    if (!empty($old_house_number)) {
        $old_house_details = DB::table('old_house_details')
            ->where('house_number', $old_house_number)
            ->where('ward_number', $ward_number)
            ->where('mohalla_name', $mohallaName)
            ->where('city', $temp_survey_personal_details->city)
            ->first();
    }

    $old_house_owner_name = $old_house_details->owner_name ?? '';
    $old_house_father_name = $old_house_details->father_name ?? '';

    // 🔹 Base update data
    $arr = [
        'old_house_number'       => $old_house_number,
        'old_house_owner_name'   => $old_house_owner_name,
        'old_house_father_name'  => $old_house_father_name,
        'name'                   => $request->input('swami_ka_naam'),
        'father_name'            => $request->input('pita_ka_naam'),
        'mobile_number'          => $request->input('mobile_num'),
        'rented_person'          => $request->input('kirayrdadasankh'),
        'area_all'               => $request->input('lengthpura'),
        'area_all_width'         => $request->input('widthpura'),
        'area_constructed'       => $request->input('lengthnirmit'),
        'area_constructed_width' => $request->input('widthnirmit'),
        'open_area'              => $request->input('lengthopen'),
        'open_area_width'        => $request->input('widthopen'),
        'basement_area'          => $basement_area,
        'basement_area_width'    => $basement_area_width,
        'basement_area_com'      => $basement_area_com,
        'basement_area_width_com'=> $basement_area_width_com,
        'no_of_floor'            => $request->input('manjilsankhya'),
        'no_of_room'             => $request->input('kamrokisankh'),
        'locality_east'          => $request->input('purab1'),
        'locality_west'          => $request->input('paschim1'),
        'locality_north'         => $request->input('uttar1'),
        'locality_south'         => $request->input('dachhin1'),
        'nirmanVarsh'            => $request->input('nirmaan_varsh'),
        'sadakKichoudai'         => $request->input('road_width'),
        'NirmanPrakriti'         => $request->input('bhavannirmankipravatti'),
        'ward_name'              => $request->input('wardName'),
        'mohalla_name'           => $mohallaName,
        'updated_name'           => session()->get('username'),
        'updated_id_1'           => session()->get('id'),
        'status'                 => 'Completed',
        'DataVerified'           => 'No',
        'FarshPrakriti'          => $request->input('bhavan_k_farsh_prakarti')
    ];

    // 🔹 Add dynamic floor details
    $floorCount = (int) $request->input('manjilsankhya', 0);
    for ($i = 1; $i <= $floorCount; $i++) {
    // Residential Floors
    $arr["floor_{$i}_length"] = $request->input("length.$i", 0);
    $arr["floor_{$i}_width"]  = $request->input("width.$i", 0);

    // Commercial Floors
    $arr["floor_com_{$i}_length"] = $request->input("length_com.$i", 0);
    $arr["floor_com_{$i}_width"]  = $request->input("width_com.$i", 0);
    }

    DB::table('survey_personal_details')->where('survey_id', $id)->update($arr);

    // 🔹 House details
    $arr1 = [
        'wardNumber'           => $ward_number,
        'nirmanBhavanKaPrakar' => $request->input('NirmanPrakar'),
        'wardName'             => $request->input('wardName'),
        'mohallaName'          => $mohallaName,
        'malik'                => $request->input('malik'),
        'kirayedaar'           => $request->input('kirayedaar'),
        'panjikaran'           => $request->input('panjikaran'),
        'sampattiShreni'       => $request->input('sampattiShreni'),
        'sampattiPrakar'       => $request->input('sampattiPrakar'),
        'sadakKePrakar'        => $request->input('sadakKePrakar'),
        'updated_name'         => session()->get('username'),
        'updated_id'           => session()->get('id'),
        'status'               => 'Completed',
        'DataVarified'         => 'No'
    ];

    DB::table('house_details')->where('personal_details_id', $id)->update($arr1);

    // 🔹 Remove old tax record if exists
    DB::table('tax_details')
        ->where('house_id', $id)
        ->where('city', $temp_survey_personal_details->city)
        ->delete();

    DB::table('survey_personal_details')
        ->where('id', $id)
        ->update([
            'status'    => 'Completed',
            'ward_name' => $request->input('wardName'),
            'mohalla'   => $mohallaName
        ]);

    return redirect('Update-Personal-Details')
        ->with(['message' => 'Personal Details Updated For House numbers '. $temp_survey_personal_details->house_number]);
}



}
?>
