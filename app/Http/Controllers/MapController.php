<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\housedetail;


class MapController extends Controller
{
	public function HouseOnMap()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Map'],
								['user_access_type.sub_menu','House on map']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		return View('house_on_map')->with('menu',$menuData)
									->with('user_access',$user_access);;
	}
	
	public function AssetsOnMap()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Map'],
								['user_access_type.sub_menu','Assests on map']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		return View('assets_on_map')->with('menu',$menuData)
									->with('user_access',$user_access);;
	}

	
	
}	

?>