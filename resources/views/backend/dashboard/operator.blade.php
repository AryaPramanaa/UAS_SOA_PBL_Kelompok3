<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Dashboard Operator</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('styles')
</head>

<body class="bg-gray-100 font-['Poppins']">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar w-[17%] md:w-[17%] top-0 left-0 min-h-screen bg-white shadow-lg transform transition-all duration-300 ease-in-out z-40 flex flex-col relative">
            <!-- Collapse/Expand Button -->
            <button id="sidebar-toggle" class="absolute top-4 right-[-16px] z-50 p-1 rounded-full bg-white shadow-lg border border-gray-200">
                <svg id="sidebar-toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path id="sidebar-toggle-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <!-- Logo -->
            <div class="flex items-center justify-center gap-x-3 py-8 border-b">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#16a34a" class="w-8 h-8">
                    <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                    <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                    <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                </svg>
                <span class="text-2xl font-bold sidebar-label transition-all duration-200 origin-left">SIMAG</span>
            </div>
            <!-- Navigation Links -->
            <div class="flex-1 flex flex-col justify-between overflow-y-auto">
                <ul class="px-4 py-6 space-y-2">
                    {{-- <li>
                        <a href=""
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Dashboard</span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ route('operator.lowonganPKL.index') }}"
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('operator/lowonganPKL') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Lowongan PKL</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('operator.pengumuman.index') }}"
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('operator/pengumuman') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Pengumuman</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('operator.suratPKL.index') }}"
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('operator/suratPKL') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Surat PKL</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('operator.perusahaanPKL.index') }}"
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('operator/perusahaanPKL*') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Perusahaan PKL</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('operator.jurusanProdi.index') }}"
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('operator/jurusanProdi') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Jurusan Prodi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('operator.pengajuanPKL.index') }}"
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('operator/pengajuanPKL*') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Pengajuan PKL</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('operator.akun.index') }}"
                            class="flex items-center gap-x-3 px-4 py-3 rounded-lg {{ request()->is('operator/akun') ? 'bg-green-100 text-green-600' : 'hover:bg-gray-100' }} transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="sidebar-label transition-all duration-200 origin-left">Akun</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Info & Logout -->
            <div class="px-4 py-6 border-t">
                <div class="px-4 py-3 rounded-lg bg-gray-100 mb-4 flex items-center gap-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-600 sidebar-label transition-all duration-200 origin-left">{{ Auth::user()->username }}</p>
                        <p class="text-xs text-gray-500 sidebar-label transition-all duration-200 origin-left">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="flex items-center justify-between px-4 py-3 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                    <span class="font-medium sidebar-label transition-all duration-200 origin-left">Logout</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                </a>
            </div>
        </nav>
        <!-- Main Content -->
        <main id="main-content" class="transition-all duration-300 flex-1 min-h-screen">
            <div class="p-6">
                <div class="bg-white rounded-xl shadow-sm">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    @stack('scripts')
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarLabels = document.querySelectorAll('.sidebar-label');
        const sidebarTogglePath = document.getElementById('sidebar-toggle-path');
        let isCollapsed = false;
        // Collapse/Expand Sidebar
        sidebarToggle?.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            sidebar.classList.toggle('collapsed', isCollapsed);
            sidebarLabels.forEach(label => label.classList.toggle('hidden', isCollapsed));
            // Ganti arah panah
            sidebarTogglePath.setAttribute('d', isCollapsed
                ? 'M9 5l7 7-7 7' // panah kanan
                : 'M15 19l-7-7 7-7' // panah kiri
            );
            // Simpan state ke localStorage
            localStorage.setItem('sidebarCollapsedOperator', isCollapsed ? '1' : '0');
        });
        // Saat halaman dimuat, cek localStorage
        document.addEventListener('DOMContentLoaded', () => {
            const collapsed = localStorage.getItem('sidebarCollapsedOperator') === '1';
            if (collapsed) {
                isCollapsed = true;
                sidebar.classList.add('collapsed');
                sidebarLabels.forEach(label => label.classList.add('hidden'));
                sidebarTogglePath.setAttribute('d', 'M9 5l7 7-7 7');
            }
        });
    </script>
    <style>
        .sidebar.collapsed {
            width: 5rem !important;
        }
        .sidebar.collapsed .sidebar-label {
            display: none !important;
        }
        .sidebar a {
            width: 100%;
            min-height: 48px;
        }
        .sidebar .bg-green-100,
        .sidebar .bg-gray-100 {
            width: 100%;
        }
    </style>
</body>

</html>
