<?php

namespace App\Http\Controllers;

use App\Exports\MasterExport;
use DB;
use Excel;
use Illuminate\Http\Request;

class ExportExcelController extends Controller
{
    public function excel(Request $request)
    {
        $city       = $request->get('nagarpalika');
        $wardNumber = $request->get('wardnum');
        $surveyor   = $request->get('surv');
        $fromDate   = $request->get('datefrom');
        $verified   = $request->get('verified');
        if ($fromDate == '' || $fromDate == null || $fromDate == "") {
            $fromDate = '0000-00-00';
        }
        $toDate = $request->get('datetoo');
        if ($toDate == '' || $toDate == null || $toDate == "") {
            $toDate = date('Y-m-d');
        }
        $status = $request->get('sts');
        if (session()->get('user_type') == 'Admin') {
            if ($wardNumber == '' || $wardNumber == null || $wardNumber == "") {
                $result = DB::table('survey_personal_details')
                    ->select('survey_personal_details.*', 'house_details.*', 'survey_step_1.proof_type')
                    ->join('house_details', 'survey_personal_details.survey_id', '=', 'house_details.personal_details_id')
                    ->join('survey_step_1', 'survey_personal_details.survey_id', '=', 'survey_step_1.id')
                    ->where([
                        ['survey_personal_details.city', $city],
                        ['survey_personal_details.user_name', 'like', '%' . $surveyor . '%'],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '>=', $fromDate],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '<=', $toDate],
                        ['survey_personal_details.status', 'like', '%' . $status . '%'],
                        ['survey_personal_details.DataVerified', 'like', '%' . $verified . '%'],
                        ['house_details.DataVarified', 'like', '%' . $verified . '%'],
                    ])->orderby('survey_personal_details.survey_id', 'asc')->get();
            } else {
                //DB::enableQueryLog();
                $ward_details = DB::table('ward_details')->where('id', $wardNumber)->first();
                $result       = DB::table('survey_personal_details')
                    ->select('survey_personal_details.*', 'house_details.*', 'survey_step_1.proof_type')
                    ->join('house_details', 'survey_personal_details.survey_id', '=', 'house_details.personal_details_id')
                    ->join('survey_step_1', 'survey_personal_details.survey_id', '=', 'survey_step_1.id')
                    ->where([
                        ['survey_personal_details.city', $city],
                        ['survey_step_1.ward_number', $ward_details->ward_number],
                        ['survey_step_1.mohalla', $ward_details->mohalla_name],
                        ['survey_personal_details.user_name', 'like', '%' . $surveyor . '%'],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '>=', $fromDate],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '<=', $toDate],
                        ['survey_personal_details.status', 'like', '%' . $status . '%'],
                        ['survey_personal_details.DataVerified', 'like', '%' . $verified . '%'],
                        ['house_details.DataVarified', 'like', '%' . $verified . '%'],
                    ])->orderby('survey_personal_details.survey_id', 'asc')->get();
            }
            //dd(DB::getQueryLog());
        } else {
            if ($wardNumber == '' || $wardNumber == null || $wardNumber == "") {
                $result = DB::table('survey_personal_details')
                    ->select('survey_personal_details.*', 'house_details.*', 'survey_step_1.proof_type')
                    ->join('house_details', 'survey_personal_details.survey_id', '=', 'house_details.personal_details_id')
                    ->join('survey_step_1', 'survey_personal_details.survey_id', '=', 'survey_step_1.id')
                    ->where([
                        ['survey_personal_details.city', $city],
                        ['survey_personal_details.user_name', 'like', '%' . $surveyor . '%'],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '>=', $fromDate],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '<=', $toDate],
                        ['survey_personal_details.status', 'like', '%' . $status . '%'],
                        ['survey_personal_details.DataVerified', 'Yes'],
                        ['house_details.DataVarified', 'Yes'],
                    ])->orderby('survey_personal_details.survey_id', 'asc')->get();
            } else {
                $ward_details = DB::table('ward_details')->where('id', $wardNumber)->first();
                $result       = DB::table('survey_personal_details')
                    ->select('survey_personal_details.*', 'house_details.*', 'survey_step_1.proof_type')
                    ->join('house_details', 'survey_personal_details.survey_id', '=', 'house_details.personal_details_id')
                    ->join('survey_step_1', 'survey_personal_details.survey_id', '=', 'survey_step_1.id')
                    ->where([
                        ['survey_personal_details.city', $city],
                        ['survey_step_1.ward_number', $ward_details->ward_number],
                        ['survey_step_1.mohalla', $ward_details->mohalla_name],
                        ['survey_personal_details.user_name', 'like', '%' . $surveyor . '%'],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '>=', $fromDate],
                        [DB::raw("(DATE_FORMAT(survey_personal_details.created_at,'%Y-%m-%d'))"), '<=', $toDate],
                        ['survey_personal_details.status', 'like', '%' . $status . '%'],
                        ['survey_personal_details.DataVerified', 'Yes'],
                        ['house_details.DataVarified', 'Yes'],
                    ])->orderby('survey_personal_details.survey_id', 'asc')->get();
            }
        }
        //dd($excel_data);
        $head = array(['old_house_number' => 'Old House Number',
            'house_number'                    => 'House Number',
            'name'                            => 'Owner Name',
            'father_name'                     => 'Father Name',
            'mobile_number'                   => 'Mobile Number',
            'rented_person'                   => 'Rented Person',
            'rented_person_name'              => 'Rented Person Name',
            'area_all'                        => 'Area All',
            'area_constructed'                => 'Constructed Area',
            'area_business'                   => 'Business Area',
            'no_of_floor'                     => 'Number Of Floor',
            'no_of_room'                      => 'Number Of Room',
            'basement_area'                   => 'Basement Area',
            'Ground Area'                     => 'Ground Area',
            'first_area'                      => 'Area Of First Floor',
            'second_area'                     => 'Area Of Second Floor',
            'third_area'                      => 'Area Of Third Floor',
            'length_east'                     => 'Lenght From East',
            'length_west'                     => 'Length From West',
            'length_north'                    => 'Length From North',
            'length_south'                    => 'Length From South',
            'locality_east'                   => 'Locality From East',
            'locality_west'                   => 'Locality From West',
            'locality_north'                  => 'Locality From North',
            'locality_south'                  => 'Locality From South',
            'nirmanVarsh'                     => 'Nirman Varsh',
            'sadakKichoudai'                  => 'Width Of Road',
            'NirmanPrakriti'                  => 'Nirman Ki Prakriti',
            'FarshPrakriti'                   => 'Farsh Ki Prakriti',
            'wardNumber'                      => 'Ward Number',
            'wardName'                        => 'Ward Name',
            'mohallaName'                     => 'Mohalla Name',
            'nirmanBhavanKaPrakar'            => 'Nirman Bhavan Ka Prakar',
            'panjikaran'                      => 'Panjikaran',
            'sampattiShreni'                  => 'Sampatti Shreni',
            'sampattiPrakar'                  => 'Sampatti Prakar',
            'souchayala'                      => 'Souchayala',
            'sadakKePrakar'                   => 'Sadak Ke Prakar',
            'gasConnection'                   => 'Gas Connection',
            'bijliMeter'                      => 'Electricity Meter',
            'dharm'                           => 'Dharm',
            'jati'                            => 'Jati',
            'jalapurti'                       => 'Jalapurti',
            'rashanCard'                      => 'Rashan Card',
            'kirayedaar'                      => 'Kirayedaar Hai',
            'malik'                           => 'Malik Hai',
            'status'                          => 'Status']);

       foreach ($result as $value) {

            $PersonalDetailArray = array([
                'old_house_number'     => $value->old_house_number,
                'house_number'         => $value->house_number,
                'name'                 => $value->name,
                'father_name'          => $value->father_name,
                'mobile_number'        => $value->mobile_number,
                'rented_person'        => $value->rented_person,
                'rented_person_name'   => $value->rented_person_name,
                'area_all'             => $value->area_all . "X" . $value->area_all_width,

                'area_constructed'     => $value->area_constructed . "X" . $value->area_constructed_width,
                'area_business'        => $value->area_business . "X" . $value->area_business_width,
                'no_of_floor'          => $value->no_of_floor,
                'no_of_room'           => $value->no_of_room,
                'basement_area'        => $value->basement_area . "X" . $value->basement_area_width,
                'ground_area'          => $value->ground_area . "X" . $value->ground_area_width,
                'first_area'           => $value->first_area . "X" . $value->first_area_width,
                'second_area'          => $value->second_area . "X" . $value->second_area_width,
                'third_area'           => $value->third_area . "X" . $value->third_area_width,
                'length_east'          => $value->length_east,
                'length_west'          => $value->length_west,
                'length_north'         => $value->length_north,
                'length_south'         => $value->length_south,
                'locality_east'        => $value->locality_east,
                'locality_west'        => $value->locality_west,
                'locality_north'       => $value->locality_north,
                'locality_south'       => $value->locality_south,
                'nirmanVarsh'          => $value->nirmanVarsh,
                'sadakKichoudai'       => $value->sadakKichoudai,
                'NirmanPrakriti'       => $value->NirmanPrakriti,
                'FarshPrakriti'        => $value->FarshPrakriti,
                'wardNumber'           => $value->wardNumber,
                'wardName'             => $value->wardName,
                'mohallaName'          => $value->mohallaName,
                'nirmanBhavanKaPrakar' => $value->nirmanBhavanKaPrakar,
                'panjikaran'           => $value->panjikaran,
                'sampattiShreni'       => $value->sampattiShreni,
                'sampattiPrakar'       => $value->sampattiPrakar,
                'souchayala'           => $value->souchayala,
                'sadakKePrakar'        => $value->sadakKePrakar,
                'gasConnection'        => $value->gasConnection,
                'bijliMeter'           => $value->bijliMeter,
                'dharm'                => $value->dharm,
                'jati'                 => $value->jati,
                'jalapurti'            => $value->jalapurti,
                'rashanCard'           => $value->rashanCard,
                'kirayedaar'           => $value->kirayedaar,
                'malik'                => $value->malik,
                'status'               => $value->status,

            ]);
            array_push($head, $PersonalDetailArray);
        }
       $export = new MasterExport($head);
        return Excel::download($export, 'Personal-Detail-Survey-Status.xlsx');

    }
    public function exportTaxReport(Request $request)
    {
        $city       = $request->get('nagarpalika');
        $wardNumber = $request->get('wardnum');
        $session    = $request->get('session');
        if ($wardNumber == '' || $wardNumber == null || $wardNumber == "") {
            $result = DB::table('tax_details')->where('city', $city)->get();
        } else {
            $result = DB::table('tax_details')->select('tax_details.*','survey_personal_details.*','house_details.sampattiPrakar')->join('survey_personal_details', 'tax_details.house_id', '=', 'survey_personal_details.survey_id')
			    ->join('house_details', 'house_details.personal_details_id', '=', 'survey_personal_details.survey_id')
                ->where([['survey_personal_details.ward_number', $wardNumber], ['tax_details.city', $city], ['tax_details.session', $session]])->get();
        }

        //dd($excel_data);
        $head = array([
            'city'                 => "Nagar Palika Name",
            'name'                 => "Owner Name",
            'house_number_1'       => "House Number",
			'sampattiPrakar'       => "Sampatti Prakar",
            'session'              => "Financial Session",
            'ward_number'          => "Ward Number",
            'bhawan_nirman_varsh'  => "Nirman Year",
			'sadak_ki_chaudai'  => "Sadak Ki Chaudai",
            'rate'                 => "Rate",
            'no_of_floor'          => "Floor",
            'discount_percent'     => "Discount",
            'area_basement'        => "Basement Area",
            'arv_basement'         => "Basement Arv",
            'house_tax_basement'   => "Basement House Tax",
            'water_tax_basement'   => "Basement Water Tax",
            'area_ground'          => "Ground Area",
            'arv_ground'           => "Ground Arv",
            'house_tax_ground'     => "Ground House Tax",
            'water_tax_ground'     => "Ground Water Tax",
            'area_first'           => "I Floor Area",
            'arv_first'            => "I Floor Arv",
            'house_tax_first'      => "I Floor House Tax",
            'water_tax_first'      => "I Floor Water Tax",
            'area_second'          => "II Floor Area",
            'arv_second'           => "II Floor Arv",
            'house_tax_second'     => "II Floor House Tax",
            'water_tax_second'     => "II Floor Water Tax",
            'area_third'           => "III Floor Area",
            'arv_third'            => "III Floor Arv",
            'house_tax_third'      => "III Floor House Tax",
            'water_tax_third'      => "III Floor Water Tax",
            'total_arv'            => "Total Arv",
            'house_tax_percentage' => "House Tax %",
            'house_tax'            => "Total House Tax",
            'water_tax_rate'       => "Water Tax %",
            'water_tax'            => "Total Water Tax",
            'sub_total'            => "Total Tax",
            'overdue_amount'       => "Overdue Tax",
            'interest'             => "Int %",
            'interest_amount'      => "Int Amount",
            'paid'                 => "Paid Amount",
            'due_amount'           => "Payable Amount",
           ]);

        foreach ($result as $value) {

            $taxdetail = array([
                'city'                 => $value->city,
                'name'                 => $value->name,
                'house_number_1'       => $value->house_number_1,
				'sampattiPrakar'       => $value->sampattiPrakar,
                'session'              => ($value->session) . "-" . ($value->session + 1),
                'ward_number'          => $value->ward_number,
                'bhawan_nirman_varsh'  => $value->bhawan_nirman_varsh,
				'sadak_ki_chaudai'  => $value->sadakKichoudai,
                'rate'                 => $value->rate,
                'no_of_floor'          => $value->no_of_floor,
                'discount_percent'     => $value->discount_percent,
                'area_basement'        => $value->area_basement,
                'arv_basement'         => $value->arv_basement,
                'house_tax_basement'   => $value->house_tax_basement,
                'water_tax_basement'   => $value->water_tax_basement,
                'area_ground'          => $value->area_ground,
                'arv_ground'           => $value->arv_ground,
                'house_tax_ground'     => $value->house_tax_ground,
                'water_tax_ground'     => $value->water_tax_ground,
                'area_first'           => $value->area_first,
                'arv_first'            => $value->arv_first,
                'house_tax_first'      => $value->house_tax_first,
                'water_tax_first'      => $value->water_tax_first,
                'area_second'          => $value->area_second,
                'arv_second'           => $value->arv_second,
                'house_tax_second'     => $value->house_tax_second,
                'water_tax_second'     => $value->water_tax_second,
                'area_third'           => $value->area_third,
                'arv_third'            => $value->arv_third,
                'house_tax_third'      => $value->house_tax_third,
                'water_tax_third'      => $value->water_tax_third,
                'total_arv'            => $value->arv_basement + $value->arv_ground + $value->arv_first + $value->arv_second + $value->arv_third,
                'house_tax_percentage' => $value->house_tax_percentage,
                'house_tax'            => $value->house_tax,
                'water_tax_rate'       => $value->water_tax_rate,
                'water_tax'            => $value->water_tax,
                'sub_total'            => $value->sub_total,
                'overdue_amount'       => $value->overdue_amount,
                'interest'             => $value->interest,
                'interest_amount'      => $value->interest_amount,
                'paid'                 => $value->paid,
                'due_amount'           => $value->due_amount,
            ]);
            array_push($head, $taxdetail);
        }

        $export = new MasterExport($head);
        return Excel::download($export, 'Tax Report.xlsx');

    }

    // public function exportTaxReportt(Request $request)
    // {
    //     $city       = $request->get('nagarpalika');
    //     $wardNumber = $request->get('wardnum');
    //     $session    = $request->get('session');
    //     if ($wardNumber == '' || $wardNumber == null || $wardNumber == "") {
    //         $result = DB::table('tax_details')->where('city', $city)->get();
    //     } else {
    //         $result = DB::table('tax_details')->join('survey_personal_details', 'tax_details.house_id', '=', 'survey_personal_details.survey_id')
    //             ->where([['survey_personal_details.ward_number', $wardNumber], ['tax_details.city', $city], ['tax_details.session', $session]])->get();
    //     }
    //     $taxdetail   = [];
    //     $taxdetail[] = [
    //         'city'                 => "City",
    //         'name'                 => "Name",
    //         'house_number_1'       => "House Number",
    //         'session'              => "Session",
    //         'ward_number'          => "Ward Number",
    //         'bhawan_nirman_varsh'  => "Nirman Year",
    //         'rate'                 => "Rate",
    //         'no_of_floor'          => "Floor",
    //         'discount_percent'     => "Discount",
    //         'area_basement'        => "Basement Area",
    //         'arv_basement'         => "Basement Arv",
    //         'house_tax_basement'   => "Basement House Tax",
    //         'water_tax_basement'   => "Basement Water Tax",
    //         'area_ground'          => "Ground Area",
    //         'arv_ground'           => "Ground Arv",
    //         'house_tax_ground'     => "Ground House Tax",
    //         'water_tax_ground'     => "Ground Water Tax",
    //         'area_first'           => "I Floor Area",
    //         'arv_first'            => "I Floor Arv",
    //         'house_tax_first'      => "I Floor House Tax",
    //         'water_tax_first'      => "I Floor Water Tax",
    //         'area_second'          => "II Floor Area",
    //         'arv_second'           => "II Floor Arv",
    //         'house_tax_second'     => "II Floor House Tax",
    //         'water_tax_second'     => "II Floor Water Tax",
    //         'area_third'           => "III Floor Area",
    //         'arv_third'            => "III Floor Arv",
    //         'house_tax_third'      => "III Floor House Tax",
    //         'water_tax_third'      => "III Floor Water Tax",
    //         'total_arv'            => "Total Arv",
    //         'house_tax_percentage' => "House Tax %",
    //         'house_tax'            => "Total House Tax",
    //         'water_tax_rate'       => "Water Tax %",
    //         'water_tax'            => "Total Water Tax",
    //         'sub_total'            => "Total Tax",
    //         'overdue_amount'       => "Overdue Tax",
    //         'interest'             => "Int %",
    //         'interest_amount'      => "Int Amount",
    //         'paid'                 => "Paid Amount",
    //         'due_amount'           => "Payable Amount",
    //     ];
    //     foreach ($result as $value) {
    //         $taxdetail[] = array
    //             (
    //             'city'                 => $value->city,
    //             'name'                 => $value->name,
    //             'house_number_1'       => $value->house_number_1,
    //             'session'              => ($value->session) . "-" . ($value->session + 1),
    //             'ward_number'          => $value->ward_number,
    //             'bhawan_nirman_varsh'  => $value->bhawan_nirman_varsh,
    //             'rate'                 => $value->rate,
    //             'no_of_floor'          => $value->no_of_floor,
    //             'discount_percent'     => $value->discount_percent,
    //             'area_basement'        => $value->area_basement,
    //             'arv_basement'         => $value->arv_basement,
    //             'house_tax_basement'   => $value->house_tax_basement,
    //             'water_tax_basement'   => $value->water_tax_basement,
    //             'area_ground'          => $value->area_ground,
    //             'arv_ground'           => $value->arv_ground,
    //             'house_tax_ground'     => $value->house_tax_ground,
    //             'water_tax_ground'     => $value->water_tax_ground,
    //             'area_first'           => $value->area_first,
    //             'arv_first'            => $value->arv_first,
    //             'house_tax_first'      => $value->house_tax_first,
    //             'water_tax_first'      => $value->water_tax_first,
    //             'area_second'          => $value->area_second,
    //             'arv_second'           => $value->arv_second,
    //             'house_tax_second'     => $value->house_tax_second,
    //             'water_tax_second'     => $value->water_tax_second,
    //             'area_third'           => $value->area_third,
    //             'arv_third'            => $value->arv_third,
    //             'house_tax_third'      => $value->house_tax_third,
    //             'water_tax_third'      => $value->water_tax_third,
    //             'total_arv'            => $value->arv_basement + $value->arv_ground + $value->arv_first + $value->arv_second + $value->arv_third,
    //             'house_tax_percentage' => $value->house_tax_percentage,
    //             'house_tax'            => $value->house_tax,
    //             'water_tax_rate'       => $value->water_tax_rate,
    //             'water_tax'            => $value->water_tax,
    //             'sub_total'            => $value->sub_total,
    //             'overdue_amount'       => $value->overdue_amount,
    //             'interest'             => $value->interest,
    //             'interest_amount'      => $value->interest_amount,
    //             'paid'                 => $value->paid,
    //             'due_amount'           => $value->due_amount,
    //         );
    //     }

    //     Excel::create('TaxReport', function ($excel) use ($taxdetail) {

    //         // Set the spreadsheet title, creator, and description
    //         $excel->setTitle('TaxReport');
    //         $excel->setCreator('Laravel')->setCompany('Business Innovations');
    //         $excel->setDescription('Tax Report file');

    //         // Build the spreadsheet, passing in the payments array
    //         $excel->sheet('Tax Report', function ($sheet) use ($taxdetail) {
    //             $sheet->fromArray($taxdetail, null, 'A1', false, false);
    //         });

    //     })->download('xlsx');

    // }
}
