<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\housedetail;


class HouseDetailController extends Controller
{
	public function OtherHouseDetailsVerifiedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Other House Details'],
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
		$house_detail_varify=DB::table('house_details')->where('DataVarified','Yes')->orderBy('updated_at', 'DESC')->paginate(50);
		}
		else
		{
			$house_detail_varify=DB::table('house_details')->where([['DataVarified','Yes'],['city',session()->get('city')]])->orderBy('updated_at', 'DESC')->paginate(50);
		}
		return View('house_details_varified')->with('house_detail_varify',$house_detail_varify)
												->with('menu',$menuData)
												->with('user_access',$user_access);
	}
	
	public function OtherHouseDetailsNonVerifiedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Other House Details'],
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
		$house_detail_not_varify=DB::table('house_details')->where('DataVarified','No')->orderBy('updated_at', 'desc')->paginate(50);
		}
		else
		{
			$house_detail_not_varify=DB::table('house_details')->where([['DataVarified','No'],['city',session()->get('city')]])->orderBy('updated_at', 'desc')->paginate(50);
		}
		return View('house_details')->with('house_detail_not_varify',$house_detail_not_varify)
									->with('menu',$menuData)
												->with('user_access',$user_access);
	}
	public function OtherHouseDetailsRejectedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Other House Details'],
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
		$rejected_house_details=DB::table('house_details')->where('DataVarified','Rejected')->orderBy('updated_at', 'desc')->paginate(50);
		}
		else
		{
			$rejected_house_details=DB::table('house_details')->where([['DataVarified','Rejected'],['city',session()->get('city')]])->orderBy('updated_at', 'desc')->paginate(50);
		}
		return View('house_details_rejected')->with('menu',$menuData)
											->with('user_access',$user_access)
											->with('rejected_house_details',$rejected_house_details);
		
	}
	
	public function OtherHouseDetailsPendingList(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Other House Details'],
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
		  $surveydata=DB::table('house_details')->where('status','Pending')->orderBy('house_number', 'asc')->paginate(50);
		}
		else
		{
			$surveydata=DB::table('house_details')->where([['status','Pending'],['city',session()->get('city')]])->orderBy('house_number', 'asc')->paginate(50);
		}
		return View('pending_house_details')->with('menu',$menuData)
											->with('user_access',$user_access)
											->with('surveydata',$surveydata);
	}
	
	public function ActionOtherHouseDetailsVerified(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Other House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_edit=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		DB::table('house_details')
            ->where('personal_details_id',$id)
            ->update(array('DataVarified'=>'Yes','verified_at'=>date('Y-m-d H:i:s'),'varifiedBy'=>session()->get('id')));
		return redirect('Other-House-Details-NonVerified-List')->with('alert', 'Updated!');
	}
	public function ActionOtherHouseDetailsRejected(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Other House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_edit=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		DB::table('house_details')
            ->where('personal_details_id',$id)
            ->update(array('DataVarified'=>'Rejected','verified_at'=>date('Y-m-d H:i:s'),'varifiedBy'=>session()->get('id')));
		return redirect('Other-House-Details-NonVerified-List')->with('alert', 'Updated!');;
	}
	
	
	
}	
?>