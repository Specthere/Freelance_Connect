@extends('Client.layout')

@section('konten')
<div class="px-6 py-8 bg-white dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Riwayat Proyek</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Daftar riwayat proyek yang telah Anda kerjakan</p>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table id="project-table" class="w-full text-sm text-left">
                    <thead class="text-xs text-white uppercase bg-gradient-to-r from-teal-600 to-blue-600">
                        <tr>
                            <th class="px-6 py-4 font-medium">Judul Proyek</th>
                            <th class="px-6 py-4 font-medium">Freelancer</th>
                            <th class="px-6 py-4 font-medium">Anggaran</th>
                            <th class="px-6 py-4 font-medium">Status Proyek</th>
                            <th class="px-6 py-4 font-medium text-center">Status Pembayaran</th>
                            <th class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($projects as $project)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $project->title }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $project->freelancer ?? 'Tidak Ada' }}
                                </td>
                                <td class="px-6 py-4 text-green-600 dark:text-green-400 font-semibold">
                                    Rp{{ number_format($project->budget, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($project->project_status == 'Completed') 
                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($project->project_status == 'In Progress')
                                            bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @elseif($project->project_status == null)
                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @else
                                            bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        {{ $project->project_status ?? 'Cancelled' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($project->payment_status == 'Paid') 
                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($project->payment_status == null)
                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @else
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @endif">
                                        {{ $project->payment_status ?? 'Cancelled' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($project->project_status != 'cancelled')
                                        <a href="{{ route('client.detailhistory', $project->id) }}" 
                                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-blue-600 rounded-lg hover:from-teal-600 hover:to-blue-700 transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    @else
                                        <button disabled
                                                class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed opacity-50">
                                            Detail
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada riwayat proyek
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Initialization -->
<script>
    $(document).ready(function() {
        $('#project-table').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Bahasa Indonesia
            },
            pageLength: 10
        });
    });
</script>
@endsection
z