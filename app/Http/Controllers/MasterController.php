<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\city;
use App\Models\ward_detail;
use App\Models\construction;
use App\Models\discount;
use App\Models\road_width_detail;
use App\Models\TaxRate;
class MasterController extends Controller
{
// manage city-------------------------------------------------------------------------start--------------------
	public function CityList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','District/Nagarpalika']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		 $citylist=DB::table('states_cities')->where("state_id",34)->paginate(100);
		}
		else
		{
			$citylist=DB::table('states_cities')->where([["state_id",34],['city',session()->get('city')]])->paginate(100);
		}
		return View('manage_city')->with('menu',$menuData)->with('user_access',$user_access)->with('citylist',$citylist);
	}
	public function SaveCity(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','District/Nagarpalika']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$data=new city;
		$data->state_id=$request->get('state');
		$data->city=$request->get('city');
		$data->interest_rate=$request->get('interest_rate');
		$data->ulb_type=$request->get('ulb_type');
		$data->save();
		return redirect('manageCity')->with('message','City Detail Added Successfully.');
		//print_r($data);
	}
	public function UpadtemanageCityView(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','District/Nagarpalika']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		if(session()->get('user_type')=='Admin')
		{
		 $citylist=DB::table('states_cities')->where('id',$id)->paginate(100);
		}
		else
		{
			$citylist=DB::table('states_cities')->where([['id',$id],['city',session()->get('city')]])->paginate(100);
		}
		 return View('Edit_city')->with('menu',$menuData)->with('user_access',$user_access)->with('citylist',$citylist);
	}
	public function SaveUpdatemanageCity(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','District/Nagarpalika']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		//$state_id=$request->get('state');
		$city=$request->get('city_name');
		$interest_rate=$request->get('interest');
		$ulb_type=$request->get('ulb_type');
		$data=array(
		//'state_id'=>$state_id,
		'city'=>$city,
		'interest_rate'=>$interest_rate,
		'ulb_type'=>$ulb_type);
		if(session()->get('user_type')=='Admin')
		{
		  DB::table('states_cities')->where('id',$id)->update($data);
		}
		else
		{
			DB::table('states_cities')->where([['id',$id],['city',session()->get('city')]])->update($data);
		}
		return redirect('/manageCity')->with('message', 'City Updated Successfully.');
	}
