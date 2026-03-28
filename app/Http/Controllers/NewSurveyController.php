<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\surveyStep1;
use Image;
use Redirect;

class NewSurveyController extends Controller
{
	public function GetSurveyDetailsVerifiedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
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
		   $surveydata=DB::table('survey_step_1')->where('DataVerfied','Yes')->orderBy('house_number', 'asc')->paginate(100);
		}
		else
		{
			$surveydata=DB::table('survey_step_1')->where([['DataVerfied','Yes'],['city',session()->get('city')]])->orderBy('ward_number', 'asc')->paginate(100);
		}
		$master=DB::table('master')->first();
		return View('survey_step1_verified')->with('master',$master)->with('menu',$menuData)->with('user_access',$user_access)->with('surveydata',$surveydata);
	}

	public function GetSurveyDetailsNonVerifiedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
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
		  $surveydata=DB::table('survey_step_1')->where('DataVerfied','No')->orderBy('id', 'desc')->paginate(50);
		}
		else
		{
			 $surveydata=DB::table('survey_step_1')->where([['DataVerfied','No'],['city',session()->get('city')]])->orderBy('id', 'desc')->paginate(50);
		}
		$master=DB::table('master')->first();
		return View('survey_step1')->with('master',$master)->with('menu',$menuData)->with('user_access',$user_access)->with('surveydata',$surveydata);
	}
	public function GetSurveyDetailsRejectedList()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
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
		$surveydatareject=DB::table('survey_step_1')->where('DataVerfied','Rejected')->orderBy('id', 'desc')->paginate(50);
		}
		else
		{
			$surveydatareject=DB::table('survey_step_1')->where([['DataVerfied','Rejected'],['city',session()->get('city')]])->orderBy('id', 'desc')->paginate(50);
		}
		$master=DB::table('master')->first();
		return View('survey_step1_rejected')->with('master',$master)->with('menu',$menuData)->with('user_access',$user_access)->with('surveydatareject',$surveydatareject);
	}

	public function ActionSurveyDataVerified(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

		$id=$request->get('id');
		DB::table('survey_step_1')
            ->where('id',$id)
            ->update(array('DataVerfied'=>'Yes','verified_at'=>date('Y-m-d H:i:s'),'veryfiedBy'=>session()->get('id')));
		return redirect('Survey-Details-NonVerified-List')->with('message','House Verified Successfully.');
	}
	public function ActionSurveyDataRejected(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
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
			DB::table('survey_step_1')
            ->where('id',$id)
            ->update(array('reject_reason'=>$reason,'DataVerfied'=>'Rejected','verified_at'=>date('Y-m-d H:i:s'),'veryfiedBy'=>session()->get('id')));
		}

		return redirect('Survey-Details-NonVerified-List')->with('message','House Rejected Successfully.');
	}

	public function RotateClockwise($id)
	{

		$data=DB::table('survey_step_1')->where('id',$id)->first();
		$destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload");
		// create Image from file
		//dd($data->image_name);
		$img = Image::make($destinationPath.'/'.$data->image_name);

		// rotate image 45 degrees clockwise
		$img->rotate(-90);
		$img->save($destinationPath.'/'.$data->image_name);
		return Redirect::back()->withErrors(['Document Rotate Successfully Please Press CTRL+ R To check new Image']);
	}

	public function RotateAntiClockwise($id)
	{
		$data=DB::table('survey_step_1')->where('id',$id)->first();
		$destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload");
		// create Image from file
		//dd($data->image_name);
		$img = Image::make($destinationPath.'/'.$data->image_name);

		// rotate image 45 degrees clockwise
		$img->rotate(90);
		$img->save($destinationPath.'/'.$data->image_name);
		return Redirect::back()->withErrors(['Document Rotate Successfully Please Press CTRL+ R To check new Image']);
	}

	public function RotateDocumentClockwise($id)
	{

		$data=DB::table('survey_step_1')->where('id',$id)->first();
		$destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload/document");
		// create Image from file
		//dd($data->image_name);
		//dd($destinationPath.'/'.$data->proof_name);
		$img = Image::make($destinationPath.'/document/'.$data->proof_name);


		// rotate image 45 degrees clockwise
		$img->rotate(-90);
		$img->save($destinationPath.'/document/'.$data->proof_name);
		return Redirect::back()->withErrors(['Document Rotate Successfully Please Press CTRL+ R To check new Image']);
	}

	public function RotateDocumentAntiClockwise($id)
	{
		$data=DB::table('survey_step_1')->where('id',$id)->first();
		$destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload/document");
		// create Image from file
		//dd($data->image_name);
		$img = Image::make($destinationPath.'/document/'.$data->proof_name);

		// rotate image 45 degrees clockwise
		$img->rotate(90);
		$img->save($destinationPath.'/document/'.$data->proof_name);
		return Redirect::back()->withErrors(['Document Rotate Successfully Please Press CTRL+ R To check new Image']);
	}

	public function ViewUpdateNewhouse(Request $request)
	{
		$id=$request->get('id');
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd(session()->get('id'));
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
			$data=DB::table('survey_step_1')->where('id',$id)->get();
			$ward_details=DB::table('ward_details')->where([['ward_number',$data[0]->ward_number],['nagarpalika',$data[0]->city]])->get();
		}
		else
		{
			$data=DB::table('survey_step_1')->where([['id',$id],['city',session()->get('city')]])->orderBy('id', 'desc')->paginate(50);
			$ward_details=DB::table('ward_details')->where([['ward_number',$data[0]->ward_number],['nagarpalika',session()->get('city')]])->get();
		}
		//dd($data);
		return View('update_new_house')
									->with('ward_details',$ward_details)
									->with('menu',$menuData)
									->with('user_access',$user_access)
									->with('data',$data);
	}

	public function updateNewhouse(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$id=$request->get('surv_id');
		//dd($id);



		$house_number=$request->get('makan_no');
		$basement=$request->get('basement');
		$nof=$request->get('nof');
		$house_type=$request->get('house_type');
		$ward_name=$request->get('ward_name');
		$mohalla=$request->get('mohalla');

		$arr = array(
			'basement'=>$basement,
			'no_of_floor'=>$nof,
			'house_type'=>$house_type,
			'ward_name'=>$ward_name,
			'mohalla'=>$mohalla,
			'updated_at'=>date('Y-m-d H:i:s'),
		);
		$house_number = array(
			'house_number'=>$house_number,
		);
		DB::table('survey_step_1')->where('id',$id)->update($arr);
		DB::table('survey_step_1')->where('id',$id)->update($house_number);
		DB::table('survey_personal_details')->where('survey_id',$id)->update($house_number);
		DB::table('house_details')->where('personal_details_id',$id)->update($house_number);
		return redirect('Survey-Details-NonVerified-List');

	}//add_new_house.blade.php

	public function AddNewHouse()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=DB::table('states_cities')->get();
		return View('add_new_house')
									->with('nagar_palika',$nagar_palika)
									->with('menu',$menuData)
									->with('user_access',$user_access);

	}//add_new_house.blade.php

	public function SaveNewHouse(Request $request)
	{
    //   dd("ghj");
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}

		$this->validate($request, [
		    'city' => 'required',
            'house_number' => 'required',
            'ward_number' => 'required|numeric',
            'basement' => 'required|alpha_num',
            'house_type' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'floor' => 'required|numeric',
            'image_name' => 'required|mimes:jpeg,png,jpg|max:5000',
            'searchAddress' => 'required'
		]);

        $image_name="image_".date('ymdhis').".jpg";
		 $destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload");
        //$destinationPath       = base_path() . "/document/new_gis";
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $request->file('image_name')->move(
            $destinationPath . '/', $image_name
        );
        // $img = Image::make($photo_image->getRealPath());
        // $img->resize(1000,1940, function ($constraint) {
        //     $constraint->aspectRatio();
        // });
        // $img->save($destinationPath.'/'.$photo);

        // $photo_image = $request->file('house_photo');
