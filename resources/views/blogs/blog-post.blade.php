<x-layout>

    @foreach ($blogs as $blog )
            <!-- Post -->
    <x-post class="post">
        <header>
            <div class="title">
                <h2><a href="/blogs/{{$blog->id}}">{{$blog->blog_title}}</a></h2>
                <p>Lorem ipsum dolor amet nullam consequat etiam feugiat</p>
            </div>
            <div class="meta">
                <time class="published" datetime="2015-11-01">{{$blog->created_at}}</time>
                <a href="#" class="author"><span class="name">{{$blog->user->first_name}} {{$blog->user->last_name}}</span><img src="images/avatar.jpg" alt="" /></a>
            </div>
        </header>
        <a href="/blogs/id" class="image featured"><img src="images/pic01.jpg" alt="" /></a>
        <p>{{$blog->blog_content}}</p>
        <footer>
            <ul class="actions">
                <li><a href="/blogs/{{$blog->id}}" class="button large">Continue Reading</a></li>
            </ul>
            <ul class="stats">
                <li><a href="#">General</a></li>
                <li><a href="#" class="icon solid fa-heart">{{$blog->blog_saved_count}}</a></li>
                <li><a href="#" class="icon solid fa-comment">128</a></li>
            </ul>
        </footer>
    </x-post>
    @endforeach

</x-layout>
        