<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class AndroidAppController extends Controller
{
    
    public function CheckUpdate(Request $request)
	{
		$imei=$request->get('imei');
		$manufacturer=$request->get('manufacturer');
		$model=$request->get('model');
		$brand=$request->get('brand');
		$sim_operator=$request->get('sim_operator');
		$software_version=$request->get('software_version');
		$subscriberId=$request->get('subscriberId');
		$sim_no=$request->get('sim_no');
		$sim_serial_number=$request->get('sim_serial_number');
		$oper_name=$request->get('oper_name');
		$reg=$request->get('reg');
		$unit_no=DB::table('unit_no')->where('imei',$imei)->first();
		$arrayData=array(
			'imei'=>$imei,
			'firebaseId'=>$reg,
			'manufacturer'=>$manufacturer,
			'model'=>$model,
			'brand'=>$brand,
			'software_version'=>$software_version,
			'sim_serial_number'=>$sim_serial_number,
			'sim_operator'=>$sim_operator,
			'subscriberId'=>$subscriberId,
			'inserted_date'=>date('Y-m-d H:i:s'),
		);
		if($unit_no==null)
		{
			DB::table('unit_no')->insert($arrayData);
		}
		else
		{
			DB::table('unit_no')->where('imei',$imei)->update($arrayData);
		}
		$survey_app_setting=DB::table('survey_app_setting')->first();
		$users=DB::table('users')->where('imei',$imei)->first();
		if($survey_app_setting==null)
		{
			$response[0]['msg']="Error";
		}
		else
		{
			$response[0]['status']=$survey_app_setting->parivar_register_app_status;
			$response[0]['app_code']=$survey_app_setting->parivar_register_app_version;
			$response[0]['msg']="Your app is not active please contact service provider";
			if($users==null)
			{
				$response[0]['login_status']="ERROR";
			}
			else
			{
				$response[0]['login_status']="SUCCESS";
				$response[0]['mobile_verified']=$users->id;
				$response[0]['data']=$users->name;
				$response[0]['ward_no']=$users->ward_no;
			}
		}
		
		$json['checkUpdate']=$response;
		header('Content-type: application/json');
		echo json_encode($json);
	}

	public function Login(Request $request)
	{
		$imei=$request->get('imei');
		$mobile=$request->get('mobile');
		$password=$request->get('password');
		$users=DB::table('users')->where([['username',$mobile],['login_type','Online'],['user_type','Parivar Surveyor']])->first();
		if($users==null)
		{
			$res['status']="WRONG_USER";
			$res['msg']="Please enter correct username";
		}
		else
		{
			if($users->password==$password)
			{
				if($users->status=="In-Active")
				{
					$res['status']="WRONG_INACTIVE";
					$res['msg']="Currently no survey active on your userid";
				}
				else
				{
					DB::table('users')->where('username',$mobile)->update(array('imei'=>$imei));
					$res['status']="SUCCESS";
					$res['msg']="Login successfull";
					$res['data']=$users;
				}
			}
			else{
				$res['status']="WRONG_PASS";
				$res['msg']="Please enter correct password";
			}
			
		}
		header('Content-type: application/json');
		echo json_encode($res);
		
	}

	public function SaveParivarDetails(Request $request)
	{
		$mobile_number=$request->get('mobile_number');
		$full_name=$request->get('full_name');
		$father_name=$request->get('father_name');
		$dob=$request->get('dob');
		$aadhar=$request->get('aadhar');
		$relation=$request->get('relation');
		$business=$request->get('business');
		$qualification=$request->get('qualification');
		$gender=$request->get('gender');
		$abhiyukyi=$request->get('abhiyukyi');
		$HouseDetailsId=$request->get('HouseDetailsId');
		$user_id=$request->get('user_id');
		$users=DB::table('users')->where([['id',$user_id]])->first();
		if($relation=="मुखिया")
		{
			$family_members=DB::table('family_members')->where([['house_id',$HouseDetailsId],['relation','मुखिया']])->first();
			if($family_members==null)
			{
				$data=array(
					'house_id'=>$HouseDetailsId,
					'father_husband'=>$father_name,
					'member_name'=>$full_name,
					'relation'=>$relation,
					'gender'=>$gender,
					'age'=>$dob,
					'vyvasay'=>$business,
					'education'=>$qualification,
					'aadhar_num'=>$aadhar,
					'abhiyukti'=>$abhiyukyi,
					'nagarpalika'=>$users->city,
					'inerted_by'=>$user_id,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')
				);
				DB::table('family_members')->insert($data);
				echo "परिवार के सदस्य को सफलतापूर्वक सम्मिलित किया गया";
				
			}
			else
			{
				echo "घर मे मुखिया पहिले से पंजीकृत है।";
			}
		}
		else
		{
			$data=array(
				'house_id'=>$HouseDetailsId,
				'father_husband'=>$father_name,
				'member_name'=>$full_name,
				'relation'=>$relation,
				'gender'=>$gender,
				'age'=>$dob,
				'vyvasay'=>$business,
				'education'=>$qualification,
				'aadhar_num'=>$aadhar,
				'abhiyukti'=>$abhiyukyi,
				'nagarpalika'=>$users->city,
				'inerted_by'=>$user_id,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s')
			);
			DB::table('family_members')->insert($data);
			echo "परिवार के सदस्य को सफलतापूर्वक सम्मिलित किया गया";
		}
		DB::table('survey_step_1')->where('id',$HouseDetailsId)->update(array('created_at'=>date('Y-m-d H:i:s')));
		DB::table('survey_personal_details')->where('survey_id',$HouseDetailsId)->update(array('mobile_number'=>$mobile_number));
	}

	public function SearchHouseDetails(Request $request)
	{
		$json=array();
		$house_number=$request->get('house_number');
		$user_id=$request->get('user_id');
		$users=DB::table('users')->where('id',$user_id)->first();
		$survey_personal_details=DB::table('survey_personal_details')
				->join('house_details','survey_personal_details.survey_id','=','house_details.personal_details_id')
				->where([['survey_personal_details.house_number',$house_number],['survey_personal_details.city',$users->city],['survey_personal_details.ward_number',$users->ward_no]])->first();
		if($survey_personal_details==null)
		{
			$json['status']="ERROR";
		}
		else
		{
			$json['status']="SUCCESS";
			$json['data']=$survey_personal_details;
		}
		
		header('Content-type: application/json');
		echo json_encode($json);
		
	}

	public function selectHouseDetailsHindi()
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
		$json['Relation']=array("संबंध चुनें","मुखिया", "पिता","माता","पुत्र","भाई","भाभी","बहन","बहू","पुत्री","पति","पत्नी","पोता","पोती","नाती","नतिनी","भतीजा","भतीजी","अन्य");
		$json['Gendor']=array("लिंग चुनें","पुरुष", "महिला","अन्य");
		$json['Qualification']=array("योग्यता का चयन करें","अनपढ़","5 वीं","8 वीं","10 वीं", "12 वीं","स्नातक","स्नातकोत्तर","पॉलिटेक्निक","आई0 टी0 आई0","अन्य");
		$json['Business']=array("व्यवसाय का चयन करें","अन्य");
		header('Content-type: application/json');
		echo json_encode($json);
	}

	public function ShowFamilyData($id)
	{
		$users=DB::table('users')->where('id',$id)->first();
		$family_members=DB::table('family_members')->where([[DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"),date('Y-m-d')],['inerted_by',$id]])->get();
		return view('android_show_family_data')->with('family_members',$family_members);
	}

	public function SearchHouseDetailsList(Request $request)
	{
		$id=$request->get('user_id');
		$users=DB::table('users')->where([['id',$id]])->first();
		$survey_step_1=DB::table('survey_step_1')
									->select('survey_step_1.*','family_members.house_id','family_members.member_name')
									->leftjoin('family_members','survey_step_1.id','=','family_members.house_id')
									->where([
											['survey_step_1.city',$users->city],
											['survey_step_1.ward_number',$users->ward_no],
											/*['family_members.relation','मुखिया'],*/
										
										])
									->groupby('survey_step_1.house_number')
									->orderby('survey_step_1.house_number','ASC')
									->get();
		if($survey_step_1==null)
		{
			$json['status']="ERROR";
		}
		else
		{
			$json['status']="SUCCESS";
			$json['data']=$survey_step_1;
		}
		header('Content-type: application/json');
		echo json_encode($json);
	}

	

}
