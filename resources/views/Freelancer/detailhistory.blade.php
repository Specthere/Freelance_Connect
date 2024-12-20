@extends('freelancer.layout')

@section('konten')
<div class="container mx-auto px-4 mt-10">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <h4 class="text-white text-xl font-semibold">Detail Riwayat Proyek</h4>
        </div>
        <div class="p-6">
            <div class="w-full">
                <div class="w-full">
                    <table class="w-full border-collapse">
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 bg-gray-50 w-1/3">Judul Proyek</th>
                            <td class="py-3 px-4">{{ $projectDetail->title }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 bg-gray-50">Perusahaan</th>
                            <td class="py-3 px-4">{{ $projectDetail->company }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 bg-gray-50">Budget</th>
                            <td class="py-3 px-4">Rp {{ number_format($projectDetail->budget, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 bg-gray-50">Deadline</th>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($projectDetail->deadline)->format('d F Y') }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 bg-gray-50">Status Pembayaran</th>
                            <td class="py-3 px-4">
                                @if($projectDetail->payment_status == 'completed')
                                    <span class="px-3 py-1 text-sm rounded-full bg-green-500 text-white">Selesai</span>
                                @elseif($projectDetail->payment_status == 'pending')
                                    <span class="px-3 py-1 text-sm rounded-full bg-yellow-500 text-white">Menunggu</span>
                                @else
                                    <span class="px-3 py-1 text-sm rounded-full bg-red-500 text-white">Belum Dibayar</span>
                                @endif
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 bg-gray-50">Nomor Rekening</th>
                            <td class="py-3 px-4">{{ $projectDetail->rekening }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('freelancer.history') }}" 
                   class="inline-block px-6 py-2.5 bg-gray-600 text-white font-medium text-sm rounded-lg hover:bg-gray-700 transition-colors duration-300">
                    Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection