
<x-layout>
    <div id="library-section" class= "bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Saved Blogs</h2>
    
        <!-- Blog Listesi -->
        <div class="space-y-4">
            @foreach($savedBlogs as $blog)
            <div class="flex items-center border-b pb-4">
                <!-- Blog Metni -->
                <div class="w-2/3">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <a href="/blogs/{{$blog->id}}" class="hover:text-blue-500 transition">
                            {{$blog->blog_title}}
                        </a>
                    </h3>
                    <p class="text-gray-600 text-sm truncate">{{$blog->blog_content}}</p>
                </div>
    
                <!-- Blog Fotoğrafı -->
                <div class="w-1/2 flex justify-end">
                    <img src="{{ asset('upload/'.$blog->blog_image) }}" alt="Blog Image" class="w-24 h-24 object-cover rounded-lg">
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script>
        function showLibrary() {
            document.getElementById("library-section").classList.toggle("hidden");
        }
    </script>
    
</x-layout>