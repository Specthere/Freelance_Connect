@extends('Client.layout')

@section('konten')
<div class="min-h-screen bg-gradient-to-b">
    <!-- Header Section -->
    <div class="mb-8 bg-white bg-opacity-90 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Payment</h1>
                <p class="text-gray-600">Informasi detail pembayaran project</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-4">
                <a href="{{ route('client.payment') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('client.detailproject', $payment->project_id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Detail Project
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Project Information -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Informasi Project</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Judul Project</label>
                        <p class="text-gray-800 font-medium">{{ $payment->project_title }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Company</label>
                        <p class="text-gray-800 font-medium">{{ $payment->client_company }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Freelancer</label>
                        <p class="text-gray-800 font-medium">{{ $payment->name }}</p>
                    </div>
                    @if($payment->status != 'not yet')
                    <div>
                        <label class="text-sm text-gray-500">Nomor Rekening</label>
                        <p class="text-gray-800 font-medium">{{ $payment->freelancer_rekening }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Nama Bank</label>
                        <p class="text-gray-800 font-medium">{{ $payment->freelancer_bank }}</p>
                    </div>
                    @endif
                   
                    <div>
                        <label class="text-sm text-gray-500">Budget</label>
                        <p class="text-green-600 font-medium">Rp {{ number_format($payment->project_budget) }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Detail Pembayaran</h2>
                <div class="space-y-3">
                    @if($payment->status != 'not yet')
                    <div>
                        <label class="text-sm text-gray-500">ID Pembayaran</label>
                        <p class="text-gray-800 font-medium">#{{ $payment->id }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Tanggal Pembayaran</label>
                        <p class="text-gray-800 font-medium">
                            {{ $payment->payment_date ? date('d F Y H:i', strtotime($payment->payment_date)) : 'Belum dibayar' }}
                        </p>
                    </div>
                    @endif
                    <div>
                        <label class="text-sm text-gray-500">Status Pembayaran</label>
                        <div class="mt-1">
                            @if($payment->status == 'completed')
                                <span class="px-3 py-1 text-sm text-green-700 bg-green-100 rounded-full">
                                    Completed
                                </span>
                            @elseif($payment->status == 'pending')
                                <span class="px-3 py-1 text-sm text-yellow-700 bg-yellow-100 rounded-full">
                                    Pending
                                </span>
                            @elseif($payment->status == 'not yet')
                                <span class="px-3 py-1 text-sm text-red-700 bg-red-100 rounded-full">
                                    Not Yet
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm text-red-700 bg-red-100 rounded-full">
                                    Failed
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Progress -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Progress Project</h2>
            <div class="space-y-3">
                <div>
                    <label class="text-sm text-gray-500">Status Project</label>
                    <p class="text-gray-800 font-medium mt-1">{{ ucfirst($payment->project_status) }}</p>
                </div>
                {{-- @if($payment->submission) --}}
                <div>
                    <label class="text-sm text-gray-500">File Submission</label>
                    <div class="mt-2">
                        <a href="{{ route('client.download_submission', $payment->detail_project_id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Submission
                        </a>
                    </div>
                </div>
                {{-- @endif --}}
            </div>
        </div>
        

        <!-- Action Buttons -->
        @if($payment->status != 'completed')
        <div class="mt-8 flex justify-end space-x-4">
            @if($payment->status == 'failed')
                <a href="{{ route('client.bayar', $payment->id) }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Coba Bayar Lagi
                </a>
            @elseif($payment->status == 'not yet')
                <div class="mt-4">
                    <a href="{{route('client.bayar', $payment->id)}}" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Lakukan Pembayaran
                    </a>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection