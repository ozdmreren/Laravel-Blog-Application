@vite(['resources/css/app.css'])

<x-layout>
    <x-post>
        <!-- Blog Başlığı ve Meta Bilgileri -->
        <header class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-800">
                <a href="/blogs/{{$blog->id}}">{{$blog->blog_title}}</a>
            </h2>
            <p class="text-gray-500 mt-2">{{$blog->sub_blog_title}}</p>
            <time class="text-gray-600 text-sm select-none">This blog created at: {{$blog->created_at->toDateString()}}</time>
            <div class="flex items-center justify-center space-x-4 mt-4">
                <a href="#" class="flex items-center space-x-2">
                    <img src="{{asset('upload/'.$blog->user->avatar)}}" class="w-12 h-12 rounded-full border" alt="User Avatar">
                    <span class="text-gray-700 font-semibold"><a href="/profile/{{$blog->user->id}}">{{$blog->user->first_name}} {{$blog->user->last_name}}</a></span>
                </a>
            </div>
        </header>

        <!-- Blog Resmi -->
        <div class="mt-6 flex justify-center">
            <img src="{{ asset('upload/'.$blog->blog_image) }}" 
                 alt="Blog Image" 
                 class="w-3/6 max-w-4xl rounded-lg shadow-md">
        </div>

        <!-- Blog İçeriği -->
        <div class="mt-6 bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
            <p class="text-gray-700 leading-relaxed break-words">{{$blog->blog_content}}</p>
        </div>

        <hr class="my-6 border-gray-300 max-w-3xl mx-auto">

        <!-- Yorum Alanı -->
        <div class="mt-5 max-w-3xl mx-auto">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">Comments</h2>
                <div class="space-y-4">
                    @foreach ($blog->comments as $comment )
                    <div class="relative p-4 border rounded-lg shadow-sm">
                      <!-- Çarpı (×) Butonu -->
                      @can('delcom',$comment)
                      <button type="button" onclick="showDeleteModal({{$comment->id}})" 
                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition">
                        &times;
                    </button>
                      @endcan

                
                      <div>
                          <div class="flex items-center space-x-2">
                            <img src="{{asset('upload/'.$comment->user->avatar)}}" alt="User Avatar" class="w-8 h-8 rounded-full">
                              <h3 class="font-semibold text-gray-700"><a href="/profile/{{$comment->user->id}}">{{$comment->user->first_name}} {{$comment->user->last_name}}</a></h3>
                              <span class="text-sm text-gray-500">{{$comment->created_at->toDateString()}}</span>
                          </div>
                          <p class="text-gray-600 mt-1">{{$comment->comment}}</a></p>
                      </div>
                  </div>
                    @endforeach
                    <div id="delete-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                      <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                          <p class="text-lg font-semibold">Bu yorumu silmek istediğinizden emin misiniz?</p>
                          <div class="mt-4 flex justify-center space-x-4">
                              <form id="delete-form" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                      Yes
                                  </button>
                                  <button type="button" onclick="hideDeleteModal()" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                                    No
                                </button>
                              </form>

                          </div>
                      </div>
                  </div>

                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2 text-gray-800">Leave a Comment</h3>
                    <form id="comment-form" action="/blogs/{{$blog->id}}" method="POST">
                      @csrf
                      <textarea id="comment-area" name="comment" class="w-full border rounded-lg p-3 text-gray-700 focus:ring focus:ring-blue-200"
                      rows="3" placeholder="Write your comment..."></textarea>
                      @auth
                      <button id="post-btn" type="submit" 
                      class="mt-3 px-6 py-2 text-white bg-gray-500 rounded-lg shadow-md border  gap-2" disabled>
                      💬 Post Comment
                   </button>
                      @endauth
                      
                      @can('edit',$blog)                        
                      
                      <button id="delete-btn" type="button" 
                      class="mt-3 mx-2 px-6 py-2 text-white bg-red-600 rounded-lg shadow-md border border-red-700 
                             hover:bg-red-700 hover:shadow-lg active:bg-red-800 transition duration-300 ease-in-out 
                             transform hover:scale-105  gap-2">
                      🗑️ Delete This Blog
                   </button>
                   

                      <a href="{{route('blog.edit',[$blog->id])}}" 
                        class="inline-block px-6 py-2 text-white bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg shadow-lg border border-blue-800 hover:from-blue-600 hover:to-blue-800 hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105">
                        ✏️ Edit Blog
                     </a>
                     
                      @endcan
                    </form>
                    <p id="success-message" class="hidden opacity-70 mt-3 text-white bg-green-500 p-3 rounded-md font-semibold">Yorum gönderildi!</p>
                  </div>
                </div>
        </div>
    </x-post>
    <div id="delete-popup" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
      
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                    <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                  </div>
                  <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">Delete this blog</h3>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">Are you sure you want to delete the blog titled "{{$blog->blog_title}}"" ?</p>
                    </div>
                  </div>
                </div>
              </div>
              <form action="{{route('blog',[$blog->id])}}" method="POST">
                @csrf
                @method('DELETE')

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button id="yes-btn" type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">Yes</button>
                    <button id="cancel-btn" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white ring-1 shadow-xs ring-gray-300  ring-inset hover:bg-green-500 sm:mt-0 sm:w-auto">No</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
    <script>
        let delete_btn = document.getElementById('delete-btn')
        if(delete_btn){
          delete_btn.addEventListener('click',delpop)
        }
        
        let cancel_btn = document.getElementById('cancel-btn')
        cancel_btn.addEventListener('click',delpop)

        let comment_form = document.getElementById('comment-form')
        comment_form.addEventListener('submit',function(event){
          event.preventDefault() // sayfanın yenilenmesini önler

          show_comment_toast()

          this.submit()
        })

        let comment_area = document.getElementById('comment-area')
        comment_area.addEventListener('input',checkComment);

        let post_btn = document.getElementById('post-btn') 

        function delpop(){
            let popup = document.getElementById('delete-popup')
            popup.classList.toggle('hidden')
        }

        function show_comment_toast(){
          let success_message = document.getElementById('success-message')
          success_message.classList.remove('hidden')

          setTimeout(function(){
            success_message.classList.add('hidden')
          },3000)

        }

        function showDeleteModal(commentId) {
        document.getElementById("delete-modal").classList.remove("hidden")
        document.getElementById("delete-form").setAttribute('action',`/comments/${commentId}`)
        }

        function hideDeleteModal() {
        document.getElementById("delete-modal").classList.add("hidden");
        }

        function checkComment(){
          if((comment_area.value).length != 0){

            post_btn.disabled = false
            post_btn.classList.add("bg-blue-600",'border-blue-700', 'hover:bg-blue-700', 'hover:shadow-lg', 'active:bg-blue-800','transition' ,'duration-300' ,'ease-in-out','transform', 'hover:scale-105')
            

          }else{
            post_btn.disabled = true
            post_btn.classList.remove('border-blue-700','hover:bg-blue-700', 'hover:shadow-lg', 'active:bg-blue-800','transition' ,'duration-300' ,'ease-in-out','transform', 'hover:scale-105')
                          
            post_btn.classList.remove('bg-blue-600')
          }
        }

    </script>
</x-layout>