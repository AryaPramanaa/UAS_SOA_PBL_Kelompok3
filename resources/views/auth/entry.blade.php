<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Sistem Manajemen Magang</title>

    @vite('resources/css/app.css')

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="{{ asset('js/lucide.js') }}"></script>
    <script>
        lucide.createIcons();
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-transition {
            transition: all 0.3s ease;
        }

        .input-transition:focus {
            transform: translateY(-2px);
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .gradient-background {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }
    </style>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: "#4f46e5",
                            foreground: "#ffffff",
                        },
                        muted: {
                            DEFAULT: "#f3f4f6",
                            foreground: "#6b7280",
                        },
                        accent: {
                            DEFAULT: "#eff6ff",
                            foreground: "#1e40af",
                        },
                    },
                }
            }
        }
    </script>
</head>

<body class="gradient-background font-['Poppins'] min-h-screen">
    <div class="flex min-h-screen relative items-center justify-center p-4">
        @if(session('error'))
            <div class="px-5 py-3 rounded-lg absolute top-5 right-5 bg-red-500 font-semibold text-xl text-white shadow-lg animate-fade-in">
                <p class="">{{ session('error') }}</p>
            </div>
        @endif
        <div class="w-full max-w-md rounded-2xl border border-gray-100 login-card p-8 shadow-xl animate-fade-in">
            <div class="flex flex-col items-center text-2xl pb-7">
                <div class="bg-green-100 p-4 rounded-full mb-3 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#16a34a"
                        class="size-12 flex-initial transform transition-transform hover:scale-110 duration-300">
                        <path
                            d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                        <path
                            d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                        <path
                            d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                    </svg>
                </div>
                <h3 class="text-slate-950 font-bold text-3xl bg-gradient-to-r from-green-600 to-green-400 bg-clip-text text-transparent">
                    SIMAG
                </h3>
            </div>

            <div class="space-y-2 text-center mb-8">
                <h2 class="text-2xl font-semibold text-gray-800">Login</h2>
                <p class="text-sm text-gray-500">Masukkan kredensial untuk mengakses akun Anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mt-4 rounded-md bg-blue-50 p-4 text-sm text-blue-600 dark:bg-blue-900/50 dark:text-blue-200 animate-fade-in">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mt-4 rounded-md bg-red-50 p-4 text-sm text-red-600 dark:bg-red-900/50 dark:text-red-200 animate-fade-in">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-6">
                <div class="mt-6">
                    <!-- Unified Login Form (works for all roles) -->
                    <form id="form-student" method="post" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label for="input_type" id="label_input"
                                class="text-sm font-medium text-gray-700 block">Username</label>
                            <input id="input_type" name="username" type="text"
                                placeholder="Masukkan Username atau NIM Anda" required
                                class="input-transition flex h-11 w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm placeholder:text-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-slate-900"
                                value="" autofocus>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="password"
                                    class="text-sm font-medium text-gray-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="" class="text-xs text-green-600 hover:text-green-700 hover:underline transition-colors">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>
                            <input id="password" name="password" type="password" placeholder="••••••••" required
                                class="input-transition flex h-11 w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm placeholder:text-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-slate-900">
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="remember" name="remember"
                                class="h-4 w-4 rounded border-gray-300 bg-white text-green-500 focus:ring-green-200">
                            <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
                        </div>

                        <button type="submit" id="login-button"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-green-500 px-4 py-3 text-sm font-medium text-white transition-all duration-300 hover:bg-green-600 hover:shadow-lg transform hover:-translate-y-0.5 focus:ring-2 focus:ring-green-200">
                            Login
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-8 flex flex-col space-y-4">
                <div class="text-center text-sm text-gray-500">
                    Tidak memiliki akun? <a href="{{ route('register.mahasiswa') }}" class="text-green-600 hover:underline">Daftar sebagai Mahasiswa</a>
                </div>
                <a href="/"
                    class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-green-600 transition-all duration-300 hover:bg-green-50 hover:shadow-md transform hover:-translate-y-0.5">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
    @yield('content')
</body>

</html>
