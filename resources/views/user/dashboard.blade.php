<x-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <!-- Profile Section -->
        <div class="flex items-center space-x-4">
            <img class="w-20 h-20 rounded-full" src="{{asset('upload/'.$user->avatar)}}" alt="{{ $user->first_name }}">
            <div>
                <div class="flex items-center gap-5">
                    <h2 class="text-xl font-semibold">{{ $user->first_name }} {{$user->last_name}}</h2>
                    <span class="text-slate-400 select-none">Joined at: {{$user->created_at->toDateString()}}</span>
                </div>
                <p class="text-gray-600">&#x2772;{{ $user->bio }}&#x2773;</p>
            </div>
        </div>
        
        <!-- Blog List -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Blogs</h3>
            <ul class="mt-2 space-y-4">
                @foreach($user->blogs as $blog)
                <li class="p-4 bg-gray-100 rounded-lg shadow flex items-center space-x-4">
                    <img class="w-24 h-24 object-cover rounded" src="{{asset('upload/'.$blog->blog_image) }}" alt="{{ $blog->blog_title }}">
                    <div class="break-words">
                        <h4 class="text-lg font-bold"> <a class="hover:text-blue-500" href="{{route('blog',[$blog->id])}}">{{ $blog->blog_title }}</a></h4>
                        <p class="text-gray-600 break-words">{{ Str::limit($blog->blog_content,70 ) }}</p>
                        <a href="{{route('blog',[$blog->id])}}" class="text-blue-500">Read more</a>
                    </div>
                </li>
                    
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>