<?php
namespace App\library;

use DB;

class DistanceCalculate
{
	public function GetNearByHouse($lat,$lng,$range,$data_size,$city)
	{
		if($city=="null")
		{
			$city="";
		}
		$result=DB::table('survey_step_1')
						->select(DB::raw('ROUND((SQRT(('.$lat.' - survey_step_1.lat) * ('.$lat.' - survey_step_1.lat) + ('.$lng.' - survey_step_1.lng) * ('.$lng.' - survey_step_1.lng))*160934.4),2) AS distance'),'survey_step_1.*','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number')
						->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
						->havingRaw('distance < '.$range)
						->where('survey_step_1.city','LIKE','%'.$city.'%')
						->orderby('distance','DESC')
						->take($data_size)
						->get();
		//dd($result);
		return $result;
	}

	public function GetNearByAssets($lat,$lng,$range,$data_size,$city)
	{
		if($city=="null")
		{
			$city="";
		}
		$result=DB::table('assets_details')
						->select(DB::raw('ROUND((SQRT(('.$lat.' - assets_details.lat) * ('.$lat.' - assets_details.lat) + ('.$lng.' - assets_details.lng) * ('.$lng.' - assets_details.lng))*160934.4),2) AS distance'),'assets_details.*')
						->havingRaw('distance < '.$range)
						->where('city','LIKE','%'.$city.'%')
						->orderby('distance','DESC')
						->take($data_size)
						->get();
		//dd($result);
		return $result;
	}

	public function SearchProperty($lat,$lng,$range,$data_size,$city,$WardNumber,$Keyword,$SearchType)
	{
		if($city=="null")
		{
			$city="";
		}
		if($WardNumber=="0" || $WardNumber=="" )
		{
			if($SearchType=="" || $SearchType==null)
			{
				$result=DB::table('survey_step_1')
							->select(DB::raw('ROUND((SQRT(('.$lat.' - survey_step_1.lat) * ('.$lat.' - survey_step_1.lat) + ('.$lng.' - survey_step_1.lng) * ('.$lng.' - survey_step_1.lng))*160934.4),2) AS distance'),'survey_step_1.*','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number')
							->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
							->where([
								['survey_step_1.city','LIKE','%'.$city.'%'],
							])
							->orderby('distance','DESC')
							->take($data_size)
							->get();
			}
			else
			{
				if($SearchType=="name")
				{
					$result=DB::table('survey_step_1')
							->select(DB::raw('ROUND((SQRT(('.$lat.' - survey_step_1.lat) * ('.$lat.' - survey_step_1.lat) + ('.$lng.' - survey_step_1.lng) * ('.$lng.' - survey_step_1.lng))*160934.4),2) AS distance'),'survey_step_1.*','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number')
							->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
							->where([
								['survey_step_1.city','LIKE','%'.$city.'%'],
								['survey_personal_details.'.$SearchType,'LIKE','%'.$Keyword.'%']
							])
							->orderby('distance','DESC')
							->take($data_size)
							->get();
				}
				else
				{
					$result=DB::table('survey_step_1')
							->select(DB::raw('ROUND((SQRT(('.$lat.' - survey_step_1.lat) * ('.$lat.' - survey_step_1.lat) + ('.$lng.' - survey_step_1.lng) * ('.$lng.' - survey_step_1.lng))*160934.4),2) AS distance'),'survey_step_1.*','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number')
							->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
							->where([
								['survey_step_1.city','LIKE','%'.$city.'%'],
								['survey_personal_details.'.$SearchType,$Keyword]
							])
							->orderby('distance','DESC')
							->take($data_size)
							->get();
				}
			}
		}
		else
		{
			if($SearchType=="" || $SearchType==null)
			{
				$result=DB::table('survey_step_1')
							->select(DB::raw('ROUND((SQRT(('.$lat.' - survey_step_1.lat) * ('.$lat.' - survey_step_1.lat) + ('.$lng.' - survey_step_1.lng) * ('.$lng.' - survey_step_1.lng))*160934.4),2) AS distance'),'survey_step_1.*','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number')
							->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
							->where([
								['survey_step_1.city','LIKE','%'.$city.'%'],
								['survey_step_1.ward_number',$WardNumber],
							])
							->orderby('distance','DESC')
							->take($data_size)
							->get();
			}
			else
			{
				if($SearchType=="name")
				{
					$result=DB::table('survey_step_1')
							->select(DB::raw('ROUND((SQRT(('.$lat.' - survey_step_1.lat) * ('.$lat.' - survey_step_1.lat) + ('.$lng.' - survey_step_1.lng) * ('.$lng.' - survey_step_1.lng))*160934.4),2) AS distance'),'survey_step_1.*','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number')
							->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
							->where([
								['survey_step_1.city','LIKE','%'.$city.'%'],
								['survey_step_1.ward_number',$WardNumber],
								['survey_personal_details.'.$SearchType,'LIKE','%'.$Keyword.'%']
							])
							->orderby('distance','DESC')
							->take($data_size)
							->get();
				}
				else
				{
					$result=DB::table('survey_step_1')
							->select(DB::raw('ROUND((SQRT(('.$lat.' - survey_step_1.lat) * ('.$lat.' - survey_step_1.lat) + ('.$lng.' - survey_step_1.lng) * ('.$lng.' - survey_step_1.lng))*160934.4),2) AS distance'),'survey_step_1.*','survey_personal_details.name','survey_personal_details.father_name','survey_personal_details.mobile_number')
							->join('survey_personal_details','survey_step_1.id','=','survey_personal_details.survey_id')
							->where([
								['survey_step_1.city','LIKE','%'.$city.'%'],
								['survey_step_1.ward_number',$WardNumber],
								['survey_personal_details.'.$SearchType,$Keyword]
							])
							->orderby('distance','DESC')
							->take($data_size)
							->get();
				}
			}
		}
		
		//dd($result);
		return $result;
	}

}

?>