// dd($photo_image);
		$data=array(
			'house_number' => $request->get('house_number'),
            'ward_number' => $request->get('ward_number'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
            'basement' => $request->get('basement'),
            'no_of_floor' => $request->get('floor'),
            'house_type' => $request->get('house_type'),
            'city' =>$request->get('city'),
            'username' => session()->get('id'),
            'user_id' => session()->get('id'),
            'imei' => "0",
            'image_name' => $image_name,
            'tstamp' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
		);





		$check_house=DB::table('survey_step_1')->where([['city',$request->get('city')],['house_number', $request->get('house_number')]])->count();
		if($check_house==0)
		{
			DB::table('survey_step_1')->insert($data);
			$msg="House number ".$request->get('house_number')." successfully inserted in ".$request->get('city');
		}
		else
		{
			$msg="House number ".$request->get('house_number')." Already registered in ".$request->get('city');
		}

		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=DB::table('states_cities')->get();
		return View('add_new_house')
									->with('msg',$msg)
									->with('nagar_palika',$nagar_palika)
									->with('nagar_palika',$nagar_palika)
									->with('menu',$menuData)
									->with('user_access',$user_access);

	}//.blade.php

	public function ChangeImage($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$survey_step_1=DB::table('survey_step_1')->where('id',$id)->first();
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$nagar_palika=DB::table('states_cities')->get();
		return View('survey_image_change')
									->with('survey_step_1',$survey_step_1)
									->with('nagar_palika',$nagar_palika)
									->with('menu',$menuData)
									->with('user_access',$user_access);

	}


	public function ChangeImageSave(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
								['user_access_type.sub_menu','Not-Verified']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}

		$this->validate($request, [
			'house_id' => 'required|numeric',
		    'image_name' => 'required|mimes:jpeg,png,jpg|max:5000',
        ]);
        $survey_step_1=DB::table('survey_step_1')->where('id',$request->get('house_id'))->first();
		$image_name=$survey_step_1->image_name;
        // $photo_image = $request->file('image_name');


        $image_name="change_".date('ymdhis').$survey_step_1->image_name;
		 $destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload");
        // $destinationPath       = base_path() . "/document/new_gis";
        // dd($destinationPath);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $request->file('image_name')->move(
            $destinationPath . '/', $image_name
        );



		// $destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload");
        // if (!file_exists($destinationPath)) {
        //     mkdir($destinationPath, 0777, true);
        // }
        // $img = Image::make($photo_image->getRealPath());
        // $img->resize(1000,1940, function ($constraint) {
        //     $constraint->aspectRatio();
        // });
		// $photo="change_".date('ymdhis').$survey_step_1->image_name;
        // $img->save($destinationPath.'/'.$photo);
        //return Redirect::back();
        DB::table('survey_step_1')->where('id',$request->get('house_id'))->update(array('image_name'=>$image_name));
        return redirect('Survey-Details-NonVerified-List');


	}//add_new_house.blade.php

	public function SearchSurveyDetails(Request $request)
	{
		$house_number=$request->get('keyword');
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','New House Details'],
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
		  $master=DB::table('master')->first();
		  $surveydata=DB::table('survey_step_1')
		  			->where('house_number','LIKE','%'.$house_number.'%')
		  			->orderBy('id', 'desc')
		  			->paginate(500);
		}
		return View('survey_step1')->with('master',$master)->with('menu',$menuData)->with('user_access',$user_access)->with('surveydata',$surveydata);
	}

	public function DeleteHouse(Request $request)
	{
		$deleted_id=$request->get('deleted_id');
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		//dd($deleted_id);
		$master=DB::table('master')->first();
		if($master->delete_house=="Yes")
		{
			DB::table('survey_step_1')->where('id',$deleted_id)->delete();
			DB::table('survey_personal_details')->where('survey_id',$deleted_id)->delete();
			DB::table('house_details')->where('personal_details_id',$deleted_id)->delete();
		}
		return back();
	}

}
?>
