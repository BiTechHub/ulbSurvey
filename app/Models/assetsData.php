<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assetsData extends Model
{
	protected $table="assets_details";
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded = [];

}

?>