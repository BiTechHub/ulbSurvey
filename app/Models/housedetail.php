<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class housedetail extends Model
{
	protected $table="house_details";
	protected $primaryKey='personal_details_id';
	public $timestamps=false;
	protected $guarded = [];

}

?>