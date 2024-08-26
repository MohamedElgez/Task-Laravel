<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\CommentNotification;
use Request;

class Comment extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    public function store(Request $request)
    {
        $comment = Comment::create($request->all());

        $postAuthor = $comment->post->user; // Assuming relationship setup
        $postAuthor->notify(new CommentNotification($comment));

        return redirect()->back();
    }

}
