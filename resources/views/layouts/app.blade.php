<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Bengkel Motor')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom Style Print -->
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="h-full font-sans text-slate-800 antialiased flex flex-col">

    <!-- NAVBAR ATAS (Sembunyi saat Cetak) -->
    <header class="bg-slate-900 text-white shadow-md sticky top-0 z-50 print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo / Brand -->
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-blue-500/30">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg tracking-wide block leading-tight">MOTO<span class="text-blue-400">SERVIS</span></span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">Bengkel Management System</span>
                    </div>
                </div>

                @if(auth()->check() && (auth()->user()->role_id == 1 || (auth()->user()->role && auth()->user()->role->name == 'admin')))
                    <nav class="hidden md:flex items-center gap-6 mt-1">
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition">Dashboard</a>
                        <a href="{{ route('workers.index') }}" class="text-sm font-medium text-slate-300 hover:text-white transition">Workers</a>
                        <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-300 hover:text-white transition">Products</a>
                    </nav>
                    @endif
                </div>

                <!-- Profile & Logout Status -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-semibold text-slate-100">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                        <div class="text-[11px] text-blue-400 font-medium uppercase tracking-wider">
                            <i class="fa-solid fa-user-shield text-[10px] mr-1"></i>
                            <!-- PERBAIKAN DI SINI: Menambahkan ->NAME atau ->name agar JSON tidak bocor -->
                            {{ auth()->user()->role->NAME ?? auth()->user()->role->name ?? auth()->user()->role ?? 'Guest' }}
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-slate-800 hover:bg-rose-600 text-slate-300 hover:text-white p-2.5 rounded-xl transition duration-200 border border-slate-700 hover:border-rose-500 text-xs flex items-center gap-2" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden md:inline font-medium">Logout</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <!-- AREA KONTEN UTAMA -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Notifikasi Global (Flash Messages) -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3.5 rounded-xl mb-6 flex items-center justify-between shadow-sm print:hidden">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3.5 rounded-xl mb-6 flex items-center justify-between shadow-sm print:hidden">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Tempat Menyisipkan View dari Anggota Kelompok -->
        @yield('content')

    </main>

    <!-- FOOTER (Sembunyi saat Cetak) -->
    <footer class="bg-white border-t border-slate-200 py-4 mt-auto print:hidden">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-400 font-medium">
            &copy; {{ date('Y') }} MotoServis System &bull; Kelompok Project Bengkel
        </div>
    </footer>

</body>
</html>