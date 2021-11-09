<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table ='posts';
    protected $fillable=['title_en','title_ar','body_en','body_ar','created_at','updated_at'];
    protected $hidden=[];
    public $timestamps=true;
}
