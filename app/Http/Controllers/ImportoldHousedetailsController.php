<?php
namespace App\Http\Controllers;
use DB;
use Excel;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\housedetail;


class ImportoldHousedetailsController extends Controller
{
    private $memory_size = "1024M";
	public function index()
	{
		if(session()->get('id')==null)
		{
			return redirect('login');
		}
		$user_access=$menu=DB::table('user_access_type')
							->join('user_access','user_access_type.id','=','user_access.access_type')
							->where([
								['user_access.user_type',session()->get('id')],
								// ['user_access_type.menu_name','Import old House Details'],
								// ['user_access_type.sub_menu','']
							])->get();
		//dd($user_access);
		if($user_access[0]->fn_view=='N')
		{
			return redirect('login');
		}
		$menuData=app('App\Http\Controllers\DashboardController')->MenuList();

			$house_detail = DB::table('old_house_import')->orderBy('created_at', 'DESC')->paginate(50);

		return View('list_import_old_house_details')->with('house_detail',$house_detail)
												->with('menu',$menuData)
												->with('user_access',$user_access);
	}

    public function create()
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
			$city=DB::table('states_cities')->get();
		}
		else
        // DB::EnableQuerylog();
		{
			$city=DB::table('states_cities')->get();
        }
        // dd(DB::getQueryLog());
        // dd($userslist);
		return View('add_old_house_details')->with('menu',$menuData)->with('user_access',$user_access)
									         ->with('city',$city);
	}

    public function ImportoldHouseDetails(Request $request)
	{
        DB::beginTransaction();
        try{
            ini_set('memory_limit', $this->memory_size);
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
                'excel' => 'required',
                'ward_number' => 'required',
                'city' => 'required',

            ]);
            $menuData=app('App\Http\Controllers\DashboardController')->MenuList();
            $file_name = "old_house_details".date('hisymdhis').".xlsx";
            $destinationPath = base_path() . "/document/old_house_details";
             if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0777, true);
            }
            $request->file('excel')->move(
                $destinationPath.'/', $file_name
            );
            $splitdropdown = $request->get('ward_number');
            //    dd($splitdropdown);
            $splitdata = explode('->',$splitdropdown);
            //    dd($splitdata);
               $wdno = $splitdata[0];
               $wdname = $splitdata[1];
               $mohlla = $splitdata[2];
            $importoldhouse = array(
                'city' => $request->get('city'),
                'ward_number' => $wdno,
                'ward_name' => $wdname,
                'mohalla_name' => $mohlla,
                'filename' => $file_name,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => session()->get('id'),
               );
            //    dd($importoldhouse);
               $insertedimportoldhouse =DB::table('old_house_import')->insertGetId($importoldhouse);
            //    dd( $insertedimportoldhouse);
               $array = Excel::toArray(new UsersImport, $destinationPath.'/'. $file_name);
               $data=$array[0];
               $data_count=0;
               $insert_array=array();
               foreach($data as $index=>$value)
               {
                   $temp_data=array(
                       'owner_name' => ucfirst($value[0]),
                       'father_name' => $value[1],
                       'house_number' => trim($value[2]),
                       'batch_id' => $insertedimportoldhouse,
                       'city' => $request->get('city'),
                       'ward_number' => $wdno,
                       'ward_name' => $wdname,
                       'mohalla_name' => $mohlla,
                       'created_at' => date('Y-m-d H:i:s'),
                       'created_by' => session()->get('id'),
                   );
                   if($index>0)
                   {
                       if(!$temp_data['house_number']==null)
                       {
                        array_push($insert_array,$temp_data);
                        $data_count++;
                       }
                    }

                }
                DB::table('old_house_details')->insert($insert_array);
                DB::table('old_house_import')->where('id',$insertedimportoldhouse)->update(array('uploaded_old_house'=>$data_count));
            DB::commit();
                session()->put('message',$data_count." Old House Datails successfully inserted");
            return redirect('Import-old-House-Details')->withErrors([str_replace("-", " ", 'Import-old-House-Details').' added successfully']);
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            dd($ex);
        }
	}

    public function DeleteImportHouseDetails(Request $request)
	{


		if(session()->get('id')==null)
		{
			return redirect('login');
		}
        $deleted_id=$request->get('deleted_id');
		// dd($deleted_id);
        $oldhouseimport = DB::table('old_house_import')->first();
        DB::table('old_house_import')->where('id',$deleted_id)->delete();
		return back();
	}

}


?>
