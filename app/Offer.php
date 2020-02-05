<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';
    protected $fillable = ['title','text','created_by','is_published','published_by','activity_id'];

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function publishedBy()
    {
        return $this->belongsTo('App\User','published_by');
    }

    public function activity()
    {
        return $this->belongsTo('App\Activity','activity_id');
    }

}
