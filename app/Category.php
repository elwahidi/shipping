<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['title','description'];
    protected $primaryKey = 'Uuid';
    public function posts(){
        return $this->belongsToMany('App\Post', 'post_category', 'category_Uuid', 'post_Uuid');
    }
}
