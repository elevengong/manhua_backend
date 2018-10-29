<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManhuaChapter extends Model
{
    protected $table = 'manhuachapters';
    protected $primaryKey = 'chapter_id';

    protected $fillable = ['chapter_id','manhua_id','chapter_name','chapter_cover','status','vip','next_chapter_id','pre_chapter_id','views','priority','coin','created_at','updated_at'];
}
