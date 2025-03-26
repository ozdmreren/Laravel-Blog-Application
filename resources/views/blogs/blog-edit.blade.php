<x-layout>
    <form class="relative" id="blog_form" method="POST" action="{{route('blog',[$blog->id])}}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <x-form-field >
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-10">
          <!-- Blog Başlığı -->
          <label for="title" class="block text-lg font-semibold text-gray-700 mb-2">Blog Title</label>
          <input type="text" id="blog_title" name="blog_title" placeholder="Enter your blog title"
              class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400 mb-4" required value="{{$blog->blog_title}}">
              <x-error-input name="blog_title"/>
  
              <!-- Sub Blog Title -->
              <label for="title" class="block text-lg font-semibold text-gray-700 mb-2">Sub Blog Title</label>
              <input type="text" id="sub_blog_title" name="sub_blog_title" placeholder="Descript your content"
                      class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400 mb-4" value="{{$blog->sub_blog_title}}">
              <x-error-input name="sub_blog_title"/>
  
  
          <!-- Resim Yükleme -->
      <!-- Resim Yükleme -->
      <label class="block text-lg font-semibold text-gray-700 mb-2">Upload Image</label>
      <div class="border-2 border-dashed border-gray-300 rounded-md p-6 flex flex-col items-center justify-center cursor-pointer hover:border-blue-500 transition">
          <svg class="w-12 h-12 text-gray-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 16V4M7 4l4 4M7 4L3 8M17 16v-4m0 0V8m0 4h4M17 12h-4"></path>
          </svg>
          <span class="text-sm text-gray-500">Click to upload an image</span>
          <input type="file" accept="image/*" class="hidden" id="blog_image" name="blog_image" required> <!-- input hidden olmalı -->
          <x-error-input name="blog_image"/>
      </div>
      <!-- Resim Görüntüleme Alanı -->
      <div id="image-preview" class="mt-4 hidden">
          <img id="preview-img" src="" alt="Image Preview" class="max-w-full rounded-md">
      </div>
      
      
          <!-- Metin Editörü -->
          <label class="block text-lg font-semibold text-gray-700 mt-6">Blog Content</label>
          <div class="border border-gray-300 rounded-md mt-2 p-4">
              <div class="flex space-x-2 mb-3">
                  <button id="bold-btn" class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 transition text-sm font-medium">Bold</button>
                  <button id="increase-font" class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 transition text-sm font-medium">Increase Font</button>
                  <button id="decrease-font" class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 transition text-sm font-medium">Decrease Font</button>
              </div>
              <div >
                <textarea id="blog-content" name="blog_content" contenteditable="true" class="w-full p-2 min-h-[150px] border-none focus:outline-none text-gray-900 placeholder-gray-400">{{$blog->blog_content}}</textarea>
                <x-error-input name="blog_content"/>
              </div>
          </div>
          

          <!-- Yayınla Butonu -->
          <button type="submit" id="publish-btn" class="mt-6 w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
              Update Blog
          </button>
          <div id="toast" class=" absolute hidden text-center w-72 h-14 -top-20 right-0  bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg transition transform translate-x-5">
              <p>✅ Blog successfully updated !</p>
          </div>
      </div>
      </x-form-field>  
    </form>
  </x-layout>
  
  
  
    <script>
  
  // Resim yükleme input'unu tetiklemek için
  document.querySelector(".border-dashed").addEventListener("click", function () {
      document.getElementById("blog_image").click();
  });
  
  // Resim seçildikten sonra önizlemeyi göster
  document.getElementById("blog_image").addEventListener("change", function (e) {
      let file = e.target.files[0];  // Seçilen dosya
      if (file) {
          let reader = new FileReader();
          reader.onload = function (e) {
              let imagePreview = document.getElementById("image-preview");
              let previewImg = document.getElementById("preview-img");
              previewImg.src = e.target.result;  // Resmi göster
              imagePreview.classList.remove("hidden");  // Resim alanını göster
          };
          reader.readAsDataURL(file);  // Dosyayı oku
      }
  });
  
  
  document.getElementById("bold-btn").addEventListener("click", function () {
      document.execCommand("bold", false, null);
  });
  
  document.getElementById("increase-font").addEventListener("click", function () {
      document.execCommand("fontSize", false, "5"); // 1-7 arasında bir değer alır
  });
  
  
  document.getElementById("decrease-font").addEventListener('click',function(){
    document.execCommand('fontSize',false,'2')
  })
  
  
  
   let blog_form = document.getElementById('blog_form')
   blog_form.addEventListener('submit',function(event){
      event.preventDefault()
  
       maketoast()
  
       setTimeout(function(){
          blog_form.submit()
       },2000)
  
   })
  
    function maketoast(){
       let toast = document.getElementById('toast')
       toast.classList.remove('hidden')
       scroll(0,0)
       setTimeout(function(){
          toast.classList.add('hidden')
       },2000)
   }
  
  
  // kateori alanını
  //const dropdownButton = document.getElementById("dropdownButton");
  //    const dropdownMenu = document.getElementById("dropdownMenu");
  //
  //    dropdownButton.addEventListener("click", () => {
  //        dropdownMenu.classList.toggle("hidden");
  //    });
  //
  //    document.addEventListener("click", (event) => {
  //        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
  //            dropdownMenu.classList.add("hidden");
  //        }
  //    });
    </script>
  </html>
  
    
    