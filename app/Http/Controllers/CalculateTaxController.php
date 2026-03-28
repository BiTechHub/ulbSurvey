<?php

namespace App\Http\Controllers;

use App\CashDetails;
use App\OnlineDetails;
use App\PaymentLog;
use App\taxDetails;
use DB;
use Illuminate\Http\Request;

//use App\Http\Requests;

class CalculateTaxController extends Controller
{
    public function GenerateTax(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Generate Tax'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $data     = new taxDetails();
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        if (session()->get('user_type') == 'Admin') {
            $city = DB::table('states_cities')->get();
        } else {
            $city = DB::table('states_cities')->where('city', session()->get('city'))->get();
        }

        return View('generate_tax')->with('menu', $menuData);
    }
    public function GenerateTaxSubmit(Request $request)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Generate Tax'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $data     = array();
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        DB::beginTransaction();
        try
        {
            $city          = $request->get('ngrpalika');
            $states_cities = DB::table('states_cities')->where('city', $city)->first();
            $ward_details  = DB::table('ward_details')
                ->where([
                    ['id', $request->get('wardnum')],
                ])
                ->first();
            $ward_number    = $ward_details->ward_number;
            $financial_year = $request->get('financial_year');
            DB::table('tax_details')->where([['paid_status', 'Due'], ['session', ($financial_year - 1)], ['ward_number', $ward_number]])->update(array('paid_status' => 'Bounce'));

            $get_personal_details = DB::table('survey_personal_details')
                ->join('house_details', 'survey_personal_details.survey_id', '=', 'house_details.personal_details_id')
                ->where([
                    ['survey_personal_details.city', $city],
                    ['survey_personal_details.ward_number', $ward_number],
                    ['survey_personal_details.status', 'Completed'],
                ])
                ->whereNotIn('survey_id', DB::table('tax_details')->where('session', $financial_year)->pluck('house_id'))
                ->whereNotNull('area_all')
                ->take(500)
                ->get();
            $tax_formula  = DB::table('tax_formula')->where([['city', $city]])->get();
            $tax_discount = DB::table('tax_discount')->where([['nagarpalika', $city]])->get();
            $count        = 0;
            $arr_discount = array();
            $arr_rate     = array();
            $rate         = DB::table('tax_rate')
                ->where([
                    ['city', $city],
                    ['ward_number', $ward_details->id],
                ])
                ->get();
				//dd($rate);
            foreach ($rate as $value) {
                $arr_rate[$value->bhawan_ka_prakar][$value->sadak_ki_choudai] = $value->rate;
            }
            foreach ($tax_discount as $value) {
                $arr_discount[$value->construction_age] = $value->discount_rate;
            }
            //dd(sizeof($tax_formula));
            if (sizeof($get_personal_details) > 0) {
				//dd($tax_formula[0]->house_tax_formula);
                if ($tax_formula[0]->house_tax_formula > 0.00) {
                    foreach ($get_personal_details as $value) {
                        $rate_final = 0.00;
                        if (isset($arr_rate[$value->NirmanPrakriti][$value->sadakKichoudai])) {
                            $tax_calc = 1;
                            //if($value->house_id=="" || $value->house_id==null)
                            {
                               // $tax_multiplication = DB::table('property_type')
                                //    ->select('tax_rate')
                                //    ->where('property_type_name', $value->sampattiPrakar)
                               //     ->first();
                               // if ($tax_multiplication != null) {
                                //    $tax_calc = $tax_multiplication->tax_rate;
                               // }
                                //dd($tax_rate_multi);
                                $rate_final            = $arr_rate[$value->NirmanPrakriti][$value->sadakKichoudai];
                                $discount_percentage   = $arr_discount[$value->nirmanVarsh];
                                $no_of_floor           = $value->no_of_floor;
                                $area_common           = $value->area_common_length * $value->area_common_width;
                                $area_basement         = $value->basement_area * $value->basement_area_width;
                                $arv_basement          = (($rate_final * $area_basement) * 9.6);
                                $arv_basement_discount = $arv_basement - (($arv_basement * $discount_percentage) / 100);
                                $house_tax_basement    = ($arv_basement_discount * $tax_formula[0]->house_tax_formula) / 100;
                                $water_tax_basement    = ($arv_basement_discount * $tax_formula[0]->water_tax_formula) / 100;
                                if ($water_tax_basement < $tax_formula[0]->min_water_tax_amount) {
                                    $water_tax_basement = $tax_formula[0]->min_water_tax_amount;
                                }

                                $area_ground         = $value->ground_area * $value->ground_area_width;
                                $arv_ground          = (($rate_final * $area_ground) * 9.6);
                                $arv_ground_discount = $arv_ground - (($arv_ground * $discount_percentage) / 100);
                                $house_tax_ground    = ($arv_ground_discount * $tax_formula[0]->house_tax_formula) / 100;
                                $water_tax_ground    = ($arv_ground_discount * $tax_formula[0]->water_tax_formula) / 100;
                                if ($water_tax_ground < $tax_formula[0]->min_water_tax_amount) {
                                    $water_tax_ground = $tax_formula[0]->min_water_tax_amount;
                                }

                                $area_first         = $value->first_area * $value->first_area_width;
                                $arv_first          = (($rate_final * $area_first) * 9.6);
                                $arv_first_discount = $arv_first - (($arv_first * $discount_percentage) / 100);
                                $house_tax_first    = ($arv_first_discount * $tax_formula[0]->house_tax_formula) / 100;
                                $water_tax_first    = ($arv_first_discount * $tax_formula[0]->water_tax_formula) / 100;
                                if ($water_tax_first < $tax_formula[0]->min_water_tax_amount) {
                                    $water_tax_first = $tax_formula[0]->min_water_tax_amount;
                                }

                                $area_second         = $value->second_area * $value->second_area_width;
                                $arv_second          = (($rate_final * $area_second) * 9.6);
                                $arv_second_discount = $arv_second - (($arv_second * $discount_percentage) / 100);
                                $house_tax_second    = ($arv_second_discount * $tax_formula[0]->house_tax_formula) / 100;
                                $water_tax_second    = ($arv_second_discount * $tax_formula[0]->water_tax_formula) / 100;
                                if ($water_tax_second < $tax_formula[0]->min_water_tax_amount) {
                                    $water_tax_second = $tax_formula[0]->min_water_tax_amount;
                                }

                                $area_third         = $value->third_area * $value->third_area_width;
                                $arv_third          = (($rate_final * $area_third) * 9.6);
                                $arv_third_discount = $arv_third - (($arv_third * $discount_percentage) / 100);
                                $house_tax_third    = ($arv_third_discount * $tax_formula[0]->house_tax_formula) / 100;
                                $water_tax_third    = ($arv_third_discount * $tax_formula[0]->water_tax_formula) / 100;
                                if ($water_tax_third < $tax_formula[0]->min_water_tax_amount) {
                                    $water_tax_third = $tax_formula[0]->min_water_tax_amount;
                                }

                                $area_commercial         = $value->area_business * $value->area_business_width;
                                $arv_commercial          = $rate_final * $area_commercial * 12;
                                $arv_commercial_discount = 0;
                                $house_tax_commercial    = ($arv_commercial * $tax_formula[0]->house_tax_formula) / 100;
                                $water_tax_commercial    = ($arv_commercial * $tax_formula[0]->house_tax_formula) / 100;
                                if ($water_tax_commercial < $tax_formula[0]->min_water_tax_amount) {
                                    $water_tax_commercial = $tax_formula[0]->min_water_tax_amount;
                                }

                                //dd($house_tax_third);
                                if ($rate_final > 0.00) {
                                    $arv_total_discount = $arv_basement_discount + $arv_ground_discount + $arv_first_discount + $arv_second_discount + $arv_third_discount + $arv_commercial_discount;
                                    $arv_total          = $arv_basement + $arv_ground + $arv_first + $arv_second + $arv_third + $arv_commercial;
                                    
									if($city == 'Nagar Panchayat Brijmanganj')
									{
									
									$totel_house_tax    = $house_tax_basement + $house_tax_ground + $house_tax_first + $house_tax_second + $house_tax_third + $house_tax_commercial;
                                    $totel_water_tax    = $water_tax_basement + $water_tax_ground + $water_tax_first + $water_tax_second + $water_tax_third + $water_tax_commercial;
                                    $sub_total          = $totel_house_tax + $totel_water_tax;
									$tempSubTotal = $sub_total;
									
									$prData = DB::table('property_type')->get();
									$vij = 0;
									foreach($prData as $prval){
										if($prval->property_type_name == $value->sampattiPrakar){
											
											$sub_total          = $tempSubTotal * $prval->tax_rate;
										}
									
									}
									
									}else{
									$totel_house_tax    = $house_tax_basement + $house_tax_ground + $house_tax_first + $house_tax_second + $house_tax_third + $house_tax_commercial;
                                    $totel_water_tax    = $water_tax_basement + $water_tax_ground + $water_tax_first + $water_tax_second + $water_tax_third + $water_tax_commercial;
                                    $sub_total          = $totel_house_tax + $totel_water_tax;	
									}
									
									
									
                                    $overdue_amount     = DB::table('tax_details')
                                        ->select('due_amount')
                                        ->where('house_id', $value->survey_id)
                                        ->orderby('id', 'DESC')
                                        ->first();
                                    if ($overdue_amount == null) {
                                        $overdue_amount1 = 0.00;
                                    } else {
                                        $overdue_amount1 = $overdue_amount->due_amount;
                                    }
                                    $interest_amount = ($overdue_amount1 * $states_cities->interest_rate) / 100;
                                    $due_amount      = $sub_total + $overdue_amount1 + $interest_amount;
                                    $arr             = array(
                                        'house_id'             => $value->survey_id,
                                        'house_number_1'       => $value->house_number,
                                        'ward_number'          => $ward_number,
                                        'city'                 => $city,
                                        'session'              => $financial_year,
                                        'bhawan_nirman_varsh'  => $value->nirmanVarsh,
                                        'rate'                 => $rate_final,
                                        'no_of_floor'          => $no_of_floor,
                                        'discount_percent'     => $discount_percentage,
                                        'area_basement'        => $area_basement,
                                        'arv_basement'         => $arv_basement,
                                        'house_tax_basement'   => $house_tax_basement,
                                        'water_tax_basement'   => $water_tax_basement,
                                        'area_ground'          => $area_ground,
                                        'arv_ground'           => $arv_ground,
                                        'house_tax_ground'     => $house_tax_ground,
                                        'water_tax_ground'     => $water_tax_ground,
                                        'area_first'           => $area_first,
                                        'arv_first'            => $arv_first,
                                        'house_tax_first'      => $house_tax_first,
                                        'water_tax_first'      => $water_tax_first,
                                        'area_second'          => $area_second,
                                        'arv_second'           => $arv_second,
                                        'house_tax_second'     => $house_tax_second,
                                        'water_tax_second'     => $water_tax_second,
                                        'area_third'           => $area_third,
                                        'arv_third'            => $arv_third,
                                        'house_tax_third'      => $house_tax_third,
                                        'water_tax_third'      => $water_tax_third,
                                        //'area_commercial'      => $area_commercial,
                                        //'arv_commercial'       => $arv_commercial,
                                        //'house_tax_commercial' => $house_tax_commercial,
                                        //'water_tax_commercial' => $water_tax_commercial,
                                        //'tax_calc'             => $tax_calc,
                                        'arv_total_discount'   => $arv_total_discount,
                                        'arv_total'            => $arv_total,
                                        'house_tax_percentage' => $tax_formula[0]->house_tax_formula,
                                        'house_tax'            => $totel_house_tax,
                                        'water_tax_rate'       => $tax_formula[0]->water_tax_formula,
                                        'water_tax'            => $totel_water_tax,
                                        'sub_total'            => $sub_total,
                                        'overdue_amount'       => $overdue_amount1,
                                        'interest'             => $states_cities->interest_rate,
                                        'interest_amount'      => $interest_amount,
                                        'due_amount'           => $due_amount,
                                        'created_at'           => date('Y-m-d H:i:s'),
                                        'updated_at'           => date('Y-m-d H:i:s'),
                                    );
                                    array_push($data, $arr);
                                    $count++;
                                }
                            }
                        }
                    }
                    if ($count != 0) {
                        DB::table('tax_details')->insert($data);
                    }

                }

            }
            echo $count;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            //session()->put('message',$e);
        }

    }
    public function ViewReportCalculateTax()
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Report'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();

        return View('Report_generate_tax')->with('menu', $menuData)->with('user_access', $user_access);
    }

    public function getTaxReport(Request $request)
    {
        $city       = $request->get('nagarpalika');
        $wardNumber = $request->get('wardnum');
        $session    = $request->get('session');
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Report'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        if (session()->get('user_type') == 'Admin') {
            if ($wardNumber == '' || $wardNumber == null || $wardNumber == "") {
                $result = DB::table('tax_details')->where('city', $city)->get();
            } else {
                $result = DB::table('tax_details')->join('survey_personal_details', 'tax_details.house_id', '=', 'survey_personal_details.survey_id')
                    ->where([['survey_personal_details.ward_number', $wardNumber], ['tax_details.city', $city], ['tax_details.session', $session]])->orderby('tax_details.house_number_1')->get();
            }
        } else {
            if ($wardNumber == '' || $wardNumber == null || $wardNumber == "") {
                $result = DB::table('tax_details')->where('city', session()->get('city'))->get();
            } else {
                $result = DB::table('tax_details')->join('survey_personal_details', 'tax_details.house_id', '=', 'survey_personal_details.survey_id')
                    ->where([['survey_personal_details.ward_number', $wardNumber], ['tax_details.city', session()->get('city')], ['tax_details.session', $session]])->get();
            }
        }

        echo json_encode($result);
    }

    public function TaxPaymentList(Request $request)
    {
        $session = $request->get('session');
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        // $wardno = DB::table('ward_details')->get();
        if (session()->get('user_type') == 'Admin') {
            $city = DB::table('states_cities')->select('city', 'id')->get();
        } else {
            $city = DB::table('states_cities')->select('city', 'id')
                ->where('city', session()->get('city'))->get();
        }
        if (session()->get('user_type') == 'Admin') {
            $tableData = DB::table('tax_details')->select('tax_details.*', 'survey_personal_details.old_house_number', 'survey_personal_details.old_house_owner_name', 'survey_personal_details.name')
                ->join('survey_personal_details', 'survey_personal_details.survey_id', 'tax_details.house_id')
                ->where([['tax_details.paid_status', 'Due']])->paginate(500);
        } else {
            $tableData = DB::table('tax_details')->select('tax_details.*', 'survey_personal_details.old_house_number', 'survey_personal_details.old_house_owner_name', 'survey_personal_details.name')
                ->join('survey_personal_details', 'survey_personal_details.survey_id', 'tax_details.house_id')
                ->where([['tax_details.paid_status', 'Due'], ['tax_details.city', session()->get('city')]])->paginate(500);
        }

        return view('tax_payment_list')->with('menu', $menuData)->with('user_access', $user_access)
        //    ->with('wardno',$wardno)
            ->with('city', $city)
            ->with('tableData', $tableData);
    }

