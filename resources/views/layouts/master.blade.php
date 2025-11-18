<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Job Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons (masih boleh dipakai untuk ikon cepat) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen font-sans antialiased">

    <div class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav class="bg-emerald-700 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">

                    <!-- Brand -->
                    <div class="flex items-center space-x-2">
                        <i class="bi bi-briefcase-fill text-2xl text-white"></i>
                        <a href="{{ route('jobs.index') }}" class="text-xl font-semibold text-white hover:text-emerald-200">
                            Admin Panel
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('jobs.index') }}" class="text-gray-100 hover:text-white flex items-center gap-1">
                            <i class="bi bi-briefcase"></i> Lowongan
                        </a>

                        <a href="{{ route('admin.jobs.index') }}" class="text-gray-100 hover:text-white flex items-center gap-1">
                            <i class="bi bi-gear"></i> Kelola Lowongan
                        </a>

                        <a href="{{ route('admin.applications.index', 1) }}" class="text-gray-100 hover:text-white flex items-center gap-1">
                            <i class="bi bi-people"></i> Pelamar
                        </a>

                        <a href="{{ route('dashboard') }}" class="text-gray-100 hover:text-white flex items-center gap-1">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-gray-100 hover:text-emerald-300 flex items-center gap-1 focus:outline-none">
                                <i class="bi bi-box-arrow-right"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 py-10 px-6 sm:px-8 bg-gray-900">
            @yield('page-content')
        </main>

        <!-- Footer -->
        <footer class="bg-emerald-800 text-gray-200 py-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} Job Portal. Semua hak dilindungi.</p>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
