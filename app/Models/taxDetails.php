<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class taxDetails extends Model
{
	protected $table="tax_details";
	protected $primaryKey='personal_details_id';
	//public $timestamps=false;
	protected $guarded = [];

}

?>