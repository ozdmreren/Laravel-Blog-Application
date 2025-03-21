<x-layout>
    <!-- Wrapper -->
    <div id="wrapper" class="bg-gray-100 min-h-screen flex justify-center px-4 sm:px-6 lg:px-8">

        <!-- Main -->
        <div id="main" class="max-w-3xl w-full py-8">
            
            <!-- Blog Posts -->
            <div class="space-y-10">
				@if ($blogs->count() != 0)
				@foreach ($blogs as $blog)
				<!-- Post -->
				<article class="post bg-white p-6 rounded-lg shadow-md">
					<header class="mb-4">
						<h2 class="text-2xl font-bold text-gray-800 hover:text-blue-600">
							<a href="/blogs/{{$blog->id}}">{{$blog->blog_title}}</a>
						</h2>
						<p class="text-gray-500">{{$blog->sub_blog_title}}</p>
						<div class="meta flex items-center mt-2 text-sm text-gray-400">
							<time class="published">{{$blog->created_at->toDateString()}}</time>
							<span class="mx-2">•</span>
							<a href="#" class="flex items-center space-x-2">
								<img src="{{asset('upload/'.$blog->user->avatar)}}" alt="" class="w-6 h-6 rounded-full">
								<span class="text-gray-600 "><a class="hover:text-gray-900" href="/profile/{{$blog->user->id}}">{{$blog->user->first_name}} {{$blog->user->last_name}}</a></span>
							</a>
						</div>
					</header>
					<a href="/blogs/{{$blog->id}}" class="block">
						<img src="{{asset('upload/'.$blog->blog_image)}}" alt="" class="w-full h-64 object-cover rounded-lg">
					</a>
					<p class="text-gray-700 mt-4 break-words">{{textclip($blog->blog_content)}}</p>
					<footer class="mt-4 flex justify-between items-center">
						<a href="/blogs/{{$blog->id}}" class="text-blue-500 hover:underline">Continue Reading</a>
						<div class="flex space-x-4 text-gray-500">
							@php
							if(auth()->user()){
								$isSaved = auth()->user()->savedBlogs()->where("blog_id",$blog->id)->exists();
							}else{
								$isSaved = false;
							}

							@endphp
							<form action="/save/{{$blog->id}}" method="POST">
								@csrf
								<button type="submit">
									<span class="flex cursor-pointer ">
										<img class="{{$isSaved ? "bg-black rounded-md":""}}" src="{{$isSaved ? asset('svgs/bookmark_saved.svg') : asset('svgs/bookmark_unsaved.svg') }}" alt="">
									</span>
								</button>
							</form>
							<span class="flex"><img src="{{asset('svgs/comment.svg')}}" alt="">{{count($blog->comments)}}</span>
						</div>
					</footer>
				</article>
				@endforeach

				@else
				<div class="text-center text-gray-500 text-lg">
					<p>📭 Bu sayfada hiç blog yoktur.</p>
				</div>
				@endif

            </div>
			<div class="mt-3">
				{{$blogs->links()}}
			</div>
        </div>
    </div>
</x-layout>
