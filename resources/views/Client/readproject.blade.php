@extends('client.layout')

@section('konten')
<div class="min-h-screen bg-gradient-to-b">
    <!-- Header Section -->
    <div class="mb-8 bg-white bg-opacity-90 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Project</h1>
                <p class="text-gray-600">Kelola semua project Anda dalam satu tempat</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('client.addproject') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Project Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Project List -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 p-4">
        <table id="projectTable" class="w-full display">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <th>Title</th>
                    <th>Budget</th>
                    <th>Deadline</th>
                    <th>Freelancer</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>Rp {{ number_format($project->budget, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}</td>
                    <td>{{ $project->first_name ?? 'Belum ada freelancer' }}</td>
                    <td>{{ ucfirst($project->status) }}</td>
                    <td class="space-x-2">
                        <a href="{{ route('client.detailproject', $project->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Detail</a>
                        @if($project->status != 'cancelled' && $project->status != 'close')
                            <a href="{{ route('client.editproject', $project->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Edit</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Initialize DataTable -->
    <script>
    $(document).ready(function() {
        $('#projectTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
    </script>
</div>
@endsection