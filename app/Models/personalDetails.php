<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personalDetails extends Model
{
	protected $table="survey_personal_details";
	//protected $primaryKey='survey_id';
	public $timestamps=false;
	protected $guarded = [];

}

?>