// Manage ward Details----------------------------------------------------------------start------------------

	public function WardDetailsList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Ward/Mohlla']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
			$wardlist=DB::table('ward_details')->get();
		}
		else
		{
			$wardlist=DB::table('ward_details')->where('nagarpalika',session()->get('city'))->get();
		}
		return View('manage_ward_mohlla')->with('menu',$menuData)->with('user_access',$user_access)->with('wardlist',$wardlist);
	}
	public function WardDetailsAdd()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Ward/Mohlla']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		 $wardlist=DB::table('ward_details')->get();
		}
		else
		{
			$wardlist=DB::table('ward_details')->where('nagarpalika',session()->get('city'))->get();
		}
		return View('Add_ward_mohlla')->with('menu',$menuData)->with('user_access',$user_access)->with('wardlist',$wardlist);
	}
	public function WardDetailsSave(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Ward/Mohlla']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
			$data=new ward_detail;
			$data->ward_number=$request->get('wardnum');
			$data->ward_name=$request->get('wardnam');
			$data->mohalla_name=$request->get('mohlla');
			$data->nagarpalika=$request->get('ngrpalika');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save();
		}
		else
		{
			$data=new ward_detail;
			$data->ward_number=$request->get('wardnum');
			$data->ward_name=$request->get('wardnam');
			$data->mohalla_name=$request->get('mohlla');
			$data->nagarpalika=$request->get('ngrpalika');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save();
		}
	    return redirect('Ward-Details-List')->with('message','Ward details added successfully.');
	}
	public function UpadteWardDetailView(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Ward/Mohlla']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		if(session()->get('user_type')=='Admin')
		{
		$wardl_data=DB::table('ward_details')->where('id',$id)->get();
		}
		//dd($wardl_data);
		else
		{
			$wardl_data=DB::table('ward_details')->where([['id',$id],['nagarpalika',session()->get('city')]])->get();
		}
		 return View('Edit_ward_mohlla')->with('menu',$menuData)->with('user_access',$user_access)->with('wardl_data',$wardl_data);
	}
	public function SaveUpdateWardDetails(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Ward/Mohlla']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
        // dd($id);
		$nagar_palika=$request->get('ngrpalika');
		$ward_num=$request->get('wardnum');
		$ward_nam=$request->get('wardnam');
		$moh=$request->get('mohlla');
		$data=array(
		'ward_number'=>$ward_num,
		'ward_name'=>$ward_nam,
		'mohalla_name'=>$moh,
		'nagarpalika'=>$nagar_palika);
		if(session()->get('user_type')=='Admin')
		{
		  DB::table('ward_details')->where('id',$id)->update($data);
		}
		else
		{
			DB::table('ward_details')->where([['id',$id],['nagarpalika',session()->get('city')]])->update($data);
		}
		return redirect('Ward-Details-List')->with('message','Ward detail updated successfully.');
	}
	// Manage construnction year------------------------------------start-----------------------------------------
	public function GetAgeList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Construction Year']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		$asset_name=DB::table('construction_age')->where('isdeleted','N')->paginate(50);
		}
		else
		{
			$asset_name=DB::table('construction_age')->where([['isdeleted','N'],['nagarpalika',session()->get('city')]])->paginate(50);
		}
		return View('manage_construction_age')->with('menu',$menuData)->with('user_access',$user_access)->with('asset_name',$asset_name);
	}
	public function SaveAgeDetails(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Construction Year']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$check = construction::where('nagarpalika', $request->get('ngrpalika'))->where('age', $request->get('year'))->first();
		if($check){
        return redirect('ConstructionDetails')->with('message','Already Added.');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
			$data=new construction;
			$data->nagarpalika=$request->get('ngrpalika');
			$data->age=$request->get('year');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save();
		}
		else
		{
			$data=new construction;
			$data->nagarpalika=$request->get('ngrpalika');
			$data->age=$request->get('year');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save()->where('nagarpalika',session()->get('city'));
		}
	    return redirect('ConstructionDetails')->with('message','Construction Age Added Successfully.');
	}
	public function UpadteConstructionView(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Construction Year']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		if(session()->get('user_type')=='Admin')
		{
		$conts_age=DB::table('construction_age')->where('id',$id)->get();
		}

		else
		{
			$conts_age=DB::table('construction_age')->where([['id',$id],['nagarpalika',session()->get('city')]])->get();
		}
	//  dd($conts_age);
		 return View('Edit_construction_year')->with('menu',$menuData)->with('user_access',$user_access)->with('conts_age',$conts_age);
	}
	public function SaveUpdateConstruction(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Construction Year']
							])->get();
		// dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		$nagar_palika=$request->get('nagarpalika');
		$age=$request->get('year');
		$check = construction::where('nagarpalika', $request->get('nagarpalika'))->where('age', $request->get('year'))->first();
		if($check){
        return redirect('ConstructionDetails')->with('message','Already Added.');
		}
		$data=array(
		'age'=>$age,
		'nagarpalika'=>$nagar_palika);
		// dd($data);
		if(session()->get('user_type')=='Admin')
		{
		  DB::table('construction_age')->where('id',$id)->update($data);
		}
		else
		{
			DB::table('construction_age')->where([['id',$id],['nagarpalika',session()->get('city')]])->update($data);
		}
		//  dd($id);
		return redirect('ConstructionDetails')->with('message','Construction Age Updated Successfully.');
	}

	// Manage Discount ---------------------------------------------------start------------------------------------------
	public function DiscountDataList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Discount']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		$discount=DB::table('tax_discount')->paginate(10);
		}
		else
		{
			$discount=DB::table('tax_discount')->where('nagarpalika',session()->get('city'))->paginate(10);
		}
		return View('manage_Discount')->with('menu',$menuData)->with('user_access',$user_access)->with('discount',$discount);
	}
	public function saveDisount(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Discount']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
			$data=new discount;
			$data->nagarpalika=$request->get('nagarpalika');
			$data->discount_rate=$request->get('discount');
			$data->construction_age=$request->get('consage');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save();
		}
		else
		{
			$data=new discount;
			$data->nagarpalika=$request->get('nagarpalika');
			$data->discount_rate=$request->get('discount');
			$data->construction_age=$request->get('consage');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save()->where('nagarpalika',session()->get('city'));
		}
	    return redirect('discount');
	}
	public function DeleteDiscount($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		//dd($deleted_id);

		DB::table('tax_discount')->where('id',$id)->delete();

		return back()->with('message','Discount Deleted Successfully.');
	}
	public function UpadteDiscountDetailView(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Discount']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		$discount=DB::table('tax_discount')->paginate(10);
		}
		else
		{
			$discount=DB::table('tax_discount')->where('nagarpalika',session()->get('city'))->paginate(10);
		}
		return View('Edit_discount')->with('menu',$menuData)->with('user_access',$user_access)->with('discount',$discount);
	// 	if(session()->get('id')==null)
	// 	{
	// 		return redirect('login');
	// 	}
	// 	$user_access=$menu=DB::table('user_access_type')
	// 						->join('user_access','user_access_type.id','=','user_access.access_type')
	// 						->where([
	// 							['user_access.user_type',session()->get('id')],
	// 							['user_access_type.menu_name','Master'],
	// 							['user_access_type.sub_menu','Manage Discount']
	// 						])->get();
	// 	//dd($user_access);
	// 	if($user_access[0]->fn_update=='N')
	// 	{
	// 		return redirect('login');
	// 	}
	// 	$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
	// 	$id=$request->get('id');
	// 	if(session()->get('user_type')=='Admin')
	// 	{
	// 	$discount_rate=DB::table('tax_discount')->where('id',$id)->get();
	// 	// $discount_rate=DB::table('tax_discount')->where('id',$id)->get();
	// 	}

	// 	else
	// 	{
	// 		 $discount_rate=DB::table('tax_discount')->where([['id',$id],['nagarpalika',session()->get('city')]])->get();

	// 	}
	// 	$city=DB::table('states_cities')->select('id','city')->get();
	// //  dd($discount);
	// 	 return View('Edit_discount')->with('menu',$menuData)
	// 	                             ->with('user_access',$user_access)
	// 	                             ->with('city',$city)
	// 								 ->with('discount_rate',$discount_rate);
	}
	public function SaveUpdateDiscountDetail(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Discount']
							])->get();
		// dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		$nagar_palika=$request->get('nagarpalika');
		$discount=$request->get('discount');
		$construction_age=$request->get('consage');
		$data=array(
		'discount_rate'=>$discount,
		'construction_age'=>$construction_age,
		'nagarpalika'=>$nagar_palika);

		// dd($data);
		if(session()->get('user_type')=='Admin')
		{
		  DB::table('tax_discount')->where('id',$id)->update($data);
		}
		else
		{
			DB::table('tax_discount')->where([['id',$id],['nagarpalika',session()->get('city')]])->update($data);
		}
		// dd($id);
		return redirect('discount')->with('message', 'Discount Rate Updated Successfully.');
	}
	// Manage Road width---------------------------------------------------------------------start----------------------
	public function RoadWidthList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Roadwidth']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		   $road_width_list=DB::table('road_width')->paginate(10);
		}
		else
		{
			$road_width_list=DB::table('road_width')->where('nagarpalika',session()->get('city'))->paginate(10);
		}
		return View('manage_road_width')->with('menu',$menuData)->with('user_access',$user_access)->with('road_width_list',$road_width_list);
	}
	public function saveRoadWidth(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Roadwidth']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
			$data=new road_width_detail;
			$data->nagarpalika=$request->get('nagarpalika');
			$data->road_width=$request->get('road_width');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save();
		}
		else
		{
			$data=new road_width_detail;
			$data->nagarpalika=$request->get('nagarpalika');
			$data->road_width=$request->get('road_width');
			$data->created_at=date('Y-m-d h:m:s');
			$data->save()->where('nagarpalika',session()->get('city'));
		}
	    return redirect('Road-Width-List')->with('message', 'Road Width Added Successfully.');
	}
	public function UpadteRoadWidthDetailView(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Roadwidth']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		if(session()->get('user_type')=='Admin')
		{
		$road_data=DB::table('road_width')->where('id',$id)->get();
		}

		else
		{
			$road_data=DB::table('road_width')->where([['id',$id],['nagarpalika',session()->get('city')]])->get();
		}
	//  dd($road_data);
		 return View('Edit_road_width')->with('menu',$menuData)->with('user_access',$user_access)->with('road_data',$road_data);
	}
	public function SaveUpdateRoadWidthDetail(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Roadwidth']
							])->get();
		// dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		$nagar_palika=$request->get('ngrpalika');
		$road_wid=$request->get('roadwid');
		$data=array(
		'road_width'=>$road_wid,
		'nagarpalika'=>$nagar_palika);
		// dd($data);
		if(session()->get('user_type')=='Admin')
		{
		  DB::table('road_width')->where('id',$id)->update($data);
		}
		else
		{
			DB::table('road_width')->where([['id',$id],['nagarpalika',session()->get('city')]])->update($data);
		}
		// dd($id);
		return redirect('Road-Width-List')->with('message', 'Road Width Updated Successfully.');
	}
	// Manage Tax Rate--------------------------------------------------------------------start------------------
	public function ViewTaxRate()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Tax Rate']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
			$tax_rate=DB::table('tax_rate')->orderby('id','DESC')->paginate(50);
		}
		else
		{
			$tax_rate=DB::table('tax_rate')->where('city',session()->get('city'))->orderby('id','DESC')->paginate(50);
		}
		return View('manage_tax_rate')->with('tax_rate',$tax_rate)->with('menu',$menuData)->with('user_access',$user_access);
	}
	public function SaveTaxRate(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Tax Rate']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$check = TaxRate::where('city', $request->get('ngrpalika'))->where('bhawan_ka_prakar', $request->get('bhavan_parkar'))->where('sadak_ki_choudai', $request->get('sadak_chaudai'))->first();
		if($check){
		return redirect('View-Tax-Rate')->with('message','Tax Rate Already Added.');	
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		    $data=new TaxRate;
			$data->city=$request->get('ngrpalika');
		//	$data->ward_number=$request->get('ward_number');
			$data->bhawan_ka_prakar=$request->get('bhavan_parkar');
           // $data->farsh_ka_prakar=$request->get('farsh_prakar');
			$data->sadak_ki_choudai=$request->get('sadak_chaudai');
			$data->rate=$request->get('rate');
			$data->save();
			return redirect('View-Tax-Rate')->with('message','Tax Rate Added Successfully.');
	}
	public function DeleteTaxRate(Request $request)
	{
		$deleted_id=$request->get('deleted_id');

		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		//dd($deleted_id);

			DB::table('tax_rate')->where('id',$deleted_id)->delete();


        DB::table('tax_rate')
        ->where('id',$deleted_id);
        // ->update(array(

        //     'isdeleted'=>'Y'
        // ));
		return back();
	}
	public function DeleteRoadWidth($id)
	{

		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		

	  //  DB::table('road_width')->where('id',$id)->update(array('isdeleted' => 'N'));
	  DB::table('road_width')->where('id',$id)->delete();

		return back()->with('message','Road Width Deleted Successfully.');
	}
	public function UpadteTaxRateDetailView($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','Manage Tax Rate']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$cities=DB::table('states_cities')->get();
		if(session()->get('user_type')=='Admin')
		{
		$tax_data=DB::table('tax_rate')->where('id',$id)->get();
		}

		else
		{
			$tax_data=DB::table('tax_rate')->where([['id',$id],['nagarpalika',session()->get('city')]])->get();
		}
	//  dd($tax_data);
		 return View('Edit_tax_rate')->with('menu',$menuData)->with('user_access',$user_access)->with('tax_data',$tax_data)->with('cities',$cities);
	}
	public function SaveUpdateTaxRateDetail(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Assign Ward'],
								['user_access_type.sub_menu','----']
							])->get();
		// dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('id');
		$nagar_palika=$request->get('ngrpalika');
		$rate=$request->get('rate');
		//$ward_no=$request->get('wardno');
		// $city=$request->get('city');
		$building_type=$request->get('bhavan_parkar');
		//$floor_type=$request->get('floortype');
		$road_type=$request->get('sadak_chaudai');
		$data=array(
		'rate'=>$rate,
		//'ward_number'=>$ward_no,
		// 'city'=>$city,
		'bhawan_ka_prakar'=>$building_type,
		//'farsh_ka_prakar'=>$floor_type,
		'sadak_ki_choudai'=>$road_type,
		'city'=>$nagar_palika
	);
		// dd($data);
		if(session()->get('user_type')=='Admin')
		{
		  DB::table('tax_rate')->where('id',$id)->update($data);
		}
		else
		{
			DB::table('tax_rate')->where([['id',$id],['nagarpalika',session()->get('city')]])->update($data);
		}
		// dd($id);
		return redirect()->back()->with('message','Tax Rate Updated Successsfully.');
	}

}
