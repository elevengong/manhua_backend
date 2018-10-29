<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Manhua extends Model
{
    protected $table = 'manhua';
    protected $primaryKey = 'manhua_id';

    protected $fillable = ['manhua_id','cid','name','author','cover','intro','views','status','finish','last_update_time','created_at','updated_at'];
}
