<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\surveyStep1;
use App\personalDetails;
class DashboardController extends Controller
{
	
	public function MenuList()
	{
		$menuData=array();
		$menu=DB::table('user_access_type')
			->join('user_access','user_access_type.id','=','user_access.access_type')
			->where([
				['user_access.fn_view','Y'],
				['user_access.user_type',session()->get('id')]
			])
			->groupby('user_access_type.menu_name')
			->orderby('priority','ASC')
			->get();
			//dd($menu);
		$i=0;
		foreach($menu as $value)
		{
			if($value->menu_type=='Main')
			{
				$menuData[$i]['menu_type']=$value->menu_type;
				$menuData[$i]['menu_name']=$value->menu_name;
				$menuData[$i]['target']=$value->target;
				$menuData[$i]['icon']=$value->icon;
				$menuData[$i]['url']=$value->url_name;
			}
			else
			{
				$temp=DB::table('user_access_type')
						->join('user_access','user_access_type.id','=','user_access.access_type')
						->where([
							['user_access_type.menu_name',$value->menu_name],
							['user_access.fn_view','Y'],
							['user_access.user_type',session()->get('id')]
						])
						->get();
				$menuData[$i]['menu_type']=$value->menu_type;
				$menuData[$i]['menu_name']=$value->menu_name;
				$menuData[$i]['target']=$value->target;
				$menuData[$i]['icon']=$value->icon;
				$menuData[$i]['url']=$value->url_name;
				$menuData[$i]['sub_menu']=$temp;
			}
			$i++;
		}
		return $menuData;
	}
    
	public function dashobaord_total_verifird_house(Request $request)
	{
		
		$username=session()->get('username');
		
		if($username==null)
		{
			return redirect('login');
		}
		$dashboardMenuData=array();
		$menu = DB::table('user_access_type')
        ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
        ->where('user_access.user_type', session()->get('id'))
        ->groupBy('user_access_type.menu_name')
        ->orderBy('priority', 'ASC')
        ->get();
		$i=0;
		foreach($menu as $value)
		{
			if($value->menu_type=='Main')
			{
				//$dashboardMenuData[$value->menu_name]['menu_name']=$value->menu_name;
				$dashboardMenuData[$value->menu_name]=$value->fn_view;
			}
			else
			{
				$temp=DB::table('user_access_type')
						->join('user_access','user_access_type.id','=','user_access.access_type')
						->where([
							['user_access_type.menu_name',$value->menu_name],
							['user_access.user_type',session()->get('id')]
						])
						->get();
				foreach($temp as $tempvalue)
				{
					//$dashboardMenuData[$tempvalue->id]['menu_name']=$tempvalue->sub_menu;
					$dashboardMenuData[$tempvalue->menu_name ." ". $tempvalue->sub_menu]=$tempvalue->fn_view;
				}
			}
		}
		$menuData=$this->MenuList();
		//dd($dashboardMenuData);
		
		$now = \Carbon\Carbon::now();
		$nagarpalika=$request->get('ngpalika');
		if(session()->get('user_type')=='Admin' && $nagarpalika=='')
		{
			
			
			$total_survey_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')]])->count();
			$total_verify_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','Yes']])->count();
			//print_r($total_verify_house_data_today);
			$total_unverify_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','No']])->count();
			$total_rejected_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','Rejected']])->count();
			$total_survey=DB::table('survey_step_1')->count();
			$total_verify_house_data=DB::table('survey_step_1')->where([['DataVerfied','Yes']])->count();
			$total_unverify_house_data=DB::table('survey_step_1')->where([['DataVerfied','No']])->count();
			$total_rejected_house_data=DB::table('survey_step_1')->where([['DataVerfied','Rejected']])->count();
			//For Personal Details Query//
			$total_personal_detail_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')]])->count();
			$total_verify_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','Yes']])->count();
			$total_unverify_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','No']])->count();
			$total_rejected_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','Rejected']])->count();
			$total_personal_data=DB::table('survey_personal_details')->count();
			$total_verify_personal_data=DB::table('survey_personal_details')->where([['DataVerified','Yes']])->count();
			$total_unverify_personal_data=DB::table('survey_personal_details')->where([['DataVerified','No']])->count();
			$total_rejected_personal_data=DB::table('survey_personal_details')->where([['DataVerified','Rejected']])->count();
			//end query For Personal Details Query//
			//Start query For house Details//
			$total_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')]])->count();
			$total_verify_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','Yes']])->count();
			$total_unverify_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','No']])->count();
			$total_rejected_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','Rejected']])->count();
			$total_house_data=DB::table('house_details')->count();
			$total_verify_house_detail=DB::table('house_details')->where([['DataVarified','Yes']])->count();
			$total_unverify_house_detail=DB::table('house_details')->where([['DataVarified','No']])->count();
			$total_rejected_house_detail=DB::table('house_details')->where([['DataVarified','Rejected']])->count();
			//end query For house Details//
			//start query For Assets//
			$total_asstes_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')]])->count();
			$total_asstes_verify_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','Yes']])->count();
			$total_asstes_unverify_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','No']])->count();
			$total_asstes_rejected_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','Rejected']])->count();
			$total_asstes=DB::table('assets_details')->count();
			$total_asstes_verify=DB::table('assets_details')->where([['DataVarfied','Yes']])->count();
			$total_asstes_unverify=DB::table('assets_details')->where([['DataVarfied','No']])->count();
			$total_asstes_reject=DB::table('assets_details')->where([['DataVarfied','Rejected']])->count();
		}
		else if(session()->get('user_type')=='Admin' && $nagarpalika!='')
		{
			//dd($nagarpalika);
			$total_survey_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',$nagarpalika]])->count();
			$total_verify_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','Yes'],['city',$nagarpalika]])->count();
			//print_r($total_verify_house_data_today);
			$total_unverify_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','No'],['city',$nagarpalika]])->count();
			$total_rejected_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','Rejected'],['city',$nagarpalika]])->count();
			$total_survey=DB::table('survey_step_1')->where('city',$nagarpalika)->count();
			$total_verify_house_data=DB::table('survey_step_1')->where([['DataVerfied','Yes'],['city',$nagarpalika]])->count();
			$total_unverify_house_data=DB::table('survey_step_1')->where([['DataVerfied','No'],['city',$nagarpalika]])->count();
			$total_rejected_house_data=DB::table('survey_step_1')->where([['DataVerfied','Rejected'],['city',$nagarpalika]])->count();
			//For Personal Details Query//
			$total_personal_detail_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',$nagarpalika]])->count();
			$total_verify_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','Yes'],['city',$nagarpalika]])->count();
			$total_unverify_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','No'],['city',$nagarpalika]])->count();
			$total_rejected_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','Rejected'],['city',$nagarpalika]])->count();
			$total_personal_data=DB::table('survey_personal_details')->where('city',$nagarpalika)->count();
			$total_verify_personal_data=DB::table('survey_personal_details')->where([['DataVerified','Yes'],['city',$nagarpalika]])->count();
			$total_unverify_personal_data=DB::table('survey_personal_details')->where([['DataVerified','No'],['city',$nagarpalika]])->count();
			$total_rejected_personal_data=DB::table('survey_personal_details')->where([['DataVerified','Rejected'],['city',$nagarpalika]])->count();
			//end query For Personal Details Query//
			//Start query For house Details//
			$total_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',$nagarpalika]])->count();
			$total_verify_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','Yes'],['city',$nagarpalika]])->count();
			$total_unverify_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','No'],['city',$nagarpalika]])->count();
			$total_rejected_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','Rejected'],['city',$nagarpalika]])->count();
			$total_house_data=DB::table('house_details')->where('city',$nagarpalika)->count();
			$total_verify_house_detail=DB::table('house_details')->where([['DataVarified','Yes'],['city',$nagarpalika]])->count();
			$total_unverify_house_detail=DB::table('house_details')->where([['DataVarified','No'],['city',$nagarpalika]])->count();
			$total_rejected_house_detail=DB::table('house_details')->where([['DataVarified','Rejected'],['city',$nagarpalika]])->count();
			//end query For house Details//
			//start query For Assets//
			$total_asstes_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',$nagarpalika]])->count();
			$total_asstes_verify_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','Yes'],['city',$nagarpalika]])->count();
			$total_asstes_unverify_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','No'],['city',$nagarpalika]])->count();
			$total_asstes_rejected_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','Rejected'],['city',$nagarpalika]])->count();
			$total_asstes=DB::table('assets_details')->where('city',$nagarpalika)->count();
			$total_asstes_verify=DB::table('assets_details')->where([['DataVarfied','Yes'],['city',$nagarpalika]])->count();
			$total_asstes_unverify=DB::table('assets_details')->where([['DataVarfied','No'],['city',$nagarpalika]])->count();
			$total_asstes_reject=DB::table('assets_details')->where([['DataVarfied','Rejected'],['city',$nagarpalika]])->count();
		}
		else
		{
			$total_survey_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',session()->get('city')]])->count();
			$total_verify_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','Yes'],['city',session()->get('city')]])->count();
			//dd($total_survey_today);
			$total_unverify_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','No'],['city',session()->get('city')]])->count();
			$total_rejected_house_data_today=DB::table('survey_step_1')->where([[DB::raw("(DATE_FORMAT(tstamp,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerfied','Rejected'],['city',session()->get('city')]])->count();
			$total_survey=DB::table('survey_step_1')->where('city',session()->get('city'))->count();
			$total_verify_house_data=DB::table('survey_step_1')->where([['DataVerfied','Yes'],['city',session()->get('city')]])->count();
			$total_unverify_house_data=DB::table('survey_step_1')->where([['DataVerfied','No'],['city',session()->get('city')]])->count();
			$total_rejected_house_data=DB::table('survey_step_1')->where([['DataVerfied','Rejected'],['city',session()->get('city')]])->count();
			//For Personal Details Query//
			$total_personal_detail_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',session()->get('city')]])->count();
			$total_verify_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','Yes'],['city',session()->get('city')]])->count();
			$total_unverify_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','No'],['city',session()->get('city')]])->count();
			$total_rejected_personal_data_today=DB::table('survey_personal_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVerified','Rejected'],['city',session()->get('city')]])->count();
			$total_personal_data=DB::table('survey_personal_details')->where('city',session()->get('city'))->count();
			$total_verify_personal_data=DB::table('survey_personal_details')->where([['DataVerified','Yes'],['city',session()->get('city')]])->count();
			$total_unverify_personal_data=DB::table('survey_personal_details')->where([['DataVerified','No'],['city',session()->get('city')]])->count();
			$total_rejected_personal_data=DB::table('survey_personal_details')->where([['DataVerified','Rejected'],['city',session()->get('city')]])->count();
			//end query For Personal Details Query//
			//Start query For house Details//
			$total_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',session()->get('city')]])->count();
			$total_verify_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','Yes'],['city',session()->get('city')]])->count();
			$total_unverify_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','No'],['city',session()->get('city')]])->count();
			$total_rejected_house_detail_today=DB::table('house_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarified','Rejected'],['city',session()->get('city')]])->count();
			$total_house_data=DB::table('house_details')->where('city',session()->get('city'))->count();
			$total_verify_house_detail=DB::table('house_details')->where([['DataVarified','Yes'],['city',session()->get('city')]])->count();
			$total_unverify_house_detail=DB::table('house_details')->where([['DataVarified','No'],['city',session()->get('city')]])->count();
			$total_rejected_house_detail=DB::table('house_details')->where([['DataVarified','Rejected'],['city',session()->get('city')]])->count();
			//end query For house Details//
			//start query For Assets//
			$total_asstes_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['city',session()->get('city')]])->count();
			$total_asstes_verify_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','Yes'],['city',session()->get('city')]])->count();
			$total_asstes_unverify_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','No'],['city',session()->get('city')]])->count();
			$total_asstes_rejected_today=DB::table('assets_details')->where([[DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"),'=',date('Y-m-d')],['DataVarfied','Rejected'],['city',session()->get('city')]])->count();
			$total_asstes=DB::table('assets_details')->where('city',session()->get('city'))->count();
			$total_asstes_verify=DB::table('assets_details')->where([['DataVarfied','Yes'],['city',session()->get('city')]])->count();
			$total_asstes_unverify=DB::table('assets_details')->where([['DataVarfied','No'],['city',session()->get('city')]])->count();
			$total_asstes_reject=DB::table('assets_details')->where([['DataVarfied','Rejected'],['city',session()->get('city')]])->count();
		}
		return View('dashboard')->with('menu',$menuData)
								->with('dashboardMenuData',$dashboardMenuData)
								->with('total_survey_today',$total_survey_today)
								->with('total_verify_house_data_today',$total_verify_house_data_today)
								->with('total_unverify_house_data_today',$total_unverify_house_data_today)
								->with('total_rejected_house_data_today',$total_rejected_house_data_today)
								->with('total_survey',$total_survey)
								->with('total_verify_house_data',$total_verify_house_data)
								->with('total_unverify_house_data',$total_unverify_house_data)
								->with('total_rejected_house_data',$total_rejected_house_data)
								->with('total_personal_detail_today',$total_personal_detail_today)
								->with('total_verify_personal_data_today',$total_verify_personal_data_today)
								->with('total_unverify_personal_data_today',$total_unverify_personal_data_today)
								->with('total_rejected_personal_data_today',$total_rejected_personal_data_today)
								->with('total_personal_data',$total_personal_data)
								->with('total_verify_personal_data',$total_verify_personal_data)
								->with('total_unverify_personal_data',$total_unverify_personal_data)
								->with('total_rejected_personal_data',$total_rejected_personal_data)
								->with('total_house_detail_today',$total_house_detail_today)
								->with('total_verify_house_detail_today',$total_verify_house_detail_today)
								->with('total_unverify_house_detail_today',$total_unverify_house_detail_today)
								->with('total_rejected_house_detail_today',$total_rejected_house_detail_today)
								->with('total_house_data',$total_house_data)
								->with('total_verify_house_detail',$total_verify_house_detail)
								->with('total_unverify_house_detail',$total_unverify_house_detail)
								->with('total_rejected_house_detail',$total_rejected_house_detail)
								->with('total_asstes_today',$total_asstes_today)
								->with('total_asstes_verify_today',$total_asstes_verify_today)
								->with('total_asstes_unverify_today',$total_asstes_unverify_today)
								->with('total_asstes_rejected_today',$total_asstes_rejected_today)
								->with('total_asstes',$total_asstes)
								->with('total_asstes_verify',$total_asstes_verify)
								->with('total_asstes_unverify',$total_asstes_unverify)
								->with('total_asstes_reject',$total_asstes_reject);
	}
	
	
	
}
