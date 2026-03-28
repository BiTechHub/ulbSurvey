<?php
namespace App\library;

use DB;



class SMSConfig
{
	public function send_sms($mobile,$message,$send_to,$purpose,$unicode=false)
	{
		$master=DB::table('master')->first();
		$sms_route=DB::table('sms_route')->where('id',$master->default_sms)->first();
		//dd($sms_route);
		$message1=$message;
		$message=urlencode($message);
		$url=$sms_route->url;
		$unicode_url=$sms_route->unicode_url;
		if($unicode==true)
		{
			$unicode_url=str_replace("#mobile#", $mobile, $unicode_url);
			$unicode_url=str_replace("#message#", $message, $unicode_url);
			$exec_url=$unicode_url;
		}
		else
		{
			$url=str_replace("#mobile#", $mobile, $url);
			$url=str_replace("#message#", $message, $url);
			$exec_url=$url;
		}
		$ch = curl_init($exec_url);
		$get_url=$exec_url;
		curl_setopt($ch, CURLOPT_POST,0);
		curl_setopt($ch, CURLOPT_URL, $get_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
		$return_val = curl_exec($ch);
		//$return_val =file_get_contents($url."?".$parameters);
		$dataArray=array(
			'send_to'=>$send_to,
			'message'=>$message1,
			'mobile'=>$mobile,
			'sender_id'=>"PHEDWT",
			'sent_date'=>date('Y-m-d H:i:s'),
			'msg_type'=>"Trans",
			'purpose'=>$purpose,
			'last_update'=>date('Y-m-d H:i:s'),
			'status'=>"Sent",
			'job_id'=>$return_val,
			'company'=>$sms_route->route_name
		);
		DB::table('sms')->insert($dataArray);
	}

	public function Check_Balance()
	{
		$master=DB::table('master')->first();
		$sms_route=DB::table('sms_route')->where('id',$master->default_sms)->first();
		//dd($sms_route);
		$message1=$message;
		$message=urlencode($message);
		$url=$sms_route->url;
		$unicode_url=$sms_route->unicode_url;
		if($unicode==true)
		{
			$unicode_url=str_replace("#mobile#", $mobile, $unicode_url);
			$unicode_url=str_replace("#message#", $message, $unicode_url);
			$exec_url=$unicode_url;
		}
		else
		{
			$url=str_replace("#mobile#", $mobile, $url);
			$url=str_replace("#message#", $message, $url);
			$exec_url=$url;
		}
		$ch = curl_init($exec_url);
		$get_url=$exec_url;
		curl_setopt($ch, CURLOPT_POST,0);
		curl_setopt($ch, CURLOPT_URL, $get_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
		$return_val = curl_exec($ch);
		//$return_val =file_get_contents($url."?".$parameters);
		$dataArray=array(
			'send_to'=>$send_to,
			'message'=>$message1,
			'mobile'=>$mobile,
			'sender_id'=>"PHEDWT",
			'sent_date'=>date('Y-m-d H:i:s'),
			'msg_type'=>"Trans",
			'agent_id'=>"0",
			'purpose'=>$purpose,
			'last_update'=>date('Y-m-d H:i:s'),
			'status'=>"Sent",
			'job_id'=>$return_val,
			'superadmin'=>$superadmin,
			'admin'=>$admin,
			'subadmin'=>$subadmin,
			'user'=>$user,
			'company'=>$sms_route->route_name
		);
		DB::table('sms')->insert($dataArray);
	}

  public function send_sms_mumbai($mobile,$message,$send_to,$purpose,$superadmin,$admin,$subadmin,$user,$unicode=false)
	{
		$username=urlencode("phed");
		$password=urlencode("phedphed");
		$sender=urlencode("PHEDWT");
		$message1=$message;
		$message=urlencode($message);
		$url="http://a2sms.in/api/mt/SendSMS";
		if($unicode==true)
		{
			$parameters="user=".$username."&password=".$password."&senderid=".$sender."&channel=Trans&DCS=8&flashsms=0&number=91".$mobile."&text=".$message."&route=55";
		}
		else
		{
			$parameters="user=".$username."&password=".$password."&senderid=".$sender."&channel=Trans&DCS=0&flashsms=0&number=91".$mobile."&text=".$message."&route=55";
		}
		$ch = curl_init($url);
		$get_url=$url."?".$parameters;
		curl_setopt($ch, CURLOPT_POST,0);
		curl_setopt($ch, CURLOPT_URL, $get_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
		$return_val = curl_exec($ch);
		//$return_val =file_get_contents($url."?".$parameters);
		$dataArray=array(
			'send_to'=>$send_to,
			'message'=>$message1,
			'mobile'=>$mobile,
			'sender_id'=>$sender,
			'sent_date'=>date('Y-m-d H:i:s'),
			'msg_type'=>"Trans",
			'agent_id'=>"0",
			'purpose'=>$purpose,
			'last_update'=>date('Y-m-d H:i:s'),
			'status'=>"Sent",
			'job_id'=>$return_val,
			'superadmin'=>$superadmin,
			'admin'=>$admin,
			'subadmin'=>$subadmin,
			'user'=>$user,
			'company'=>"A2SMS"
		);
		DB::table('sms')->insert($dataArray);
	}

	public function send_sms_makemysms($mobile,$message,$send_to,$purpose,$superadmin,$admin,$subadmin,$user,$unicode=false)
	{
		$username = 'phed';
		$password = 'phedphed';
		$senderid = 'PHEDWT';
		$type = '1';
		$product = '1';
		$mobile=str_replace(" ","",$mobile);
		$credentials = 'username='.$username.'&password='.$password;
		if($unicode==true)
		{
			$url = 'http://makemysms.co.in/sms_api/smsUnicode.php';
			$data = '&mobile='.$mobile.'&sendername='.$senderid.'&message='.$message."&MType=U";
		}
		else
		{
			$data = '&mobile='.$mobile.'&sendername='.$senderid.'&message='.$message;
			$url = 'http://makemysms.co.in/sms_api/sendsms.php';
		}
		
		// make url to post using cURL
		
		$get_url = $url.'?'. $credentials . $data;
		$ch = curl_init($url);
		$get_url = str_replace(" ", '%20', $get_url);
		curl_setopt($ch, CURLOPT_POST,0);
		curl_setopt($ch, CURLOPT_URL, $get_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
		$content = curl_exec($ch);
		$err = curl_errno ( $ch ); 
		$errmsg = curl_error ( $ch ); 
		$header = curl_getinfo ( $ch ); 
		$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE ); 
		curl_close ( $ch ); 
		//$return_val =file_get_contents($url."?".$parameters);
		$dataArray=array(
			'send_to'=>$send_to,
			'message'=>$message,
			'mobile'=>$mobile,
			'sender_id'=>$senderid,
			'sent_date'=>date('Y-m-d H:i:s'),
			'msg_type'=>"Trans",
			'agent_id'=>"0",
			'purpose'=>$purpose,
			'last_update'=>date('Y-m-d H:i:s'),
			'status'=>"Sent",
			'job_id'=>$content,
			'superadmin'=>$superadmin,
			'admin'=>$admin,
			'subadmin'=>$subadmin,
			'user'=>$user,
			'company'=>"Make My Sms"
		);
		DB::table('sms')->insert($dataArray);
	}

	public function send_sms_360sms($mobile,$message,$send_to,$purpose,$superadmin,$admin,$subadmin,$user,$unicode=false)
	{
		$username = 'phed';
		$password = 'phedphed';
		$senderid = 'PHEDWT';
		$type = '1';
		$product = '1';
		$mobile=str_replace(" ","",$mobile);
		$credentials = 'user='.$username.'&password='.$password;
		if($unicode==true)
		{
			$url = 'http://sms.360marketings.in/vendorsms/pushsms.aspx';
			$data = '&msisdn='.$mobile.'&sid='.$senderid.'&msg='.$message."&fl=0&gwid=2&dc=8";
		}
		else
		{
			$data = '&msisdn='.$mobile.'&sid='.$senderid.'&msg='.$message.'&fl=0&gwid=2';
			$url = 'http://sms.360marketings.in/vendorsms/pushsms.aspx';
		}
		
		// make url to post using cURL
		
		$get_url = $url.'?'. $credentials . $data;
		$ch = curl_init($url);
		$get_url = str_replace(" ", '%20', $get_url);
		curl_setopt($ch, CURLOPT_POST,0);
		curl_setopt($ch, CURLOPT_URL, $get_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
		$content = curl_exec($ch);
		$err = curl_errno ( $ch ); 
		$errmsg = curl_error ( $ch ); 
		$header = curl_getinfo ( $ch ); 
		$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE ); 
		curl_close ( $ch ); 
		//$return_val =file_get_contents($url."?".$parameters);
		$dataArray=array(
			'send_to'=>$send_to,
			'message'=>$message,
			'mobile'=>$mobile,
			'sender_id'=>$senderid,
			'sent_date'=>date('Y-m-d H:i:s'),
			'msg_type'=>"Trans",
			'agent_id'=>"0",
			'purpose'=>$purpose,
			'last_update'=>date('Y-m-d H:i:s'),
			'status'=>"Sent",
			'job_id'=>$content,
			'superadmin'=>$superadmin,
			'admin'=>$admin,
			'subadmin'=>$subadmin,
			'user'=>$user,
			'company'=>"Make My Sms"
		);
		DB::table('sms')->insert($dataArray);
	}

	
}


?>