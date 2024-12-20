@extends('client.layout')

@section('konten')
<div class="min-h-screen bg-gradient-to-b">
    <!-- Header Section -->
    <div class="mb-8 bg-white bg-opacity-90 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Project</h1>
                <p class="text-gray-600">ID Pembayaran: #{{ $payment->id }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('client.detailpayment', $payment->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pembayaran</h2>
        <div class="space-y-4">
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-blue-800">Silakan transfer ke:</p>
                <div class="mt-2 space-y-2">
                    <p class="font-medium text-lg text-blue-900">{{ $payment->name }}</p>
                    <div class="flex gap-3">
                        <p class="font-bold text-2xl text-blue-900">{{ $payment->nama_bank }}</p>
                        <p class="font-bold text-2xl text-blue-900">{{ $payment->freelancer_rekening }}</p>
                    </div>
                    <p class="font-bold text-xl text-green-600">Rp {{ number_format($payment->project_budget) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Instructions -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tata Cara Pembayaran</h2>
        
        <!-- M-Banking Instructions -->
        <div class="mb-6">
            <button onclick="toggleInstructions('mbanking')" class="w-full flex justify-between items-center text-lg font-medium text-gray-800 mb-3 hover:text-blue-600">
                <span>Melalui M-Banking</span>
                <svg id="mbanking-icon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="mbanking-instructions" class="hidden">
                <ol class="list-decimal list-inside space-y-2 text-gray-600">
                    <li>Buka aplikasi M-Banking Anda</li>
                    <li>Pilih menu "Transfer"</li>
                    <li>Pilih "Transfer ke Bank yang sama" atau "Transfer ke Bank lain" sesuai tujuan</li>
                    <li>Masukkan nomor rekening: <span class="font-medium text-gray-800">{{ $payment->freelancer_rekening }}</span></li>
                    <li>Masukkan nominal: <span class="font-medium text-gray-800">Rp {{ number_format($payment->project_budget) }}</span></li>
                    <li>Pastikan nama penerima adalah <span class="font-medium text-gray-800">{{ $payment->name }}</span></li>
                    <li>Periksa kembali detail transaksi</li>
                    <li>Masukkan PIN M-Banking Anda</li>
                    <li>Transaksi selesai, simpan bukti pembayaran</li>
                </ol>
            </div>
        </div>

        <!-- ATM Instructions -->
        <div>
            <button onclick="toggleInstructions('atm')" class="w-full flex justify-between items-center text-lg font-medium text-gray-800 mb-3 hover:text-blue-600">
                <span>Melalui ATM</span>
                <svg id="atm-icon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="atm-instructions" class="hidden">
                <ol class="list-decimal list-inside space-y-2 text-gray-600">
                    <li>Masukkan kartu ATM Anda</li>
                    <li>Masukkan PIN ATM</li>
                    <li>Pilih menu "Transfer"</li>
                    <li>Pilih "Transfer ke rekening bank yang sama" atau "Transfer ke bank lain"</li>
                    <li>Masukkan kode bank (jika transfer ke bank lain)</li>
                    <li>Masukkan nomor rekening: <span class="font-medium text-gray-800">{{ $payment->freelancer_rekening }}</span></li>
                    <li>Masukkan nominal: <span class="font-medium text-gray-800">Rp {{ number_format($payment->project_budget) }}</span></li>
                    <li>Periksa nama penerima: <span class="font-medium text-gray-800">{{ $payment->name }}</span></li>
                    <li>Konfirmasi transaksi</li>
                    <li>Transaksi selesai, ambil dan simpan bukti pembayaran</li>
                </ol>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <h3 class="text-lg font-medium text-yellow-800 mb-2">Catatan Penting:</h3>
            <ul class="list-disc list-inside space-y-1 text-yellow-700">
                <li>Pastikan data penerima dan nominal sudah benar sebelum melakukan transfer</li>
                <li>Simpan bukti pembayaran sebagai bukti transaksi</li>
                <li>Pembayaran akan diverifikasi oleh freelancer</li>
            </ul>
        </div>
    </div>

    <!-- Payment Status Button -->
    <div class="mt-4 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 p-6">
        <div class="text-center">
            <p class="text-gray-600 mb-4">Konfirmasi Jika Sudah Melakukan Pembayaran</p>
            <form action="{{ route('client.update-status-payment', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if($payment->payment_status == 'pending')
                <button type="submit" disabled 
                    class="w-full md:w-auto px-8 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed opacity-75 flex items-center justify-center mx-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Menunggu Konfirmasi
                </button>
                @else
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center justify-center mx-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Sudah Melakukan Pembayaran
                </button>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
function toggleInstructions(type) {
    const instructions = document.getElementById(`${type}-instructions`);
    const icon = document.getElementById(`${type}-icon`);
    
    if (instructions.classList.contains('hidden')) {
        instructions.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        instructions.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>
@endsection