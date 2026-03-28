<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class discount extends Model
{
	protected $table="tax_discount";
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded = [];

}

?>