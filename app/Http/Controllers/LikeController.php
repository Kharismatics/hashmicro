<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Like;
use App\Models\Post;
  
class LikeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required',
        ]);
        $store = Like::create($request->all());
        return Post::find($store->post_id)->getTotalLikes();       
    }
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Like::find($request->input('id'))->delete();
        }
        return Post::find($request->input('id'))->getTotalLikes(); 
    }
}