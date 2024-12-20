@extends('admin.layout')

@section('konten')

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="client-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <th scope="col" class="px-6 py-3">User ID</th>
                <th scope="col" class="px-6 py-3">Company</th>
                <th scope="col" class="px-6 py-3">Bio</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $index => $client)    
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $index + 1 }}
                    </th>
                    <td class="px-6 py-4">{{ $client->company }}</td>
                    <td class="px-6 py-4">{{ $client->bio }}</td>
                    <td class="px-6 py-4 text-right">
                        <!-- Form delete -->
                        <form id="delete-form-{{ $client->id }}" action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button 
                            type="button" 
                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-red-600 transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                            onclick="confirmDeletion({{ $client->id }})">
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
    // Initialize DataTable
    $(document).ready(function () {
        $('#client-table').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Bahasa Indonesia
            }
        });
    });

    // Konfirmasi Delete dengan SweetAlert
    function confirmDeletion(clientId) {
        Swal.fire({
            title: 'Yakin ingin menghapus ini?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${clientId}`).submit();
                Swal.fire({
                    title: "Deleted!",
                    text: "Data berhasil dihapus.",
                    icon: "success"
                });
            }
        });
    }
</script>

@endsection
