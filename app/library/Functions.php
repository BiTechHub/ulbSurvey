<?php
namespace App\library;
use DB;
use MYSQLI;


class db_connect {
    protected $mysqli;
    
    function __construct() {
        //create Database connection 
        //@$this->mysqli = new mysqli("localhost", "root", "", "jalalpur");
        @$this->mysqli = new mysqli("localhost", "ulbup13d_newsurvey", "{X%,r7()o==u", "ulbup13d_newsurvey");
        if (mysqli_connect_errno()) {
            printf("Error: Unable To Connect Database");
            exit();
        }else{
            // return database object
            return $this->mysqli;
        }
    }
    
    function __destruct() {
        @$this->mysqli->close(); // Close Database connection
        
    }  
}

class Functions extends db_connect {
   
    public function data_insert($sql)
    {
	$this->mysqli->set_charset("utf8");
        $result= $this->mysqli->query($sql) or die($this->mysqli->error);
        return $result;
    }
    
    public function data_select($sql)
    { 
			$data= array();
		$this->mysqli->set_charset("utf8");	
            $select=$this->mysqli->query($sql) or die($this->mysqli->error);      
            if($select->num_rows==0){
               return 'no';
            }  else {
				
               while ($row = $select->fetch_array(MYSQLI_ASSOC)) {
              array_push($data,$row);
				               }
			
               return $data;
            }
        
    }
	
	public function data_select_hindi($sql)
    { 
			$data= array();
			$this->mysqli->set_charset("utf8");
            $select=$this->mysqli->query($sql) or die($this->mysqli->error);      
            if($select->num_rows==0){
               return 'no';
            }  else {
				
               while ($row = $select->fetch_array(MYSQLI_ASSOC)) {
              array_push($data,$row);
				               }
			
               return $data;
            }
        
    }
	public function data_update($sql)
    {
	$this->mysqli->set_charset("utf8");
        $result= $this->mysqli->query($sql) or die($this->mysqli->error);
        return $result;
    }
	
	public function data_insert_multiple($sql)
    {
	$this->mysqli->set_charset("utf8");
        $result= $this->mysqli->multi_query($sql) or die($this->mysqli->error);
        return $result;
    }
	
	
	 public function data_insert_get_inserted_id($sql)
    {
		
     	$result= $this->mysqli->query($sql) or die($this->mysqli->error);
		return $id=$this->mysqli->insert_id;
      	//return $this->mysqli->insert_id($sql); // $mysqli->insert_id;
    }
	
	public function send_sms($mobile,$message,$send_to,$purpose)
	{
		//$mobile=919838422400;
		//$message="hi sujeet";
		$username=urlencode("bispl");
		$password=urlencode("1234567");
		$sender=urlencode("ASGINV");
		$message1=$message;
		$message=urlencode($message);
	
		$parameters="username=".$username."&password=".$password."&mobile=".$mobile."&sendername=".$sender."&message=".$message."&templateid=1707162486540801923";
	
		$url="http://makemysms.co.in/sms_api/sendsms.php";
	
		$ch = curl_init($url);
	
		if(isset($_POST))
		{
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
		}
		else
		{
			$get_url=$url."?".$parameters;
			curl_setopt($ch, CURLOPT_POST,0);
			curl_setopt($ch, CURLOPT_URL, $get_url);
		}
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
		$return_val = curl_exec($ch);
		//$return_val =file_get_contents($url."?".$parameters);
		if($return_val=="")
		{  
			//echo "Process Failed, Please check domain, username and password.";
			//$sql="CALL `store_sms`('".$send_to."','".$message1."', '".$mobile."', '".$sender."', '".date('Y-m-d H:i:s')."', 'Sent', 'H', 0, '".$purpose."', '0000-00-00 00:00:00','".$return_val."');";
			$sql="INSERT INTO `sms`(`send_to`, `message`, `mobile`, `sender_id`, `sent_date`, `status`, `purpose`, `last_update`,job_id) VALUES ('".$send_to."','".$message1."','".$mobile."','".$sender."','".date('Y-m-d H:i:s')."','Failed','".$purpose."','0000-00-00 00:00:00','".$return_val."')";
			$result= $this->mysqli->query($sql) or die($this->mysqli->error);
		}
		else
		{
			//$sql="CALL `store_sms`('".$send_to."','".$message1."', '".$mobile."', '".$sender."', '".date('Y-m-d H:i:s')."', 'Sent', 'H', 0, '".$purpose."', '0000-00-00 00:00:00','".$return_val."');";
			$sql="INSERT INTO `sms`(`send_to`, `message`, `mobile`, `sender_id`, `sent_date`, `status`, `purpose`, `last_update`,job_id) VALUES ('".$send_to."','".$message1."','".$mobile."','".$sender."','".date('Y-m-d H:i:s')."','Sent','".$purpose."','0000-00-00 00:00:00','".$return_val."')";
			$result= $this->mysqli->query($sql) or die($this->mysqli->error);
			//echo "$return_val";
		}
	}
	
