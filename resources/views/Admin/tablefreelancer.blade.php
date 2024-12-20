@extends('admin.layout')

@section('konten')

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="freelancer-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <th scope="col" class="px-6 py-3">User ID</th>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Experience</th>
                <th scope="col" class="px-6 py-3">Skills</th>
                <th scope="col" class="px-6 py-3">Bio</th>
                <th scope="col" class="px-6 py-3">Rekening</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($freelancers as $index => $freelancer)    
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $index + 1 }}
                    </th>
                    <td class="px-6 py-4">{{ $freelancer->first_name }}</td>
                    <td class="px-6 py-4">{{ $freelancer->experience }}</td>
                    <td class="px-6 py-4">{{ $freelancer->skills }}</td>
                    <td class="px-6 py-4">{{ $freelancer->bio }}</td>
                    <td class="px-6 py-4">{{ number_format($freelancer->rekening) }}</td>
                    <td class="px-6 py-4 text-right">
                        <form id="delete-form-{{ $freelancer->id }}" action="{{ route('freelancers.destroy', $freelancer->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button 
                            type="button" 
                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-red-600 transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                            onclick="confirmDeletion({{ $freelancer->id }})">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4a1 1 0 011-1h6a1 1 0 011 1v2m-3 5v6m-4-6v6m-7 2a2 2 0 002 2h10a2 2 0 002-2V6H5v12a2 2 0 01-2 2z" />
                            </svg>                            
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Inisialisasi DataTables
    $(document).ready(function () {
        $('#freelancer-table').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Bahasa Indonesia
            }
        });
    });

    // Konfirmasi Hapus dengan SweetAlert
    function confirmDeletion(freelancerId) {
        Swal.fire({
            title: 'Yakin ingin menghapus Freelancer ini?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${freelancerId}`).submit();
                Swal.fire({
                    title: "Deleted!",
                    text: "Data freelancer berhasil dihapus.",
                    icon: "success"
                });
            }
        });
    }
</script>

@endsection
