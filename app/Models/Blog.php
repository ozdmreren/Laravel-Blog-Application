<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = "blogs";
    protected $fillable = ["blog_title","sub_blog_title","blog_image","blog_content","blog_saved_count","user_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function savedByUsers(){
        return $this->belongsToMany(User::class,'saved_blogs');
    }
}
