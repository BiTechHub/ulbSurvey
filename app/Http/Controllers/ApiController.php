<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function GetBillDetail(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $ip_whitelist_api=DB::table('ip_whitelist_api')->where('ip',$_SERVER['REMOTE_ADDR'])->count();
            if($ip_whitelist_api>0)
            {
                $house_id    = $request->get('house_id');
                $tax_details = DB::table('survey_step_1')
                    ->select('tax_details.id', 'survey_personal_details.survey_id', 'survey_personal_details.name', 'survey_personal_details.father_name', 'survey_personal_details.mobile_number', 'tax_details.house_number_1', 'house_details.wardName', 'house_details.mohallaName', 'tax_details.session', 'tax_details.arv_total', 'tax_details.interest_amount', 'tax_details.overdue_amount', 'tax_details.house_tax', 'tax_details.water_tax', 'tax_details.due_amount', 'tax_details.paid', 'tax_details.id as tax_id', 'survey_personal_details.city', 'house_details.wardNumber', 'tax_details.created_at')
                    ->join('survey_personal_details', 'survey_step_1.id', '=', 'survey_personal_details.survey_id')
                    ->join('house_details', 'house_details.personal_details_id', '=', 'survey_personal_details.survey_id')
                    ->join('tax_details', 'survey_step_1.id', '=', 'tax_details.house_id')
                    ->where([
                        ['tax_details.paid_status', '!=', 'Bounce'],
                        ['tax_details.city', 'Sitapur'],
                        ['tax_details.house_id', '=', $house_id],
                    ])
                    ->orderby('survey_step_1.house_number', 'ASC')
                    ->first();
                if ($tax_details == null) {
                    $data = array(
                        'status'    => 'FAILURE',
                        'errorCode' => '002',
                        'message'   => 'Customer Not Found / Invalid identifier',
                    );
                } else if ($tax_details->due_amount <= 0) {
                    $data = array(
                        'status'    => 'FAILURE',
                        'errorCode' => '003',
                        'message'   => 'No Amount Due / Payment already made',
                    );
                } else {
                    $additionalInfo = array(
                        "interest"     => $tax_details->interest_amount, // Optional
                        "house_number" => $tax_details->house_number_1, // Optional
                    );
                    $data = array(
                        'status'         => 'SUCCESS',
                        'errorCode'      => '000',
                        'customerName'   => $tax_details->name,
                        'amountDue'      => $tax_details->due_amount,
                        'billDate'       => date('Y-m-d', strtotime($tax_details->created_at)),
                        'dueDate'        => date('Y-m-d', strtotime("+15 day", strtotime($tax_details->created_at))),
                        'billNumber'     => $tax_details->id,
                        'billPeriod'     => 'YEARLY',
                        'additionalInfo' => $additionalInfo,
                    );
                }
                DB::commit();
            }
            else
            {
                $data = array(
                    'status'    => 'FAILURE',
                    'errorCode' => '005',
                    'message'   => 'Unauthorised IP detected',
                );
            }
            header('Content-type: application/json');
            return response()->json($data, 401);
        } catch (\Exception $e) {
            DB::rollback();
            $data = array(
                "status"    => "FAILURE", // Optional
                "errorCode" => "002", // Optional
                "message"   => $e->getLine() . " :- " . $e->getMessage(),
            );
            header('Content-type: application/json');
            return response()->json($data, 401);
        }
    }

    public function BillPayResponse(Request $request)
    {
        $ip_whitelist_api=DB::table('ip_whitelist_api')->where('ip',$_SERVER['REMOTE_ADDR'])->count();
        if($ip_whitelist_api>0)
        {
            DB::beginTransaction();
            try {
                $house_id            = $request->get('house_id');
                $amountPaid          = $request->get('amountPaid');
                $transactionId       = $request->get('transactionId');
                $paymentMode         = $request->get('paymentMode');
                $paymentDate         = $request->get('paymentDate');
                $billNumber          = $request->get('billNumber');
                if ($house_id == null) {
                    $data = array(
                        "status"            => "FAILURE", // Optional
                        "acknowledgementId" => "", // Optional
                        "message"           => "house id missing...",
                    );
                    header('Content-type: application/json');
                    return response()->json($data, 401);
                }
                else if ($amountPaid == null) {
                    $data = array(
                        "status"            => "FAILURE", // Optional
                        "acknowledgementId" => "", // Optional
                        "message"           => "amount missing...",
                    );
                    header('Content-type: application/json');
                    return response()->json($data, 401);
                }
                else if ($transactionId == null) {
                    $data = array(
                        "status"            => "FAILURE", // Optional
                        "acknowledgementId" => "", // Optional
                        "message"           => "transction id missing...",
                    );
                    header('Content-type: application/json');
                    return response()->json($data, 401);
                }
                else if ($paymentMode == null) {
                    $data = array(
                        "status"            => "FAILURE", // Optional
                        "acknowledgementId" => "", // Optional
                        "message"           => "payment mode missing...",
                    );
                    header('Content-type: application/json');
                    return response()->json($data, 401);
                }
                $online_payment_data = DB::table('online_payment')->where([['mihpayid', $transactionId], ['bank_ref_num', $billNumber]])->first();
                if ($online_payment_data != null) {
                    $data = array(
                        "status"            => "DUPLICATE", // Optional
                        "acknowledgementId" => "", // Optional
                        "message"           => "Bill number & transction id already exists...",
                    );
                    header('Content-type: application/json');
                    return response()->json($data, 401);
                }
                $tax_details = DB::table('survey_step_1')
                    ->select('tax_details.id', 'survey_personal_details.survey_id', 'survey_personal_details.name', 'survey_personal_details.father_name', 'survey_personal_details.mobile_number', 'tax_details.house_number_1', 'house_details.wardName', 'house_details.mohallaName', 'tax_details.session', 'tax_details.arv_total', 'tax_details.interest_amount', 'tax_details.overdue_amount', 'tax_details.house_tax', 'tax_details.water_tax', 'tax_details.due_amount', 'tax_details.paid', 'tax_details.id as tax_id', 'survey_personal_details.city', 'house_details.wardNumber', 'tax_details.created_at')
                    ->join('survey_personal_details', 'survey_step_1.id', '=', 'survey_personal_details.survey_id')
                    ->join('house_details', 'house_details.personal_details_id', '=', 'survey_personal_details.survey_id')
                    ->join('tax_details', 'survey_step_1.id', '=', 'tax_details.house_id')
                    ->where([
                        ['tax_details.paid_status', '!=', 'Bounce'],
                        ['tax_details.city', 'Sitapur'],
                        ['tax_details.house_id', '=', $house_id],
                    ])
                    ->orderby('survey_step_1.house_number', 'ASC')
                    ->first();
                $payMode = $paymentMode;
                $ret     = "SUCCESS";
                $ret1    = "SUCCESS";
                $data    = array(
                    'tax_id'           => $tax_details->tax_id,
                    'city'             => $tax_details->city,
                    'ward_number'      => $tax_details->wardNumber,
                    'house_id'         => $tax_details->survey_id,
                    'txn_id'           => date('ymdhis') . str_pad($tax_details->tax_id, 4, "0", STR_PAD_LEFT),
                    'amount'           => $amountPaid,
                    'product'          => "House & water tax",
                    'first_name'       => $tax_details->name,
                    'father_name'      => $tax_details->father_name,
                    'email'            => "",
                    'phone'            => $tax_details->mobile_number,

                    'pg'               => "BBPS",
                    'mihpayid'         => $transactionId,
                    'bank_ref_num'     => $billNumber,
                    'amt'              => $amountPaid,
                    'bankcode'         => "BBPS UPI",
                    'error_code'       => "000",
                    'error_Message'    => "",
                    'net_amount_debit' => $amountPaid,
                    'disc'             => "0.00",
                    'mode'             => $payMode,
                    'PG_TYPE'          => $payMode,
                    //'card_no'=>$request->get('cardnum'),
                    //'name_on_card'=>$request->get('name_on_card'),
                    'status'           => $ret,
                    'unmappedstatus'   => $ret1,
                );
                $inserted_id         = DB::table('online_payment')->insertGetId($data);
                $online_payment_data = DB::table('online_payment')->where('id', $inserted_id)->first();
                $tax_details         = DB::table('tax_details')->where('id', $online_payment_data->tax_id)->first();
                $old_due             = $tax_details->due_amount;
                $old_advanced        = $tax_details->paid;
                $current_paid        = $old_advanced + $amountPaid;
                $current_due         = $old_due - $amountPaid;
                //dd($current_due);
                $word = app('App\library\NumberToString')->displaywords($amountPaid);
                DB::table('tax_details')->where('id', $online_payment_data->tax_id)->update(array('due_amount' => $current_due, 'paid' => $current_paid));
                $paymentData = array(
                    'tax_id'          => $online_payment_data->tax_id,
                    'house_id'        => $online_payment_data->house_id,
                    'bank_name'       => $payMode,
                    'refrence_number' => $transactionId,
                    'total'           => $amountPaid,
                    'words'           => $word,
                    'remark'          => $request->get('status'),
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s'),
                );
                $pay_on_id   = DB::table('online_payment_details')->insertGetId($paymentData);
                $paymentLogs = array(
                    'payment_id'        => $pay_on_id,
                    'online_pay_id'     => $inserted_id,
                    'payment_reference' => $online_payment_data->txn_id,
                    'tax_id'            => $online_payment_data->tax_id,
                    'house_id'          => $online_payment_data->house_id,
                    'old_due'           => $old_due,
                    'payment'           => $amountPaid,
                    'current_due'       => $current_due,
                    'amount_words'      => $word,
                    'payment_mode'      => "Payment Gateway",
                    'remark'            => "Payment received (Pay Mode : " . $payMode . ")",
                    'city'              => $online_payment_data->city,
                    'ward_number'       => $online_payment_data->ward_number,
                    'created_by'        => "0",
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s'),
                );
                $PayLogId = DB::table('payment_logs')->insertGetId($paymentLogs);
                $tax_log  = array(
                    'tax_id'     => $online_payment_data->tax_id,
                    'house_id'   => $online_payment_data->house_id,
                    'remark'     => "Payment received (Pay Mode : " . $payMode . ")",
                    'type'       => "Credit",
                    'amount'     => $amountPaid,
                    'mode'       => $payMode,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                DB::table('tax_log')->insert($tax_log);
                DB::table('payment_logs')->where('pay_id', $PayLogId)->update(array('receipt_number' => 'NPO' . date('dmyhis') . str_pad($PayLogId, 5, "0", STR_PAD_LEFT)));
                DB::table('online_payment')->where('id', $inserted_id)->update(array('receipt_number' => 'NPM' . date('dmyhis') . str_pad($PayLogId, 5, "0", STR_PAD_LEFT)));
                DB::commit();
                $data = array(
                    "status"            => "SUCCESS", // Optional
                    "acknowledgementId" => $inserted_id,
                );
                header('Content-type: application/json');
                return response()->json($data, 401);
            }
            catch (\Exception $e) {
                DB::rollback();
                $data = array(
                    "status"            => "FAILURE", // Optional
                    "acknowledgementId" => "002", // Optional
                    "message"           => $e->getLine() . " :- " . $e->getMessage(),
                );
                header('Content-type: application/json');
                return response()->json($data, 401);
            }
        }
        else
        {
            $data = array(
                "status"            => "FAILURE", // Optional
                "acknowledgementId" => "005", // Optional
                "message"           => "Unauthorised IP detected",
            );
        }

        header('Content-type: application/json');
        return response()->json($data, 401);
    }

}

/*
DB::beginTransaction();
try
{

DB::commit();
}
catch (\Exception $e) {
DB::rollback();
dd($e);
//session()->put('message',$e);
}*/
