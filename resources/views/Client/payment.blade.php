@extends('client.layout')

@section('konten')
<div class="min-h-screen bg-gradient-to-b">
    <!-- Header Section -->
    <div class="mb-8 bg-white bg-opacity-90 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Payment History</h1>
                <p class="text-gray-600">Riwayat pembayaran project Anda</p>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Payment List -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table id="payment-table" class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Freelancer</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Budget</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $payment->project_title }}</span>
                        </td>
                        <td class="px-6 py-4">{{ $payment->freelancer_name }}</td>
                        <td class="px-6 py-4 text-green-600 font-medium">
                            Rp {{ number_format($payment->project_budget) }}
                        </td>
                        <td class="px-6 py-4">{{ ucfirst($payment->payment_status) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('client.detailpayment', $payment->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                    Detail
                                </a>
                                @if($payment->payment_status == 'not yet' || $payment->payment_status == 'failed')
                                    <a href="{{ route('client.bayar', $payment->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                                        Bayar
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada riwayat pembayaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#payment-table').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Menggunakan Bahasa Indonesia
                },
                pageLength: 10, // Jumlah baris yang ditampilkan per halaman
                order: [[0, 'asc']] // Urutan default kolom pertama (Title)
            });
        });
    </script>
    

    <!-- Pagination -->
    @if(method_exists($payments, 'links'))
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @endif
</div>
@endsection