// --tax payment search result----------------
    public function TaxPaymentSearch(Request $request)
    {
        // dd('');
        $session = $request->get('session');
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        $wardnum  = $request->get('wardnum');

        $city        = $request->get('city');
        $housenumber = $request->get('housenumber');
        // dd($housenumber);
        $keyword = $request->get('keyword');
        if (session()->get('user_type') == 'Admin') {
            $tableData = DB::table('tax_details')->select('tax_details.*', 'survey_personal_details.old_house_number', 'survey_personal_details.old_house_owner_name', 'survey_personal_details.name')
                ->join('survey_personal_details', 'survey_personal_details.survey_id', 'tax_details.house_id')
                ->where([
                    ['tax_details.city', $city],
                    ['tax_details.ward_number', $wardnum],
                    // ['house_number_1','LIKE', '%'.$housenumber.'%'],
                ])
                ->where(function ($query) use ($keyword) {
                    $query->where('survey_personal_details.old_house_number', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('survey_personal_details.old_house_owner_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_details.house_number_1', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_details.ward_number', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('survey_personal_details.name', 'LIKE', '%' . $keyword . '%')
                    ;

                })
                ->paginate(5000);
        } else {
            $tableData = DB::table('tax_details')->select('tax_details.*', 'survey_personal_details.old_house_number', 'survey_personal_details.old_house_owner_name', 'survey_personal_details.name')
                ->join('survey_personal_details', 'survey_personal_details.survey_id', 'tax_details.house_id')
                ->where([
                    ['tax_details.ward_number', $wardnum],
                    // ['house_number_1','LIKE', '%'.$housenumber.'%'],
                    ['tax_details.city', $city],
                ])
                ->where(function ($query) use ($keyword) {
                    $query->where('survey_personal_details.old_house_number', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('survey_personal_details.old_house_owner_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_details.house_number_1', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_details.ward_number', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('survey_personal_details.name', 'LIKE', '%' . $keyword . '%')
                    ;

                })
                ->paginate(5000);
        }
        //dd($tableData);

        return view('tax_payment_list')
            ->with('menu', $menuData)->with('user_access', $user_access)
            ->with('tableData', $tableData);
    }
    // ----------------------------------------------------------
    public function TaxPay($id)
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        $ifsc     = DB::table('ifsc')->groupby('bank')->get();
        if (session()->get('user_type') == 'Admin') {
            $tableData = DB::table('tax_details')
                ->where([['id', $id]])->first();
        } else {
            $tableData = DB::table('tax_details')
                ->where([['id', $id], ['city', session()->get('city')]])->first();
        }
        if (session()->get('user_type') == 'Admin') {
            $paymentData = DB::table('tax_details')
                ->where([['id', $id]])->first();
        } else {
            $paymentData = DB::table('tax_details')
                ->where([['id', $id], ['city', session()->get('city')]])->first();
        }

        return view('tax_payment')->with('menu', $menuData)
            ->with('user_access', $user_access)
            ->with('ifsc', $ifsc)
            ->with('tableData', $tableData)
            ->with('paymentData', $paymentData);
    }

    public function SavePaymentDetails(Request $request)
    {
        $PayLog      = new PaymentLog;
        $tax_details = DB::table('tax_details')->where('id', $request->get('tax_id'))->first();
        if (session()->get('id') == null) {
            return redirect('/');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment'],
            ])->get();
        //dd($user_accesses);
        if ($user_access[0]->fn_add == 'N') {
            return redirect('/');
        }
        $old_due      = $tax_details->due_amount;
        $old_advanced = $tax_details->paid;
        $old_total    = $old_due;
        $paymentMode  = $request->get('payment_mode');
        if ($paymentMode == "Cash") {
            $paymentData            = new CashDetails;
            $paymentData->dem_2000  = $request->get('cash_2000');
            $paymentData->dem_500   = $request->get('cash_500');
            $paymentData->dem_200   = $request->get('cash_200');
            $paymentData->dem_100   = $request->get('cash_100');
            $paymentData->dem_50    = $request->get('cash_50');
            $paymentData->dem_20    = $request->get('cash_20');
            $paymentData->dem_10    = $request->get('cash_10');
            $paymentData->dem_5     = $request->get('cash_5');
            $paymentData->dem_2     = $request->get('cash_2');
            $paymentData->dem_1     = $request->get('cash_1');
            $paymentData->dem_other = $request->get('cash_other');
            $paymentData->total     = (($request->get('cash_2000') * 2000) +
                ($request->get('cash_500') * 500) +
                ($request->get('cash_200') * 200) +
                ($request->get('cash_100') * 100) +
                ($request->get('cash_50') * 50) +
                ($request->get('cash_20') * 20) +
                ($request->get('cash_10') * 10) +
                ($request->get('cash_5') * 5) +
                ($request->get('cash_2') * 2) +
                ($request->get('cash_1') * 1) +
                ($request->get('cash_other')));
            $paymentData->words        = $request->get('cashWords');
            $paymentData->remark       = $request->get('cash_remark');
            $paymentData->created_at   = date('Y-m-d H:i:s');
            $paymentData->updated_at   = date('Y-m-d H:i:s');
            $due_amounts               = $paymentData->total;
            $PayLog->remark            = 'Cash payment received';
            $PayLog->payment_reference = 'CSH' . date('dymhis');
        } else if ($paymentMode == "Credit Card") {
            $paymentData                  = new OnlineDetails;
            $paymentData->bank_name       = $request->get('credit_card_bank_name');
            $paymentData->refrence_number = $request->get('credit_card_transction_id');
            $paymentData->total           = $request->get('credit_card_amount');
            $paymentData->words           = $request->get('credit_card_cashWords');
            $paymentData->remark          = $request->get('credit_card_remark');
            $paymentData->created_at      = date('Y-m-d H:i:s');
            $paymentData->updated_at      = date('Y-m-d H:i:s');
            $due_amounts                  = $request->get('credit_card_amount');
            $PayLog->remark               = 'Payment received via credit card';
            $PayLog->payment_reference    = $request->get('credit_card_transction_id');
        } else if ($paymentMode == "Debit Card") {
            $paymentData                  = new OnlineDetails;
            $paymentData->bank_name       = $request->get('debit_card_bank_name');
            $paymentData->refrence_number = $request->get('debit_card_transction_id');
            $paymentData->total           = $request->get('debit_card_amount');
            $paymentData->words           = $request->get('debit_card_cashWords');
            $paymentData->remark          = $request->get('debit_card_remark');
            $paymentData->created_at      = date('Y-m-d H:i:s');
            $paymentData->updated_at      = date('Y-m-d H:i:s');
            $due_amounts                  = $request->get('debit_card_amount');
            $PayLog->remark               = 'Payment received via debit card';
            $PayLog->payment_reference    = $request->get('debit_card_transction_id');
        } else if ($paymentMode == "Cheque") {
            $paymentData                  = new OnlineDetails;
            $paymentData->bank_name       = $request->get('cheque_bank_name');
            $paymentData->refrence_number = $request->get('cheque_transction_id');
            $paymentData->total           = $request->get('cheque_amount');
            $paymentData->words           = $request->get('cheque_cashWords');
            $paymentData->remark          = $request->get('cheque_remark');
            $paymentData->created_at      = date('Y-m-d H:i:s');
            $paymentData->updated_at      = date('Y-m-d H:i:s');
            $due_amounts                  = $request->get('cheque_amount');
            $PayLog->remark               = 'Payment received via cheque #' . $request->get('cheque_transction_id');
            $PayLog->payment_reference    = $request->get('cheque_transction_id');
        } else if ($paymentMode == "NEFT" || $paymentMode == "IMPS" || $paymentMode == "RTGS") {
            $paymentData                  = new OnlineDetails;
            $paymentData->bank_name       = $request->get('neft_bank_name');
            $paymentData->refrence_number = $request->get('neft_transction_id');
            $paymentData->total           = $request->get('neft_amount');
            $paymentData->words           = $request->get('neft_cashWords');
            $paymentData->remark          = $request->get('neft_remark');
            $paymentData->created_at      = date('Y-m-d H:i:s');
            $paymentData->updated_at      = date('Y-m-d H:i:s');
            $due_amounts                  = $request->get('neft_amount');
            $PayLog->remark               = 'Payment received via ' . $request->get('payment_mode');
            $PayLog->payment_reference    = $request->get('neft_transction_id');
        } else if ($paymentMode == "Bank Transfer") {
            $paymentData                  = new OnlineDetails;
            $paymentData->bank_name       = $request->get('bank_trf_bank_name');
            $paymentData->refrence_number = $request->get('bank_trf_transction_id');
            $paymentData->total           = $request->get('bank_trf_amount');
            $paymentData->words           = $request->get('bank_trf_cashWords');
            $paymentData->remark          = $request->get('bank_trf_remark');
            $paymentData->created_at      = date('Y-m-d H:i:s');
            $paymentData->updated_at      = date('Y-m-d H:i:s');
            $due_amounts                  = $request->get('bank_trf_amount');
            $PayLog->remark               = 'Payment received via Bank transfer';
            $PayLog->payment_reference    = $request->get('bank_trf_transction_id');
        }

        $new_advanced = $old_advanced + $paymentData->total;
        $new_due      = $old_total - $paymentData->total;

        $paymentData->save();
        if ($paymentMode == "Cash") {
            $inserted_id = $paymentData->cash_id;
        } else {
            $inserted_id = $paymentData->online_id;
        }

        $tax_id               = $request->get('tax_id');
        $PayLog->payment_id   = $inserted_id;
        $PayLog->tax_id       = $tax_id;
        $PayLog->house_id     = $tax_details->house_id;
        $PayLog->old_due      = $old_total;
        $PayLog->payment      = $due_amounts;
        $PayLog->current_due  = $new_due;
        $PayLog->payment_mode = $paymentMode;
        $PayLog->amount_words = $paymentData->words;
        $PayLog->city         = $tax_details->city;
        $PayLog->ward_number  = $tax_details->ward_number;
        $PayLog->created_by   = session()->get('id');
        $PayLog->created_at   = date('Y-m-d H:i:s');
        $PayLog->updated_at   = date('Y-m-d H:i:s');
        $PayLog->save();
        $tax_log = array(
            'tax_id'     => $tax_id,
            'house_id'   => $tax_details->house_id,
            'remark'     => "Payment received (Pay Mode : " . $paymentMode . ")",
            'type'       => "Credit",
            'amount'     => $due_amounts,
            'mode'       => $paymentMode,
            'created_at' => date('Y-m-d H:i:s'),
            'tax_id'     => $tax_id,
        );
        DB::table('tax_log')->insert($tax_log);
        DB::table('payment_logs')->where('pay_id', $PayLog->pay_id)->update(array('receipt_number' => 'NPM' . date('dmyhis') . str_pad($PayLog->pay_id, 5, "0", STR_PAD_LEFT)));

        if ($new_due > 0) {
            DB::table('tax_details')
                ->where([['id', $tax_details->id]])
                ->update(array('paid' => $new_advanced, 'due_amount' => $new_due));
            session()->put('message', $PayLog->payment_mode . ' Payment  ' . $PayLog->payment . ' received successfully your due amount is ' . $new_due);
        } else {
            DB::table('tax_details')
                ->where([['id', $tax_details->id]])
                ->update(array('paid' => $new_advanced, 'due_amount' => $new_due, 'paid_status', 'Paid'));
            session()->put('message', $PayLog->payment_mode . ' Payment  ' . $PayLog->payment . ' received successfully');
        }

        return redirect('Tax-Payment-Receipt');
    }

    public function TaxPaymentReceipt()
    {
        if (session()->get('id') == null) {
            return redirect('/');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment Receipt'],
            ])->get();
        //dd($user_accesses);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('/');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        if (session()->get('user_type') == 'Admin') {
            $payment_logs = DB::table('payment_logs')
                ->select('payment_logs.*', 'tax_details.*', 'payment_logs.created_at')
                ->join('tax_details', 'tax_details.id', '=', 'payment_logs.tax_id')
                ->orderby('pay_id', 'DESC')
                ->paginate(100);
        } else {
            $payment_logs = DB::table('payment_logs')
                ->select('payment_logs.*', 'tax_details.*', 'payment_logs.created_at')
                ->join('tax_details', 'tax_details.id', '=', 'payment_logs.tax_id')
                ->where('tax_details.city', session()->get('city'))
                ->orderby('pay_id', 'DESC')
                ->paginate(100);
        }

        return view('tax_payment_log')->with('menu', $menuData)
            ->with('user_access', $user_access)
            ->with('tableData', $payment_logs);
    }

    public function PrintInvoice($id)
    {
        if (session()->get('id') == null) {
            return redirect('/');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment Receipt'],
            ])->get();
        //dd($user_accesses);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('/');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();

        $payment_logs            = DB::table('payment_logs')->where([['pay_id', $id]])->first();
        $tax_details             = DB::table('tax_details')->where('id', $payment_logs->tax_id)->first();
        $users                   = DB::table('users')->where('id', $payment_logs->created_by)->first();
        $survey_personal_details = DB::table('survey_personal_details')->where('survey_id', $tax_details->house_id)->first();
        //dd($plot_bookings);
        $pay_details = array();
        if ($payment_logs->payment_mode == "Cash") {
            $data                     = DB::table('cash_details')->where('cash_id', $payment_logs->payment_id)->first();
            $pay_details['bank_name'] = "";
            $pay_details['remark']    = "";
        } else {
            $data                     = DB::table('online_payment_details')->where('online_id', $payment_logs->payment_id)->first();
            $pay_details['bank_name'] = $data->bank_name;
            $pay_details['remark']    = "";
        }
        $states_cities = DB::table('states_cities')->where([['city', $survey_personal_details->city]])->first();
        return view('payment_receipt')->with('menu', $menuData)
            ->with('user_access', $user_access)
            ->with('states_cities', $states_cities)
            ->with('tax_details', $tax_details)
            ->with('survey_personal_details', $survey_personal_details)
            ->with('users', $users)
            ->with('pay_details', $pay_details)
            ->with('payment_logs', $payment_logs);

    }

    public function TaxPaymentNotice()
    {
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment Notice'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        //if(session()->get('user_type')=='Admin')
        return view('tax_payment_notice')->with('menu', $menuData)
            ->with('user_access', $user_access);
    }

    public function TaxPaymentBulkList(Request $request)
    {
        $session = $request->get('session');
        if (session()->get('id') == null) {
            return redirect('login');
        }
        $user_access = $menu = DB::table('user_access_type')
            ->join('user_access', 'user_access_type.id', '=', 'user_access.access_type')
            ->where([
                ['user_access.user_type', session()->get('id')],
                ['user_access_type.menu_name', 'Manage Tax'],
                ['user_access_type.sub_menu', 'Tax Payment Notice'],
            ])->get();
        //dd($user_access);
        if ($user_access[0]->fn_view == 'N') {
            return redirect('login');
        }
        $menuData = app('App\Http\Controllers\DashboardController')->MenuList();
        $this->validate($request, [
            'nagar_palika' => 'required',
            'ward_number'  => 'required',
        ]);
		$city = $request->get('city_name');
        $nagar_palika = $request->get('nagar_palika');
        $ward_number  = $request->get('ward_number');
        if (session()->get('user_type') == 'Admin') {
            $tableData = DB::table('tax_details')
                ->select('survey_personal_details.*', 'tax_details.*', 'house_details.mohallaName')
                ->join('survey_personal_details', 'survey_personal_details.survey_id', '=', 'tax_details.house_id')
                ->join('house_details', 'house_details.personal_details_id', '=', 'tax_details.house_id')
                ->where([
                    ['tax_details.paid_status', 'Due'],
                    ['survey_personal_details.city', $nagar_palika],
					['survey_personal_details.DataVerified', 'Yes'],
                    ['survey_personal_details.ward_number', $ward_number],
                ])
				->orderby('tax_details.house_number_1')
				->get();
        } else {
            $tableData = DB::table('tax_details')
                ->select('survey_personal_details.*', 'tax_details.*', 'house_details.mohallaName')
                ->join('survey_personal_details', 'survey_personal_details.survey_id', '=', 'tax_details.house_id')
                ->join('house_details', 'house_details.personal_details_id', '=', 'tax_details.house_id')
                ->where([
                    ['tax_details.paid_status', 'Due'],
                    ['survey_personal_details.city', $nagar_palika],
                    ['survey_personal_details.ward_number', $ward_number],
                ])
                ->get();
        }

        // dd(DB::getQueryLog());
        // dd($tableData);
        return view('bulk_print')->with('menu', $menuData)->with('city', $city)->with('user_access', $user_access)->with('tableData', $tableData);
    }

    public function DeleteTaxAmount(Request $request)
    {
        $deleted_id = $request->get('id');

        if (session()->get('id') == null) {
            return redirect('login');
        }

        try {
            DB::table('tax_details')->where('id', $deleted_id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e->getMessage());
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                $json['api_status'] = "ERROR";
                $msgs               = "Error- 1451 Data can not delete from system because it is used in another table";
                session()->put('errorMsg', $msgs);
                return redirect('/Tax-Payment-List')->withSuccess($msgs);
            } else {
                session()->put('errorMsg', "Error-" . $errorCode . "" . $e->getLine() . " :- " . $e->getMessage());
                return redirect('/Tax-Payment-List')->withSuccess("Error-" . $errorCode . "" . $e->getLine() . " :- " . $e->getMessage());
            }
            // Note any method of class PDOException can be called on $ex.
        } catch (\Exception $ex) {
            dd($ex);
        }

        session()->put('message', "Data successfuly deleted");
        return back();
    }
}
