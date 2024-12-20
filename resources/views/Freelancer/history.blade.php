@extends('Freelancer.layout')

@section('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
@endsection

@section('konten')
<h2 class="mb-6 text-2xl font-extrabold text-gray-900 dark:text-white">History</h2>
<div class="relative overflow-x-auto shadow-lg rounded-lg">
    <table id="historyTable" class="w-full text-sm text-left stripe hover">
        <thead class="text-xs text-white uppercase bg-gradient-to-r from-green-500 via-teal-500 to-blue-600 dark:from-gray-700 dark:via-gray-800 dark:to-gray-900">
            <tr>
                <th scope="col" class="px-6 py-4">Title</th>
                <th scope="col" class="px-6 py-4">Company</th>
                <th scope="col" class="px-6 py-4">Budget</th>
                <th scope="col" class="px-6 py-4">Project Status</th>
                <th scope="col" class="px-6 py-4">Payment Status</th>
                <th scope="col" class="px-6 py-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td class="px-6 py-4 font-medium">{{ $project->title }}</td>
                    <td class="px-6 py-4">{{ $project->company }}</td>
                    <td class="px-6 py-4 text-green-700 dark:text-green-400 font-bold">Rp{{ number_format($project->budget, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $project->project_status }}</td>
                    <td class="px-6 py-4">{{ $project->payment_status }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('freelancer.detail_history', $project->id) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-blue-600 rounded-lg shadow-md hover:from-teal-600 hover:to-blue-700">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m4 4H9m4-8H9m8 8a9.003 9.003 0 00-9-9 9.003 9.003 0 00-9 9 9.003 9.003 0 009 9 9.003 9.003 0 009-9z" />
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#historyTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
            },
            columnDefs: [
                { orderable: false, targets: [5] }, // Menonaktifkan sorting untuk kolom Action
                { searchable: false, targets: [5] } // Menonaktifkan pencarian untuk kolom Action
            ]
        });
    });
</script>
@endsection