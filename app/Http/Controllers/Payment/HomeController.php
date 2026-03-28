<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use DB;
use App\library\AesForJava;


class HomeController extends Controller
{
    public function home()
    {
        return view('payment.home');
    }

    public function payTax()
    {
        $mohalla=DB::table('ward_details')->where('nagarpalika','Sitapur')->get();
        return view('payment.pay_tax')->with('mohalla',$mohalla);
    }
    public function payTaxList(Request $request)
    {
        $tabledata=DB::table('survey_step_1')
            ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.due_amount')
            ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
            ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
            ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
            ->where([
                ['tax_details.paid_status', '!=', 'Bounce'],
                ['tax_details.city', 'Sitapur'],
                ['tax_details.sub_total', '>', '0'],
            ])
            ->where(function($query) use($request)  {
                $query->where('house_details.mohallaName','=',$request->get('mohalla'))
                  ->orWhere('survey_personal_details.mobile_number','=',$request->get('mobile_number'))
                  ->orWhere('survey_step_1.id','=',$request->get('property_id'))
                  ->orWhere('survey_personal_details.name','=',$request->get('name'))
                  ->orWhere('survey_step_1.house_number','=',$request->get('house_number'))
                  //->orWhere('vehicle.vehicle_name','=',$request->get('receipt_number'))
                  ;
            })
            ->orderby('survey_step_1.house_number','ASC')
            ->get();
        return view('payment.tax_list')->with('tabledata',$tabledata);
    }

