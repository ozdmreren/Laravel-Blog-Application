<x-layout>
    <div class="max-w-4xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Settings</h2> 
        
            <!-- Profile Image Section -->
            <form action="/profile/{{$user->id}}/edit-avatar" enctype="multipart/form-data" method="POST" id="avatar_form">
                @csrf
                @method('PATCH')
                <div class="mb-6">
                    <label class="relative cursor-pointer block w-32 h-32 rounded-full overflow-hidden border-2 border-gray-700 hover:border-gray-500">
                        <img id="avatar-preview" src="{{asset('upload/'.$user->avatar)}}" alt="NO AVATAR"  class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                            <span class="text-sm">Change</span>
                        </div>
                        <input type="file" class="hidden" name="avatar" accept="image/*"  onchange="previewImage(event)" required>
                        <x-error-input name="avatar"/>
                    </label>
                </div>
            </form>

            <form action="/profile/{{$user->id}}/edit" method="POST" class="space-y-4" >
                @csrf
                @method('PATCH')
            <div>
                <label class="block text-sm">First Name</label>
                <input type="text" name="first_name" value="{{ $user->first_name }}" class="w-full bg-gray-800 border-none p-2 rounded" required>
                <x-error-input name="first_name"/>
            </div>
    
            <div>
                <label class="block text-sm">Last Name</label>
                <input type="text" name="last_name" value="{{ $user->last_name }}" class="w-full bg-gray-800 border-none p-2 rounded" required>
                <x-error-input name="last_name"/>
            </div>

            <div>
                <label class="block text-sm">Bio</label>
                <input type="text" name="bio" value="{{ $user->bio }}" class="w-full bg-gray-800 border-none p-2 rounded" required>
                <x-error-input name="bio"/>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-green-500 px-4 py-2 rounded">Save Changes</button>
            </div>
        </form>
    </div>

    <script>


        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('avatar-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);

            let avatar_form = document.getElementById('avatar_form')

            setTimeout(function(){
                avatar_form.submit()
            },2000)
        }
    </script>
</x-layout>
