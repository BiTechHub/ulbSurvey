<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashDetails extends Model
{
    protected $table='cash_details';
	protected $primaryKey='cash_id';
	protected $guarded = [];
}
