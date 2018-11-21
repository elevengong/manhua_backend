<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Paymentaccount extends Model
{
    protected $table = 'paymentaccount';
    protected $primaryKey = 'account_id';
    public $timestamps = false;
}