    public function ledger()
    {
        return view('payment.search_ledger');
    }
    public function viewLedger(Request $request)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|numeric'
        ]);

        $tabledata=DB::table('survey_step_1')
            ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.session','tax_details.arv_total','tax_details.interest_amount','tax_details.overdue_amount','tax_details.house_tax','tax_details.water_tax','tax_details.due_amount','tax_details.paid')
            ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
            ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
            ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
            ->where([
                ['tax_details.paid_status', '!=', 'Bounce'],
                ['tax_details.city', 'Sitapur'],
                ['tax_details.house_id', '=', $request->get('property_id')],
            ])
            ->orderby('survey_step_1.house_number','ASC')
            ->first();
        $tax_log=DB::table('tax_log')
            ->where([
                ['house_id', '=', $request->get('property_id')],
            ])
            ->get();
        if(sizeof($tax_log)==0)
        {
            session()->put('message',"No Data Found");
            return view('payment.search_receipt');
        }
        return view('payment.view_ledger')->with('tax_log',$tax_log)->with('tabledata',$tabledata);
    }
    public function viewReceipt()
    {
        return view('payment.search_receipt');
    }
    public function receiptList(Request $request)
    {
        $validatedData = $request->validate([
            'property_id' => 'required_if:receipt_number,""|numeric',
            'receipt_number' => 'required_if:property_id,""'
        ]);
        if($request->get('receipt_number')=="")
        {
            $payment_logs=DB::table('payment_logs')
                ->where([
                    ['house_id', '=', $request->get('property_id')],
                ])
                ->get();
        }
        if($request->get('property_id')=="")
        {
            $payment_logs=DB::table('payment_logs')
                ->where([
                    ['receipt_number', '=', $request->get('receipt_number')],
                ])
                ->get();
        }
        if(sizeof($payment_logs)>0)
        {
            $tabledata=DB::table('survey_step_1')
                ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.session','tax_details.arv_total','tax_details.interest_amount','tax_details.overdue_amount','tax_details.house_tax','tax_details.water_tax','tax_details.due_amount','tax_details.paid')
                ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
                ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
                ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
                ->where([
                    ['tax_details.paid_status', '!=', 'Bounce'],
                    ['tax_details.city', 'Sitapur'],
                    ['tax_details.house_id', '=', $payment_logs[0]->house_id],
                ])
                ->orderby('survey_step_1.house_number','ASC')
                ->first();
        }
        else
        {
            session()->put('message',"No Data Found");
            return view('payment.search_receipt');
        }

        return view('payment.view_receipt_list')->with('tabledata',$tabledata)->with('payment_logs',$payment_logs);
    }
    public function printReceipt($receipt_id)
    {
        $online_payment_data=DB::table('payment_logs')->where('receipt_number',$receipt_id)->first();
        $payment_logs=DB::table('payment_logs')
                ->where([
                    ['receipt_number', '=', $receipt_id],
                ])
                ->first();
                $tabledata=DB::table('survey_step_1')
                ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.session','tax_details.arv_total','tax_details.interest_amount','tax_details.overdue_amount','tax_details.house_tax','tax_details.water_tax','tax_details.due_amount','tax_details.paid')
                ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
                ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
                ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
                ->where([
                    ['tax_details.id', '=', $online_payment_data->tax_id],
                    ['tax_details.city', 'Sitapur'],
                ])
                ->orderby('survey_step_1.house_number','ASC')
                ->first();
        return view('payment.print_receipt')->with('tabledata',$tabledata)->with('payment_logs',$payment_logs)
        ;
    }


    public function payNow($house_id)
    {
        $tabledata=DB::table('survey_step_1')
            ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.session','tax_details.arv_total','tax_details.interest_amount','tax_details.overdue_amount','tax_details.house_tax','tax_details.water_tax','tax_details.due_amount','tax_details.paid','survey_personal_details.city')
            ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
            ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
            ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
            ->where([
                ['tax_details.paid_status', '!=', 'Bounce'],
                ['tax_details.house_id', '=', $house_id],
                ['tax_details.city', 'Sitapur'],
            ])
            ->orderby('survey_step_1.house_number','ASC')
            ->first();

        return view('payment.pay_now')->with('tabledata',$tabledata);
    }

    public function pay(Request $request)
    {
        $validatedData = $request->validate([
            //'email' => 'required|email',
            'mobile' => 'required|numeric|digits:10',
            'pay_amount' => 'required|numeric|gt:0'
        ]);

        $cid=env('cid');
        $ver=env('ver');
        $tabledata=DB::table('survey_step_1')
            ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.session','tax_details.arv_total','tax_details.interest_amount','tax_details.overdue_amount','tax_details.house_tax','tax_details.water_tax','tax_details.due_amount','tax_details.paid','tax_details.id as tax_id','survey_personal_details.city','house_details.wardNumber')
            ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
            ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
            ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
            ->where([
                ['tax_details.paid_status', '!=', 'Bounce'],
                ['tax_details.city', 'Sitapur'],
                ['tax_details.house_id', '=', $request->get('house_id')],
            ])
            ->orderby('survey_step_1.house_number','ASC')
            ->first();
        $action = env('ACTION_URL');
        $call_back = env('CALL_BACK');
        $encryption_key = env('encryption_key');
        $type = env('type');
        //online_payment
        $data=array(
            'tax_id'=>$tabledata->tax_id,
            'city'=>$tabledata->city,
            'ward_number'=>$tabledata->wardNumber,
            'house_id'=>$tabledata->survey_id,
            'txn_id'=>date('ymdhis').str_pad($tabledata->tax_id,4,"0",STR_PAD_LEFT),
            'amount'=>$request->get('pay_amount'),
            'product'=>"House & water tax",
            'first_name'=>$tabledata->name,
            'father_name'=>$tabledata->father_name,
            'email'=>$request->get('email'),
            'phone'=>$request->get('mobile'),
        );
        $word=app('App\library\NumberToString')->displaywords($request->get('pay_amount'));
        $pay_id=DB::table('online_payment')->insertGetId($data);
        $dataa=DB::table('online_payment')->where('id',$pay_id)->first();
        session()->put('payment_initiated','true');
        return view('payment.pay_redirect')->with('cid',$cid)
        ->with('ver',$ver)
        ->with('action',$action)
        ->with('tabledata',$tabledata)
        ->with('call_back',$call_back)
        ->with('type',$type)
        ->with('encryption_key',$encryption_key)
        ->with('pay_id',$pay_id)
        ->with('dataa',$dataa);
    }

    public function payResponse(Request $request)
    {
        DB::beginTransaction();
        try{
            $encryption_key = env('encryption_key');
            preg_match_all('/(\w+)=([^&]+)/', $_SERVER["QUERY_STRING"], $pairs);
            $_GET = array_combine($pairs[1], $pairs[2]);

            $aes = new AesForJava();
            $qStr = $aes->decrypt(urldecode($_GET['i']), $encryption_key, 128);
            parse_str($qStr, $get_array);
            //dd($get_array);
            //dd($request);
            $payMode=app('App\library\NumberToString')->payMode($get_array['PMD']);
            $ret=app('App\library\NumberToString')->paymentStatus($get_array['STC']);
            $ret1=app('App\library\NumberToString')->failedReason($get_array['STC']);
            $data=array(
                'pg'=>$payMode,
                'mihpayid'=>$get_array['TRN'],
                'bank_ref_num'=>$get_array['BRN'],
                'amt'=>$get_array['AMT'],
                'bankcode'=>$get_array['BRN'],
                'error_code'=>$get_array['STC'],
                //'addedon'=>$request->get('addedon'),
                //'payment_source'=>$request->get('payment_source'),
                //'card_type'=>$request->get('cardCategory'),
                'error_Message'=>$get_array['STC'],
                'net_amount_debit'=>$get_array['AMT'],
                'disc'=>"0.00",
                'mode'=>$payMode,
                'PG_TYPE'=>$payMode,
                //'card_no'=>$request->get('cardnum'),
                //'name_on_card'=>$request->get('name_on_card'),
                'status'=>$ret,
                'unmappedstatus'=>$ret1,
            );
            DB::table('online_payment')->where('id',$get_array['CRN'])->update($data);
            if($get_array['STC']=="000")
            {
                $online_payment_data=DB::table('online_payment')->where('id',$get_array['CRN'])->first();
                $tax_details=DB::table('tax_details')->where('id',$online_payment_data->tax_id)->first();
                $old_due=$tax_details->due_amount;
                $old_advanced=$tax_details->paid;
                $current_paid=$old_advanced+$get_array['AMT'];
                $current_due=$old_due-$get_array['AMT'];
                //dd($current_due);
                $word=app('App\library\NumberToString')->displaywords($get_array['AMT']);
                DB::table('tax_details')->where('id',$online_payment_data->tax_id)->update(array('due_amount'=>$current_due,'paid'=>$current_paid));
                $paymentData=array(
                    'tax_id'=>$online_payment_data->tax_id,
                    'house_id'=>$online_payment_data->house_id,
                    'bank_name'=>$payMode,
                    'refrence_number'=>$get_array['BRN'],
                    'total'=>$get_array['AMT'],
                    'words'=>$word,
                    'remark'=>$request->get('status'),
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                );
                $pay_on_id=DB::table('online_payment_details')->insertGetId($paymentData);
                $paymentLogs=array(
                    'payment_id'=>$pay_on_id,
                    'online_pay_id'=>$get_array['CRN'],
                    'payment_reference'=>$online_payment_data->txn_id,
                    'tax_id'=>$online_payment_data->tax_id,
                    'house_id'=>$online_payment_data->house_id,
                    'old_due'=>$old_due,
                    'payment'=>$get_array['AMT'],
                    'current_due'=>$current_due,
                    'amount_words'=>$word,
                    'payment_mode'=>"Payment Gateway",
                    'remark'=>"Payment received (Pay Mode : ".$payMode.")",
                    'city'=>$online_payment_data->city,
                    'ward_number'=>$online_payment_data->ward_number,
                    'created_by'=>"0",
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                );
                $PayLogId=DB::table('payment_logs')->insertGetId($paymentLogs);
                $tax_log=array(
                    'tax_id'=>$online_payment_data->tax_id,
                    'house_id'=>$online_payment_data->house_id,
                    'remark'=>"Payment received (Pay Mode : ".$payMode.")",
                    'type'=>"Credit",
                    'amount'=>$get_array['AMT'],
                    'mode'=>$payMode,
                    'created_at'=>date('Y-m-d H:i:s'),
                );
                DB::table('tax_log')->insert($tax_log);
                DB::table('payment_logs')->where('pay_id',$PayLogId)->update(array('receipt_number'=>'NPO'.date('dmyhis').str_pad($PayLogId,5,"0",STR_PAD_LEFT)));
                DB::table('online_payment')->where('id',$get_array['CRN'])->update(array('receipt_number'=>'NPM'.date('dmyhis').str_pad($PayLogId,5,"0",STR_PAD_LEFT)));
                DB::commit();

                $msg = "Transaction Successful, Hash Verified...<br />";
                //Do success order processing here...
                //Additional step - Use verify payment api to double check payment.
                session()->forget('payment_initiated');
                session()->put('pay_id',$get_array['CRN']);
                session()->put('message',$msg);
                $online_payment_data=DB::table('online_payment')->where('id',$get_array['CRN'])->first();
                return redirect('/payment/Payment-Success/'.$online_payment_data->txn_id);
            }else
            {
                $online_payment_data=DB::table('online_payment')->where('id',$get_array['CRN'])->first();
                $msg = "Payment failed for Hash not verified...";
                session()->forget('payment_initiated');
                session()->put('pay_id',$get_array['CRN']);
                session()->put('message',$msg);
                DB::commit();
                return redirect('/payment/Payment-Failed/'.$online_payment_data->txn_id);
            }
        }
        catch(\Exception $ex)
        {
			dd($ex);
            DB::rollback();
        }
    }


    public function payCancel(Request $request)
    {
        DB::beginTransaction();
        try{
            $key=env('KEY');
            $salt=env('SALT');

            $key				=   $request->get('key');
            $txnid 				= 	$request->get('txnid');
            $amount      		= 	$request->get('amount');
            $productInfo  		= 	$request->get('productinfo');
            $firstname    		= 	$request->get('firstname');
            $email        		=	$request->get('email');
            $udf5				=   $request->get('udf5');
            $status				= 	$request->get('status');
            $resphash			= 	$request->get('hash');
            //Calculate response hash to verify
            $keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
            $keyArray 	  		= 	explode("|",$keyString);
            $reverseKeyArray 	= 	array_reverse($keyArray);
            $reverseKeyString	=	implode("|",$reverseKeyArray);
            $CalcHashString 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString)); //hash without additionalcharges
            //dd($request);
            $dataCancel=array(
                'pg'=>$request->get('mode'),
                'mihpayid'=>$request->get('mihpayid'),
                'bank_ref_num'=>$request->get('bank_ref_num'),
                'amt'=>$request->get('amount'),
                'bankcode'=>$request->get('bankcode'),
                'error_code'=>$request->get('error'),
                'addedon'=>$request->get('addedon'),
                'payment_source'=>$request->get('payment_source'),
                'card_type'=>$request->get('cardCategory'),
                'error_Message'=>$request->get('error_Message'),
                'net_amount_debit'=>$request->get('net_amount_debit'),
                'disc'=>$request->get('discount'),
                'mode'=>$request->get('mode'),
                'PG_TYPE'=>$request->get('PG_TYPE'),
                'card_no'=>$request->get('cardnum'),
                'name_on_card'=>$request->get('name_on_card'),
                'status'=>$request->get('status'),
                'unmappedstatus'=>$request->get('unmappedstatus'),
            );

            DB::table('online_payment')->where('id',$request->get('udf5'))->update($dataCancel);
			DB::commit();
			$online_payment_data=DB::table('online_payment')->where('id',$request->get('udf5'))->first();
			$msg = $request->get('error_Message');
            session()->forget('payment_initiated');
            session()->put('pay_id',$request->get('udf5'));
            session()->put('message',$msg);
            return redirect('/payment/Payment-Failed/'.$online_payment_data->txn_id);
        }
        catch(\Exception $ex)
        {
			dd($ex);
            DB::rollback();
        }
    }

    function verifyPayment($key,$salt,$txnid,$status)
    {
        $command = "verify_payment"; //mandatory parameter

        $hash_str = $key  . '|' . $command . '|' . $txnid . '|' . $salt ;
        $hash = strtolower(hash('sha512', $hash_str)); //generate hash for verify payment request

        $r = array('key' => $key , 'hash' =>$hash , 'var1' => $txnid, 'command' => $command);

        $qs= http_build_query($r);
        //for production
        //$wsUrl = "https://info.payu.in/merchant/postservice.php?form=2";

        //for test
        $wsUrl =env('VERIFY_PAYMENT');
        try
        {
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $wsUrl);
            curl_setopt($c, CURLOPT_POST, 1);
            curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
            curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_SSLVERSION, 6); //TLS 1.2 mandatory
            curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
            $o = curl_exec($c);
            if (curl_errno($c)) {
                $sad = curl_error($c);
                throw new \Exception($sad);
            }
            curl_close($c);

            /*
            Here is json response example -

            {"status":1,
            "msg":"1 out of 1 Transactions Fetched Successfully",
            "transaction_details":</strong>
            {
                "Txn72738624":
                {
                    "mihpayid":"403993715519726325",
                    "request_id":"",
                    "bank_ref_num":"670272",
                    "amt":"6.17",
                    "transaction_amount":"6.00",
                    "txnid":"Txn72738624",
                    "additional_charges":"0.17",
                    "productinfo":"P01 P02",
                    "firstname":"Viatechs",
                    "bankcode":"CC",
                    "udf1":null,
                    "udf3":null,
                    "udf4":null,
                    "udf5":"PayUBiz_PHP7_Kit",
                    "field2":"179782",
                    "field9":" Verification of Secure Hash Failed: E700 -- Approved -- Transaction Successful -- Unable to be determined--E000",
                    "error_code":"E000",
                    "addedon":"2019-08-09 14:07:25",
                    "payment_source":"payu",
                    "card_type":"MAST",
                    "error_Message":"NO ERROR",
                    "net_amount_debit":6.17,
                    "disc":"0.00",
                    "mode":"CC",
                    "PG_TYPE":"AXISPG",
                    "card_no":"512345XXXXXX2346",
                    "name_on_card":"Test Owenr",
                    "udf2":null,
                    "status":"success",
                    "unmappedstatus":"captured",
                    "Merchant_UTR":null,
                    "Settled_At":"0000-00-00 00:00:00"
                }
            }
            }

            Decode the Json response and retrieve "transaction_details"
            Then retrieve {txnid} part. This is dynamic as per txnid sent in var1.
            Then check for mihpayid and status.

            */
            $response = json_decode($o,true);

            if(isset($response['status']))
            {
                // response is in Json format. Use the transaction_detailspart for status
                $response = $response['transaction_details'];
                $response = $response[$txnid];

                if($response['status'] == $status) //payment response status and verify status matched
                    return true;
                else
                    return false;
            }
            else {
                return false;
            }
        }
        catch (\Exception $e){
            return false;
        }
    }

    function paymentSuccess($txn_id)
    {
        $online_payment_data=DB::table('online_payment')->where('txn_id',$txn_id)->first();
        $payment_logs=DB::table('payment_logs')->where('payment_reference',$txn_id)->first();
        $tabledata=DB::table('survey_step_1')
            ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.session','tax_details.arv_total','tax_details.interest_amount','tax_details.overdue_amount','tax_details.house_tax','tax_details.water_tax','tax_details.due_amount','tax_details.paid','tax_details.id as tax_id','survey_personal_details.city','house_details.wardNumber')
            ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
            ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
            ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
            ->where([
                ['tax_details.paid_status', '!=', 'Bounce'],
                ['tax_details.city', 'Sitapur'],
                ['tax_details.house_id', '=', $online_payment_data->house_id],
            ])
            ->orderby('survey_step_1.house_number','ASC')
            ->first();

        return view('payment.pay_success')->with('tabledata',$tabledata)->with('online_payment_data',$online_payment_data)->with('payment_logs',$payment_logs);
    }

    function paymentFailed($txn_id)
    {
        $online_payment_data=DB::table('online_payment')->where('txn_id',$txn_id)->first();
        $tabledata=DB::table('survey_step_1')
            ->select('survey_personal_details.survey_id','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number','tax_details.house_number_1','house_details.wardName','house_details.mohallaName','tax_details.session','tax_details.arv_total','tax_details.interest_amount','tax_details.overdue_amount','tax_details.house_tax','tax_details.water_tax','tax_details.due_amount','tax_details.paid','tax_details.id as tax_id','survey_personal_details.city','house_details.wardNumber')
            ->join('survey_personal_details' , 'survey_step_1.id','=','survey_personal_details.survey_id')
            ->join('house_details' , 'house_details.personal_details_id','=','survey_personal_details.survey_id')
            ->join('tax_details','survey_step_1.id','=','tax_details.house_id')
            ->where([
                ['tax_details.paid_status', '!=', 'Bounce'],
                ['tax_details.city', 'Sitapur'],
                ['tax_details.house_id', '=', $online_payment_data->house_id],
            ])
            ->orderby('survey_step_1.house_number','ASC')
            ->first();

        return view('payment.payment_failed')->with('tabledata',$tabledata)->with('online_payment_data',$online_payment_data);
    }

    public function termsCondition()
    {
        return view('payment.terms_condition');
    }

    public function privacyPolicy()
    {
        return view('payment.privacy_policy');
    }

    public function returnPolicy()
    {
        return view('payment.return_policy');
    }


}
