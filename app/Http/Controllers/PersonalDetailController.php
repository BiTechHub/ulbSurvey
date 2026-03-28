<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\personalDetails;


class PersonalDetailController extends Controller
{
	public function GetPersonalDetailsVerifiedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		  $Personaldata=DB::table('survey_personal_details')->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([
		  	['DataVerified','Yes'],
		  	['survey_personal_details.status','Completed']
		  ])->orderBy('survey_id', 'desc')->paginate(50);
		}
		else
		{
			$Personaldata=DB::table('survey_personal_details')->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([['DataVerified','Yes'],['survey_personal_details.city',session()->get('city')]])->orderBy('survey_id', 'desc')->paginate(50);
		}
		return View('personal_details_verify')->with('menu',$menuData)->with('user_access',$user_access)->with('Personaldata',$Personaldata);
	}

	public function GetPersonalDetailsNonVerifiedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		  $surveydata=DB::table('survey_personal_details')->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([['DataVerified','No'],['survey_personal_details.status','Completed']])->orderBy('survey_id', 'ASC')->paginate(50);
		}

		else
		{
			$surveydata=DB::table('survey_personal_details')->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([['DataVerified','No'],['survey_personal_details.status','Completed'],['survey_personal_details.city',session()->get('city')]])->orderBy('survey_id', 'ASC')->paginate(50);
		}
		//dd($surveydata);
		return View('personal_details')->with('menu',$menuData)->with('user_access',$user_access)->with('surveydata',$surveydata);
	}
	public function GetPersonalDetailsRejectedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Rejected']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		$surveydata=DB::table('survey_personal_details')->where('DataVerified','Rejected')->orderBy('survey_id', 'desc')->paginate(50);
		}
		else
		{
			$surveydata=DB::table('survey_personal_details')->where([['DataVerified','Rejected'],['city',session()->get('city')]])->orderBy('survey_id', 'desc')->paginate(50);
		}
		return View('personal_details_reject')->with('menu',$menuData)->with('user_access',$user_access)->with('surveydata',$surveydata);
	}

	public function GetPersonalDetailsPendingList(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Pending']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		$surveydata=DB::table('survey_personal_details')->where('status','Pending')->orderBy('house_number', 'asc')->paginate(50);
		}
		else
		{
			$surveydata=DB::table('survey_personal_details')->where([['status','Pending'],['city',session()->get('city')]])->orderBy('house_number', 'asc')->paginate(50);
		}
		return View('pending_personal_details')->with('menu',$menuData)->with('user_access',$user_access)->with('surveydata',$surveydata);
	}

	public function ActionPersonalDetailsVerified(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		$id=$request->get('id');

			DB::table('survey_personal_details')
				->where('survey_id',$id)
				->update(array('DataVerified'=>'Yes','verified_at'=>date('Y-m-d H:i:s'),'verifiedBy'=>session()->get('id')));
			DB::table('house_details')
				->where('personal_details_id',$id)
				->update(array('DataVarified'=>'Yes','verified_at'=>date('Y-m-d H:i:s'),'varifiedBy'=>session()->get('id')));


		return redirect('Personal-Details-NonVerified-List')->with('alert', 'Updated!');;
	}
	public function ActionPersonalDetailsUnVerified(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		$id=$request->get('id');

			DB::table('survey_personal_details')
				->where('survey_id',$id)
				->update(array('DataVerified'=>'No','verified_at'=>date('Y-m-d H:i:s'),'verifiedBy'=>session()->get('id')));
			DB::table('house_details')
				->where('personal_details_id',$id)
				->update(array('DataVarified'=>'No','verified_at'=>date('Y-m-d H:i:s'),'varifiedBy'=>session()->get('id')));


		return redirect('Personal-Details-NonVerified-List')->with('alert', 'Updated!');;
	}
	public function ActionPersonalDetailsRejected(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$validatedData = $request->validate([
        'id' => 'required',
        'reason' => 'required'
    ]);
		$id=$request->get('id');
		$reason=$request->get('reason');
		if(!($reason=="" || $reason=="null" || $reason==null ))
		{
			DB::table('survey_personal_details')
				->where('survey_id',$id)
				->update(array('reject_reason'=>$reason,'status'=>'Pending','DataVerified'=>'Rejected','verifiedBy'=>session()->get('id')));
			DB::table('survey_step_1')
				->where('id',$id)
				->update(array('status'=>'Pending'));
			DB::table('house_details')
				->where('personal_details_id',$id)
				->update(array('reject_reason'=>$reason,'status'=>'Pending','DataVarified'=>'Rejected','varifiedBy'=>session()->get('id')));
		}



		return redirect('Personal-Details-NonVerified-List')->with('alert', 'Updated!');;
	}

	public function ActionRejecteDocument($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		DB::table('survey_step_1')
				->where('id',$id)
				->update(array('proof_name'=>null,'proof_type'=>null));
		return redirect('Personal-Details-NonVerified-List')->with('alert', 'Updated!');;
	}

	public function UpdatePersonalDetailsView(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		$id=$request->get('id');
        //dd($id);
		$get_personal_details=DB::table('survey_personal_details')->where('survey_id',$id)->get();
		$get_house_details=DB::table('house_details')->where('personal_details_id',$id)->get();
		$property_type=DB::table('property_type')->get();
		$get_ward_number=DB::table('ward_details')->where('nagarpalika',$get_personal_details[0]->city)->get();
		$surveydata=DB::table('survey_step_1')->where('id',$id)->get();
		//dd($surveydata);
		return View('UpdatePersonalDetails')->with('property_type',$property_type)
                   ->with('get_ward_number',$get_ward_number)->with('menu',$menuData)->with('user_access',$user_access)->with('get_personal_details',$get_personal_details)->with('get_house_details',$get_house_details)->with('surveydata',$surveydata);
		//print_r($get_personal_details);

	}
	public function UpdatePersonalDetailsSave(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		$id=$request->get('surv_id');
        $temp_survey_personal_details=DB::table('survey_personal_details')->where('survey_id',$id)->first();
		//dd($id);
		$swaminame=$request->get('swami_ka_naam');
		$old_house_number=$request->get('old_house_number');

		$fathername=$request->get('pita_ka_naam');
		$mob=$request->get('mobile_num');
		$lengthp=$request->get('lengthpura');
		$widthp=$request->get('widthpura');
		$lengthn=$request->get('lengthnirmit');
		$widthn=$request->get('widthnirmit');
		$lengthv=$request->get('lengthvyvsaik');
		$widthv=$request->get('widthvyvsaik');
		$len=$request->get('Length');
		$wid=$request->get('width');
		$lengthcomon=$request->get('lengthcomon');
		$widthcomon=$request->get('widthcomon');
		$num_floor=$request->get('manjilsankhya');
		$num_rent=$request->get('kirayrdadasankh');
		$num_room=$request->get('kamrokisankh');
		$east=$request->get('purab');
		$west=$request->get('paschim');
		$north=$request->get('uttar');
		$south=$request->get('dachhin');
		$lb=$request->get('lengthbasement');
		$wb=$request->get('widthbasement');
		$lg=$request->get('lengthground');
		$wg=$request->get('widthground');
		$lf=$request->get('lengthfirst');
		$wf=$request->get('widthfirst');
		$ls=$request->get('lengthsecond');
		$ws=$request->get('widthsecond');
		$lt=$request->get('lengththird');
		$wt=$request->get('widththird');
		$niramanYear=$request->get('nirmaan_varsh');
		$typeOfmakan=$request->get('bhavannirmankipravatti');
		$TypeofFarsh=$request->get('bhavan_k_farsh_prakarti');
		$roadwidth=$request->get('road_width');
		$east1=$request->get('purab1');
		$west1=$request->get('paschim1');
		$north1=$request->get('uttar1');
		$south1=$request->get('dachhin1');
		$ward_number=$request->get('ward_number');
		$wardName=$request->get('wardName');
		$mohallaName=$request->get('mohallaName');
		$NirmanPrakar=$request->get('NirmanPrakar');
		$panjikaran=$request->get('panjikaran');
		//$NirmanPrakar=$request->get('NirmanPrakar');
		$sampattiShreni=$request->get('sampattiShreni');
		$sampattiPrakar=$request->get('sampattiPrakar');
		$souchayala=$request->get('souchayala');
		$sadakKePrakar=$request->get('sadakKePrakar');
		$dharm=$request->get('dharm');
		$jati=$request->get('jati');
		$jalapurti=$request->get('jalapurti');
		$bijliMeter=$request->get('bijliMeter');
		$kirayedaar=$request->get('kirayedaar');
		$malik=$request->get('malik');
		$gasConnection=$request->get('gasConnection');
		$rashanCard=$request->get('rashanCard');
		$rashanCardNumber=$request->get('rashanCardNumber');
		$bijliMeterNumber=$request->get('bijliMeterNumber');

		//DB::enableQueryLog();
		$old_house_details=DB::table('old_house_details')
											->where([
												['house_number',$old_house_number],
												['ward_number',$ward_number],
												['mohalla_name',$mohallaName],
												['city',$temp_survey_personal_details->city],
											])
											->first();
		//dd(DB::getQueryLog());
		//dd($old_house_details);
		if($old_house_details==null)
		{
			$old_house_owner_name="";
			$old_house_father_name="";
		}
		else
		{
			$old_house_owner_name=$old_house_details->owner_name;
			$old_house_father_name=$old_house_details->father_name;
		}
	   //dd($result);
		$arr=array(
				'old_house_number' => $old_house_number,
				'old_house_owner_name' => $old_house_owner_name,
				'old_house_father_name' => $old_house_father_name,
				'name' => $swaminame,
				'father_name' => $fathername,
				'mobile_number' => $mob,
				'rented_person' =>$num_rent,
				'area_all' =>$lengthp,
				'area_all_width' =>$widthp,
				'area_constructed' =>$lengthn,
				'area_constructed_width' =>$widthn,
				'area_business' =>$lengthv,
				'area_business_width' =>$widthv,
				'area_common_length' =>$lengthcomon,
				'area_common_width' =>$widthcomon,
				'no_of_floor' =>$num_floor,
				'no_of_room' =>$num_room,
				'basement_area' =>$lb,
				'basement_area_width' =>$wb,
				'ground_area' =>$lg,
				'ground_area_width' =>$wg,
				'first_area' =>$lf,
				'first_area_width' =>$wf,
				'second_area' =>$ls,
				'second_area_width' =>$ws,
				'third_area' => $lt,
				'third_area_width' => $wt,
				'length_east' =>$east,
				'length_west' =>$west,
				'length_north' =>$north,
				'length_south' =>$south,
				'locality_east' =>$east1,
				'locality_west' =>$west1,
				'locality_north' =>$north1,
				'locality_south' =>$south1,
				'nirmanVarsh' => $niramanYear,
				'sadakKichoudai' =>$roadwidth,
				'NirmanPrakriti' =>$typeOfmakan,
				'ward_name' =>$wardName,
				'mohalla_name' =>$mohallaName,
				'updated_name' =>session()->get('username'),
				'updated_id_1' =>session()->get('id'),
				'status'=>'Completed',
				'DataVerified'=>'No',
				'FarshPrakriti' =>$TypeofFarsh);

				DB::table('survey_personal_details')->where('survey_id',$id)->update($arr);
			   $arr1=array(
			   		'wardNumber'=>$ward_number,
			      'nirmanBhavanKaPrakar'=>$NirmanPrakar,
						'wardName'=>$wardName,
						'mohallaName'=>$mohallaName,
						'malik'=>$malik,
						'kirayedaar'=>$kirayedaar,
						'panjikaran'=>$panjikaran,
						'sampattiShreni'=>$sampattiShreni,
						'sampattiPrakar'=>$sampattiPrakar,
						'souchayala'=>$souchayala,
						'sadakKePrakar'=>$sadakKePrakar,
						'gasConnection'=>$gasConnection,
						'bijliMeter'=>$bijliMeter,
						'dharm'=>$dharm,
						'jati'=>$jati,
						'jalapurti'=>$jalapurti,
						'rashanCard'=>$rashanCard,
						'rashanCardNumber'=>$rashanCardNumber,
						'bijliMeterNumber'=>$bijliMeterNumber,
						'updated_name' =>session()->get('username'),
						'updated_id' =>session()->get('id'),
						'status'=>'Completed',
						'DataVarified'=>'No'
					);
					DB::table('house_details')->where('personal_details_id',$id)->update($arr1);
					DB::table('survey_step_1')
						->where('id',$id)
						->update(array('status'=>'Completed','ward_name' =>$wardName,'mohalla' =>$mohallaName));
		        return redirect('Personal-Details-NonVerified-List');


	}


	public function SearchPersonalDetailsList(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Personal Details'],
								['user_access_type.sub_menu','Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=$request->get('nagar_palika');
		$ward_number=$request->get('ward_number');
		$house_number=$request->get('house_number');
		$search_type=$request->get('search_type');
		if(session()->get('user_type')=='Admin')
		{

			if($ward_number=="" || $ward_number==null)
			{
				$surveydata=DB::table('survey_personal_details')
			  	->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([
				  	['survey_personal_details.city',$nagar_palika],
				  	['survey_step_1.house_number','LIKE','%'.$house_number.'%'],
				  	['DataVerified',$search_type],
				  ])->orderBy('survey_id', 'ASC')->paginate(5000);
			}
			else
			{
				$surveydata=DB::table('survey_personal_details')
			  	->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([
				  	['survey_personal_details.city',$nagar_palika],
				  	['survey_step_1.house_number','LIKE','%'.$house_number.'%'],
				  	['survey_personal_details.ward_number',$ward_number],
				  	['DataVerified',$search_type],
				  ])->orderBy('survey_id', 'ASC')->paginate(5000);
			}

		}

		else
		{
			if($ward_number=="" || $ward_number==null)
			{
				$surveydata=DB::table('survey_personal_details')->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([
					['DataVerified',$search_type],
					['survey_personal_details.status','Completed'],
					['survey_personal_details.city',session()->get('city')],
					['survey_step_1.house_number','LIKE','%'.$house_number.'%']
				])->orderBy('survey_id', 'ASC')->paginate(5000);
			}
			else
			{
				$surveydata=DB::table('survey_personal_details')->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')->where([
					['DataVerified',$search_type],
					['survey_personal_details.status','Completed'],
					['survey_personal_details.ward_number',$ward_number],
					['survey_personal_details.city',session()->get('city')],
					['survey_step_1.house_number','LIKE','%'.$house_number.'%']
				])->orderBy('survey_id', 'ASC')->paginate(5000);
			}
		}
		//dd($surveydata);
		return View('search_personal_details')->with('menu',$menuData)->with('user_access',$user_access)->with('surveydata',$surveydata);
	}



}
?>
