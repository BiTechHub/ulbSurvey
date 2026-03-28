<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $table='payment_logs';
	protected $primaryKey='pay_id';
	protected $guarded = [];
}
