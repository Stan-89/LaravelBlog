<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    //For authentication
    use Authenticatable;

    //Relation to posts: a user can have many posts, so hasMany
    public function posts()
    {
      return $this->hasMany('App\Post');
    }
}
