<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\SavedBlog;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function add_comment(Blog $blog){

        Comment::create([
            'user_id'=>auth()->user()->id,
            'blog_id'=>$blog->id,
            'comment'=>request('comment')
        ]);

        return redirect('/blogs/'.$blog->id);
    } 

    public function saveBlog(Blog $blog){
        $isExist = auth()->user()->savedBlogs()->where('blog_id',$blog->id)->exists();
        if($isExist){
            auth()->user()->savedBlogs()->detach($blog->id);

            return redirect('/');
        }
        else{
            SavedBlog::create([
                'user_id'=>auth()->user()->id,
                'blog_id'=>$blog->id,
            ]);

            return redirect('/blogs/'.$blog->id);
        }
    }

    public function editProfile(User $user){
        return view('auth.edit-profile',[
            'user'=>$user
        ]);
    }

    public function editSecurity(User $user){
        return view('auth.security-password',[
            'user'=>$user
        ]);
    }

    public function updateProfile(User $user){

            request()->validate([
                'first_name'=>['required','max:255'],
                'last_name'=>['required','max:255'],
                'bio'=>['required','max:255']
            ]);


         $user->update([
            'first_name'=>request('first_name'),
            'last_name'=>request('last_name'),
            'bio'=>request('bio'),
        ]);

        return redirect('/profile/'.$user->id);

    }

    public function updateSecurityEmail(User $user){
        
        if(request('email') == $user->email){
            return redirect('/profile/'.$user->id.'/security');
        }

        request()->validate([
            'email'=>['required','email','max:255','unique:users']
        ]);

        $user->update([
            'email'=>request('email')
        ]);

        return redirect('/profile/'.$user->id);

    }

    public function updateSecurityPassword(User $user){

        if(!Hash::check(request('old-password'),$user->password)){
            return redirect()->back()->withErrors([
                'old-password'=>'Your old password is not correct'
            ]);
        }

        request()->validate([
            'password'=>['required',Password::min(6)]
        ]);

        if(request('password') != request('password_confirmation')){
            return redirect()->back()->withErrors([
                'password'=>'The password confirmation does not match.',
            ]);
        }

        $user->update([
            'password'=>Hash::make(request('password'))
        ]);

        return redirect('/profile/'.$user->id);
    }

    public function updateAvatar(User $user){

        request()->file('avatar')->move(public_path('upload/'),request()->file('avatar')->getClientOriginalName());

        $user->update([
            'avatar'=>request()->file('avatar')->getClientOriginalName()
        ]);

        return redirect('/profile/'.$user->id);
    }

    public function deleteComment(Comment $comment){
        $comment->delete();

        return back();
    }

    public function showLib(User $user){
        $blogs = $user->savedBlogs;

        return view('mylib',[
            'savedBlogs'=>$blogs
        ]);
    }

    public function showStories(User $user){
        $comments = $user->comments;
        return view('user.stories',[
            'comments'=>$comments
        ]);
    }

    public function dashboard(User $user){

        return view('user.dashboard',[
            'user'=>$user
        ]);
    }
}
