<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $table = 'statistics';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id','daili_id','ip','coming_url','area','created_at'];
}
