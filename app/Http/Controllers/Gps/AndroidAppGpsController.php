<?php

namespace App\Http\Controllers\Gps;

use Illuminate\Http\Request;
use DB;
use App\library\DistanceCalculate;


class AndroidAppGpsController extends Controller
{
    
    public function CheckUpdate(Request $request)
	{
		$imei=$request->get('imei');
		$manufacturer=$request->get('manufacturer');
		$model=$request->get('model');
		$brand=$request->get('brand');
		$sim_operator=$request->get('sim_operator');
		$software_version=$request->get('software_version');
		$subscriberId=$request->get('subscriberId');
		$sim_no=$request->get('sim_no');
		$sim_serial_number=$request->get('sim_serial_number');
		$oper_name=$request->get('oper_name');
		$reg=$request->get('reg');
		$gps_unit_no=DB::table('gps_unit_no')->where('imei',$imei)->first();
		$arrayData=array(
			'imei'=>$imei,
			'firebaseId'=>$reg,
			'manufacturer'=>$manufacturer,
			'model'=>$model,
			'brand'=>$brand,
			'software_version'=>$software_version,
			'sim_serial_number'=>$sim_serial_number,
			'sim_operator'=>$sim_operator,
			'subscriberId'=>$subscriberId,
			'inserted_date'=>date('Y-m-d H:i:s'),
		);
		if($gps_unit_no==null)
		{
			DB::table('gps_unit_no')->insert($arrayData);
		}
		else
		{
			DB::table('gps_unit_no')->where('imei',$imei)->update($arrayData);
		}
		$survey_app_setting=DB::table('survey_app_setting')->first();
		$android_user=DB::table('android_user')->where('imei',$imei)->first();
		if($survey_app_setting==null)
		{
			$response[0]['msg']="Error";
		}
		else
		{
			$response[0]['status']=$survey_app_setting->parivar_register_app_status;
			$response[0]['app_code']=$survey_app_setting->parivar_register_app_version;
			$response[0]['msg']="Your app is not active please contact service provider";
			if($android_user==null)
			{
				$response[0]['login_status']="ERROR";
			}
			else
			{
				$response[0]['login_status']="SUCCESS";
				$response[0]['mobile_verified']=$android_user->id;
				$response[0]['data']=$android_user->name;
				$response[0]['ward_no']=$android_user->ward_no;
			}
		}
		
		$json['checkUpdate']=$response;
		$json['api_status']="OK";
		header('Content-type: application/json');
		echo json_encode($json);
	}

	public function VerifyUser(Request $request)
	{
		$imei=$request->get('imei');
		$id=$request->get('id');
		$android_user=DB::table('android_user')->where([['id',$id]])->first();
		if($android_user!=null)
		{
			$json['api_status']="OK";
			$json['status']=$android_user->status;
			$json['data']=$android_user;
			$json['msg']="User Successfully verified";
		}
		else
		{
			$json['api_status']="Error";
			$json['msg']="User not verified please login again";
		}
		header('Content-type: application/json');
		echo json_encode($json);
	}

	public function Login(Request $request)
	{
		$imei=$request->get('imei');
		$mobile_number=$request->get('mobile_number');
		$password=$request->get('password');
		$android_user=DB::table('android_user')->where([['username',$mobile_number],['status','Active']])->first();
		if($android_user==null)
		{
			$json['api_status']="ERROR";
			$json['msg']="User not registered please contact administrator";
		}
		else
		{
			if($password==$android_user->password)
			{
				$json['api_status']="OK";
				$json['data']=$android_user;
				$json['msg']="";
			}
			else
			{
				$json['api_status']="ERROR";
				$json['data']="";
				$json['msg']="User not registered please contact administrator";
			}
			
		}
		header('Content-type: application/json');
		echo json_encode($json);
	}

	public function getNearByHouse(Request $request)
	{
		$lat=$request->get('lat');
		$lng=$request->get('lng');
		$user_id=$request->get('user_id');
		$range=$request->get('range');
		$data_size=$request->get('data_size');
		$city=$request->get('city');
		$ward_number=$request->get('ward_number');
		$mohalla_name=$request->get('mohalla_name');
		$ward_name=$request->get('ward_name');
		$DistanceCalculate=new DistanceCalculate;
		$data=$DistanceCalculate->GetNearByHouse($lat,$lng,$range,$data_size,$city);
		if($data==null)
		{
			$json['api_status']="ERROR";
			$json['data']="";
			$json['msg']="No house found near by you";
		}
		else
		{
			$json['api_status']="OK";
			$json['data']=$data;
			$json['msg']="No house found near by you";
		}
		header('Content-type: application/json');
		echo json_encode($json);
		
	}

	public function getNearByAssets(Request $request)
	{
		$lat=$request->get('lat');
		$lng=$request->get('lng');
		$user_id=$request->get('user_id');
		$range=$request->get('range');
		$data_size=$request->get('data_size');
		$city=$request->get('city');
		$ward_number=$request->get('ward_number');
		$mohalla_name=$request->get('mohalla_name');
		$ward_name=$request->get('ward_name');
		$DistanceCalculate=new DistanceCalculate;
		$data=$DistanceCalculate->GetNearByAssets($lat,$lng,$range,$data_size,$city);
		if($data==null)
		{
			$json['api_status']="ERROR";
			$json['data']="";
			$json['msg']="No assets found near by you";
		}
		else
		{
			$json['api_status']="OK";
			$json['data']=$data;
			$json['msg']="No assets found near by you";
		}
		header('Content-type: application/json');
		echo json_encode($json);
		
	}

	public function SearchProperty(Request $request)
	{
		$lat=$request->get('lat');
		$lng=$request->get('lng');
		$user_id=$request->get('user_id');
		$range=$request->get('range');
		$data_size=$request->get('data_size');
		$city=$request->get('city');
		$ward_number=$request->get('ward_number');
		$mohalla_name=$request->get('mohalla_name');
		$ward_name=$request->get('ward_name');
		$WardNumber=$request->get('WardNumber');
		$Keyword=$request->get('Keyword');
		$SearchType=$request->get('SearchType');
		$DistanceCalculate=new DistanceCalculate;
		$data=$DistanceCalculate->SearchProperty($lat,$lng,$range,$data_size,$city,$WardNumber,$Keyword,$SearchType);
		if($data==null)
		{
			$json['api_status']="ERROR";
			$json['data']="";
			$json['msg']="No house found near by you";
		}
		else
		{
			$json['api_status']="OK";
			$json['data']=$data;
			$json['msg']="No house found near by you";
		}
		header('Content-type: application/json');
		echo json_encode($json);
		
	}

	public function getHouseDetailsByHouseId(Request $request)
	{
		$houseId=$request->get('houseId');
		$data=DB::table('survey_step_1')
					->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
					->join('house_details','survey_step_1.id','=','house_details.personal_details_id')
					->where('survey_step_1.id',$houseId)
					->first();
		if($data==null)
		{
			$json['api_status']="ERROR";
			$json['data']="";
			$json['msg']="No house found near by you";
		}
		else
		{
			$json['api_status']="OK";
			$json['data']=$data;
			$json['msg']="No house found near by you";
		}
		header('Content-type: application/json');
		echo json_encode($json);
		
	}

	
	

}
