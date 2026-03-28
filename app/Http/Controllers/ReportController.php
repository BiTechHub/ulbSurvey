<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;


class ReportController extends Controller
{

	public function ReportSurveyDataView()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Survey Data Report']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		return View('Report_Survey_Data')->with('menu',$menuData)->with('user_access',$user_access);
	}

   public function get_survey_report(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Survey Data Report']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		$city=$request->get('city');
		$wardNumber=$request->get('wardNumber');
		$surveyor=$request->get('surveyor');
		$fromDate=$request->get('fromDate');
		$verified=$request->get('verified');
		//dd($verified);
		if($fromDate=='' || $fromDate==null || $fromDate=="")
		{
			$fromDate='0000-00-00';
		}
		$toDate=$request->get('toDate');
		if($toDate=='' || $toDate==null || $toDate=="")
		{
			$toDate=date('Y-m-d');
		}
		$status=$request->get('status');
		if(session()->get('user_type')=='Admin')
		{
			if($wardNumber=='' || $wardNumber==null || $wardNumber=="")
			{
				$result=DB::table('survey_personal_details')
							->select('survey_personal_details.*','house_details.*','survey_step_1.proof_type')
							->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
							->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')
						->where([
							['survey_personal_details.city',$city],
							['survey_personal_details.user_name','like','%'.$surveyor.'%'],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'<=',$toDate],
							['survey_personal_details.status','like','%'.$status.'%'],
							['survey_personal_details.DataVerified','like','%'.$verified.'%'],
							['house_details.DataVarified','like','%'.$verified.'%']
						])->orderby('survey_personal_details.survey_id','asc')->get();
			}
			else
			{
				//DB::enableQueryLog();
				$ward_details=DB::table('ward_details')->where('id',$wardNumber)->first();
				$result=DB::table('survey_personal_details')
							->select('survey_personal_details.*','house_details.*','survey_step_1.proof_type')
							->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
							->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')
						->where([
							['survey_personal_details.city',$city],
							['survey_step_1.ward_number',$ward_details->ward_number],
							['survey_step_1.mohalla',$ward_details->mohalla_name],
							['survey_personal_details.user_name','like','%'.$surveyor.'%'],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'<=',$toDate],
							['survey_personal_details.status','like','%'.$status.'%'],
							['survey_personal_details.DataVerified','like','%'.$verified.'%'],
							['house_details.DataVarified','like','%'.$verified.'%']
						])->orderby('survey_personal_details.survey_id','asc')->get();
			}
			//dd(DB::getQueryLog());
		}
		else
		{
			if($wardNumber=='' || $wardNumber==null || $wardNumber=="")
			{
				$result=DB::table('survey_personal_details')
							->select('survey_personal_details.*','house_details.*','survey_step_1.proof_type')
							->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
							->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')
						->where([
							['survey_personal_details.city',$city],
							['survey_personal_details.user_name','like','%'.$surveyor.'%'],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'<=',$toDate],
							['survey_personal_details.status','like','%'.$status.'%'],
							['survey_personal_details.DataVerified','like','%'.$verified.'%'],
							['house_details.DataVarified','like','%'.$verified.'%']
						])->orderby('survey_personal_details.survey_id','asc')->get();
			}
			else
			{
				$ward_details=DB::table('ward_details')->where('id',$wardNumber)->first();
				$result=DB::table('survey_personal_details')
							->select('survey_personal_details.*','house_details.*','survey_step_1.proof_type')
							->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
							->join('survey_step_1','survey_personal_details.survey_id','=','survey_step_1.id')
						->where([
							['survey_personal_details.city',$city],
							['survey_step_1.ward_number',$ward_details->ward_number],
							['survey_step_1.mohalla',$ward_details->mohalla_name],
							['survey_personal_details.user_name','like','%'.$surveyor.'%'],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"),'<=',$toDate],
							['survey_personal_details.status','like','%'.$status.'%'],
							['survey_personal_details.DataVerified','Yes'],
							['house_details.DataVarified','Yes']
						])->orderby('survey_personal_details.survey_id','asc')->get();
			}
		}
		echo json_encode($result);
	}

	public function SurveyParivarRegister()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Parivar Register']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		return View('report_parivar_register')->with('menu',$menuData)->with('user_access',$user_access);
		//report_parivar_register
	}

	public function SearchSurveyParivarRegister(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Parivar Register']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagarpalika=$request->get('city');
		$wardnum=$request->get('wardNumber');
		$datefrom=$request->get('fromDate');
		$datetoo=$request->get('toDate');

		if(session()->get('user_type')=='Admin')
		{
			$surv=$request->get('surveyor');
			$verified=$request->get('verified');
			if($wardnum=='' || $wardnum==null || $wardnum=="")
				{
					if($surv=='' || $surv==null || $surv=="")
					{
						$family_members=DB::table('survey_personal_details')
								->select('survey_step_1.house_number','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','survey_step_1.family_data_status','users.name as inerted_by')
								->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
								->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
								->join('survey_step_1','family_members.house_id','=','survey_step_1.id')
								->join('users','users.id','=','family_members.inerted_by')
								->where([
									['survey_step_1.city',$nagarpalika],
									[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'>=',$datefrom],
									[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'<=',$datetoo],
									['survey_step_1.family_data_status','LIKE','%'.$verified.'%']
								])
								->orderby('family_members.id','DESC')
								->groupby('family_members.house_id')
								->get();
					}
					else
					{
						$family_members=DB::table('survey_personal_details')
								->select('survey_step_1.house_number','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','survey_step_1.family_data_status','users.name as inerted_by')
								->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
								->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
								->join('survey_step_1','family_members.house_id','=','survey_step_1.id')
								->join('users','users.id','=','family_members.inerted_by')
								->where([
									['survey_step_1.city',$nagarpalika],
									['family_members.inerted_by',$surv],
									[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'>=',$datefrom],
									[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'<=',$datetoo],
									['survey_step_1.family_data_status','LIKE','%'.$verified.'%']
								])
								->orderby('family_members.id','DESC')
								->groupby('family_members.house_id')
								->get();
					}

				}
				else
				{
					if($surv=='' || $surv==null || $surv=="")
					{
						$family_members=DB::table('survey_personal_details')
								->select('survey_step_1.house_number','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','survey_step_1.family_data_status','users.name as inerted_by')
								->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
								->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
								->join('survey_step_1','family_members.house_id','=','survey_step_1.id')
								->join('users','users.id','=','family_members.inerted_by')
								->where([
									['survey_step_1.city',$nagarpalika],
									['survey_step_1.ward_number',$wardnum],
									[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'>=',$datefrom],
									[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'<=',$datetoo],
									['survey_step_1.family_data_status','LIKE','%'.$verified.'%']
								])
								->orderby('family_members.id','DESC')
								->groupby('family_members.house_id')
								->get();
					}
					else
					{
						$family_members=DB::table('survey_personal_details')
							->select('survey_step_1.house_number','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','survey_step_1.family_data_status','users.name as inerted_by')
							->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
							->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
							->join('survey_step_1','family_members.house_id','=','survey_step_1.id')
							->join('users','users.id','=','family_members.inerted_by')
							->where([
								['survey_step_1.city',$nagarpalika],
								['survey_step_1.ward_number',$wardnum],
								['family_members.inerted_by',$surv],
								[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'>=',$datefrom],
								[DB::raw("(DATE_FORMAT(family_members.created_at,'%Y-%m-%d'))"),'<=',$datetoo],
								['survey_step_1.family_data_status','LIKE','%'.$verified.'%']
							])
							->orderby('family_members.id','DESC')
							->groupby('family_members.house_id')
							->get();
					}
				}

			}
		else
		{

		}
		echo $family_members;
	}


	public function ListLatLng()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Lat Lng Report']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$city=DB::table('states_cities')->get();
		return View('list_lat_lng')
									->with('city',$city)
									->with('tabledata',null)
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}

	public function ShowListLatLng(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Lat Lng Report']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=$request->get('nagar_palika');
		$ward_number=$request->get('ward_number');
		$type=$request->get('type');
		if($type=="House")
		{
			$tabledata=DB::table('survey_step_1')
							->where([
								['city',$nagar_palika],
								['ward_number',$ward_number],
							])
							->get();
		}
		else
		{
			$tabledata=DB::table('assets_details')
							->where([
								['city',$nagar_palika],
								['ward_number',$ward_number],
							])
							->get();
		}

		return View('list_lat_lng')
									->with('tabledata',$tabledata)
									->with('type',$type)
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}


	public function ReportSurveyDataHouseView()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','House Mapping Report']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		return View('report_house_mapping_data')->with('menu',$menuData)->with('user_access',$user_access);
	}

	public function getSurveyHouseReportList(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','House Mapping Report']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		$city=$request->get('city');
		$wardNumber=$request->get('wardNumber');
		$surveyor=$request->get('surveyor');
		$fromDate=$request->get('fromDate');
		$verified=$request->get('verified');
		//dd($verified);
		if($fromDate=='' || $fromDate==null || $fromDate=="")
		{
			$fromDate='1970-01-01';
		}
		$toDate=$request->get('toDate');
		if($toDate=='' || $toDate==null || $toDate=="")
		{
			$toDate=date('Y-m-d');
		}
		$status=$request->get('status');
		if(session()->get('user_type')=='Admin')
		{
			if($wardNumber=='' || $wardNumber==null || $wardNumber=="")
			{
				$result=DB::table('survey_step_1')
						->where([
							['city',$city],
							['username','like','%'.$surveyor.'%'],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'<=',$toDate],
							['status','like','%'.$status.'%'],
							['DataVerfied','like','%'.$verified.'%'],
						])->orderby('id','asc')->get();
			}
			else
			{
				$ward_details=DB::table('ward_details')->where('id',$wardNumber)->first();
				$result=DB::table('survey_step_1')
						->where([
							['city',$city],
							['username','like','%'.$surveyor.'%'],
							['ward_number',$ward_details->ward_number],
							['mohalla',$ward_details->mohalla_name],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'<=',$toDate],
							['status','like','%'.$status.'%'],
							['DataVerfied','like','%'.$verified.'%'],
						])->orderby('id','asc')->get();
			}
		}
		else
		{
			if($wardNumber=='' || $wardNumber==null || $wardNumber=="")
			{
				$result=DB::table('survey_step_1')
						->where([
							['city',$city],
							['username','like','%'.$surveyor.'%'],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'<=',$toDate],
							['status','like','%'.$status.'%'],
							['DataVerfied','Yes'],
						])->orderby('id','asc')->get();
			}
			else
			{
				$ward_details=DB::table('ward_details')->where('id',$wardNumber)->first();
				$result=DB::table('survey_step_1')
						->where([
							['city',$city],
							['username','like','%'.$surveyor.'%'],
							['ward_number',$ward_details->ward_number],
							['mohalla',$ward_details->mohalla_name],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'>=',$fromDate],
							[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'<=',$toDate],
							['status','like','%'.$status.'%'],
							['DataVerfied','Yes'],
						])->orderby('id','asc')->get();
			}
		}
		echo json_encode($result);
	}

	public function ReportSurveyDataOldAndNewMappingView()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Old And New Mapping']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$city=DB::table('states_cities')->get();
		$ward_details=DB::table('ward_details')->where('nagarpalika','Sitapur')->orderby('ward_number','ASC')->get();
		return View('list_old_new_mapping')->with('ward_details',$ward_details)->with('city',$city)->with('tabledata',null)->with('menu',$menuData)->with('user_access',$user_access);
	}

	public function ReportSurveyDataOldAndNewMappingList(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Old And New Mapping']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=$request->get('nagar_palika');
		$ward_number=$request->get('ward_number');
        // dd($ward_number);
		$ward_details=DB::table('ward_details')->where('id',$ward_number)->first();
		$query='SELECT old_house_details.ward_number AS old_ward_number,old_house_details.house_number AS old_house_number,old_house_details.owner_name AS old_owner_name,old_house_details.father_name AS old_father_name,survey_personal_details.house_number AS new_house_number,survey_personal_details.name AS new_name,survey_personal_details.father_name AS new_father_name , old_house_details.mohalla_name FROM old_house_details LEFT JOIN survey_personal_details ON old_house_details.house_number=survey_personal_details.old_house_number AND survey_personal_details.ward_number='.$ward_details->ward_number.' AND survey_personal_details.mohalla_name=\''.$ward_details->mohalla_name.'\' WHERE old_house_details.ward_number='.$ward_details->ward_number.' AND old_house_details.mohalla_name=\''.$ward_details->mohalla_name.'\' ORDER BY old_house_details.id ASC';
		$tabledata=DB::select($query);
		$city=DB::table('states_cities')->get();
		$ward_details=DB::table('ward_details')->where('nagarpalika','Sitapur')->orderby('ward_number','ASC')->get();
		// dd($query);
		return View('list_old_new_mapping')
									->with('tabledata',$tabledata)
									->with('ward_details',$ward_details)
									->with('city',$city)
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}

	public function ReportDocumentMapping()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Document Mapping']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$city=DB::table('states_cities')->get();
		return View('list_document_mapping')->with('city',$city)->with('tabledata',null)->with('menu',$menuData)->with('user_access',$user_access);
	}

	public function ReportDocumentMappingList(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Document Mapping']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=$request->get('nagar_palika');
		$ward_number=$request->get('ward_number');
		$tabledata=DB::table('survey_step_1')
								->where([['city',$nagar_palika],['ward_number',$ward_number]])
								->get();

		return View('list_document_mapping')
									->with('tabledata',$tabledata)
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}



	public function SurveyerLog(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Surveyer Log']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=$request->get('nagar_palika');
		$ward_number=$request->get('ward_number');
		$type=$request->get('type');
		if($type=="House")
		{
			$tabledata=DB::table('survey_step_1')
							->where([
								['city',$nagar_palika],
								['ward_number',$ward_number],
							])
							->get();
		}
		else
		{
			$tabledata=DB::table('assets_details')
							->where([
								['city',$nagar_palika],
								['ward_number',$ward_number],
							])
							->get();
		}

		return View('report_surveyer_data_log')
									->with('tabledata',array())
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}


	public function ShowListSurveyerLog(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Surveyer Log']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$validatedData = $request->validate([
            'nagarpalika' => 'required',
        ]);
		$nagarpalika=$request->get('nagarpalika');
		$wardnum=$request->get('wardnum');
		$surveyer=$request->get('surveyer');
		$datefrom=$request->get('datefrom');
		$datetoo=$request->get('datetoo');
		//dd($verified);
		if($datefrom=='' || $datefrom==null || $datefrom=="")
		{
			$datefrom='1970-01-01';
		}
		if($datetoo=='' || $datetoo==null || $datetoo=="")
		{
			$datetoo=date('Y-m-d');
		}

		$json=array();
		if($surveyer=='' || $surveyer==null || $surveyer=="")
		{
			$users=DB::table('users')->where([['user_type','Surveyor'],['status','Active'],['city',$nagarpalika]])->get();
			foreach($users as $value)
			{
				$get_sell_quantity=DB::select('CALL get_surveyer_log(\''.$value->id.'\',\''.$nagarpalika.'\',\''.$datefrom.'\',\''.$datetoo.'\')');
				//dd($get_sell_quantity);
				$flag=array(
					'total_house_mapping'=>$get_sell_quantity['0']->total_house_mapping,
					'survey_personal_details'=>$get_sell_quantity['0']->survey_personal_details,
					'assets_details'=>$get_sell_quantity['0']->assets_details,
					'surveyer_name'=>$value->name,
					'nagarpalika'=>$nagarpalika,
				);
				array_push($json, $flag);
			}
		}
		else
		{
			$users=DB::table('users')->where([['user_type','Surveyor'],['status','Active'],['city',$nagarpalika],['id',$surveyer]])->first();
			$get_sell_quantity=DB::select('CALL get_surveyer_log(\''.$surveyer.'\',\''.$nagarpalika.'\',\''.$datefrom.'\',\''.$datetoo.'\')');
				//dd($get_sell_quantity);
				$flag=array(
					'total_house_mapping'=>$get_sell_quantity['0']->total_house_mapping,
					'survey_personal_details'=>$get_sell_quantity['0']->survey_personal_details,
					'assets_details'=>$get_sell_quantity['0']->assets_details,
					'surveyer_name'=>$users->name,
					'nagarpalika'=>$nagarpalika,
				);
				array_push($json, $flag);
		}


		if($wardnum=='' || $wardnum==null || $wardnum=="")
		{

		}

		return View('report_surveyer_data_log')
									->with('tabledata',$json)
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}




	public function DataVerification(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Data Verification']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=$request->get('nagar_palika');
		$ward_number=$request->get('ward_number');
		$type=$request->get('type');
		if($type=="House")
		{
			$tabledata=DB::table('survey_step_1')
							->where([
								['city',$nagar_palika],
								['ward_number',$ward_number],
							])
							->get();
		}
		else
		{
			$tabledata=DB::table('assets_details')
							->where([
								['city',$nagar_palika],
								['ward_number',$ward_number],
							])
							->get();
		}

		return View('report_surveyer_data_log')
									->with('tabledata',array())
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}


	public function ShowListDataVerification(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Reports'],
								['user_access_type.sub_menu','Data Verification']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$validatedData = $request->validate([
            'nagarpalika' => 'required',
        ]);
		$nagarpalika=$request->get('nagarpalika');
		$wardnum=$request->get('wardnum');
		$surveyer=$request->get('surveyer');
		$datefrom=$request->get('datefrom');
		$datetoo=$request->get('datetoo');
		//dd($verified);
		if($datefrom=='' || $datefrom==null || $datefrom=="")
		{
			$datefrom='1970-01-01';
		}
		if($datetoo=='' || $datetoo==null || $datetoo=="")
		{
			$datetoo=date('Y-m-d');
		}

		$json=array();
		if($surveyer=='' || $surveyer==null || $surveyer=="")
		{
			$users=DB::table('users')->where([['user_type','!=','Surveyor'],['status','Active'],['city',$nagarpalika]])->get();
			foreach($users as $value)
			{
				$get_sell_quantity=DB::select('CALL get_data_verification(\''.$value->id.'\',\''.$nagarpalika.'\',\''.$datefrom.'\',\''.$datetoo.'\')');
				//dd($get_sell_quantity);
				$flag=array(
					'total_house_mapping'=>$get_sell_quantity['0']->total_house_mapping,
					'survey_personal_details'=>$get_sell_quantity['0']->survey_personal_details,
					'assets_details'=>$get_sell_quantity['0']->assets_details,
					'surveyer_name'=>$value->name,
					'nagarpalika'=>$nagarpalika,
				);
				array_push($json, $flag);
			}
		}
		else
		{
			$users=DB::table('users')->where([['user_type','!=','Surveyor'],['status','Active'],['city',$nagarpalika],['id',$surveyer]])->first();
			$get_sell_quantity=DB::select('CALL get_data_verification(\''.$surveyer.'\',\''.$nagarpalika.'\',\''.$datefrom.'\',\''.$datetoo.'\')');
				//dd($get_sell_quantity);
				$flag=array(
					'total_house_mapping'=>$get_sell_quantity['0']->total_house_mapping,
					'survey_personal_details'=>$get_sell_quantity['0']->survey_personal_details,
					'assets_details'=>$get_sell_quantity['0']->assets_details,
					'surveyer_name'=>$users->name,
					'nagarpalika'=>$nagarpalika,
				);
				array_push($json, $flag);
		}


		if($wardnum=='' || $wardnum==null || $wardnum=="")
		{

		}

		return View('report_surveyer_data_log')
									->with('tabledata',$json)
									->with('menu',$menuData)
									->with('user_access',$user_access);
	}

	public function test()
	{
		$house_details=DB::table('house_details')->select('personal_details_id')->where([['wardNumber','9'],['mohallaName','Shivpuri']])->get();
		$flag=array();
		foreach($house_details as $value)
		{
			array_push($flag, $value->personal_details_id);
			DB::table('survey_step_1')->where('id', $value->personal_details_id)->update(array('ward_name'=>'Sadar Bazar','mohalla'=>'Shivpuri'));
			DB::table('survey_personal_details')->where('survey_id', $value->personal_details_id)->update(array('ward_name'=>'Sadar Bazar','mohalla_name'=>'Shivpuri'));
		}
		echo sizeof($flag)." data updated";
	}

}
