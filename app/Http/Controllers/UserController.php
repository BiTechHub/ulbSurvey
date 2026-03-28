<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Users;
use App\ward_detail;

class UserController extends Controller
{
  public function viewLogin()
	{
		$attributes = [
            'data-theme' => 'light'
        ];
		return View('login')->with('attributes',$attributes);
	}

	public function loginaction(Request $request)
    {
    // Validate incoming data with type-hinting and added error messages
    $validatedData = $request->validate([
        'username' => 'required',
        'password' => 'required',
        //'g-recaptcha-response' => 'required|captcha', // Uncomment if you use Google reCAPTCHA
    ]);
    //dd($request);
    // Retrieve username and password from request
    $username = $request->get('username');
    $password = $request->get('password');
    
    // Query the database using Eloquent (recommended over DB facade)
    $result = DB::table('users')->where('username', $username)->first();
    //dd($result);
    // Check if user is found
    if (!$result) {
        return redirect('login')->with('status', 'Incorrect Username or Password.');
    }

    // Validate the password (You should hash the password in a real-world scenario)
    if ($result->password!=$password) {
        return redirect('login')->with('status', 'Incorrect Password.');
    }

    // Store user session data
    session([
        'id' => $result->id,
        'name' => $result->name,
        'username' => $result->username,
        'user_type' => $result->user_type,
        'ward_no' => $result->ward_no,
        'ward_name' => $result->ward_name,
        'mohalla' => $result->mohalla,
        'city' => $result->city,
    ]);

    return redirect('dashboard');
    }


	public function viewAndroidLogin($imei)
	{
		$users=DB::table('users')->where('imei',$imei)->first();
		if($users==null)
		{
			$attributes = [
	            'data-theme' => 'light'
	        ];
			return View('android_login')->with('attributes',$attributes)->with('imei',$imei);
		}
		else
		{
			session()->put('id',$users->id);
			session()->put('name',$users->name);
			session()->put('username',$users->username);
			session()->put('user_type',$users->user_type);
			session()->put('city',$users->city);
			return redirect('dashboard');
		}

	}

	public function androidloginaction(Request $request)
	{
		$validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);
		$username=$request->get('username');
		$password=$request->get('password');
		$imei=$request->get('imei');
		$result=DB::table('users')->where("username",$username)->first();

