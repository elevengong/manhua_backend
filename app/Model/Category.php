<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cid';
    //public $timestamps = '';

    protected $fillable = ['cid','c_name','parents_id','url','priority','status','created_at','updated_at'];
}
