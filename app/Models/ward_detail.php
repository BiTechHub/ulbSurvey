<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ward_detail extends Model
{
	protected $table="ward_details";
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded = [];

}

?>