		if($result==null)
		{
		  return redirect('login');
		}
		if($result->password!=$password)
		{
			return redirect('login');
		}
		else
		{
			DB::table('users')->where("username",$username)->update(array('imei'=>$imei));
			session()->put('id',$result->id);
			session()->put('name',$result->name);
			session()->put('username',$result->username);
			session()->put('user_type',$result->user_type);
			session()->put('city',$result->city);
			return redirect('dashboard');
		}
	}


	public function craeteuser()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$statelist=DB::table('states')->get();
		return View('create_user')->with('statelist',$statelist)->with('menu',$menuData)->with('user_access',$user_access);
	}

	public function saveUser(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_add=='N')
		{
			return redirect('login');
		}
		$validatedData = $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'email' => 'required',
            'user_name' => 'required|unique:users,username',
            'user_type' => 'required',
            'password' => 'required',
            'state' => 'required',
            'city' => 'required',
            'login_type' => 'required'
        ]);
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=="Admin")
		{
			$data=new Users;
			$data->name=$request->get('name');
			$data->contact=$request->get('mobile');
			$data->address=$request->get('address');
			$data->email=$request->get('email');
			$data->username=$request->get('user_name');
			$data->user_type=$request->get('user_type');
			$data->password=$request->get('password');
			$data->state_id=$request->get('state');
			$data->city=$request->get('city');
			$data->login_type=$request->get('login_type');
			//$data->images=$request->get('name');
			$data->save();
		}
		else
		{
			$data=new Users;
			$data->name=$request->get('name');
			$data->contact=$request->get('mobile');
			$data->address=$request->get('address');
			$data->email=$request->get('email');
			$data->username=$request->get('user_name');
			$data->user_type=$request->get('user_type');
			$data->password=$request->get('password');
			$data->state_id=$request->get('state');
			$data->city=$request->get('city');
			//$data->images=$request->get('name');
			$data->save()->where('city',session()->get('city'));
		}


		return redirect('assignWard')->with('message','User created successfully. Please assign ward to user.');
	}

	public function manageUser(Request $request)
	{

		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
        
		if(session()->get('user_type')=="Admin")
		{
			$query=DB::table('users')->orderBy('status','ASC');
			if ($request->has('status') && $request->status !== '') {
				$query->where('status', $request->status);
				}
			$userslist = $query->get();
		}
		else
        // DB::EnableQuerylog();
		{
			$query=DB::table('users')->where('city',session()->get('city'))
            ->orderBy('status','ASC');
            if ($request->has('status') && $request->status !== '') {
				$query->where('status', $request->status);
				}
			$userslist = $query->get();

		}
        // dd(DB::getQueryLog());
        // dd($userslist);
		return View('manage_user')->with('menu',$menuData)->with('user_access',$user_access)
									->with('userslist',$userslist);
	}
	
	public function SearchManageUser(Request $request)
	{

		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		
		$query = $request->input('query');
        $userslist = [];

		if(session()->get('user_type')=="Admin")
		{
			$userslist=DB::table('users')
			->where('name', 'like', "%{$query}%")
            ->orWhere('contact', 'like', "%{$query}%")
            ->orWhere('username', 'like', "%{$query}%")
			->orderBy('status','ASC')->get();
		}
		else
        // DB::EnableQuerylog();
		{
			$userslist=DB::table('users')->where('city',session()->get('city'))
			->where('name', 'like', "%{$query}%")
            ->orWhere('contact', 'like', "%{$query}%")
            ->orWhere('username', 'like', "%{$query}%")
            ->orderBy('status','ASC')
            ->get();


		}
        // dd(DB::getQueryLog());
        // dd($userslist);
		return View('manage_user')->with('menu',$menuData)->with('user_access',$user_access)
									->with('userslist',$userslist);
	}
	
	public function SearchAccess(Request $request)
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
								['user_access_type.sub_menu','User Control']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		
		$query = $request->input('query');
        $userslist1 = [];
        $userslist=DB::table('users')->get();
		if(session()->get('user_type')=="Admin")
		{
			$userslist1=DB::table('user_access_type')
			->where('menu_name', 'like', "%{$query}%")
            ->orWhere('sub_menu', 'like', "%{$query}%")
            ->get();
		}
		else
        // DB::EnableQuerylog();
		{
			$userslist1=DB::table('user_access_type')
			->where('menu_name', 'like', "%{$query}%")
            ->orWhere('sub_menu', 'like', "%{$query}%")
            ->get();


		}
        // dd(DB::getQueryLog());
        // dd($userslist);
		return View('user_control')->with('menu',$menuData)->with('user_access',$user_access)
									->with('userslist1',$userslist1)->with('userslist',$userslist);
	}
	
	public function searchWardMohalla(Request $request)
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
		
		$query = $request->input('query');
        $wardlist = [];
        
		if(session()->get('user_type')=="Admin")
		{
			$wardlist=DB::table('ward_details')
			->where('ward_name', 'like', "%{$query}%")
            ->orWhere('mohalla_name', 'like', "%{$query}%")
            ->orWhere('nagarpalika', 'like', "%{$query}%")
            ->get();
		}
		else
        // DB::EnableQuerylog();
		{
			$wardlist=DB::table('ward_details')
			->where('ward_name', 'like', "%{$query}%")
            ->orWhere('mohalla_name', 'like', "%{$query}%")
            ->orWhere('nagarpalika', 'like', "%{$query}%")
            ->get();


		}
        // dd(DB::getQueryLog());
        // dd($userslist);
		return View('manage_ward_mohlla')->with('menu',$menuData)->with('user_access',$user_access)
									->with('wardlist',$wardlist);
	}



	public function editUser($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$statelist=DB::table('states')->get();
		$editData=DB::table('users')->where("id",$id)->first();
		return View('update_user')
										->with('statelist',$statelist)
										->with('menu',$menuData)
										->with('editData',$editData)
										->with('user_access',$user_access);
	}

	public function updateUser(Request $request,$id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$validatedData = $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'user_type' => 'required',
            'password' => 'required',
            'state' => 'required',
            'city' => 'required',
            'login_type' => 'required'
        ]);
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=="Admin")
		{
			//$data->images=$request->get('name');
			$data=array(
				'name'=>$request->get('name'),
				'contact'=>$request->get('mobile'),
				'address'=>$request->get('address'),
				'email'=>$request->get('email'),
				'user_type'=>$request->get('user_type'),
				'password'=>$request->get('password'),
				'state_id'=>$request->get('state'),
				'city'=>$request->get('city'),
				'login_type'=>$request->get('login_type'),
			);

			$editData=DB::table('users')->where("id",$id)->update($data);
		}
		else
		{
			$data=array(
				'name'=>$request->get('name'),
				'contact'=>$request->get('mobile'),
				'address'=>$request->get('address'),
				'email'=>$request->get('email'),
				'user_type'=>$request->get('user_type'),
				'password'=>$request->get('password'),
				'state_id'=>$request->get('state'),
				'city'=>$request->get('city'),
				'login_type'=>$request->get('login_type'),
			);

			$editData=DB::table('users')->where("id",$id)->update($data);
		}


		return redirect('manageUser')->with('message','User details updated successfully.');
	}


	public function updateWard(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}

		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}

		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$ngrpalika=$request->get('ngrpalika');
		$wardnum=$request->get('wardnum');
		$mohalla=$request->get('mohalla');
		$surv=$request->get('surv');
		$checkUser = DB::table('users')
				->where('id', $surv)->first();
		if(session()->get('user_type')=="Admin")
		{
			$result=DB::table('ward_details')->where([['ward_number',$wardnum],['nagarpalika',$ngrpalika],['mohalla_name',$mohalla]])->first();


			$arr=array('ward_no' => $result->ward_number,
					'ward_name' => $result->ward_name,
					'mohalla' => $result->mohalla_name);

			DB::table('users')
				->where('id', $surv)
				->update($arr);
		}
		else
		{
			$result=DB::table('ward_details')->where([["id",$wardnum],['nagarapalika',session()->get('city')]])->first();


			$arr=array('ward_no' => $result->ward_number,
					'ward_name' => $result->ward_name,
					'mohalla' => $result->mohalla_name);

			DB::table('users')
				->where([['id',$surv],['nagarapalika',session()->get('city')]])
				->update($arr);
		}
		return redirect('manageUser')->with('message','Ward Number '. $result->ward_number . ', Ward Name '. $result->ward_name .', Mohalla '. $result->mohalla_name .', Assigned Successfully To surveyor '. $checkUser->name);
	}

	public function updateStatus(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Manage Users']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$stauts=$request->get('status');
		$id=$request->get('id');
		if(session()->get('user_type')=="Admin")
		{
			$arr=array('status' => $stauts,'imei'=>'0','ward_no'=>'0','ward_name'=>'0','mohalla'=>'0');
			//dd($result);
			DB::table('users')
				->where('id', $id)
				->update($arr);
		}
	    else
		{
			$arr=array('status' => $stauts,'imei'=>'0','ward_no'=>'0','ward_name'=>'0','mohalla'=>'0');
			//dd($result);
			DB::table('users')
				->where([['id', $id],['city',session()->get('city')]])
				->update($arr);
		}
		return redirect('manageUser');
	}

	public function userControlView(Request $request)
	{
		$username=session()->get('username');
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Master'],
								['user_access_type.sub_menu','User Control']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$userslist=DB::table('users')->get();
		return View('user_control')->with('userslist',$userslist)
									->with('menu',$menuData);
	}

   public function logout()
   {
   	DB::table('users')->where("id",session()->get('id'))->update(array('imei'=>""));
		session()->put('id',null);
		session()->put('name',null);
		session()->put('username',null);
		session()->put('user_type',null);
		return redirect('login');
   }


   public function AssignWard()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Assign Ward']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		return View('assign_ward')->with('menu',$menuData)->with('user_access',$user_access);
	}

}
