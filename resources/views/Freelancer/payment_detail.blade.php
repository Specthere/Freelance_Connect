@extends('Freelancer.layout')

@section('konten')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8 bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Detail Pembayaran</h2>
                <p class="text-gray-600 mt-2">Informasi lengkap mengenai pembayaran proyek</p>
            </div>
            <a href="{{ route('freelancer.waiting_payment') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Project Details Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Proyek</h3>
                
                <div class="space-y-4">
                    <!-- Judul Proyek -->
                    <div class="flex items-start">
                        <div class="w-40 flex-shrink-0">
                            <span class="text-gray-600">Judul Proyek</span>
                        </div>
                        <div class="flex-grow">
                            <span class="font-medium text-gray-800">{{ $payment->title }}</span>
                        </div>
                    </div>

                    <!-- Perusahaan Client -->
                    <div class="flex items-start">
                        <div class="w-40 flex-shrink-0">
                            <span class="text-gray-600">Perusahaan</span>
                        </div>
                        <div class="flex-grow">
                            <span class="font-medium text-gray-800">{{ $payment->company }}</span>
                        </div>
                    </div>

                    <!-- Budget -->
                    <div class="flex items-start">
                        <div class="w-40 flex-shrink-0">
                            <span class="text-gray-600">Budget</span>
                        </div>
                        <div class="flex-grow">
                            <span class="font-medium text-green-600">
                                Rp {{ number_format($payment->budget, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Deadline -->
                    <div class="flex items-start">
                        <div class="w-40 flex-shrink-0">
                            <span class="text-gray-600">Deadline</span>
                        </div>
                        <div class="flex-grow">
                            <span class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($payment->deadline)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Status Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Status Pembayaran</h3>
                
                <div class="space-y-6">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-center">
                        @if($payment->status == 'pending')
                            <div class="px-4 py-2 bg-yellow-100 rounded-full">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium text-yellow-700">Menunggu Konfirmasi</span>
                                </div>
                            </div>
                        @elseif($payment->status == 'completed')
                            <div class="px-4 py-2 bg-green-100 rounded-full">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="font-medium text-green-700">Pembayaran Selesai</span>
                                </div>
                            </div>
                        @else
                            <div class="px-4 py-2 bg-gray-100 rounded-full">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium text-gray-700">{{ ucfirst($payment->status) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Timeline -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Pembayaran Dibuat</p>
                                <p class="text-sm text-gray-500">{{ $payment->created_at}}</p>
                            </div>
                        </div>

                        @if($payment->status == 'completed')
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Pembayaran Dikonfirmasi</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if($payment->status == 'pending')
                    <form action="{{ route('freelancer.payment.confirm', $payment->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection