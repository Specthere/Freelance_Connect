@extends('freelancer.layout')

@section('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection

@section('konten')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-purple-50 py-8">
    <!-- Header Section -->
    <div class="mb-8 bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl shadow-xl p-8 border border-gray-200 transform hover:scale-[1.02] transition-all duration-300" data-aos="fade-down">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">Profile Settings</h1>
        <p class="text-gray-600 text-lg">Kelola informasi profile dan pengaturan akun Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-4" data-aos="fade-right">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200 transform hover:scale-[1.02] transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 px-6 py-12 relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 left-0 w-full h-full">
                        <div class="absolute transform rotate-45 translate-x-1/2 -translate-y-1/2 bg-white opacity-10 w-32 h-32"></div>
                        <div class="absolute bottom-0 right-0 transform rotate-45 translate-x-1/2 translate-y-1/2 bg-purple-400 opacity-10 w-32 h-32"></div>
                    </div>
                    
                    <div class="relative">
                        <div class="flex justify-center">
                            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center border-4 border-white shadow-xl transform hover:scale-105 transition-all duration-300">
                                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-6 text-center">
                            <h2 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h2>
                            <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-lg rounded-xl text-white text-sm font-medium">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gradient-to-b from-white to-gray-50">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-700">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">Joined {{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="lg:col-span-8" data-aos="fade-left">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Profile Information
                    </h2>
                </div>

                <div class="p-8">
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div class="space-y-2 transform hover:scale-[1.01] transition-all duration-200">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nama Lengkap
                            </label>
                            <div class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="space-y-2 transform hover:scale-[1.01] transition-all duration-200">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email
                            </label>
                            <div class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50">
                                {{ $user->email }}
                            </div>
                        </div>

                        <!-- Edit Profile Button -->
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('user.edit', $user->id) }}" 
                               class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 flex items-center shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
@endsection