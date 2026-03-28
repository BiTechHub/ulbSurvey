<?php
namespace App\Http\Controllers;

use App\assts;
use DB;
use Illuminate\Http\Request;
use Image;

class AssetsController extends Controller
{
    public function AssetsList()
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Master'],
                ['user_access_type.sub_menu', 'Manage Assets'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        if (session()->get('user_type') == 'Admin') {
            $asset_name = DB::table('assets')->where('isdeleted', 'N')->paginate(10);
        } else {
            $asset_name = DB::table('assets')->where('isdeleted', 'N')->paginate(10);
        }
        return View('manage_assets')->with('menu', $menuData)->with('user_access', $user_access)->with('asset_name', $asset_name);
    }

    public function SaveAssets(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Master'],
                ['user_access_type.sub_menu', 'Manage Assets'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_add == 'N') {
            return redirect('login');
        }
        $validatedData = $request->validate([
            'asset_name' => 'required',
        ]);
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();

        $data              = new assts;
        $data->assets_name = $request->get('asset_name');

        $data->created_at = date('Y-m-d h:m:s');
        $data->save();
        return redirect('Assets');

    }
    public function DeleteAssets(Request $request)
    {
        $deleted_id = $request->get('deleted_id');

        if (session()->get('id') == null) {
            return redirect('login');
        }
        //dd($deleted_id);

        DB::table('assets')->where('id', $deleted_id)->delete();

        DB::table('assets')
            ->where('id', $deleted_id);
        // ->update(array(

        //     'isdeleted'=>'Y'
        // ));
        return back();
    }

    public function UpadteAssetsDetailView(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Master'],
                ['user_access_type.sub_menu', 'Manage Assets'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_update == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        $id       = $request->get('id');
        if (session()->get('user_type') == 'Admin') {
            $asset = DB::table('assets')->where('id', $id)->get();
        } else {
            $asset = DB::table('assets')->where([['id', $id]])->get();
        }
        //  dd($asset_name);
        return View('Edit_asset')->with('menu', $menuData)->with('user_access', $user_access)->with('asset', $asset);
    }
    public function SaveUpdateAssetsDetail(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assign Ward'],
                ['user_access_type.sub_menu', '----'],
            ])->get();
        // dd($user_access);
        if ($user_access[0]->fn_update == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        $id       = $request->get('id');

        $asset_name = $request->get('assetname');
        $data       = array(
            'assets_name' => $asset_name,
        );
        // dd($data);
        if (session()->get('user_type') == 'Admin') {
            DB::table('assets')->where('id', $id)->update($data);
        } else {
            DB::table('assets')->where([['id', $id]])->update($data);
        }
        // dd($id);
        return redirect('Assets');
    }

    public function AssetsDetailsVerifiedList()
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assets Details'],
                ['user_access_type.sub_menu', 'Verified'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        if (session()->get('user_type') == 'Admin') {
            $assets_detail_varify = DB::table('assets_details')->where('DataVarfied', 'Yes')->orderBy('id', 'DESC')->paginate(50);
        } else {
            $assets_detail_varify = DB::table('assets_details')->where([['DataVarfied', 'Yes'], ['city', session()->get('city')]])->orderBy('id', 'DESC')->paginate(50);
        }
        return View('VarifyAssetsData')->with('menu', $menuData)->with('user_access', $user_access)->with('assets_detail_varify', $assets_detail_varify);
    }

