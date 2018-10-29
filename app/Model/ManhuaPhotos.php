<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManhuaPhotos extends Model
{
    protected $table = 'manhuaphotos';
    protected $primaryKey = 'p_id';
    public $timestamps = false;

    protected $fillable = ['p_id','chapter_id','photo','priority','status'];
}
