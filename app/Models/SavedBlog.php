<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedBlog extends Model
{
    use HasFactory;

    protected $table = "saved_blogs";

    protected $fillable = ["blog_id","user_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function blogs(){
        return $this->hasMany(Blog::class);
    }
}
