@extends('freelancer.layout')

@section('konten')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-t-2xl p-6 shadow-lg">
            <h4 class="text-2xl font-bold text-white mb-2">Detail Riwayat Proyek</h4>
            <p class="text-blue-100">Informasi lengkap mengenai proyek Anda</p>
        </div>

        <!-- Content Section -->
        <div class="bg-white rounded-b-2xl shadow-lg p-6">
            <!-- Project Information -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Project Title -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Judul Proyek</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $projectDetail->title }}</p>
                        </div>
                    </div>
                </div>

                <!-- Project Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Company -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Freelancer</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $projectDetail->freelancer }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Budget -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Budget</p>
                                <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($projectDetail->budget, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Deadline -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-red-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Deadline</p>
                                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($projectDetail->deadline)->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-yellow-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status Pembayaran</p>
                                <div class="mt-1">
                                    @if($projectDetail->payment_status == 'completed')
                                        <span class="px-3 py-1 text-sm text-green-800 bg-green-100 rounded-full">Selesai</span>
                                    @elseif($projectDetail->payment_status == 'pending')
                                        <span class="px-3 py-1 text-sm text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                                    @else
                                        <span class="px-3 py-1 text-sm text-red-800 bg-red-100 rounded-full">Belum Dibayar</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Detail Section -->
                @if(isset($projectDetail->detail) && $projectDetail->detail)
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-indigo-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">File Detail Proyek</p>
                                    <p class="text-xs text-gray-500">{{ basename($projectDetail->detail) }}</p>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('preview.detail', $projectDetail->id) }}" target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded-lg hover:bg-indigo-600 transition-all duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Preview
                                </a>
                                <a href="{{ route('download.detail', $projectDetail->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition-all duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-12">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Tidak ada file detail yang tersedia</p>
                        </div>
                    </div>
                @endif

                <!-- Back Button -->
                <div class="flex justify-center mt-6">
                    <a href="{{ route('client.history') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Message -->
@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif
@endsection