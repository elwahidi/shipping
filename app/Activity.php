<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    protected $fillable = ['title','description'];

    public function offers()
    {
        return $this->hasMany('App\Offer','activity_id');
    }
}
