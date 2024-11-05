@extends('home-admin.layouts.layout')

@section('title', 'Settings - Lembaga Sertifikasi Profesi UGM')

@section('content')
    <div class="flex-1 p-6 bg-gray-100">
        <h2 class="text-3xl font-bold mb-6">Admin Settings</h2>

        <!-- Update Profile Section -->
        <section class="bg-white p-6 rounded-md shadow-md mb-6">
            <h3 class="text-2xl font-semibold mb-4">Update Profile</h3>
            <form action="#" method="POST" enctype="multipart/form-data">
                <!-- Nama -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-md" value="John Doe">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-md" value="john.doe@example.com">
                </div>

                <!-- Foto Profil -->
                <div class="mb-4">
                    <label for="profile_picture" class="block text-gray-700">Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" class="w-full p-2 border border-gray-300 rounded-md">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update Profile</button>
            </form>
        </section>

        <!-- Change Password Section -->
        <section class="bg-white p-6 rounded-md shadow-md mb-6">
            <h3 class="text-2xl font-semibold mb-4">Change Password</h3>
            <form action="#" method="POST">
                <!-- Current Password -->
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter current password">
                </div>

                <!-- New Password -->
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter new password">
                </div>

                <!-- Confirm New Password -->
                <div class="mb-4">
                    <label for="new_password_confirmation" class="block text-gray-700">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Confirm new password">
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">Change Password</button>
            </form>
        </section>

        <!-- Manage Other Information -->
        <section class="bg-white p-6 rounded-md shadow-md">
            <h3 class="text-2xl font-semibold mb-4">Manage Other Information</h3>
            <form action="#" method="POST">
                <!-- Informasi Tambahan -->
                <div class="mb-4">
                    <label for="additional_info" class="block text-gray-700">Additional Information</label>
                    <textarea id="additional_info" name="additional_info" rows="4" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter any additional information">This is some additional information.</textarea>
                </div>

                <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-600 transition duration-200">Save Information</button>
            </form>
        </section>
    </div>
@endsection