    public function AssetsDetailsNonVerifiedList()
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assets Details'],
                ['user_access_type.sub_menu', 'Not-Verified'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        if (session()->get('user_type') == 'Admin') {
            $assets_detail_not_varify = DB::table('assets_details')->where('DataVarfied', 'No')->orderBy('id', 'desc')->paginate(50);
        } else {
            $assets_detail_not_varify = DB::table('assets_details')->where([['DataVarfied', 'No'], ['city', session()->get('city')]])->orderBy('id', 'desc')->paginate(50);
        }
        return View('AssetsData')->with('menu', $menuData)->with('user_access', $user_access)->with('assets_detail_not_varify', $assets_detail_not_varify);
    }
//edit asset non verified list-----------------------------------------------------------------
    public function UpadteAssetsDetailsNonVerifiedListView(Request $request)
    {
        $id = $request->get('id');
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assets Details'],
                ['user_access_type.sub_menu', 'Not-Verified'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_update == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        $id       = $request->get('id');
        if (session()->get('user_type') == 'Admin') {
            $asset_list = DB::table('assets')->get();
            $assets_detail_not_varify = DB::table('assets_details')
                                       ->where([['DataVarfied', 'No'], ['id', $id]
                                       ])->get();
        } else {
            $asset_list = DB::table('assets')->get();
            $assets_detail_not_varify = DB::table('assets_details')
                                    ->where([['id', $id], ['DataVarfied', 'No'],
                                             ['city', session()->get('city')]
                                            ])->get();
        }
// dd($asset_list[0]);
        return View('Edit_asset_non_verified')
            ->with('assets_detail_not_varify', $assets_detail_not_varify)
            ->with('asset_list', $asset_list)
            ->with('menu', $menuData)
            ->with('user_access', $user_access);

    }

    public function SaveUpdateAssetsDetailsNonVerified(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assets Details'],
                ['user_access_type.sub_menu', 'Not-Verified'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_update == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();

        $id = $request->get('id');

        $land_mark  = $request->get('landmark');
        $ward_num   = $request->get('wardnum');
        $asset_list = $request->get('asset');
        $data       = array(
            'landmark'    => $land_mark,
            'ward_number' => $ward_num,
            'assets_name' => $asset_list,
            'updated_at'=>date('Y-m-d H:i:s'),
        );

        if (session()->get('user_type') == 'Admin') {
            DB::table('assets_details')->where([['id', $id], ['DataVarfied', 'No']])->update($data);
        } else {
            DB::table('assets_details')->where([['id', $id], ['DataVarfied', 'No'], ['city', session()->get('city')]])->update($data);
        }

        return redirect('Assets-Details-NonVerified-List');

    }
// -------------------------------------------------------------------------------------------
    public function AssetsDetailsRejectedList()
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assets Details'],
                ['user_access_type.sub_menu', 'Rejected'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        if (session()->get('user_type') == 'Admin') {
            $assets_detail_rejected = DB::table('assets_details')->where('DataVarfied', 'Rejected')->orderBy('id', 'desc')->paginate(50);
        } else {
            $assets_detail_rejected = DB::table('assets_details')->where([['DataVarfied', 'Rejected'], ['city', session()->get('city')]])->orderBy('id', 'desc')->paginate(50);
        }
        return View('RejectedAssetsData')->with('menu', $menuData)->with('user_access', $user_access)->with('assets_detail_rejected', $assets_detail_rejected);

    }

    public function ActionAssetsDetailsVerified(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assets Details'],
                ['user_access_type.sub_menu', 'Not-Verified'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_update == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();

        $id = $request->get('id');
        DB::table('assets_details')
            ->where('id', $id)
            ->update(array('DataVarfied' => 'Yes', 'varifiedBy' => session()->get('id')));
        return redirect('Assets-Details-NonVerified-List')->with('alert', 'Updated!');
    }
    public function ActionAssetsDetailsRejected(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Assets Details'],
                ['user_access_type.sub_menu', 'Not-Verified'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_update == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();

        $id = $request->get('id');
        DB::table('assets_details')
            ->where('id', $id)
            ->update(array('DataVarfied' => 'Rejected', 'varifiedBy' => session()->get('id')));
        return redirect('Assets-Details-NonVerified-List')->with('alert', 'Updated!');
    }
    public function RotateClockwise($id)
    {

        $data = DB::table('assets_details')->where('id', $id)->first();
        //dd($data);
        $destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload") . '/assets';
        // create Image from file
        //dd($data->image_name);
        $img = Image::make($destinationPath . '/' . $data->photo);

        // rotate image 45 degrees clockwise
        $img->rotate(-90);
        $img->save($destinationPath . '/' . $data->photo);
        return redirect('Assets-Details-NonVerified-List');
    }
    public function RotateAntiClockwise($id)
    {
        $data            = DB::table('assets_details')->where('id', $id)->first();
        $destinationPath = base_path() . env("UPLOAD_PATH", "/../wwwroot/new_gis/upload") . '/assets';
        // create Image from file
        //dd($data->image_name);
        $img = Image::make($destinationPath . '/' . $data->photo);

        // rotate image 45 degrees clockwise
        $img->rotate(90);
        $img->save($destinationPath . '/' . $data->photo);
        return redirect('Assets-Details-NonVerified-List');
    }
}
