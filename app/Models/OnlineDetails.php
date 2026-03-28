<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineDetails extends Model
{
    protected $table='online_payment_details';
	protected $primaryKey='online_id';
	protected $guarded = [];
}
