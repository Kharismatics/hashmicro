<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\User;
  
class PostController extends Controller
{
    public function home(Request $request)
    {
        $data = Post::with(['user']);
        if ($request->input('user_id')) {
            $data = $data->where('created_by', auth()->user()->id);
        }
        $data = $data->orderBy('id','desc');
        $data = $data->get();
        for ($i=0; $i < count($data) ; $i++) { 
            $data[$i]["likes"]=Post::find($data[$i]["id"])->getTotalLikes();
            $data[$i]["comments"]=Post::find($data[$i]["id"])->getTotalComments();
        }
        return Inertia::render('Home', ['Postdata' => $data]);
    }
    public function index() // not used
    {
        $data = Post::all();
        return Inertia::render('posts/index', ['data' => $data]);
    }
    public function create(Request $request)
    {
        $user = auth()->user();
        if($user->hasTeamPermission($user->currentTeam, 'server:create'))
            return Inertia::render('post/create', [
                'formTitle'=>'Create',
                'defaultItem' => [
                    'title'=> $request->old('title'),
                    'caption'=> $request->old('caption'),
                ]
            ]); 
        else 
            return redirect()->back()->with('message', 'Unauthorized');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'caption' => 'required'
        ]);
        $row = Post::create($request->all());
        if ($request->hasFile('singlefile')) {
            $path = $request->file('singlefile');
            $path->storePublicly('public/files'); // store file to storage/app/public/files
            Post::find($row->id)->update(["image"=>$path->hashName()]);
        }
        return redirect()->route('home')->with('message', 'Data Created Successfully.');
    }
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Post::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}