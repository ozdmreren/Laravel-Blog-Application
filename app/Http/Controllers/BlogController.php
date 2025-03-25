<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Notify;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function home(){
        $blogs = Blog::with(['user','comments'])->paginate(4);
        $notifies = Notify::all();

        //dd(auth()->user()->notifies);
        return view('home',[
            'blogs'=>$blogs
        ]);
    }

    public function write(){
        return view('blogs.blog-create');
    }

    public function search(Request $request){
        $query = $request->input('q');
        $blogs = Blog::where('blog_title', 'LIKE', "%{$query}%")->get(['id','blog_title']);
        return response()->json($blogs);
    }
    
    public function store(){

         request()->validate([
             'blog_title'=>['required','min:10'],
             'sub_blog_title'=>['required','max:60','min:20'],
             'blog_image'=>['required'],
             'blog_content'=>['required','min:150'],
         ]);

         $path = request()->file('blog_image')->move(public_path('upload'),request()->file('blog_image')->getClientOriginalName());

         $blog = Blog::create([
             'blog_title'=>request('blog_title'),
             'sub_blog_title'=>request('sub_blog_title'),
             'blog_image'=>request()->file('blog_image')->getClientOriginalName(),
             'blog_content'=> request('blog_content'),
             'user_id'=>auth()->user()->id
         ]);

         return redirect('/',)->with('success','The blog successfully created !');
    }

    public function show(Blog $blog){
        return view('blogs.single-blog',[
            'blog'=>$blog
        ]);
    }

    public function edit(Blog $blog){
        return view('blogs.blog-edit',[
            'blog'=>$blog
        ]);
    }

    public function update(Blog $blog){
        request()->validate([
            'blog_title'=>['required','min:10'],
            'blog_image'=>['required'],
            'blog_content'=>['required'],
        ]);

        $blog->update([
            'blog_title'=>request('blog_title'),
            'blog_image'=>request()->file('blog_image')->getClientOriginalName(),
            'blog_content'=>request('blog_content'),
        ]);

        return redirect('/blogs/'.$blog->id);
    }

    public function delete(Blog $blog){
        $blog->delete();

        return redirect('/');
    }

}
