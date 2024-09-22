<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Defining the relation between them
    public function posts()
    {
      return $this->belongsToMany('\App\Post', 'categories_posts');
    }
}
