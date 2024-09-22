<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //A post has an author (user)
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    //Defining the relation between the categories and posts
    public function categories()
    {
      return $this->belongsToMany('\App\Category', 'categories_posts');
    }
}
