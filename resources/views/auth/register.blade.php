<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Navbar -->
    <nav class="w-full p-4 bg-gray-900 shadow-md flex items-center">
        <a href="/" class="text-xl font-bold px-4 py-2 rounded-full transition duration-300 hover:bg-slate-500 hover:text-black">Yazi Mi Yazsam</a>
    </nav>
    
    <!-- Register Form -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-6 bg-gray-900 rounded-lg shadow-lg animate-fadeIn">
            <h2 class="text-2xl font-bold text-center">Register</h2>
            <form action="/register" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="first_name" class="block text-sm">First Name</label>
                    <input type="text" id="first_name" name="first_name" required class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <x-error-input name="first_name" />
                </div>
                <div>
                    <label for="last_name" class="block text-sm">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <x-error-input name="last_name"/>
                </div>
                <div>
                    <label for="email" class="block text-sm">Email</label>
                    <input type="email" id="email" name="email" required class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <x-error-input name="email"/>
                </div>
                <div>
                    <label for="password" class="block text-sm">Password</label>
                    <input type="password" id="password" name="password" required class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <x-error-input name="password"/>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full p-3 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <x-error-input name="password_confirmation" />
                </div>
                <span class= "text-gray-500 text-sm">
                    <a class="hover:text-gray-400 hover:underline  hover:underline-offset-2" href="/login">Have you an account?</a>
                </span>
                <button type="submit" class="w-full p-3 mt-4 bg-white text-black font-semibold rounded hover:bg-gray-300 transition">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
