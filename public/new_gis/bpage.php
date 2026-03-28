<?php
error_reporting(0);
include_once('include/config.php');
date_default_timezone_set("Asia/Kolkata") ;

if($_REQUEST['action']=="genHouseNumber")
{
	genHouseNumber();
}

if($_REQUEST['action']=="login")
{
	login();
}

if($_REQUEST['action']=="checkUpdate")
{
	checkUpdate();
}

if($_REQUEST['action']=="Pendinglist")
{
	Pendinglist();
}

if($_REQUEST['action']=="PendingProofDocument")
{
	PendingProofDocument();
}

if($_REQUEST['action']=="updateNewHouse")
{
	updateNewHouse();
}

if($_REQUEST['action']=="UploadProofDocument")
{
	UploadProofDocument();
}

if($_REQUEST['action']=="RejectedNewHouselist")
{
	RejectedNewHouselist();
}

if($_REQUEST['action']=="updatePersonalData")
{
	updatePersonalData();
}

if($_REQUEST['action']=="Personallist")
{
	Personallist();
}

if($_REQUEST['action']=="RejectedPersonallist")
{
	RejectedPersonallist();
}

if($_REQUEST['action']=="updateHouseData")
{
	updateHouseData();
}
if($_REQUEST['action']=="insertAssets")
{
	insertAssets();
}
if($_REQUEST['action']=="selectHouseDetails")
{
	selectHouseDetails();
}

if($_REQUEST['action']=="selectHouseDetailsById")
{
	selectHouseDetailsById();
}

if($_REQUEST['action']=="UpdateHouseDetailsById")
{
	UpdateHouseDetailsById();
}

if($_REQUEST['action']=="selectOldHouseDetailsById")
{
	selectOldHouseDetailsById();
}

if($_REQUEST['action']=="selectHouseDetailsByIdForUpload")
{
	selectHouseDetailsByIdForUpload();
}

