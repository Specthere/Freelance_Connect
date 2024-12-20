<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Freelance Connnect | Freelancer</title>
    @vite('resources/css/app.css')
</head>
<body class="dark:bg-gray-900">
    {{-- nav bar --}}
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="#" class="flex ms-2 md:me-24">
                        <img src="{{ asset('storage/icon/freelance.png') }}"" class="h-12 me-3" alt="Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Freelance Connect</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <h1 class="self-center text-xl font-semibold sm:text-xs whitespace-nowrap dark:text-white">{{Auth :: user()->name}}</h1>
                </div>
            </div>
        </div>
    </nav>

    {{-- Side Bar --}}
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('freelancer.show') }}" 
                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white {{ Request::routeIs('freelancer.show') ? 'bg-blue-700 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                        <svg class="w-5 h-5 {{ Request::routeIs('freelancer.show') ? 'text-white' : 'text-gray-500' }} transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Project</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('freelancer.ongoing_projects')}}" 
                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white {{ Request::routeIs('freelancer.ongoing_projects') ? 'bg-blue-700 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                        <svg class="w-5 h-5 {{ Request::routeIs('freelancer.ongoing_projects') ? 'text-white' : 'text-gray-500' }} transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="ms-3">Ongoing Project</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('freelancer.waiting_payment')}}" 
                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white {{ Request::routeIs('freelancer.waiting_payment') ? 'bg-blue-700 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                        <svg class="w-5 h-5 {{ Request::routeIs('freelancer.waiting_payment') ? 'text-white' : 'text-gray-500' }} transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Menunggu Pembayaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('freelancer.history')}}" 
                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white {{ Request::routeIs('freelancer.history') ? 'bg-blue-700 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                        <svg class="w-5 h-5 {{ Request::routeIs('freelancer.history') ? 'text-white' : 'text-gray-500' }} transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">History</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile') }}" 
                       class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white {{ Request::routeIs('user.profile') ? 'bg-blue-700 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                        <svg class="w-5 h-5 {{ Request::routeIs('user.profile') ? 'text-white' : 'text-gray-500' }} transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" 
                        onclick="confirmLogout('{{ route('logout') }}')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 hover:text-white dark:hover:bg-red-600 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-white dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            @yield('konten')  
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmLogout(logoutUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin logout?',
            text: "Anda akan keluar dari sesi ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = logoutUrl;
            }
        });
    }
</script>
</body>
</html>
