<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class WebServiceController extends Controller
{
    public function get_city_by_state($state_id)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		if(session()->get('user_type')=="Admin")
		{
			$result=DB::table('states_cities')->where("state_id",$state_id)->get();
			echo json_encode($result);
		}
		else
		{
			$result=DB::table('states_cities')->where([["state_id",$state_id],['city',session()->get('city')]])->get();
			echo json_encode($result);
		}
	}
	public function getWardDetailsByWardNumber($ward_number,$city)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		//$state_id=$request->get('state');
		if(session()->get('user_type')=="Admin")
		{
			$result=DB::table('ward_details')->where([["ward_number",$ward_number],['nagarpalika',$city]])->get();
			echo json_encode($result);
		}
		else
		{
			$result=DB::table('ward_details')->where([["ward_number",$ward_number],['nagarpalika',session()->get('city')]])->get();
			echo json_encode($result);
		}
	}
	public function get_city()
{
    $username = session()->get('username');
    if ($username == null) {
        return redirect('login');
    }

    if (session()->get('user_type') == "Admin") {
        $result = DB::table('states_cities')->get();
    } else {
        $result = DB::table('states_cities')
            ->where('city', session()->get('city'))
            ->get();
    }

    return response()->json($result);
}

	public function get_ward_number($nagarpalika)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		//$state_id=$request->get('state');
		if(session()->get('user_type')=="Admin")
		{
			$result=DB::table('ward_details')->where("nagarpalika",$nagarpalika)->orderby('ward_number','ASC')->get();
			echo json_encode($result);
		}
		else
		{
			$result=DB::table('ward_details')->where("nagarpalika",session()->get('city'))->orderby('ward_number','ASC')->get();
			echo json_encode($result);
		}
	}
	public function get_surveyor_list($nagarpalika)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		//$ngrpalika=$request->get('city');
	    //dd($city);
		if(session()->get('user_type')=='Admin')
		{
			$result=DB::table('users')->where([['city',$nagarpalika]])->whereIn('user_type',['Surveyor','Parivar Surveyor'])->get();
			echo json_encode($result);
		}
		else
		{
			$result=DB::table('users')->where([['user_type','Surveyor'],['city',session()->get('city')]])->get();
			echo json_encode($result);
		}
	}


	public function getmohalla($ward,$nagarpalika)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		//$ngrpalika=$request->get('city');
	    //dd($city);
		if(session()->get('user_type')=='Admin')
		{
			$result=DB::table('ward_details')->where([['nagarpalika',$nagarpalika],['ward_number',$ward]])->get();
			echo json_encode($result);
		}
		else
		{
			$result=DB::table('ward_details')->where([['nagarpalika',session()->get('city')],['ward_number',$nagarpalika]])->get();
			echo json_encode($result);
		}
	}


	public function UserControlList($user_id)
	{
		//$user_id=$request->get('id');
		$user_access=null;
		$user_menu=DB::table('user_access_type')->get();
		$user_access=DB::table('user_access')->where('user_type',$user_id)->get();
		//dd($user_access);
		if($user_access!=null)
		{
			foreach($user_menu as $menu)
			{
				$user_access1=null;
				$user_access1=DB::table('user_access')->where([['user_type',$user_id],['access_type',$menu->id]])->count();
				//dd($user_access1);
				//$user_access1=$obj->data_select($sql);
				if($user_access1==0)
				{
					//$sql="INSERT INTO `user_access`(`user_type`, `access_type`) VALUES ('".$user_id."','".$menu['id']."')";
					//echo "user_access1";
					DB::table('user_access')->insert(array('user_type' => $user_id, 'access_type' => $menu->id));
					//$obj->data_insert($sql);
				}
			}
		}
		else
		{
			dd($user_access);
			foreach($user_menu as $menu)
			{
				//dd($user_menu);
				//$sql="INSERT INTO `user_access`(`user_type`, `access_type`) VALUES ('".$user_id."','".$menu['id']."')";
				DB::table('user_access')->insert(array('user_type' => $user_id, 'access_type' => $menu->id));
			}
		}
		$menu=DB::table('user_access_type')
			->join('user_access','user_access_type.id','=','user_access.access_type')
			->where([
				['user_access.user_type',$user_id]
			])->get();
		echo json_encode($menu);
	}

	public function changeUserControl(Request $request)
	{
		$id=$request->get('id');
		$status=$request->get('status');
		$type=$request->get('type');
		if($type=='add')
		{
			DB::table('user_access')
				->where('id', $id)
				->update(array('fn_add'=>$status));
		}
		else if($type=='view')
		{
			DB::table('user_access')
				->where('id', $id)
				->update(array('fn_view'=>$status));
		}
		else if($type=='delete')
		{
			DB::table('user_access')
				->where('id', $id)
				->update(array('fn_delete'=>$status));
		}
		else if($type=='edit')
		{
			DB::table('user_access')
				->where('id', $id)
				->update(array('fn_update'=>$status));
		}
		else if($type=='excel')
		{
			DB::table('user_access')
				->where('id', $id)
				->update(array('fn_excel'=>$status));
		}
	}

	public function get_construction_age($nagarpalika)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		//$ngrpalika=$request->get('city');
	    //dd($city);
		if(session()->get('user_type')=='Admin')
		{
		$result=DB::table('construction_age')->where([['nagarpalika',$nagarpalika]])->get();
		echo json_encode($result);
		}
		else
		{
			$result=DB::table('construction_age')->where([['nagarpalika',session()->get('city')]])->get();
		       echo json_encode($result);
		}
	}
	public function getRoadwidth($nagarpalika)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		//$ngrpalika=$request->get('city');
	    //dd($city);

		$result=DB::table('road_width')->where([['nagarpalika',$nagarpalika]])->get();
		echo json_encode($result);



	}
	public function MapData($city,$ward_number)
	{


		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		if(session()->get('user_type')=='Admin')
		{
			if($ward_number==0)
			{
				$result=DB::table('survey_step_1')->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
											   ->where([['survey_personal_details.city',$city],['survey_step_1.status','Completed']])->get();
			}
			else
			{
			$result=DB::table('survey_step_1')->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
											   ->where([['survey_personal_details.city',$city],['survey_step_1.ward_number',$ward_number],['survey_step_1.status','Completed']])->get();
			}
		}
		else
		{
			if($ward_number==0)
			{
			   $result=DB::table('survey_step_1')->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
											   ->where([['survey_personal_details.city',session()->get('city')],['survey_step_1.status','Completed']])->get();
			}
			else
			{
				$result=DB::table('survey_step_1')->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
											   ->where([['survey_personal_details.city',session()->get('city')],['survey_step_1.ward_number',$ward_number],['survey_step_1.status','Completed']])->get();
			}
		}
		echo json_encode($result);
	}
	public function AssetsDataMap($city,$ward_number,$assets)
	{

		//dd($assets);
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		if(session()->get('user_type')=='Admin')
		{
			if($city!="All" && $ward_number=="All" && $assets=="All")
			{
			 $result=DB::table('assets_details')->where([['city',$city],['DataVarfied','Yes']])->get();

			}
            elseif($assets=='All')
            {
				$result=DB::table('assets_details')
											   ->where([['city',$city],['ward_number',$ward_number],['DataVarfied','Yes']])->get();
			}
            else
            {
				$result=DB::table('assets_details')
											   ->where([['city',$city],['ward_number',$ward_number],['assets_name',$assets],['DataVarfied','Yes']])->get();
			}
		}
		else
		{
			if($city==session()->get('city') && $ward_number=="All" && $assets=="All")
			{
			 $result=DB::table('assets_details')
											   ->where([['city',session()->get('city')],['DataVarfied','Yes']])->get();
			}
            elseif($assets=='All')
            {
				$result=DB::table('assets_details')
											   ->where([['city',session()->get('city')],['ward_number',$ward_number],['DataVarfied','Yes']])->get();
			}
            else
			{
				$result=DB::table('assets_details')
											   ->where([['city',session()->get('city')],['ward_number',$ward_number],['assets_name',$assets],['DataVarfied','Yes']])->get();
			}

		}
		echo json_encode($result);
	}
	public function moreHousedata($house_id)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		$result=DB::table('survey_step_1')->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
											   ->where([['survey_personal_details.DataVerified','Yes'],['survey_step_1.status','Completed'],['survey_step_1.id',$house_id]])->get();
		 echo json_encode($result);
	}
	public function moreAssetsData($assets_id)
	{
		$result=DB::table('assets_details')->where([['id',$assets_id],['DataVarfied','Yes']])->get();
	     echo json_encode($result);
	}
	public function getAssets()
	{
		$result=DB::table('assets')->get();
	     echo json_encode($result);
	}
	public function searchvarifiedhousedetails(Request $request)
	{
		$housenumber=$request->get('housenumber');
		$city=$request->get('ngpalika');
		if(session()->get('user_type')=='Admin')
		{
			$result=DB::table('survey_personal_details')->where([['house_number',$housenumber],['dataverified','Yes'],['city',$city]])->get();
		}
		else
		{
			$result=DB::table('survey_personal_details')->where([['house_number',$housenumber],['city',session()->get('city')],['dataverified','Yes']])->get();
		}
	     echo json_encode($result);
	}
	public function searchnotvarifiedhousedetails(Request $request)
	{
		$housenumber=$request->get('housenumber');
		$city=$request->get('ngpalika');
		//dd($ngpalika);
		if(session()->get('user_type')=='Admin')
		{
			$result=DB::table('survey_personal_details')->where([['house_number',$housenumber],['dataverified','No'],['city',$city]])->get();
		}
		else
		{
			$result=DB::table('survey_personal_details')->where([['house_number',$housenumber],['city',session()->get('city')],['dataverified','No']])->get();
		}
	     echo json_encode($result);
	}

	public function checkHoseNumber(Request $request)
	{
		$housenumber=$request->get('housenumber');
		$city=$request->get('ngpalika');
		//dd($ngpalika);
		$check_house=DB::table('survey_step_1')->where([['city',$city],['house_number', $housenumber]])->count();
	    echo json_encode($check_house);
	}

	public function GetHouseDetailsForFamily($house_number,$city)
	{
		header("Access-Control-Allow-Origin: *");
		$check_house=DB::table('survey_personal_details')
									->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
									->where([['survey_personal_details.city',$city],['survey_personal_details.house_number', $house_number]])->first();
	    echo json_encode($check_house);
	}


    public function insert_house()
	{//SELECT * FROM  survey_step_1 WHERE id NOT IN (SELECT survey_id FROM `survey_personal_details`)
		$survey_step_1=DB::table('survey_step_1')
        ->whereNotIn('id',DB::table('survey_personal_details')->pluck('survey_id'))
        ->get();
        $array_personal_data=array();
        foreach($survey_step_1 as $value)
        {
            $data=array(
                'survey_id'=>$value->id,
                'house_number'=>$value->house_number,
                'city'=>$value->city,
                'user_name'=>'',
                'ward_number'=>$value->ward_number,
            );
            array_push($array_personal_data,$data);
        }
        //dd($array_personal_data);
        DB::table('survey_personal_details')->insert($array_personal_data);
	}
    public function get_mohlla_ward($city)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		//$ngrpalika=$request->get('city');
	    //dd($city);
		if(session()->get('user_type')=='Admin')
		{
			$result=DB::table('ward_details')->where([['nagarpalika',$city]])->get();
			echo json_encode($result);
		}
		else
		{
			$result=DB::table('ward_details')->where([['nagarpalika',session()->get('city')]])->get();
			echo json_encode($result);
		}
	}

	public function get_RoadWidth($city)
	{
		$username=session()->get('username');
		if($username==null)
		{
			return redirect('login');
		}
		$road_width=DB::table('road_width')->where([['nagarpalika',$city]])->get();
		$construction_age=DB::table('construction_age')->where([['nagarpalika',$city]])->get();
		$result['road_width']=$road_width;
		$result['construction_age']=$construction_age;
		echo json_encode($result);
	}

}