	public function send_email($email,$message,$replyTo,$replyFrom,$subject)
	{
		date_default_timezone_set("Asia/Kolkata");
		$date1=date('d-M-Y');
		$currdate=date("d-M-Y", strtotime($date1));
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "66-199-242-227.reverse.ezzi.net";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "shobhitkumar1990@gmail.com";
		$mail->Password = 'itsshobhit@5490';
		$mail->ClearReplyTos();
		$mail->SetFrom($replyFrom,"Taxi exchange");
		$mail->AddAddress($email);
		//$mail->AddCC($cc);
		//$mail->AddCC("rinku@mobisofttech.co.in");
		$mail->Subject = $subject;
		$mail->Body = $message;
		//$mail->AddAttachment("user.xlsx");
		 if(!$mail->Send()){
			date_default_timezone_set("Asia/Kolkata");
			$dt=date('Y-m-d h:i:s');
			return "Message not send";
		}
		else{
			echo "Message has been sent";
		}

		
	}
	
	public function send_email_without_smtp($email,$message,$replyTo,$replyFrom,$subject)
	{
		$fromAddress = "From: ".$replyFrom."\r\n"."Reply-To: ".$replyTo."\r\n"."MIME-Version: 1.0\r\n"."Content-Type: text/html; charset=ISO-8859-1\r\n"."X-Mailer: PHP/" . phpversion();
		mail($email,$subject,$message,$fromAddress);
	}
	
	public function send_invoice_email_without_smtp($email,$message,$replyTo,$replyFrom,$subject,$cc)
	{
		$fromAddress = "From: ".$replyFrom."\r\n"."Reply-To: ".$replyTo."\r\n"."CC: ".$cc."\r\n"."MIME-Version: 1.0\r\n"."Content-Type: text/html; charset=ISO-8859-1\r\n"."X-Mailer: PHP/" . phpversion();
		mail($email,$subject,$message,$fromAddress);
	}
	
	
	
	
	public function send_email_invoice($email,$message,$replyTo,$replyFrom,$subject,$attachment)
	{
		date_default_timezone_set("Asia/Kolkata");
		$date1=date('d-M-Y');
		$currdate=date("d-M-Y", strtotime($date1));
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "mycab.invoice@gmail.com";
		$mail->Password = "shobhit@1990";
		//$mail->ClearReplyTos();
		$mail->SetFrom($replyFrom,"Taxi exchange");
		$mail->AddAddress($email);
		$mail->AddCC("invoice@taxiexchange.in");
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AddAttachment($attachment);
		$mail->Send();

		
	}
	
	
	
	public function  send_invoice_details($htmlbody,$to,$subject,$file,$from)
	{
		$headers = "From: ".$from."\r\nReply-To: ".$from."\r\nCC: invoice@taxiexchange.in ";
		$random_hash = md5(date('r', time()));
		$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
		$attachment = chunk_split(base64_encode(file_get_contents($file))); // Set your file path here
		$message = "--PHP-mixed-$random_hash\r\n"."Content-Type: multipart/alternative; boundary=\"PHP-alt-$random_hash\"\r\n\r\n";
		$message .= "--PHP-alt-$random_hash\r\n"."Content-Type: text/plain; charset=\"iso-8859-1\"\r\n"."Content-Transfer-Encoding: 7bit\r\n\r\n";
		$message .= $htmlbody;
		$message .="\r\n\r\n--PHP-alt-$random_hash--\r\n\r\n";
		$message .= "--PHP-mixed-$random_hash\r\n"."Content-Type: application/zip; name=\"".$file."\"\r\n"."Content-Transfer-Encoding: base64\r\n"."Content-Disposition: attachment\r\n\r\n";
		$message .= $attachment;
		$message .= "/r/n--PHP-mixed-$random_hash--";
		$mail = mail( $to, $subject , $message, $headers );
		return $mail ? "success" : "failed";

	}
}


?>