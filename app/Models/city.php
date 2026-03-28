<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
	protected $table="states_cities";
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded = [];

}

?>