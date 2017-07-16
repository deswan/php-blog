<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title','text','short','draft'];
    function categories(){
        return $this->belongsToMany('App\\Category');
    }
}
