<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
        public function user() {
        return $this->belongsTo(User::class);
    }
     public function comments() {
        return $this->hasmany(Comment::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    //  public function likes() {
    //     return $this->hasmany(Like::class);
    // }
}
