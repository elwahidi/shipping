<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['categories','createdBy','publishedBy'])->orderBy('Uuid','desc')->get();
        return response()->json($posts);
    }

    /**
     * Store a new post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request['created_by'] = auth()->user()->id;
        $data = $this->validate($request,[
            'title'=>'required|max:255',
            'text'=>'required|max:50000',
            'created_by'=>'required|exists:users,id',
            'img'=>'nullable|mimes:jpeg,bmp,png,jpg',
        ]);
        $data['created_by'] = auth()->user()->id;
        $data['is_published'] = 0;
        $data['published_by'] = null;

        if($request->hasFile('img')){
            $data['img'] = $request->file('img')->store('images');
        }

        $post = Post::create($data);

        $post->categories()->attach($request->categories);
        return response()->json(['post'=>$post,'categories'=>$request->categories]);
    }

    /**
     * Remove the specified post.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
         $post->categories()->detach();
         $e = $post->delete();
        return response()->json($e);
    }

    public function publish($id)
    {
        $post = Post::where('Uuid',$id)->first();
        $post->is_published = true;
        $post->published_by = auth()->user()->id;
        if($post->update()){
            return response()->json(true);
        }
    }

    public function edit($id)
    {
        $post = Post::with('categories')->where('Uuid',$id)->first();
        return response()->json($post);
    }

    public function update(Request $request)
    {
        $data = $this->validate($request,[
            'title'=>'required|max:255',
            'text'=>'required|max:50000',
            'img'=>'mimes:jpeg,bmp,png,jpg',
        ]);
        $post = Post::where('Uuid',$request->id)->first();
        $post->title = $request->title;
        $post->text = $request->text;
        if($request->hasFile('img')){
            unlink(public_path('storage/'.$post->img));
            $post->img = $request->file('img')->store('images');
        }
        $post->update();
        $post->categories()->sync($request->categories);
        return response()->json('update-success');
    }
}