function checkUpdate()
{
	//$imei=$_REQUEST['imei'];
	$imei=$_REQUEST['imei'];
	$mobilemanuf=$_REQUEST['mobilemanuf'];
	$mobilemodel=$_REQUEST['mobilemodel'];
	$mobilebrand=$_REQUEST['mobilebrand'];
	$oper_name=$_REQUEST['oper_name'];
	$reg=$_REQUEST['reg'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT * from unit_no WHERE imei='".$imei."'";
	$im=$obj->data_select($sql);
	if($im=='no')
	{
		$sql="INSERT INTO unit_no (imei,firebaseId,manufacturer,model,brand,sim_operator) VALUES ('".$imei."','".$reg."','".$mobilemanuf."','".$mobilemodel."','".$mobilebrand."','".$oper_name."')";
		$obj->data_insert($sql);
	}
	else
	{
		$sql="UPDATE unit_no SET firebaseId='".$reg."', sim_operator='".$oper_name."' WHERE imei='".$imei."'";
		$obj->data_insert($sql);
	}

	$sql="SELECT * FROM survey_app_setting";
	$res=$obj->data_select($sql);
	if($res=='no')
	{
		$response[0]['msg']="Error";
	}
	else
	{
		$response[0]['status']=$res[0]['app_status'];
		$response[0]['app_code']=$res[0]['app_version'];
		$response[0]['msg']="Your app is not active please contact service provider";
		$sql="SELECT * FROM users WHERE imei='".$imei."' AND login_type='Online' AND user_type='Surveyor'";
		$res_user=$obj->data_select($sql);
		if($res_user=='no')
		{
			$response[0]['user_msg']="";
			$response[0]['user_status']="ERROR";
		}
		else
		{
			if($res_user[0]['status']=="In-Active")
			{
				$response[0]['user_status']="ERROR";
				$response[0]['user_msg']="Currently no survey active on your account";
			}
			else
			{
				$sql="SELECT * FROM road_width WHERE nagarpalika='".$res_user[0]['city']."'";
				$res_road_width=$obj->data_select($sql);
				$i=1;
				$res_road_width1[0]['id']=0;
				$res_road_width1[0]['road_width']="-- सड़क की चौड़ाई --";
				foreach($res_road_width as $value)
				{
					$res_road_width1[$i]['id']=$value['id'];
					$res_road_width1[$i]['road_width']=$value['road_width'];
					$i++;
				}
				$sql="SELECT * FROM construction_age WHERE nagarpalika='".$res_user[0]['city']."'";
				$res_construction_age=$obj->data_select($sql);
				$i=1;
				$res_construction_age1[0]['id']=0;
				$res_construction_age1[0]['age']="-- निर्माण वर्ष --";
				foreach($res_construction_age as $value)
				{
					$res_construction_age1[$i]['id']=$value['id'];
					$res_construction_age1[$i]['age']=$value['age'];
					$i++;
				}

				$sql="SELECT * FROM assets Order by assets_name ASC";
				$res_assets=$obj->data_select($sql);
				$i=1;
				$res_assets1[0]['id']=0;
				$res_assets1[0]['assets_name']="Select Assets Name ";
				foreach($res_assets as $value)
				{
					$res_assets1[$i]['id']=$value['id'];
					$res_assets1[$i]['assets_name']=$value['assets_name'];
					$i++;
				}
				$sql="SELECT * FROM ward_details WHERE nagarpalika='".$res_user[0]['city']."' Order by ward_number ASC";
				$res_ward_details=$obj->data_select($sql);
				$i=1;
				$res_ward_details1[0]['id']=0;
				$res_ward_details1[0]['ward_number']="Select Ward Number";
				$res_ward_details1[0]['ward_name']="Select Ward Name";
				$res_ward_details1[0]['mohalla_name']="Select Mohalla Name";
				foreach($res_ward_details as $value)
				{
					$res_ward_details1[$i]['id']=$value['id'];
					$res_ward_details1[$i]['ward_number']=$value['ward_number'];
					$res_ward_details1[$i]['ward_name']=$value['ward_name'];
					$res_ward_details1[$i]['mohalla_name']=$value['mohalla_name'];
					$i++;
				}
				$response[0]['user_details']=$res_user;
				$response[0]['road_width']=$res_road_width1;
				$response[0]['construction_age']=$res_construction_age1;
				$response[0]['ward_details']=$res_ward_details1;
				$response[0]['assets']=$res_assets1;
				$response[0]['user_status']="OK";

			}

		}
	}
	header('Content-type: application/json');
	echo json_encode($response);
}

function login()
{
	$mobile=$_REQUEST['mobile'];
	$password=$_REQUEST['password'];
	$imei=$_REQUEST['imei'];
	$sim_no=$_REQUEST['sim_no'];
	/*$mobilemanuf=$_REQUEST['mobilemanuf'];
	$mobilemodel=$_REQUEST['mobilemodel'];
	$mobilebrand=$_REQUEST['mobilebrand'];*/
	$software_version=$_REQUEST['software_version'];
	$sim_serial_number=$_REQUEST['sim_serial_number'];
	$oper_name=$_REQUEST['oper_name'];
	$subscriberId=$_REQUEST['subscriberId'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT * from users WHERE username='".$mobile."' AND login_type='Online' AND user_type='Surveyor'";
	$response=$obj->data_select($sql);
	if($response=='no')
	{
		$res['msg']="WRONG_USER";
		$res['data']="Please enter correct username";
	}
	else
	{
		if($response[0]['password']==$password)
		{
			if($response[0]['status']=="In-Active")
			{
				$res['msg']="WRONG_PASS";
				$res['data']="Currently no survey active on your userid";
			}
			else
			{
				$sql="UPDATE users SET imei='".$imei."' WHERE username='".$mobile."'";
				$obj->data_insert($sql);
				$sql="SELECT * FROM road_width WHERE nagarpalika='".$response[0]['city']."'";
				$res_road_width=$obj->data_select($sql);
				$i=1;
				$res_road_width1[0]['id']=0;
				$res_road_width1[0]['road_width']="Select Road Width";
				foreach($res_road_width as $value)
				{
					$res_road_width1[$i]['id']=$value['id'];
					$res_road_width1[$i]['road_width']=$value['road_width'];
					$i++;
				}
				$sql="SELECT * FROM construction_age WHERE nagarpalika='".$response[0]['city']."'";
				$res_construction_age=$obj->data_select($sql);
				$i=1;
				$res_construction_age1[0]['id']=0;
				$res_construction_age1[0]['age']="Select Nirman Varsh";
				foreach($res_construction_age as $value)
				{
					$res_construction_age1[$i]['id']=$value['id'];
					$res_construction_age1[$i]['age']=$value['age'];
					$i++;
				}

				$sql="SELECT * FROM assets Order by assets_name ASC";
				$res_assets=$obj->data_select($sql);
				$i=1;
				$res_assets1[0]['id']=0;
				$res_assets1[0]['assets_name']="Select Assets Name ";
				foreach($res_assets as $value)
				{
					$res_assets1[$i]['id']=$value['id'];
					$res_assets1[$i]['assets_name']=$value['assets_name'];
					$i++;
				}
				$sql="SELECT * FROM ward_details WHERE nagarpalika='".$response[0]['city']."' Order by ward_number ASC";
				$res_ward_details=$obj->data_select($sql);
				$i=1;
				$res_ward_details1[0]['id']=0;
				$res_ward_details1[0]['ward_number']="Select Ward Number";
				$res_ward_details1[0]['ward_name']="Select Ward Name";
				$res_ward_details1[0]['mohalla_name']="Select Mohalla Name";
				foreach($res_ward_details as $value)
				{
					$res_ward_details1[$i]['id']=$value['id'];
					$res_ward_details1[$i]['ward_number']=$value['ward_number'];
					$res_ward_details1[$i]['ward_name']=$value['ward_name'];
					$res_ward_details1[$i]['mohalla_name']=$value['mohalla_name'];
					$i++;
				}
				$res['msg']="OK";
				$res['data']=$response;
				$res['road_width']=$res_road_width1;
				$res['construction_age']=$res_construction_age1;
				$res['ward_details']=$res_ward_details1;
				$res['assets']=$res_assets1;
			}
		}
		else{
			$res['msg']="WRONG_PASS";
			$res['data']="Please enter correct password";
		}

	}


	header('Content-type: application/json');
	echo json_encode($res);
}


function genHouseNumber()
{
	$array_house=array("", "/A", "/B","/C","/D","/E","/F","/G","/H","/I");
	$house_type=$_REQUEST['house_type'];
	$file_name=$_REQUEST['file_name'];
	$wardnumber=$_REQUEST['wardnumber'];
	$houseqty=$_REQUEST['houseqty'];
	$lat=$_REQUEST['lat'];
	$lng=$_REQUEST['lng'];
	$imei=$_REQUEST['imei'];
	$basement=$_REQUEST['basement'];
	$no_of_floor=$_REQUEST['no_of_floor'];
	$city=$_REQUEST['city'];
	$username=$_REQUEST['username'];
	$id=$_REQUEST['id'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$targetPath = "upload/".$file_name;
	$data="data:image/png;base64,".$_REQUEST['temp'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents($targetPath, $data);
	$sql="SELECT * FROM users WHERE username='".$username."'";
	$users_details=$obj->data_select($sql);
	$insert_sql="INSERT INTO survey_step_1 (house_number,ward_number,lat,lng,basement,no_of_floor,house_type,city,username,user_id,imei,image_name,ward_name,mohalla) VALUES ";
	$house_data=array();
	$sql="SELECT IFNULL(MAX(house_number),0) AS house_number FROM survey_step_1 WHERE ward_number='".$wardnumber."' AND city='".$city."' ORDER BY id DESC LIMIT 0,1";
	$house_number_result=$obj->data_select($sql);
	$house_number_db=$house_number_result[0]['house_number'];
	/*if($house_number_result!='no')
	{
		preg_match_all('!\d+!', $house_number_result[0]['house_number'], $matches);
		$house_number_db=($matches[0][0])-(1000*$wardnumber);
	}*/
	if($house_number_db==0)
	{
		$house_number_db=(($house_number_db+1)+(10000*$wardnumber));
	}
	else{
		$house_number_db=$house_number_db+1;
	}
	$temp_house_number=array();
	for($i=0;$i<$houseqty;$i++)
	{
		$temp_house_number[$i]=$house_number_db."".$array_house[$i];
		$flag="('".$temp_house_number[$i]."','".$wardnumber."','".$lat."','".$lng."','".$basement."','".$no_of_floor."','".$house_type."','".$city."',
		'".$username."','".$id."','".$imei."','".$file_name."','".$users_details[0]['ward_name']."','".$users_details[0]['mohalla']."')";
		array_push($house_data,$flag);

	}
	$insert_data=implode(",",$house_data);
	$obj->data_insert($insert_sql."".$insert_data);
	$hn=implode(",",$temp_house_number);
	//header('Content-type: application/json');
	echo "House number is ".$hn."";
}


function updateNewHouse()
{
	$survey_id=$_REQUEST['survey_id'];
	$file_name=$_REQUEST['file_name'];
	$wardnumber=$_REQUEST['wardnumber'];
	$houseqty=$_REQUEST['houseqty'];
	$lat=$_REQUEST['lat'];
	$lng=$_REQUEST['lng'];
	$imei=$_REQUEST['imei'];
	$basement=$_REQUEST['basement'];
	$no_of_floor=$_REQUEST['no_of_floor'];
	$city=$_REQUEST['city'];
	$username=$_REQUEST['username'];
	$id=$_REQUEST['id'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$targetPath = "upload/".$file_name;
	$data="data:image/png;base64,".$_REQUEST['temp'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents($targetPath, $data);
	$insert_sql="UPDATE survey_step_1 SET status='Pending',DataVerfied='No',lat='".$lat."',lng='".$lng."',basement='".$basement."',image_name='".$file_name."' WHERE id='".$survey_id."'";
	$obj->data_update($insert_sql);
	$hn=implode(",",$temp_house_number);
	//header('Content-type: application/json');
	echo "Your house details updated successfully.";
}

function inte()
{
	preg_match_all('!\d+!',"1001", $matches);
	echo $matches[0][0];
}



function Pendinglist()
{
	$city=$_REQUEST['city'];
	$ward_no=$_REQUEST['ward_no'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT * from survey_step_1 WHERE status='Pending' AND city='".$city."' AND ward_number='".$ward_no."'";
	//$sql="SELECT * from survey_step_1 WHERE status='Pending' AND city='".$city."' AND ward_number='".$ward_no."'";
	$response=$obj->data_select($sql);
	if($response=='no')
	{
		$res['msg']="WRONG_USER";
		$res['data']="No booking details found";
	}
	else
	{
		$res['msg']="OK";
		$res['data']=$response;
	}
	header('Content-type: application/json');
	echo json_encode($res);
}

function PendingProofDocument()
{
	$city=$_REQUEST['city'];
	$ward_no=$_REQUEST['ward_no'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT * from survey_step_1 WHERE city='".$city."' AND ward_number='".$ward_no."' AND proof_name is NULL";
	//$sql="SELECT * from survey_step_1 WHERE status='Pending' AND city='".$city."' AND ward_number='".$ward_no."'";
	$response=$obj->data_select($sql);
	if($response=='no')
	{
		$res['msg']="WRONG_USER";
		$res['data']="No booking details found";
	}
	else
	{
		$res['msg']="OK";
		$res['data']=$response;
	}
	header('Content-type: application/json');
	echo json_encode($res);
}

function UploadProofDocument()
{
	$proof_type=$_REQUEST['proof_type'];
	$file_name=$_REQUEST['file_name'];
	$house_number=$_REQUEST['house_number'];
	$imei=$_REQUEST['imei'];
	$city=$_REQUEST['city'];
	$username=$_REQUEST['username'];
	$id=$_REQUEST['id'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$targetPath = "upload/document/".$file_name;
	$data="data:image/png;base64,".$_REQUEST['temp'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents($targetPath, $data);
	$insert_sql="UPDATE survey_step_1 SET proof_type='".$proof_type."',proof_name='".$file_name."' WHERE house_number='".$house_number."' AND city='".$city."'";
	$obj->data_update($insert_sql);
	//header('Content-type: application/json');
	echo "Document successfully uploaded";
}

function RejectedNewHouselist()
{
	$city=$_REQUEST['city'];
	$ward_no=$_REQUEST['ward_no'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT * from survey_step_1 WHERE DataVerfied='Rejected' AND city='".$city."'";
	//$sql="SELECT * from survey_step_1 WHERE status='Pending' AND city='".$city."' AND ward_number='".$ward_no."'";
	$response=$obj->data_select($sql);
	if($response=='no')
	{
		$res['msg']="WRONG_USER";
		$res['data']="No details found";
	}
	else
	{
		$res['msg']="OK";
		$res['data']=$response;
	}
	header('Content-type: application/json');
	echo json_encode($res);
}

function updatePersonalData()
{
	$id=$_REQUEST['id'];
	$house_owner_address=$_REQUEST['house_owner_address'];
	$old_house_number=$_REQUEST['old_house_number'];
	$house_number=$_REQUEST['house_number'];
	$name=$_REQUEST['name'];
	$fname=$_REQUEST['fname'];
	$mobile=$_REQUEST['mobile'];
	$rentedPerson=$_REQUEST['rentedPerson'];
	$rentedPersonName=$_REQUEST['rentedPersonName'];
	$areaAll=$_REQUEST['areaAllLength'];
	$areaAllWidth=$_REQUEST['areaAllWidth'];
	$areaConstructed=$_REQUEST['areaConstructedLength'];
	$areaConstructedWidth=$_REQUEST['areaConstructedWidth'];
	$areaBusiness=$_REQUEST['areaBusinessLength'];
	$areaBusinessWidth=$_REQUEST['areaBusinessWidth'];
	$areaCommomLength=$_REQUEST['areaCommomLength'];
	$areaCommomWidth=$_REQUEST['areaCommomWidth'];
	$noOfFloor=$_REQUEST['noOfFloor'];
	$noOfRoom=$_REQUEST['noOfRoom'];
	$basementArea=$_REQUEST['basementAreaLength'];
	$basementAreaWidth=$_REQUEST['basementAreaWidth'];
	$groundArea=$_REQUEST['groundAreaLength'];
	$groundAreaWidth=$_REQUEST['groundAreaWidth'];
	$firstArea=$_REQUEST['firstAreaLength'];
	$firstAreaWidth=$_REQUEST['firstAreaWidth'];
	$secondArea=$_REQUEST['secondAreaLength'];
	$secondAreaWidth=$_REQUEST['secondAreaWidth'];
	$thirdArea=$_REQUEST['thirdAreaLength'];
	$thirdAreaWidth=$_REQUEST['thirdAreaWidth'];
	$lengthEast=$_REQUEST['lengthEast'];
	$lengthWest=$_REQUEST['lengthWest'];
	$lengthNorth=$_REQUEST['lengthNorth'];
	$lengthSouth=$_REQUEST['lengthSouth'];
	$localEast=$_REQUEST['localEast'];
	$localWest=$_REQUEST['localWest'];
	$localNorth=$_REQUEST['localNorth'];
	$localSouth=$_REQUEST['localSouth'];
	$nirmanVarsh=$_REQUEST['nirmanVarsh'];
	$sadakKichoudai=$_REQUEST['sadakKichoudai'];
	$FarshPrakriti=$_REQUEST['FarshPrakriti'];
	$NirmanPrakriti=$_REQUEST['NirmanPrakriti'];
	$wardnumber=$_REQUEST['ward_number'];
	$city=$_REQUEST['city'];
	$user_id=$_REQUEST['user_id'];
	$username=$_REQUEST['username'];
	$imei=$_REQUEST['imei'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT * FROM users WHERE username='".$username."'";
	$users_details=$obj->data_select($sql);
	$sql="SELECT * FROM old_house_details WHERE house_number='".$old_house_number."' AND ward_number='".$wardnumber."' AND mohalla_name='".$users_details[0]['mohalla']."'";
	$old_house_details=$obj->data_select($sql);
	if($old_house_details=='no')
	{
		$old_house_owner_name="";
		$old_house_father_name="";
	}
	else
	{
		$old_house_owner_name=$old_house_details[0]['owner_name'];
		$old_house_father_name=$old_house_details[0]['father_name'];
	}
	$sql="UPDATE `survey_personal_details` SET
	`old_house_number`='".$old_house_number."',
	`old_house_owner_name`='".$old_house_owner_name."',
	`old_house_father_name`='".$old_house_father_name."',
	`name`='".$name."',
	`house_owner_address`='".$house_owner_address."',
	`father_name`='".$fname."',
	`mobile_number`='".$mobile."',
	`rented_person`='".$rentedPerson."',
	`rented_person_name`='".$rentedPersonName."',
	`area_all`='".$areaAll."',
	`area_all_width`='".$areaAllWidth."',
	`area_constructed`='".$areaConstructed."',
	`area_constructed_width`='".$areaConstructedWidth."',
	`area_business`='".$areaBusiness."',
	`area_business_width`='".$areaBusinessWidth."',
	`area_common_length`='".$areaCommomLength."',
	`area_common_width`='".$areaCommomWidth."',
	`no_of_floor`='".$noOfFloor."',
	`no_of_room`='".$noOfRoom."',
	`basement_area`='".$basementArea."',
	`basement_area_width`='".$basementAreaWidth."',
	`ground_area`='".$groundArea."',
	`ground_area_width`='".$groundAreaWidth."',
	`first_area`='".$firstArea."',
	`first_area_width`='".$firstAreaWidth."',
	`second_area`='".$secondArea."',
	`second_area_width`='".$secondAreaWidth."',
	`third_area`='".$thirdArea."',
	`third_area_width`='".$thirdAreaWidth."',
	`length_east`='".$lengthEast."',
	`length_west`='".$lengthWest."',
	`length_north`='".$lengthNorth."',
	`length_south`='".$lengthSouth."',
	`locality_east`='".$localEast."',
	`locality_west`='".$localWest."',
	`locality_north`='".$localNorth."',
	`locality_south`='".$localSouth."',
	nirmanVarsh='".$nirmanVarsh."',
	sadakKichoudai='".$sadakKichoudai."',
	FarshPrakriti='".$FarshPrakriti."',
	NirmanPrakriti='".$NirmanPrakriti."',
	city='".$city."',
	user_name='".$username."',
	ward_number='".$wardnumber."',
	ward_name='".$users_details[0]['ward_name']."',
	mohalla_name='".$users_details[0]['mohalla']."',
	`status`='Pending',
	`DataVerified`='No',
	`updated_id`='".$user_id."',
	`updated_at`='".date('Y-m-d H:i:s')."',
	`created_at`='".date('Y-m-d H:i:s')."'
	WHERE survey_id='".$id."'";
	$obj->data_update($sql);
	$sql="UPDATE survey_step_1 SET status='Completed' WHERE id='".$id."'";
	$obj->data_update($sql);

	if($mobile!="0000000000")
	{
		$message="H N ".$house_number." House tax survey is free of cost by ".$city.". Please do not give any money to anyone Regards ASGINV";
		$send_to="User";
		$purpose="House Confirmation";
		$obj->send_sms($mobile,$message,$send_to,$purpose);
	}



	echo "Data updated successfully ";

}

function Personallist()
{
	$city=$_REQUEST['city'];
	$ward_no=$_REQUEST['ward_no'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT ss.id,ss.house_number,ss.lat,ss.lng,ss.house_number,spd.name from survey_step_1 ss JOIN survey_personal_details spd ON ss.id=spd.survey_id WHERE spd.status='Pending' AND ss.city='".$city."' AND ss.ward_number='".$ward_no."'  AND spd.name is NOT NULL";
	$response=$obj->data_select($sql);
	if($response=='no')
	{
		$res['msg']="WRONG_USER";
		$res['data']="No personal details found";
	}
	else
	{
		$res['msg']="OK";
		$res['data']=$response;
	}
	header('Content-type: application/json');
	echo json_encode($res);
}

function RejectedPersonallist()
{
	$city=$_REQUEST['city'];
	$ward_no=$_REQUEST['ward_no'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="SELECT ss.id,ss.house_number,ss.lat,ss.lng,ss.house_number,spd.name,spd.reject_reason from survey_step_1 ss JOIN survey_personal_details spd ON ss.id=spd.survey_id WHERE spd.DataVerified='Rejected' AND ss.city='".$city."' AND ss.ward_number='".$ward_no."'  AND spd.name is NOT NULL";
	$response=$obj->data_select($sql);
	if($response=='no')
	{
		$res['msg']="WRONG_USER";
		$res['data']="No personal details found";
	}
	else
	{
		$res['msg']="OK";
		$res['data']=$response;
	}
	header('Content-type: application/json');
	echo json_encode($res);
}

function updateHouseData()
{
	$id=$_REQUEST['id'];
	$house_number=urldecode($_REQUEST['house_number']);
	$nirmanBhavanKaPrakar=urldecode($_REQUEST['nirmanBhavanKaPrakar']);
	$wardNumber=urldecode($_REQUEST['wardNumber']);
	$wardName=urldecode($_REQUEST['wardName']);
	$mohallaName=urldecode($_REQUEST['mohallaName']);
	$malik=urldecode($_REQUEST['malik']);
	$kirayedaar=urldecode($_REQUEST['kirayedaar']);
	$panjikaran=urldecode($_REQUEST['panjikaran']);
	$sampattiShreni=urldecode($_REQUEST['sampattiShreni']);
	$sampattiPrakar=urldecode($_REQUEST['sampattiPrakar']);
	//$nirmanVarsh=urldecode($_REQUEST['nirmanVarsh']);
	//$nirmanPrakriti=urldecode($_REQUEST['nirmanPrakriti']);
	//$farshPrakriti=urldecode($_REQUEST['farshPrakriti']);
	$souchayala=urldecode($_REQUEST['souchayala']);
	//$sadakKiChoudai=urldecode($_REQUEST['sadakKiChoudai']);
	$sadakKePrakar=urldecode($_REQUEST['sadakKePrakar']);
	$gasConnection=urldecode($_REQUEST['gasConnection']);
	$bijliMeter=urldecode($_REQUEST['bijliMeter']);
	$bijliMeterNumber=urldecode($_REQUEST['bijliMeterNumber']);
	$dharm=urldecode($_REQUEST['dharm']);
	$jati=urldecode($_REQUEST['jati']);
	$jalapurti=urldecode($_REQUEST['jalapurti']);
	$rashanCard=urldecode($_REQUEST['rashanCard']);
	$rashanCardNumber=urldecode($_REQUEST['rashanCardNumber']);
	$city=urldecode($_REQUEST['city']);
	$localNorth=urldecode($_REQUEST['localNorth']);
	$localSouth=urldecode($_REQUEST['localSouth']);
	$user_id=urldecode($_REQUEST['user_id']);
	$username=urldecode($_REQUEST['username']);
	$imei=urldecode($_REQUEST['imei']);
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$sql="UPDATE `house_details` SET
	`nirmanBhavanKaPrakar`='".$nirmanBhavanKaPrakar."',
	`wardNumber`='".$wardNumber."',
	`wardName`='".$wardName."',
	`mohallaName`='".$mohallaName."',
	`malik`='".$malik."',
	`kirayedaar`='".$kirayedaar."',
	`panjikaran`='".$panjikaran."',
	`sampattiShreni`='".$sampattiShreni."',
	`sampattiPrakar`='".$sampattiPrakar."',
	`souchayala`='".$souchayala."',
	`sadakKePrakar`='".$sadakKePrakar."',
	`gasConnection`='".$gasConnection."',
	`bijliMeter`='".$bijliMeter."',
	`bijliMeterNumber`='".$bijliMeterNumber."',
	`dharm`='".$dharm."',
	`jati`='".$jati."',
	`jalapurti`='".$jalapurti."',
	`rashanCard`='".$rashanCard."',
	`rashanCardNumber`='".$rashanCardNumber."',
	`city`='".$city."',
	`user_name`='".$username."',
	`status`='Completed',
	`DataVarified`='No',
	`user_id`='".$user_id."',
	`updated_at`='".date('Y-m-d H:i:s')."',
	`created_at`='".date('Y-m-d H:i:s')."'
	WHERE personal_details_id='".$id."'";
	$obj->data_update($sql);
	$sql="UPDATE survey_personal_details SET status='Completed' WHERE survey_id='".$id."'";
	$obj->data_update($sql);
	echo "Data updated successfully ";
}



function insertAssets()
{
	$file_name=$_REQUEST['file_name'];
	$assetsName=$_REQUEST['assetsName'];
	$assetsWardNumber=$_REQUEST['assetsWardNumber'];
	$lat=$_REQUEST['lat'];
	$lng=$_REQUEST['lng'];
	$imei=$_REQUEST['imei'];
	$landmark=$_REQUEST['landmark'];
	$address=$_REQUEST['address'];
	$city=$_REQUEST['city'];
	$username=$_REQUEST['username'];
	$id=$_REQUEST['id'];
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$targetPath = "upload/assets/".$file_name;
	$data="data:image/png;base64,".$_REQUEST['temp'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents($targetPath, $data);
	$sql="INSERT INTO assets_details(city,assets_name,photo,lat,lng,address,ward_number,landmark,created_at,updated_at,inserted_by,inserted_name)VALUES('".$city."','".$assetsName."',
	'".$file_name."','".$lat."','".$lng."','".$address."','".$assetsWardNumber."','".$landmark."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$id."','".$username."')";
	$obj->data_insert($sql);
	//header('Content-type: application/json');
	echo "Assets ".$assetsName." inserted in ward number ".$assetsWardNumber." Successfully";
}



function selectHouseDetailsById()
{
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$id=$_REQUEST['user_id'];
	$sql="SELECT * FROM users WHERE id='".$id."'";
	$res_user=$obj->data_select($sql);
	$sql="SELECT * FROM road_width WHERE nagarpalika='".$res_user[0]['city']."'";
	$res_road_width=$obj->data_select($sql);
	$i=1;
	$res_road_width1[0]['id']=0;
	$res_road_width1[0]['road_width']="-- सड़क की चौड़ाई --";
	foreach($res_road_width as $value)
	{
		$res_road_width1[$i]['id']=$value['id'];
		$res_road_width1[$i]['road_width']=$value['road_width'];
		$i++;
	}
	$sql="SELECT * FROM construction_age WHERE nagarpalika='".$res_user[0]['city']."'";
	$res_construction_age=$obj->data_select($sql);
	$i=1;
	$res_construction_age1[0]['id']=0;
	$res_construction_age1[0]['age']="-- निर्माण वर्ष --";
	foreach($res_construction_age as $value)
	{
		$res_construction_age1[$i]['id']=$value['id'];
		$res_construction_age1[$i]['age']=$value['age'];
		$i++;
	}

	$sql="SELECT * FROM assets Order by assets_name ASC";
	$res_assets=$obj->data_select($sql);
	$i=1;
	$res_assets1[0]['id']=0;
	$res_assets1[0]['assets_name']="Select Assets Name ";
	foreach($res_assets as $value)
	{
		$res_assets1[$i]['id']=$value['id'];
		$res_assets1[$i]['assets_name']=$value['assets_name'];
		$i++;
	}
	$sql="SELECT * FROM ward_details WHERE nagarpalika='".$res_user[0]['city']."' Order by ward_number ASC";
	$res_ward_details=$obj->data_select($sql);
	$i=1;
	$res_ward_details1[0]['id']=0;
	$res_ward_details1[0]['ward_number']="Select Ward Number";
	$res_ward_details1[0]['ward_name']="Select Ward Name";
	$res_ward_details1[0]['mohalla_name']="Select Mohalla Name";
	foreach($res_ward_details as $value)
	{
		$res_ward_details1[$i]['id']=$value['id'];
		$res_ward_details1[$i]['ward_number']=$value['ward_number'];
		$res_ward_details1[$i]['ward_name']=$value['ward_name'];
		$res_ward_details1[$i]['mohalla_name']=$value['mohalla_name'];
		$i++;
	}
	$json['user_details']=$res_user;
	$json['road_width']=$res_road_width1;
	$json['construction_age']=$res_construction_age1;
	$json['ward_details']=$res_ward_details1;
	$json['assets']=$res_assets1;

	$json['malikhai']=array("मालिक इस घर में रहते है","Yes","No");
	$json['kitayedarhai']=array("किरायेदार हैं","Yes","No");
	$json['gasconnection']=array("गैस कनेक्शन","Yes","No");
	$json['electricity']=array("बिजली के मीटर","Yes","No");
	$json['NirmanPrakar']=array("निर्माण भवन का प्रकार","Already Registered", "New Registration","Name Change");
	$json['PanjikaranPrakar']=array("पंजीकरण का प्रकार","Bainama", "Wasiyat","Paitrik","Ikrarnama");
	$json['SampatiShreni']=array("संपत्ति श्रेणी","Government", "Non Government","Parent","Agreement");
	$json['SampatiPrakar']=array("संपत्ति प्रकार","House","House+Shop","Hospital","Factory","Office","Shop","Other");
	$json['NirmanVarsh']=array("निर्माण वर्ष","0 To 10 Year", "10 To 20 Year","More than 20 Year");
	$json['NirmanPrakriti']=array("भवन के निमार्ण की प्रकृति","Pakka", "Ardh Pakka","Kachcha","Chhappar","Plot");
	$json['FarshPrakriti']=array("भवन के फर्श की प्रकृति","Tiles", "Pakka Farsh","Kachcha Farsh");
	$json['Souchalaya']=array("शौचालय","Safety tank", "Sewer","Water flowing","Collective","None");
	$json['SadakKiChoudai']=array("सड़क की चौड़ाई","More than 20 sqft", " 12 To 24 sqft","Less than 12 sqft");
	$json['SadakKePrakar']=array("सड़क के प्रकार","RCC", "Daamar","Interlocking","Khadanza","Kachcha");
	$json['Dharm']=array("धर्म","Hindu", "Muslim","Sikh","Isai","Other");
	$json['Jati']=array("जाति","General", "OBC","S.C.","S.T.");
	$json['Jalapurti']=array("जलापूर्ति","Nikay", "Handpump","Self","Water Collection");
	$json['RashanCard']=array("राशन कार्ड","APL", "BPL","Antodaya","Other");
	header('Content-type: application/json');
	echo json_encode($json);
}


function UpdateHouseDetailsById()
{
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$id=$_REQUEST['user_id'];
	$survey_id=$_REQUEST['survey_id'];
	$sql="SELECT * FROM users WHERE id='".$id."'";
	$res_user=$obj->data_select($sql);
	$sql="SELECT * FROM road_width WHERE nagarpalika='".$res_user[0]['city']."'";
	$res_road_width=$obj->data_select($sql);
	$i=1;
	$res_road_width1[0]['id']=0;
	$res_road_width1[0]['road_width']="-- सड़क की चौड़ाई --";
	foreach($res_road_width as $value)
	{
		$res_road_width1[$i]['id']=$value['id'];
		$res_road_width1[$i]['road_width']=$value['road_width'];
		$i++;
	}
	$sql="SELECT * FROM survey_personal_details WHERE survey_id='".$survey_id."'";
	$survey_personal_details=$obj->data_select($sql);
	$sql="SELECT * FROM house_details WHERE personal_details_id='".$survey_id."'";
	$house_details=$obj->data_select($sql);
	$sql="SELECT * FROM construction_age WHERE nagarpalika='".$res_user[0]['city']."'";
	$res_construction_age=$obj->data_select($sql);
	$i=1;
	$res_construction_age1[0]['id']=0;
	$res_construction_age1[0]['age']="-- निर्माण वर्ष --";
	foreach($res_construction_age as $value)
	{
		$res_construction_age1[$i]['id']=$value['id'];
		$res_construction_age1[$i]['age']=$value['age'];
		$i++;
	}

	$sql="SELECT * FROM assets Order by assets_name ASC";
	$res_assets=$obj->data_select($sql);
	$i=1;
	$res_assets1[0]['id']=0;
	$res_assets1[0]['assets_name']="Select Assets Name ";
	foreach($res_assets as $value)
	{
		$res_assets1[$i]['id']=$value['id'];
		$res_assets1[$i]['assets_name']=$value['assets_name'];
		$i++;
	}
	$sql="SELECT * FROM ward_details WHERE nagarpalika='".$res_user[0]['city']."' Order by ward_number ASC";
	$res_ward_details=$obj->data_select($sql);
	$i=1;
	$res_ward_details1[0]['id']=0;
	$res_ward_details1[0]['ward_number']="Select Ward Number";
	$res_ward_details1[0]['ward_name']="Select Ward Name";
	$res_ward_details1[0]['mohalla_name']="Select Mohalla Name";
	foreach($res_ward_details as $value)
	{
		$res_ward_details1[$i]['id']=$value['id'];
		$res_ward_details1[$i]['ward_number']=$value['ward_number'];
		$res_ward_details1[$i]['ward_name']=$value['ward_name'];
		$res_ward_details1[$i]['mohalla_name']=$value['mohalla_name'];
		$i++;
	}
	$json['house_details']=$house_details;
	$json['survey_personal_details']=$survey_personal_details;
	$json['user_details']=$res_user;
	$json['road_width']=$res_road_width1;
	$json['construction_age']=$res_construction_age1;
	$json['ward_details']=$res_ward_details1;
	$json['assets']=$res_assets1;

	$json['malikhai']=array("मालिक इस घर में रहते है","Yes","No");
	$json['kitayedarhai']=array("किरायेदार हैं","Yes","No");
	$json['gasconnection']=array("गैस कनेक्शन","Yes","No");
	$json['electricity']=array("बिजली के मीटर","Yes","No");
	$json['NirmanPrakar']=array("निर्माण भवन का प्रकार","Already Registered", "New Registration","Name Change");
	$json['PanjikaranPrakar']=array("पंजीकरण का प्रकार","Bainama", "Wasiyat","Paitrik","Ikrarnama");
	$json['SampatiShreni']=array("संपत्ति श्रेणी","Government", "Non Government","Parent","Agreement");
	$json['SampatiPrakar']=array("संपत्ति प्रकार","House","House+Shop","Hospital","Factory","Office","Shop","Other");
	$json['NirmanVarsh']=array("निर्माण वर्ष","0 To 10", "10 To 20","More Than 20");
	$json['NirmanPrakriti']=array("भवन के निमार्ण की प्रकृति","Pakka", "Ardh Pakka","Kachcha","Chhappar","Plot");
	$json['FarshPrakriti']=array("भवन के फर्श की प्रकृति","Tiles", "Pakka Farsh","Kachcha Farsh");
	$json['Souchalaya']=array("शौचालय","Safety tank", "Sewer","Water flowing","Collective","None");
	$json['SadakKiChoudai']=array("सड़क की चौड़ाई","0 To 10", "10 To 20","20 To 30" ,"More than 30");
	$json['SadakKePrakar']=array("सड़क के प्रकार","RCC", "Daamar","Interlocking","Khadanza","Kachcha");
	$json['Dharm']=array("धर्म","Hindu", "Muslim","Sikh","Isai","Other");
	$json['Jati']=array("जाति","General", "OBC","S.C.","S.T.");
	$json['Jalapurti']=array("जलापूर्ति","Nikay", "Handpump","Self","Water Collection");
	$json['RashanCard']=array("राशन कार्ड","APL", "BPL","Antodaya","Other");
	$json['proof_type']=array("Select Proof","Aadhar Card","House Registration Paper");
	header('Content-type: application/json');
	echo json_encode($json);
}


function selectHouseDetails()
{
	$json['malikhai']=array("मालिक इस घर में रहते है","Yes","No");
	$json['kitayedarhai']=array("किरायेदार हैं","Yes","No");
	$json['gasconnection']=array("गैस कनेक्शन","Yes","No");
	$json['electricity']=array("बिजली के मीटर","Yes","No");
	$json['NirmanPrakar']=array("निर्माण भवन का प्रकार","Already Registered", "New Registration","Name Change");
	$json['PanjikaranPrakar']=array("पंजीकरण का प्रकार","Bainama", "Wasiyat","Paitrik","Ikrarnama");
	$json['SampatiShreni']=array("संपत्ति श्रेणी","Government", "Non Government","Parent","Agreement");
	$json['SampatiPrakar']=array("संपत्ति प्रकार","House", "House+Shop","Hospital","Factory","Office","Shop","Other");
	$json['NirmanVarsh']=array("निर्माण वर्ष","0 To 10", "10 To 20","More Than 20");
	$json['NirmanPrakriti']=array("भवन के निमार्ण की प्रकृति","Pakka", "Ardh Pakka","Kachcha","Chhappar","Plot");
	$json['FarshPrakriti']=array("भवन के फर्श की प्रकृति","Tiles", "Pakka Farsh","Kachcha Farsh");
	$json['Souchalaya']=array("शौचालय","Safety tank", "Sewer","Water flowing","Collective","None");
	$json['SadakKiChoudai']=array("सड़क की चौड़ाई","0 To 10", "10 To 20","20 To 30" ,"More than 30");
	$json['SadakKePrakar']=array("सड़क के प्रकार","RCC", "Daamar","Interlocking","Khadanza","Kachcha");
	$json['Dharm']=array("धर्म","Hindu", "Muslim","Sikh","Isai","Other");
	$json['Jati']=array("जाति","General", "OBC","S.C.","S.T.");
	$json['Jalapurti']=array("जलापूर्ति","Nikay", "Handpump","Self","Water Collection");
	$json['RashanCard']=array("राशन कार्ड","APL", "BPL","Antodaya","Other");
	header('Content-type: application/json');
	echo json_encode($json);
}

function selectHouseDetailsHindi()
{
	$json['malikhai']=array("मालिक इस घर में रहते है","हां","नहीं");
	$json['kitayedarhai']=array("किरायेदार हैं","हां","नहीं");
	$json['gasconnection']=array("गैस कनेक्शन","हां","नहीं");
	$json['electricity']=array("बिजली के मीटर","हां","नहीं");
	$json['NirmanPrakar']=array("निर्माण भवन का प्रकार","पहले से दर्ज है", "नया भवन","नाम परिवर्तन");
	$json['PanjikaranPrakar']=array("पंजीकरण का प्रकार","बैनामा", "वसीयत","पैत्रिक","इकरारनामा");
	$json['SampatiShreni']=array("संपत्ति श्रेणी","सरकारी", "गैर सरकारी","पैत्रिक","इकरारनामा");
	$json['SampatiPrakar']=array("संपत्ति प्रकार","घर", "अस्पताल","कारखाना","कार्यालय","दूकान","अन्य");
	$json['NirmanVarsh']=array("निर्माण वर्ष","0 से 10 वर्ष", "10 से 20 वर्ष","20 वर्ष से अधिक");
	$json['NirmanPrakriti']=array("भवन के निमार्ण की प्रकृति","पक्का", "अर्ध पक्का","कच्चा","छप्पर","प्लॉट");
	$json['FarshPrakriti']=array("भवन के फर्श की प्रकृति","टायल्स", "पक्का फर्श","कच्चा फर्श");
	$json['Souchalaya']=array("शौचालय","सेफ्टी टैंक", "सीवर","जल प्रवाहित","सामूहिक","नहीं है");
	$json['SadakKiChoudai']=array("सड़क की चौड़ाई","24 वर्गफिट से अधिक", "12 से 24 वर्गफिट","12 वर्गफिट से कम");
	$json['SadakKePrakar']=array("सड़क के प्रकार","आरसीसी", "डामर","इंटरलॉकिंग","खडंजा","कच्चा");
	$json['Dharm']=array("धर्म","हिन्दू", "मुस्लिम","सिक्ख","इसाई","अन्य");
	$json['Jati']=array("जाति","सामान्य वर्ग", "अन्य पिछड़ा वर्ग","अनुसूचित जाति","अनुसूचित जन जाति");
	$json['Jalapurti']=array("जलापूर्ति","निकाय द्वारा", "हैण्डपंप","स्वयं का","जल संरक्षण");
	$json['RashanCard']=array("राशन कार्ड","APL", "BPL","अन्त्योदय","अन्य");
	header('Content-type: application/json');
	echo json_encode($json);
}


function selectOldHouseDetailsById()
{//username
	date_default_timezone_set("Asia/Kolkata") ;
	$obj=new functions();
	$ward_number=$_REQUEST['ward_number'];
	$house_number=$_REQUEST['house_number'];
	$username=$_REQUEST['username'];
	$sql="SELECT * FROM users WHERE username='".$username."'";
	$users_details=$obj->data_select($sql);
	$sql="SELECT * FROM old_house_details WHERE house_number='".$house_number."' AND ward_number='".$ward_number."' AND mohalla_name='".$users_details[0]['mohalla']."' AND city='".$users_details[0]['city']."'";
	$res_details=$obj->data_select($sql);
	if($res_details=='no')
	{
		$json['api_status']="Error";
	}
	else
	{
		$json['api_status']="OK";
		$json['owner_name']=$res_details[0]['owner_name'];
		$json['father_name']=$res_details[0]['father_name'];
	}
	header('Content-type: application/json');
	echo json_encode($json);
}




?>

