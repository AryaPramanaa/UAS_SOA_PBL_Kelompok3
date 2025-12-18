<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if(app()->environment('testing'))
        {{-- Skip Vite asset injection during tests to avoid manifest errors --}}
    @else
        @vite('resources/css/app.css')
    @endif
    <title>SIMAG-homepage</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">
        
    <style>
        @keyframes slide {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-100%);
            }
        }

        .animate-slide {
            animation: slide 20s linear infinite;
        }

        .partners-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }

        .partners-container:hover .animate-slide {
            animation-play-state: paused;
        }

        .partners-container::before,
        .partners-container::after {
            content: "";
            position: absolute;
            top: 0;
            width: 100px;
            height: 100%;
            z-index: 2;
        }

        .partners-container::before {
            left: 0;
            background: linear-gradient(to right, #f1f4f5 0%, transparent 100%);
        }

        .partners-container::after {
            right: 0;
            background: linear-gradient(to left, #f1f4f5 0%, transparent 100%);
        }

        @media (max-width: 768px) {
            .mobile-menu {
                display: none;
            }
            
            .mobile-menu.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 1rem;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            }
        }
        #hero-img-slider {
            transition: opacity 0.7s ease;
        }
    </style>
</head>

<body class="bg-[#f1f4f5] font-['Poppins']">
    <!-- Navbar Wrapper Centered & Full Height -->
    <div class="flex items-center justify-center min-h-[100px] bg-transparent w-full">
      <nav class="flex flex-row max-w-7xl w-full justify-between items-center px-4 py-3 mt-6 bg-white rounded-2xl shadow-lg">
        <!-- Logo & Judul -->
        <div class="flex gap-x-1 items-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#16a34a" class="size-8">
            <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/>
            <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z"/>
            <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z"/>
          </svg>
          <span class="font-bold text-2xl">SIMAG</span>
        </div>
        <!-- Hamburger (Mobile) -->
        {{-- <button class="md:hidden" onclick="toggleMenu()">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16" />
          </svg>
        </button> --}}
        <!-- Nav Menu -->
        <ul class="hidden md:flex flex-row gap-x-7 mobile-menu">
          <li><a href="#hero" class="text-base text-green-950 hover:text-green-600 hover:font-semibold">Home</a></li>
          <li><a href="#pengumuman" class="text-base text-green-950 hover:text-green-600 hover:font-semibold">Announcement</a></li>
          <li><a href="#partners" class="text-base text-green-950 hover:text-green-600 hover:font-semibold">Companies</a></li>
          <li><a href="#footer" class="text-base text-green-950 hover:text-green-600 hover:font-semibold">About</a></li>
        </ul>
        <!-- Sign In Button -->
        <div class="hidden md:flex">
          <a href="/entry" class="bg-green-700 text-white py-3 px-8 rounded-full font-semibold hover:bg-green-600 transition-colors duration-300">Sign in</a>
        </div>
      </nav>
    </div>
    <!-- END NAVBAR -->

    <section id="hero" class="hero max-w-7xl mx-auto mt-10  py-28 px-5 bg-gradient-to-br from-green-50 to-white rounded-3xl shadow mb-12">
        <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-8">
            <div class="flex flex-col gap-y-10 w-full md:w-1/2">
                <div class="flex gap-y-2 flex-col text-center md:text-left">
                    <h1 class="text-slate-950 font-['Manrope'] font-extrabold text-4xl lg:text-[60px] leading-tight drop-shadow-sm">
                        Temukan <span class="text-green-700">Magang Impianmu</span> <br class="hidden md:block">di SIMAG
                    </h1>
                    <p class="text-lg leading-loose text-gray-500">
                        Koneksi langsung ke perusahaan terbaik sesuai jurusan dan minat karirmu. Mulai perjalanan profesionalmu hari ini!
                    </p>
                </div>
                <div class="flex justify-center md:justify-start">
                    <a href="#internships"
                        class="w-full md:w-fit text-lg hover:bg-green-600 bg-green-700 text-white py-4 px-10 rounded-full font-bold shadow-lg transition-colors duration-300">Jelajahi Lowongan
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex justify-center">
                <img id="hero-img-slider" src="imgFE/GedungPNP1.jpg" alt="Internship"
                    class="w-full h-auto max-h-[450px] rounded-3xl object-cover shadow-xl border-4 border-white">
            </div>
        </div>
    </section>

    <!-- Pengumuman Section Start -->
    <section id="pengumuman" class="max-w-7xl mx-auto py-8 px-5">
        <div class="flex flex-col items-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-2 font-['Manrope']">Pengumuman</h2>
            <p class="text-gray-500 text-base">Informasi terbaru dari operator SIMAG</p>
        </div>
        @php
            $count = isset($pengumumans) ? count($pengumumans) : 0;
        @endphp
        @if($count === 1)
            <div class="flex justify-center">
                @foreach($pengumumans as $item)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-shadow border-l-4 border-green-600 w-full max-w-xl">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row justify-between items-center w-full">
                                <span class="text-green-700 font-semibold">Tanggal Buka: {{ $item->tanggal_buka ? date('d M Y', strtotime($item->tanggal_buka)) : '-' }}</span>
                                <span class="text-green-700 font-semibold">Tanggal Tutup: {{ $item->tanggal_tutup ? date('d M Y', strtotime($item->tanggal_tutup)) : '-' }}</span>
                            </div>
                            <div class="w-full flex justify-center">
                                <span class="text-gray-500 font-semibold ">Tahun Akademik: {{ $item->tahun_akademik }}</span>
                            </div>
                            <span class="text-gray-800 block text-center font-semibold">{{ $item->deskripsi }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($count === 2)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($pengumumans as $item)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-shadow border-l-4 border-green-600">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row justify-between items-center w-full">
                                <span class="text-green-700 font-semibold">Tanggal Buka: {{ $item->tanggal_buka ? date('d M Y', strtotime($item->tanggal_buka)) : '-' }}</span>
                                <span class="text-green-700 font-semibold">Tanggal Tutup: {{ $item->tanggal_tutup ? date('d M Y', strtotime($item->tanggal_tutup)) : '-' }}</span>
                            </div>
                            <div class="w-full flex justify-center">
                                <span class="text-gray-800 font-semibold text-lg">Tahun Akademik: {{ $item->tahun_akademik }}</span>
                            </div>
                            <span class="text-gray-600 block text-center">Deskripsi: {{ $item->deskripsi }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($count > 2)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($pengumumans->take(2) as $item)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-shadow border-l-4 border-green-600">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row justify-between items-center w-full">
                                <span class="text-green-700 font-semibold">Tanggal Buka: {{ $item->tanggal_buka ? date('d M Y', strtotime($item->tanggal_buka)) : '-' }}</span>
                                <span class="text-green-700 font-semibold">Tanggal Tutup: {{ $item->tanggal_tutup ? date('d M Y', strtotime($item->tanggal_tutup)) : '-' }}</span>
                            </div>
                            <div class="w-full flex justify-center">
                                <span class="text-gray-800 font-semibold text-lg">Tahun Akademik: {{ $item->tahun_akademik }}</span>
                            </div>
                            <span class="text-gray-600 block text-center">Deskripsi: {{ $item->deskripsi }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center mt-6">
                @foreach($pengumumans->slice(2) as $item)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-shadow border-l-4 border-green-600 w-full max-w-xl mx-2">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row justify-between items-center w-full">
                                <span class="text-green-700 font-semibold">Tanggal Buka: {{ $item->tanggal_buka ? date('d M Y', strtotime($item->tanggal_buka)) : '-' }}</span>
                                <span class="text-green-700 font-semibold">Tanggal Tutup: {{ $item->tanggal_tutup ? date('d M Y', strtotime($item->tanggal_tutup)) : '-' }}</span>
                            </div>
                            <div class="w-full flex justify-center">
                                <span class="text-gray-800 font-semibold text-lg">Tahun Akademik: {{ $item->tahun_akademik }}</span>
                            </div>
                            <span class="text-gray-600 block text-center">Deskripsi: {{ $item->deskripsi }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-600 text-center">
                <h3 class="font-bold text-xl mb-1">Belum ada pengumuman terbaru.</h3>
            </div>
        @endif
    </section>
    <!-- Pengumuman Section End -->

    <section id="partners" class="partners max-w-7xl mx-auto py-12 overflow-hidden">
        <div class="partners-container bg-white rounded-2xl shadow-lg border border-gray-100 py-6">
            <div class="flex gap-x-16 animate-slide items-center">
                <img src="imgFE/pertamina.png" alt="pertamina logo" class="w-40 grayscale hover:grayscale-0 transition">
                <img src="imgFE/trakindo.png" alt="trakindo logo" class="w-40 grayscale hover:grayscale-0 transition">
                <img src="imgFE/united_tractor.png" alt="united tractor logo" class="w-40 grayscale hover:grayscale-0 transition">
                <img src="imgFE/toyota.png" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">
                <img src="imgFE/MSU-Management-Science-University-1.png" alt="pertamina logo" class="w-40 grayscale hover:grayscale-0 transition">
                <img src="imgFE/Red_Hat-Logo.wine_-768x512.png" alt="trakindo logo" class="w-40 grayscale hover:grayscale-0 transition">
                <img src="imgFE/united_tractor.png" alt="united tractor logo" class="w-40 grayscale hover:grayscale-0 transition">
                <img src="imgFE/mikrotik-academy-logo.jpg" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">  
                <img src="imgFE/cisco.jpg" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">
                <img src="imgFE/LiuGong-Indonesia-01.jpg" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">
                <img src="imgFE/Logo_PLN.png" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">
                <img src="imgFE/Logo_Semen_Padang.png" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">
                <img src="imgFE/logo-PT-kurnia-abadi.jpeg" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">
                <img src="imgFE/logo-pt-peruri.png" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">
                <img src="imgFE/logo-pt-witbox-creative-media.jpeg" alt="toyota logo" class="w-20 grayscale hover:grayscale-0 transition">

            </div>
        </div>
    </section>

    <section id="features" class="features max-w-7xl mx-auto py-16 text-center ">
        <div class="flex flex-col mb-8">
            <h3 class="text-slate-950 font-['Manrope'] font-extrabold text-[44px] mb-2">
                Kenapa <span class="text-green-700">SIMAG?</span>
            </h3>
            <p class="text-lg leading-loose text-gray-500">
                Kami menghubungkan mahasiswa dengan <span class="text-green-700 font-semibold">kesempatan magang terbaik</span>
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="my-card bg-white rounded-2xl p-8 flex flex-col gap-y-5 items-center shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2 border-t-4 border-green-600">
                <svg class="w-11 h-11 fill-none stroke-green-600 bg-green-100 rounded-2xl p-2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22 10V16M21.42 10.922C21.599 10.843 21.7509 10.7133 21.8569 10.5488C21.9629 10.3843 22.0183 10.1924 22.0163 9.99674C22.0143 9.80108 21.9549 9.61032 21.8455 9.44808C21.7362 9.28584 21.5816 9.15925 21.401 9.084L12.83 5.18C12.5694 5.06115 12.2864 4.99964 12 4.99964C11.7136 4.99964 11.4306 5.06115 11.17 5.18L2.6 9.08C2.42196 9.15797 2.27051 9.28613 2.16416 9.44881C2.05781 9.61149 2.00117 9.80164 2.00117 9.996C2.00117 10.1904 2.05781 10.3805 2.16416 10.5432C2.27051 10.7059 2.42196 10.834 2.6 10.912L11.17 14.82C11.4306 14.9388 11.7136 15.0004 12 15.0004C12.2864 15.0004 12.5694 14.9388 12.83 14.82L21.42 10.922Z"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M6 12.5V16C6 16.7956 6.63214 17.5587 7.75736 18.1213C8.88258 18.6839 10.4087 19 12 19C13.5913 19 15.1174 18.6839 16.2426 18.1213C17.3679 17.5587 18 16.7956 18 16V12.5"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="font-bold text-2xl ">
                    Major-Specific Opportunities
                </h3>
                <p class="text-base leading-loose text-gray-500">
                    Temukan magang yang disesuaikan dengan bidang studi dan tujuan karir Anda.
                </p>
            </div>
            <div class="my-card bg-white rounded-2xl p-8 flex flex-col gap-y-5 items-center shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2 border-t-4 border-green-600">
                <svg class="w-11 h-11 fill-none stroke-green-600 bg-green-100 rounded-2xl p-2"viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M3 21H21M9 8H10M9 12H10M9 16H10M14 8H15M14 12H15M14 16H15M5 21V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H17C17.5304 3 18.0391 3.21071 18.4142 3.58579C18.7893 3.96086 19 4.46957 19 5V21"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <h3 class="font-bold text-2xl ">
                    Top Companies
                </h3>
                <p class="text-base leading-loose text-gray-500">
                    Terhubung dengan perusahaan-perusahaan terkemuka yang mencari mahasiswa berbakat seperti Anda.
                </p>
            </div>
            <div class="my-card bg-white rounded-2xl p-8 flex flex-col gap-y-5 items-center shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2 border-t-4 border-green-600">
                <svg class="w-11 h-11 fill-green-600 stroke-green-600 bg-green-100 rounded-2xl p-2" viewBox="0 0 28 28"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M19.223 14.616C21.616 14.616 23.566 12.4845 23.566 9.89101C23.566 7.32701 21.626 5.29601 19.223 5.29601C16.84 5.29601 14.8795 7.35701 14.8795 9.91101C14.8895 12.4945 16.84 14.616 19.223 14.616ZM7.641 14.837C9.712 14.837 11.411 12.977 11.411 10.695C11.411 8.463 9.732 6.66351 7.641 6.66351C5.57 6.66351 3.861 8.49351 3.871 10.715C3.881 12.9875 5.57 14.837 7.641 14.837ZM19.223 13.098C17.755 13.098 16.498 11.6905 16.498 9.91101C16.498 8.16101 17.735 6.81451 19.223 6.81451C20.721 6.81451 21.9475 8.14151 21.9475 9.89051C21.9475 11.6705 20.711 13.098 19.223 13.098ZM7.641 13.339C6.4145 13.339 5.369 12.163 5.369 10.715C5.369 9.29751 6.404 8.16151 7.641 8.16151C8.9075 8.16151 9.923 9.2775 9.923 10.695C9.923 12.163 8.8775 13.339 7.641 13.339ZM2.051 24.0565H9.9435C9.4605 23.785 9.0885 23.1815 9.159 22.5685H1.8C1.599 22.5685 1.4985 22.4885 1.4985 22.297C1.4985 19.804 4.3435 17.4715 7.6315 17.4715C8.898 17.4715 10.034 17.773 11.0095 18.346C11.3331 17.9363 11.716 17.5772 12.1455 17.2805C10.8485 16.4255 9.2905 15.9835 7.6315 15.9835C3.4185 15.9835 0 19.0395 0 22.3875C0 23.5035 0.6835 24.0565 2.051 24.0565ZM12.909 24.0565H25.537C27.2055 24.0565 28 23.554 28 22.448C28 19.814 24.672 16.003 19.223 16.003C13.7635 16.003 10.436 19.814 10.436 22.448C10.436 23.554 11.23 24.0565 12.909 24.0565ZM12.4265 22.5385C12.165 22.5385 12.0545 22.4685 12.0545 22.257C12.0545 20.608 14.608 17.522 19.223 17.522C23.828 17.522 26.381 20.608 26.381 22.257C26.381 22.468 26.281 22.5385 26.019 22.5385H12.4265Z" />
                </svg>

                <h3 class="font-bold text-2xl ">
                    Career Support
                </h3>
                <p class="text-base leading-loose text-gray-500">
                    Dapatkan panduan dan dukungan untuk membantu Anda berhasil dalam magang Anda.
                </p>
            </div>
        </div>
    </section>

    <section id="internships" class="internships max-w-7xl mx-auto py-16 ">
        <div class="flex flex-col justify-center items-center text-center mb-8">
            <h3 class="text-slate-950 font-['Manrope'] font-extrabold text-[44px] mb-2">
                Lowongan Magang <span class="text-green-700">Terbaru</span>
            </h3>
            <p class="text-lg leading-loose text-gray-500">
                Temukan peluang sesuai jurusan dan minatmu
            </p>
        </div>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($lowongans as $lowongan)
                <div class="my-card bg-white rounded-2xl p-8 flex flex-col shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2">
                    <div class="flex flex-col items-center pb-4">
                        <h3 class="font-bold text-2xl ">
                            {{ $lowongan->divisi }}
                        </h3>
                        <p class="text-base leading-loose text-gray-500">
                            {{ $lowongan->perusahaan->nama_perusahaan ?? '-' }}
                        </p>
                    </div>
                    <div class="flex flex-row gap-x-2 items-center pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>  
                        <p class="text-base leading-loose text-gray-950">
                            {{ $lowongan->perusahaan->alamat ?? '-' }}
                        </p>
                    </div>
                    <div class="flex flex-row gap-x-2 items-center pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                        </svg>                          
                        <p class="text-base leading-loose text-gray-950">
                            Kuota: {{ $lowongan->kuota ?? '-' }}
                        </p>
                    </div>
                    <div class="flex justify-center p-2 bg-gray-200 rounded-2xl  hover:text-green-600 hover:bg-green-100 hover:rounded-xl m-4  active:text-green-600 active:bg-green-100 active:rounded-xl">
                        <a href="/entry">View Detail</a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-500">Belum ada lowongan magang tersedia.</div>
            @endforelse
        </div>
    </section>

    <section id="footer" class="footer w-full bg-green-950 rounded-t-3xl mt-16">
        <div class="max-w-6xl mx-auto pt-12 grid grid-cols-1 md:grid-cols-3 gap-8 justify-items-strech">
            <div class="identity flex flex-col gap-y-7 justify-self-start">
                <div class="flex flex-row  gap-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#16a34a"
                        class="size-8 flex-initial ">
                        <path
                            d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                        <path
                            d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                        <path
                            d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                    </svg>
                    <span class="flex-initial font-bold text-white text-2xl">SIMAG</span>
                </div>
                <p class="text-base leading-loose text-gray-500">
                    Politeknik Negeri Padang <br>
                    Teknologi Informasi <br>
                    D4 Teknologi Rekayasa Perangkat Lunak <br>
                </p>
                <div class="flex flex-row gap-x-2 items-center ">
                    <a href="">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#16a34a"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.484 11.976L22.635 6.632V17.259L16.484 11.976ZM8.558 12.881L10.718 14.756C11.057 15.044 11.499 15.218 11.982 15.218H11.999H12.012C12.496 15.218 12.938 15.043 13.281 14.753L13.278 14.755L15.438 12.88L22.004 18.519H1.995L8.558 12.881ZM1.986 5.365H22.016L12.395 13.721C12.2873 13.8074 12.1531 13.854 12.015 13.853H12.001H11.988C11.8495 13.854 11.7148 13.807 11.607 13.72L11.608 13.721L1.986 5.365ZM1.365 6.631L7.515 11.975L1.365 17.255V6.631ZM22.965 4.19C22.725 4.07 22.443 4 22.144 4H1.859C1.56929 4.00115 1.28367 4.06853 1.024 4.197L1.035 4.192C0.724866 4.34548 0.463696 4.58244 0.280854 4.87622C0.0980128 5.17 0.00074936 5.50897 0 5.855L0 18.027C0.000529404 18.5196 0.196452 18.9919 0.54478 19.3402C0.893108 19.6885 1.36539 19.8845 1.858 19.885H22.141C22.6336 19.8845 23.1059 19.6885 23.4542 19.3402C23.8025 18.9919 23.9985 18.5196 23.999 18.027V5.855C23.999 5.128 23.58 4.498 22.97 4.195L22.959 4.19H22.965Z"
                                fill="#16a34a" />
                        </svg>
                    </a>
                    <a href="">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#16a34a"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.752 6.925C3.74668 6.82664 3.72204 6.73029 3.67949 6.64145C3.63693 6.55261 3.5773 6.47303 3.50399 6.40724C3.43067 6.34145 3.34512 6.29074 3.25221 6.25801C3.15931 6.22529 3.06086 6.21118 2.9625 6.2165C2.86414 6.22182 2.76779 6.24646 2.67895 6.28901C2.59012 6.33156 2.51053 6.3912 2.44474 6.46451C2.37895 6.53782 2.32824 6.62338 2.29552 6.71628C2.26279 6.80919 2.24868 6.90764 2.254 7.006L3.752 6.925ZM4.718 3.092C4.58667 3.23714 4.51728 3.42787 4.52465 3.62347C4.53202 3.81907 4.61558 4.00404 4.75746 4.13888C4.89935 4.27372 5.08834 4.34775 5.28406 4.34515C5.47978 4.34256 5.66674 4.26355 5.805 4.125L4.718 3.092ZM10.664 19.812C10.7474 19.8657 10.8406 19.9024 10.9383 19.9199C11.036 19.9373 11.1361 19.9352 11.233 19.9137C11.3298 19.8922 11.4214 19.8517 11.5025 19.7945C11.5836 19.7373 11.6525 19.6646 11.7053 19.5806C11.7581 19.4966 11.7937 19.4029 11.81 19.3051C11.8264 19.2072 11.8231 19.1071 11.8005 19.0105C11.7779 18.9139 11.7363 18.8227 11.6782 18.7423C11.6201 18.6619 11.5466 18.5938 11.462 18.542L10.664 19.812ZM15.113 20.058C14.9182 20.0173 14.7152 20.0556 14.5487 20.1646C14.3821 20.2735 14.2657 20.4442 14.225 20.639C14.1843 20.8338 14.2226 21.0368 14.3316 21.2033C14.4405 21.3699 14.6112 21.4863 14.806 21.527L15.113 20.058ZM15.645 15.544L16.1 15.064L15.012 14.031L14.557 14.511L15.645 15.544ZM17.599 14.862L19.509 15.962L20.258 14.662L18.347 13.562L17.599 14.862ZM19.878 18.242L18.457 19.737L19.545 20.771L20.965 19.275L19.878 18.242ZM8.359 15.959C4.483 11.878 3.833 8.435 3.752 6.925L2.254 7.006C2.354 8.856 3.138 12.64 7.272 16.992L8.359 15.959ZM9.735 9.322L10.021 9.02L8.934 7.987L8.647 8.289L9.735 9.322ZM10.247 5.26L8.986 3.477L7.761 4.343L9.021 6.126L10.247 5.26ZM9.19 8.805C9.01003 8.63154 8.82836 8.45987 8.645 8.29L8.643 8.292L8.64 8.295L8.59 8.353C8.49208 8.48282 8.41452 8.6268 8.36 8.78C8.262 9.055 8.21 9.419 8.276 9.873C8.406 10.765 8.991 11.964 10.518 13.573L11.606 12.539C10.178 11.036 9.826 10.111 9.76 9.655C9.728 9.435 9.76 9.32 9.773 9.283L9.781 9.264L9.753 9.301L9.735 9.322L9.19 8.805ZM10.518 13.572C12.041 15.176 13.191 15.806 14.068 15.949C14.519 16.022 14.884 15.963 15.16 15.854C15.3134 15.7944 15.456 15.7099 15.582 15.604L15.617 15.57L15.631 15.556L15.638 15.55L15.641 15.547L15.642 15.545C15.642 15.545 15.644 15.544 15.1 15.027C14.556 14.511 14.557 14.51 14.557 14.509L14.559 14.508L14.561 14.505L14.567 14.5L14.614 14.458C14.6233 14.4527 14.6217 14.453 14.609 14.459C14.589 14.467 14.499 14.499 14.309 14.468C13.907 14.402 13.039 14.048 11.606 12.539L10.518 13.572ZM8.986 3.477C7.972 2.043 5.944 1.8 4.718 3.092L5.805 4.125C6.328 3.575 7.249 3.618 7.761 4.343L8.986 3.477ZM18.457 19.737C18.178 20.031 17.887 20.189 17.603 20.217L17.75 21.709C18.497 21.636 19.102 21.238 19.545 20.771L18.457 19.737ZM10.021 9.02C10.989 8.001 11.057 6.407 10.247 5.26L9.022 6.126C9.444 6.723 9.379 7.519 8.934 7.987L10.021 9.02ZM19.509 15.962C20.33 16.435 20.491 17.597 19.878 18.242L20.965 19.275C22.27 17.901 21.89 15.602 20.258 14.662L19.509 15.962ZM16.1 15.064C16.485 14.658 17.086 14.567 17.599 14.862L18.347 13.562C17.248 12.93 15.887 13.111 15.012 14.031L16.1 15.064ZM11.462 18.542C10.479 17.924 9.432 17.088 8.359 15.959L7.272 16.992C8.426 18.207 9.569 19.124 10.664 19.812L11.462 18.542ZM17.602 20.217C16.7691 20.2897 15.9299 20.2361 15.113 20.058L14.806 21.527C15.7725 21.7358 16.7651 21.7972 17.75 21.709L17.602 20.217Z"
                                fill="#16a34a" />
                        </svg>
                    </a>
                    <a href="#">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.5 12C2.5 7.522 2.5 5.282 3.891 3.891C5.282 2.5 7.521 2.5 12 2.5C16.478 2.5 18.718 2.5 20.109 3.891C21.5 5.282 21.5 7.521 21.5 12C21.5 16.478 21.5 18.718 20.109 20.109C18.718 21.5 16.479 21.5 12 21.5C7.522 21.5 5.282 21.5 3.891 20.109C2.5 18.718 2.5 16.479 2.5 12Z"
                                stroke="#16a34a" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M17.508 6.5H17.498M16.5 12C16.5 13.1935 16.0259 14.3381 15.182 15.182C14.3381 16.0259 13.1935 16.5 12 16.5C10.8065 16.5 9.66193 16.0259 8.81802 15.182C7.97411 14.3381 7.5 13.1935 7.5 12C7.5 10.8065 7.97411 9.66193 8.81802 8.81802C9.66193 7.97411 10.8065 7.5 12 7.5C13.1935 7.5 14.3381 7.97411 15.182 8.81802C16.0259 9.66193 16.5 10.8065 16.5 12Z"
                                stroke="#16a34a" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="resource flex flex-col gap-7 justify-self-center">
                <h1 class="text-white font-['Manrope] font-bold text-2xl ">
                    Resource<br>
                </h1>
                <p class="text-base leading-loose text-gray-500">
                    <a href="#">
                        Help Center <br>
                    </a>
                    <a href="#">
                        About us <br>
                    </a>
                </p>
            </div>

            <div class="company flex flex-col gap-7 justify-self-end">
                <h1 class="text-white font-['Manrope] font-bold text-2xl ">
                    Company <br>
                </h1>
                <p class="text-base leading-loose text-gray-500">
                    <a href="#">
                        Privacy and Policy <br>
                    </a>
                    <a href="#">
                        Terms and Condition <br>
                    </a>
                </p>
            </div>
        </div>
        <div class="copyright border-t border-green-800 mt-8">
            <p class="text-base leading-loose text-gray-400 py-8 flex justify-center">
                &copy; 2025 SIMAG by Kelompok 3 PBL 2B TRPL Padang. All Rights Reserved.
            </p>
        </div>
    </section>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('.mobile-menu');
            menu.classList.toggle('active');
        }

        // Optional: Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.querySelector('.mobile-menu');
            const button = document.querySelector('button');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    </script>
    <script>
const heroImages = [
    'imgFE/GedungPNP1.jpg',
    'imgFE/GedungPNP2.jpg',
    'imgFE/magang.jpg'
];
let heroCurrent = 0;
const heroImg = document.getElementById('hero-img-slider');
function showHeroImg(idx) {
    heroImg.style.opacity = 0;
    setTimeout(() => {
        heroImg.src = heroImages[idx];
        heroImg.style.opacity = 1;
    }, 400);
}
function nextHeroImg() {
    heroCurrent = (heroCurrent + 1) % heroImages.length;
    showHeroImg(heroCurrent);
}
setInterval(nextHeroImg, 4000);
</script>
</body>

</html>
