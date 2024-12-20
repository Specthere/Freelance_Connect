@extends('client.layout')

@section('konten')
<div class="min-h-screen bg-gray-50 p-8">
    <!-- Header Section -->
    <div class="mb-8 bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Project</h1>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
        <form action="{{ route('client.updateproject', $project->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Title Input -->
            <div class="space-y-2">
                <label for="title" class="text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Judul Project
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{$project->title}}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                       required>
            </div>

            <!-- Budget Input -->
            <div class="space-y-2">
                <label for="budget" class="text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Budget Project
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2 text-gray-500">Rp</span>
                    <input type="number" 
                           name="budget" 
                           id="budget" 
                           value="{{$project->budget}}"
                           class="w-full px-4 py-2 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           required>
                </div>
            </div>

            <!-- Deadline Input -->
            <div class="space-y-2">
                <label for="deadline" class="text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Deadline Project (Minimal 3 hari dari sekarang)
                </label>
                <input type="date" 
                       name="deadline" 
                       id="deadline" 
                       value="{{ date('Y-m-d', strtotime($project->deadline)) }}"
                       min="{{ date('Y-m-d', strtotime('+3 days')) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                       required>
                <p class="text-sm text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Deadline minimal: {{ date('d M Y', strtotime('+3 days')) }}
                </p>
            </div>

            <!-- Description Input -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    Deskripsi Project
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="6" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                          required>{{$project->description}}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
                
                <a href="{{ route('client.project') }}" 
                   class="px-6 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection