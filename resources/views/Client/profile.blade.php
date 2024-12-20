@extends('client.layout')

@section('konten')
<div class="min-h-screen bg-gradient-to-b">
    <!-- Header Section -->
    <div class="mb-8 bg-white bg-opacity-90 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Profile Settings</h1>
        <p class="text-gray-600">Kelola informasi profile dan pengaturan akun Anda</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-4" data-aos="fade-right">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200 transform hover:scale-[1.02] transition-all duration-300">
                    <!-- Header Background -->
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

                    <!-- Info Section -->
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="text-gray-700">{{ $client->company }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div class="lg:col-span-8" data-aos="fade-left">
                <div class="bg-white rounded-xl shadow-lg">
                    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 px-6 py-6 relative overflow-hidden">
                        <h2 class="text-xl font-semibold text-gray-900">Edit Profile</h2>
                    </div>

                    <form action="{{ route('client.profile.update') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <!-- Name Input -->
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium text-gray-700 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-100 cursor-not-allowed"
                                   readonly
                                   onclick="showNameEditAlert()">
                        </div>

                        <!-- Company Input -->
                        <div class="space-y-2">
                            <label for="company" class="text-sm font-medium text-gray-700 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Nama Perusahaan
                            </label>
                            <input type="text" name="company" id="company" value="{{ old('company', $client->company) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Bio Input -->
                        <div class="space-y-2">
                            <label for="bio" class="text-sm font-medium text-gray-700 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Bio
                            </label>
                            <textarea name="bio" id="bio" rows="4" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $client->bio) }}</textarea>
                            <p class="text-sm text-gray-500">Ceritakan sedikit tentang Anda atau perusahaan Anda</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="button" 
                                    onclick="confirmSubmit()"
                                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 flex items-center shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });

    function showNameEditAlert() {
        Swal.fire({
            title: 'Tidak dapat mengubah nama',
            text: 'Nama pengguna tidak dapat diubah untuk menjaga keamanan akun',
            icon: 'info',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#3B82F6'
        });
    }

    function confirmSubmit() {
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Apakah Anda yakin ingin menyimpan perubahan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3B82F6',
            cancelButtonColor: '#EF4444',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading state
                Swal.fire({
                    title: 'Menyimpan...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading()
                    },
                });
                // Submit form
                document.querySelector('form').submit();
            }
        });
    }

    // Tampilkan pesan sukses jika ada
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: true,
            confirmButtonColor: '#3B82F6',
            timer: 3000
        });
    @endif

    // Tampilkan pesan error jika ada
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            showConfirmButton: true,
            confirmButtonColor: '#EF4444',
        });
    @endif
</script>
@endsection