<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Comment;
use App\Models\Post;
  
class CommentController extends Controller
{
    public function index(Post $post, Request $request)
    {
        $data = Comment::where('post_id', $post->id)->with(['user']);
        $data = $data->orderBy('id');
        $data = $data->get();
        return Inertia::render('comment/index', [
            'pageTitle'=>'Files',
            'Commentdata' => $data,
            'defaultItem'=>['post'=>$post,'comment'=>$request->old('comment')]
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'comment' => 'required',
        ]);
        $store = Comment::create($request->all());
        return redirect()->back();     
    }
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Comment::find($request->input('id'))->delete();
        }
        return redirect()->back();
    }
}