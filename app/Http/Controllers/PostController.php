<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{


    public function index()
    {
        $posts = Post::all();
    return view('posts.index', compact('posts'));
    }



    public function create()
    {
        return view('posts.create', []);
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);

    Post::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('posts.index');
}

    public function show($id)
    {
        //
    }


    public function edit(Post $post)
{
    $this->authorize('update', $post);
    return view('posts.edit', compact('post'));
}




public function update(Request $request, Post $post)
{
    $this->authorize('update', $post);

    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);

    $post->update($request->only('title', 'content'));

    return redirect()->route('posts.index');
}




    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index');

}
}
