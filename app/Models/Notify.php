<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;

    protected $table = "notifies";

    protected $fillable = ['blog_id','sender_id','receiver_id','comment_id','seen'];

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function blog(){
        return $this->belongsTo(Blog::class);
    }
}
