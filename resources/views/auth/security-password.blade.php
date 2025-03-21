<x-layout>
    <div class="space-y-5">
        <div class="max-w-4xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4">Email Settings</h2> 
            
            <!-- Profile Form -->
            <form action="/profile/{{auth()->user()->id}}/security/email" method="POST" class="space-y-4" >
                @csrf
                @method('PATCH')
        
                <div class="space-y-3">
                    <label class="block text-sm"><strong class="text-lg"> Email: {{auth()->user()->email}} </strong></label>
                    <input type="email" name="email" placeholder="New email" class="w-full bg-gray-800 border-none p-2 rounded">
                    <x-error-input name="email"/>
                </div>
        
                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-green-500 px-4 py-2 rounded">Save Changes</button>
                </div>

            </form>
        </div>
    
        <div class="max-w-4xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4">Password Settings</h2> 
            
            <!-- Profile Form -->
            <form action="/profile/{{auth()->user()->id}}/security/password" method="POST" enctype="multipart/form-data" class="space-y-4" >
                @csrf
                @method('PATCH')
        
                <div>
                    <label class="block text-sm">Old Password</label>
                    <input type="password" name="old-password" placeholder="Old password" class="w-full bg-gray-800 border-none p-2 rounded" required>
                    <x-error-input name="old-password"/>
                </div>
        
                <div>
                    <label class="block text-sm">New Password</label>
                    <input type="password" name="password" placeholder="New password" class="w-full bg-gray-800 border-none p-2 rounded" required>
                    <x-error-input name="password"/>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm">New Password Confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your new password" class="w-full bg-gray-800 border-none p-2 rounded" required>
                    <x-error-input name="password_confirmation"/>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-green-500 px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('avatar-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-layout>
