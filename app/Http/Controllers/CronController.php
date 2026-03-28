<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CronController extends Controller
{
    public function RunCronEveryHour()
    {
    	$this->UpdatePersonalBackData();
    	$this->UpdatePersonalHouseBackData();
    }

    private function UpdatePersonalBackData()
    {
    	$start=date('Y-m-d H:i:s');
    	$data=DB::table('survey_step_1')
    		->select('survey_step_1.id')
    		->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
    		->where([
    			['survey_step_1.status','Pending'],
    			['survey_personal_details.status','Completed'],
    		])
    		->whereNotNull('survey_personal_details.name')
    		->get();
    	//dd($data);
    	if(sizeof($data)>0)
    	{
    		foreach($data as $value)
	    	{
	    		DB::table('survey_step_1')->where('id',$value->id)->update(array('status'=>'Completed'));
	    		DB::table('survey_step_1')->where('id',$value->id)->update(array('status'=>'Completed'));
	    	}
    	}
    	$end=date('Y-m-d H:i:s');
    	$log_data=array(
    		'start'=>$start,
    		'end'=>$end
    	);
    	DB::table('cron')->insert($log_data);
    	//dd($data);
    }

    private function UpdatePersonalHouseBackData()
    {
    	$start=date('Y-m-d H:i:s');
    	$data=DB::table('survey_step_1')
    		->select('survey_step_1.id','survey_step_1.house_number','survey_personal_details.name')
    		->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
    		->where([
    			['survey_personal_details.status','Pending'],
    		])
    		->whereNotNull('survey_personal_details.name')
    		->get();
    	//dd($data);
    	if(sizeof($data)>0)
    	{
    		foreach($data as $value)
	    	{
	    		DB::table('survey_step_1')->where('id',$value->id)->update(array('status'=>'Completed'));
	    		DB::table('survey_personal_details')->where('survey_id',$value->id)->update(array('status'=>'Completed'));
	    		DB::table('house_details')->where('personal_details_id',$value->id)->update(array('status'=>'Completed'));
	    	}
    	}
    	$end=date('Y-m-d H:i:s');
    	$log_data=array(
    		'start'=>$start,
    		'end'=>$end
    	);
    	DB::table('cron')->insert($log_data);
    	//dd($data);
    }
}
