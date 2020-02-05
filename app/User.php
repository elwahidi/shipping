<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function postsCreated()
    {
        return $this->hasMany('App\Post','created_by');
    }

    public function postsPublished()
    {
        return $this->hasMany('App\Post','published_by');
    }

    public function offersCreated()
    {
        return $this->hasMany('App\Offer','created_by');
    }

    public function offersPublished()
    {
        return $this->hasMany('App\Offer','published_by');
    }

}
