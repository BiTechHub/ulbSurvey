<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assts extends Model
{
	protected $table="assets";
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded = [];

}

?>