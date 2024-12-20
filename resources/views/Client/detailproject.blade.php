@extends('client.layout')

@section('konten')
<div class="min-h-screen bg-gray-50 p-8">
    <!-- Header Section dengan Glass Effect -->
    <div class="mb-8 bg-white bg-opacity-95 backdrop-blur-lg rounded-2xl shadow-lg p-6 border border-gray-200">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $project->title }}</h1>
                <div class="flex flex-wrap gap-3 items-center">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        Project #{{ $project->id }}
                    </span>
                    <span class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Dibuat: {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}
                    </span>
                </div>
            </div>
            
            <!-- Status Badge -->
            <div>
                @php
                    $statusColors = [
                        'open' => 'bg-yellow-100 text-yellow-800',
                        'in progress' => 'bg-blue-100 text-blue-800',
                        'done' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'close' => 'bg-gray-100 text-gray-800',
                        '' => 'bg-gray-100 text-gray-800'
                    ];

                    $dotColors = [
                        'open' => 'bg-yellow-400',
                        'in progress' => 'bg-blue-400',
                        'done' => 'bg-green-400',
                        'cancelled' => 'bg-red-400',
                        'close' => 'bg-gray-400',
                        '' => 'bg-gray-400'
                    ];
                @endphp
                
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$project->status ?? ''] }}">
                    <span class="w-2 h-2 rounded-full mr-2 {{ $dotColors[$project->status ?? ''] }}"></span>
                    {{ ucfirst($project->status ?? 'Unknown') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Project Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Deskripsi Project
                    </h2>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 rounded-xl p-4 max-h-[300px] overflow-y-auto custom-scrollbar">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $project->description }}</p>
                    </div>
                </div>
            </div>

            <!-- File Details Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        File Detail Project
                    </h2>
                </div>
                <div class="p-6">
                    @if($project->detail)
                        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center space-x-4">
                                <div class="bg-indigo-100 p-3 rounded-lg">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Detail Project</p>
                                    <p class="text-xs text-gray-500">Klik untuk download atau preview</p>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('preview.detail', $project->id) }}" target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition-all duration-200">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Preview
                                </a>
                                <a href="{{ route('download.detail', $project->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition-all duration-200">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center h-32 bg-gray-50 rounded-xl">
                            <p class="text-gray-500 italic">Tidak ada file detail</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Info Cards -->
        <div class="space-y-6">
            <!-- Budget Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Budget Project
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-2xl font-bold text-green-600 text-center">
                        Rp {{ number_format($project->budget, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Deadline Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Deadline Project
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-2xl font-bold text-red-600 text-center">
                        {{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}
                    </p>
                </div>
            </div>

            <!-- Freelancer Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Freelancer
                    </h2>
                </div>
                <div class="p-6">
                    @if($project->first_name)
                        <div class="flex items-center space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $project->first_name . ' ' . $project->last_name }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $project->email }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center h-20">
                            <p class="text-gray-500 italic">Belum ada freelancer</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex flex-wrap gap-4">
        <a href="{{ route('client.project') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-800 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 shadow-lg">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Project
        </a>

        @if($project->status === 'open')
            <form action="{{ route('client.project.cancel', $project->id) }}" method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan project ini?');">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-xl 
                               hover:bg-red-700 transition-all duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Cancel Project
                </button>
            </form>
        @else
            <button type="button" 
                    onclick="alert('Project tidak bisa dibatalkan karena sudah memiliki freelancer')"
                    class="inline-flex items-center px-6 py-3 bg-gray-400 text-white rounded-xl cursor-not-allowed shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Cancel Project
            </button>
        @endif
    </div>
</div>

<style>
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #CBD5E0 #EDF2F7;
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #EDF2F7;
        border-radius: 4px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #CBD5E0;
        border-radius: 4px;
        border: 2px solid #EDF2F7;
    }
</style>
@endsection