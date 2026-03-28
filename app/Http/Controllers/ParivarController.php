<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Image;
use Redirect;

class ParivarController extends Controller
{
    public function AddParivar()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Add Family Member']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		
		return View('add_family_member')->with('menu',$menuData)->with('user_access',$user_access);
	}
	
	public function SaveParivar(Request $request)
	{
		
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		//dd();
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Add Family Member']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$check_user = DB::table('users')->where('id',session()->get('id'))->first();
		//dd($check_user);
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		
		    $sid = DB::table('survey_step_1')
				->where('house_number',$request->get('houseid'))
				->where('city',$request->get('ngrpalika'))
				->first();
		    //dd($sid);
			$i=0;
            $multi_count = count($request->father_husband);
			//dd($request);
            for($i=0;$i<$multi_count;$i++){
			$data = array(
			'house_id'=>$sid->id,
			'mukhiya_name'=>$request['mukhiya_n'][$i],
			'father_husband'=>$request['father_husband'][$i],
			'member_name'=>$request['member'][$i],
			'relation'=>$request['relation'][$i],
			'gender'=>$request['gender'][$i],
			'age'=>$request['age'][$i],
			'vyvasay'=>$request['occupation'][$i],
			'education'=>$request['education'][$i],
			'aadhar_num'=>$request['aadhar'][$i],
			'abhiyukti'=>$request['abhiyukti'][$i],
			'nagarpalika'=>$request->get('ngrpalika'),
			'created_at'=>date('Y-m-d'),
			'inerted_by'=>$check_user->name
			);
			DB::table('family_members')->insert($data);
			}
			return redirect()->back()->with('success', 'Family Member Content Inserted Successfully.');
	}
	public function SaveMukhiya(Request $request)
	{
		
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		//dd();
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Add Family Member']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$check_user = DB::table('users')->where('id',session()->get('id'))->first();
		//dd($check_user);
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		
		    $sid = DB::table('survey_step_1')
				->where('house_number',$request->get('houseid'))
				->where('city',$request->get('ngrpalika'))
				->first();
		    //dd($sid);
			
            
			DB::table('mukhiya')->insert(array('house_id'=>$sid->id, 'mukhiya'=>$request->mukhiya,'city'=>$request->ngrpalika,'inserted_by'=>$check_user->name));
			
			return redirect()->back()->with('success1', 'Mukhiya Name Inserted Successfully.');
	}
	public function verifyHouse($val)
	{
		$msg="";
		$data= DB::table('survey_personal_details')
					->where('survey_id',$val)
					->where('city','Nagar Panchayat Brijmanganj')
					->first();
		if($data==null)
		{
			$msg="House id not registered";
		}
		else
		{
			
		}
		echo $msg;
	}
	public function getmukhiyaname(Request $request)
	{
		
		$housenumber=$request->get('housenumber');
		$city=$request->get('ngpalika');
		
		$sid = DB::table('survey_step_1')
				->where('house_number',$housenumber)
				->where('city',$city)
				->first();
		$result= DB::table('mukhiya')
					->where('city',$city)
					->where('house_id',$sid->id)
					->get();
		
		echo $result;
	}
	
	public function GetReport()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
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
		   $family_members=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->join('survey_step_1','family_members.house_id','=','survey_step_1.id')
				->where([['survey_step_1.family_data_status','Pending']])
				->orderby('family_members.id','DESC') 
				->groupby('family_members.house_id') 
				->paginate(50);
		}
		else
		{
			$family_members=DB::table('survey_personal_details')->select('survey_personal_details.*','house_details.*','family_members.*')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->where([['family_members.nagarpalika',session()->get('city')],['family_members.inerted_by',session()->get('name')]])
				->orderby('family_members.id','DESC') 
				->groupby('family_members.house_id') 
				->paginate(50);
				//dd(session()->get('city'));
		}
		return View('list_parivar_head')->with('menu',$menuData)->with('user_access',$user_access)->with('family_members',$family_members);
	}


	public function GetApproveReport()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Approve']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		if(session()->get('user_type')=='Admin')
		{
		   $family_members=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->join('survey_step_1','family_members.house_id','=','survey_step_1.id')
				->where([['family_members.relation','मुखिया'],['survey_step_1.family_data_status','Approve']])
				->orderby('family_members.id','DESC') 
				->paginate(50);
		}
		else
		{
			$family_members=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->where([['family_members.relation','मुखिया'],['family_members.nagarpalika',session()->get('city')]])
				->orderby('family_members.id','DESC') 
				->paginate(50);
		}
		return View('list_parivar_head')->with('menu',$menuData)->with('user_access',$user_access)->with('family_members',$family_members);
	}

	public function GetAllFamilyMember($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
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
		   $family_members=DB::table('family_members')
		   		->where([['house_id',$id]])
				->orderby('id','DESC') 
				->get();
		}
		else
		{
			$family_members=DB::table('family_members')
		   		->where([['house_id',$id],['nagarpalika',session()->get('city')]])
				->orderby('id','DESC') 
				->get();
		}
		return View('list_parivar_member_all')->with('menu',$menuData)->with('user_access',$user_access)->with('family_members',$family_members);
	}//

	public function PrintParivarRegister($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
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
		   $family_members=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->where([['survey_personal_details.survey_id',$id]])
				->orderby('family_members.id','DESC') 
				->first();
		}
		else
		{
			$family_members=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->where([['family_members.relation','Self'],['family_members.nagarpalika',session()->get('city')],['survey_personal_details.survey_id',$id]])
				->orderby('family_members.id','DESC') 
				->first();
		}
		$family_members_all=DB::table('family_members')
		   		->where([['house_id',$id],['nagarpalika','Nagar Panchayat Brijmanganj']])
				->orderby('id','ASC') 
				->get();
		return View('print_parivar')
									->with('menu',$menuData)
									->with('family_members_all',$family_members_all)
									->with('user_access',$user_access)
									->with('family_members',$family_members);
	}

	public function SearchParivar(Request $request)
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
								['user_access_type.menu_name','Parivar Register'],
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
		   $family_members=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->where([['survey_personal_details.house_number',$house_number]])
				->orderby('family_members.id','DESC')
				->groupby('family_members.house_id')  
				->paginate(50);
		}
		else
		{
			$family_members=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->join('family_members','family_members.house_id','=','survey_personal_details.survey_id')
				->where([['family_members.nagarpalika',session()->get('city')],['survey_personal_details.house_number',$house_number]])
				->orderby('family_members.id','DESC') 
				->paginate(50);
		}
		return View('list_parivar_head')->with('menu',$menuData)->with('user_access',$user_access)->with('family_members',$family_members);
	}


	public function ActionParivarRejected(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Pending']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		
		$id=$request->get('id');
		
			DB::table('family_members')->where('house_id',$id)->delete();
			DB::table('survey_step_1')
				->where('id',$id)
				->update(array('family_data_status'=>'Reject','family_data_approved_by'=>session()->get('id'),'family_data_approved_date'=>date('Y-m-d H:i:s')));	
			return redirect('Parivar-Report')->with('alert', 'Updated!');;
	}

	public function ActionParivarApproved(Request $request)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Pending']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		
		$id=$request->get('id');
		
			DB::table('survey_step_1')
				->where('id',$id)
				->update(array('family_data_status'=>'Approve','family_data_approved_by'=>session()->get('id'),'family_data_approved_date'=>date('Y-m-d H:i:s')));		
			return redirect('Parivar-Report')->with('alert', 'Updated!');;
	}


	public function DeleteFamilyMemberSingle(Request $request)
	{
		if(session()->get('id')==null)
        {
            return redirect('/');
        }
        $user_access=DB::table('user_access_type')
                            ->join('user_access','user_access_type.id','=','user_access.access_type')
                            ->where([
                                ['user_access.user_type',session()->get('id')],
                                ['user_access_type.menu_name','Parivar Register'],
																['user_access_type.sub_menu','Pending']
                            ])->get();
        //dd($user_access);
        if($user_access!=null)
        {
            if($user_access[0]->fn_delete=='N')
            {
                session()->put('message','Access denied');
                return redirect($master->admin_access.'/dashboard');
            }
        }
        else
        {
            session()->put('message','Access denied');
            return redirect($master->admin_access.'/dashboard');   
        }
        $deleted_id=$request->get('deleted_id');
        $deleted_data=DB::table('family_members')->where('id',$deleted_id)->first();
        DB::table('family_members')->where('id',$deleted_id)->delete();
        return Redirect::back();
	}
	
	public function EditFamilyMember($id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Pending']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$relation=DB::table('relation')->get();
		$education=DB::table('education')->get();
		$family_members=DB::table('family_members')
		   		->where([['id',$id]])
					->orderby('id','DESC') 
					->first();
		return View('update_family_member')
						->with('menu',$menuData)
						->with('user_access',$user_access)
						->with('relation',$relation)
						->with('education',$education)
						->with('family_members',$family_members);
	}//

	public function UpdateFamilyMember(Request $request,$id)
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								['user_access_type.menu_name','Parivar Register'],
								['user_access_type.sub_menu','Pending']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_update=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();
		$validatedData = $request->validate([
        'member_name' => 'required',
        'father_husband' => 'required',
        'date_of_birth' => 'required',
        'aadhar_num' => 'required',
        'abhiyukti' => 'required',
        'vyvasay' => 'required',
        'gender' => 'required',
        'relation' => 'required',
        'education' => 'required',
    ]);
    $data=array(
    	'member_name'=>$request->get('member_name'),
    	'father_husband'=>$request->get('father_husband'),
    	'age'=>$request->get('date_of_birth'),
    	'aadhar_num'=>$request->get('aadhar_num'),
    	'abhiyukti'=>$request->get('abhiyukti'),
    	'vyvasay'=>$request->get('vyvasay'),
    	'gender'=>$request->get('gender'),
    	'relation'=>$request->get('relation'),
    	'education'=>$request->get('education'),
    );
		$family_members=DB::table('family_members')->where([['id',$id]])->update($data);
		return Redirect::back();
	}//
	
	
}	
?>