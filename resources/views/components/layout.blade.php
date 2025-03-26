@php
    $current = currentUser();
@endphp

<!DOCTYPE HTML>
<html lang="tr">
<head>
    <title>Yazi Mi Yazsam</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div id="wrapper" class="min-h-screen flex flex-col">
        
        <!-- Header -->
        <header id="header" class="bg-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto flex justify-between items-center px-6 py-4">
                
                <!-- Logo -->
                <h1 class="text-2xl font-bold text-blue-600 px-4 py-2 rounded-lg border-2 border-white hover:border-gray-200 transition duration-300 hover:shadow-lg hover:text-blue-700">
                    <a href="{{route('home')}}">Yazi Mi Yazsam</a>
                </h1>

                <div class="relative w-96 mx-auto mt-5">
                    <input type="text" id="searchInput" placeholder="Search..."
                        class="w-full px-5 py-2 border rounded-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                
                    <button class="absolute right-4 top-2 text-gray-400 hover:text-blue-500 transition">
                        🔍
                    </button>
                
                    <!-- Sonuçları gösteren liste -->
                    <ul id="results" class="absolute w-full bg-white border rounded-lg shadow-md hidden mt-1"></ul>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-6">
                    <a href="{{route('write')}}" class="px-6 py-2 text-black font-bold bg-gray-100 opacity-70 hover:bg-gray-300 hover:opacity-100 transition duration-500 rounded-full shadow-lg">Write</a>
                    @auth
                    <div class="relative">
                        <!-- Bildirim Butonu -->
                        <button id="notificationButton" class="relative text-gray-600 shadow-lg hover:bg-gray-100 transition duration-300 px-3 py-2 rounded-full">
                            🔔
                            <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 p-1 w-5 h-5 flex items-center justify-center text-xs font-bold text-white bg-red-500 rounded-full">
                                {{$current->notifies->where('seen',0)->count()}}
                            </span>
                        </button>
                        
                
                        <!-- Bildirim Menüsü -->
                        <div id="notificationMenu" class="hidden absolute right-0 mt-2 w-96 bg-white shadow-lg rounded-lg p-3">
                            <ul id="notificationList">
                                <!-- Mesajlar buraya eklenecek -->
                                @foreach ($current->notifies as $notify )
                                <li class="py-2 mb-3 flex justify-between items-center hover:bg-gray-100 px-2 transition cursor-pointer notify-item" data-form-id="notify-{{ $notify->id }}">
                                    @if ($notify->seen == 0)
                                        <span class="text-xs text-red-500 font-semibold">New</span>
                                    @endif
                                    <form action="/notifies/{{$notify->id}}" method="POST" class="hidden" id="notify-{{ $notify->id }}">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                    <p class="text-sm"><strong>{{$notify->blog->blog_title}}</strong></p>
                                    <span>{{$notify->comment->user->first_name}}: {{Str::limit($notify->comment->comment, 35)}}</span>
                                    <div class="w-12">
                                        <img src="{{asset('upload/'.$notify->blog->blog_image)}}" alt="">
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endauth

                    <!-- Avatar Dropdown -->
                    <div class="relative">
                        <button id="avatar-btn" class="focus:outline-none">
                            @php
                                if($current){
                                    $isExist = true;
                                }
                                else{
                                    $isExist = false;
                                }
                            @endphp
                            <img src="{{$isExist ? asset('upload/'.$current->avatar) : asset('upload/logo.jpg')}}" alt="Avatar" class="w-10 h-10 rounded-full">
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden border">
                            <ul class="text-gray-700 text-sm">
                                @auth
                                    
                                <li><a href="{{route('dashboard',[$current->id])}}" class="block px-4 py-2 hover:bg-gray-100">Profile</a></li>
                                <li><a href="{{route('user.library',[$current->id])}}" class="block px-4 py-2 hover:bg-gray-100">Library</a></li>
                                <li><a href="{{route('user.stories',[$current->id])}}" class="block px-4 py-2 hover:bg-gray-100">Stories</a></li>
                                <hr>
                                <li>
                                    <button id="settings-button" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                        Settings
                                    </button>
                                </li>
                                <div id="settings-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden border">
                                    <ul class="text-gray-700 text-sm">
                                        <li><a href="{{route('profile.edit',[$current->id])}}" class="block px-4 py-2 hover:bg-gray-100">Edit Profile</a></li>
                                        <li><a href="{{route('profile.security',[$current->id])}}" class="block px-4 py-2 hover:bg-gray-100">Password & Security</a></li>
                                    </ul>
                                </div>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Help</a></li>
                                <hr>
                                @endauth
                                @guest
                                <li><a href="{{route('register')}}" class="block px-4 py-2 text-black font-bold  hover:bg-gray-100">Sign Up</a></li>
                                <li><a href="{{route('login')}}" class="block px-4 py-2 text-black font-bold hover:bg-gray-100">Sign In</a></li>    
                                @endguest
                                
                                @auth
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <li>
                                        <p id="signOutButton" class="text-left w-full px-4 py-2 text-red-600 hover:bg-gray-100 select-none">
                                            Sign Out
                                        </p>
                                    </li>
                                    
                                    <!-- Çıkış Onay Modali -->
                                    <div id="signOutModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center">
                                            <h2 class="text-lg font-semibold text-gray-800">Do you want to exit?</h2>
                                            <div class="mt-4 flex justify-center gap-4">
                                                <button id="confirmSignOut" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                                    Yes
                                                </button>
                                                <p id="cancelSignOut" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                                                    No
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <li class="px-4 py-2 text-xs text-gray-500">{{$current->email}}</li>
                                </form>    
                                @endauth
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div id="main" class="flex-1 container mx-auto py-8 px-6">
            {{$slot}}
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.getElementById("avatar-btn").addEventListener("click", function() {
            document.getElementById("dropdown-menu").classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function(event) {
            let dropdown = document.getElementById("dropdown-menu");
            let avatarBtn = document.getElementById("avatar-btn");
            if (!avatarBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
        const settingsButton = document.getElementById("settings-button");
        const settingsDropdown = document.getElementById("settings-dropdown");

        settingsButton.addEventListener("click", function (event) {
            event.stopPropagation();
            settingsDropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!settingsDropdown.contains(event.target) && !settingsButton.contains(event.target)) {
                settingsDropdown.classList.add("hidden");
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.notify-item').forEach(item => {
            item.addEventListener('click', function () {
                let formId = this.getAttribute('data-form-id');
                document.getElementById(formId).submit();
            });
        });
    });

    notificationButton.addEventListener("click", function () {
                notificationMenu.classList.toggle("hidden");
            })
            // Menü dışına tıklanınca kapat
            document.addEventListener("click", function (event) {
                if (!notificationButton.contains(event.target) && !notificationMenu.contains(event.target)) {
                    notificationMenu.classList.add("hidden");
                }
            });



        //SIGN OUT'A BASTIĞIMDA ÇIKACAK OLAN KUTUCUK
        const signOutButton = document.getElementById("signOutButton");
    const signOutModal = document.getElementById("signOutModal");
    const confirmSignOut = document.getElementById("confirmSignOut");
    const cancelSignOut = document.getElementById("cancelSignOut");

    // Sign Out butonuna tıklanınca modalı aç
    signOutButton.addEventListener("click", () => {
        signOutModal.classList.remove("hidden");
    });

    // Çıkışı onaylarsa yönlendir
    confirmSignOut.addEventListener("click", () => {
        window.location.href = "/logout"; // Laravel logout route'u
    });

    // Çıkışı iptal ederse modalı kapat
    cancelSignOut.addEventListener("click", () => {
        signOutModal.classList.add("hidden");
    });

    // Modal dışına tıklanınca kapanmasını sağla
    window.addEventListener("click", (event) => {
        if (event.target === signOutModal) {
            signOutModal.classList.add("hidden");
        }
    });


    //SEARCHBAR

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const resultsContainer = document.getElementById('results');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();

            if (query.length === 0) {
                resultsContainer.classList.add('hidden');
                return;
            }

            fetch(`/search?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';

                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<li class="p-2 text-gray-500">No results found</li>';
                    } else {
                        data.forEach(blog => {
                            const li = document.createElement('li');
                            li.textContent = blog.blog_title;
                            li.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer', 'border-b');

                            // Tıklanınca ilgili blog sayfasına git
                            li.addEventListener('click', function () {
                                window.location.href = `/blogs/${blog.id}`;
                            });

                            resultsContainer.appendChild(li);
                        });
                    }

                    resultsContainer.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        });

        // Input dışına tıklanınca listeyi gizle
        document.addEventListener('click', function (event) {
            if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
                resultsContainer.classList.add('hidden');
            }
        });
    });
    </script>
</body>
</html>