<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Portal')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @media print{
            .no-print{display:none!important;}
            body{background:white!important;}
        }
    </style>
</head>

<body class="h-full font-sans text-slate-800 antialiased flex flex-col">

<!-- ================= NAVBAR ================= -->

<header class="bg-slate-900 text-white shadow-md sticky top-0 z-50 print:hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between h-16">

            <!-- Logo -->

            <div class="flex items-center gap-3">

                <div class="bg-blue-600 w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-wrench"></i>
                </div>

                <div>
                    <span class="font-bold text-lg tracking-wide block leading-tight">
                        MOTO<span class="text-blue-400">SERVIS</span>
                    </span>

                    <span class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">
                        Customer Portal
                    </span>
                </div>

            </div>

            <!-- User -->

            <div class="flex items-center gap-4">

                <div class="text-right hidden sm:block">

                    <div class="text-sm font-semibold text-slate-100">
                        {{ Auth::guard('customer')->user()->name }}
                    </div>

                    <div class="text-[11px] text-blue-400 uppercase tracking-wider font-medium">

                        <i class="fa-solid fa-user mr-1"></i>

                        CUSTOMER

                    </div>

                </div>

                <form action="{{ route('customer.logout') }}" method="POST">

                    @csrf

                    <button
                        class="bg-slate-800 hover:bg-rose-600 text-slate-300 hover:text-white p-2.5 rounded-xl border border-slate-700 hover:border-rose-500 transition">

                        <i class="fa-solid fa-right-from-bracket"></i>

                    </button>

                </form>

            </div>

        </div>

    </div>

</header>

<!-- ================= CONTENT ================= -->

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl px-4 py-3 mb-5">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="bg-red-100 border border-red-300 text-red-700 rounded-xl px-4 py-3 mb-5">

            {{ session('error') }}

        </div>

    @endif

    @yield('content')

</main>

<!-- ================= FOOTER ================= -->

<footer class="bg-white border-t border-slate-200 py-4">

    <div class="max-w-7xl mx-auto text-center text-xs text-slate-400">

        © {{ date('Y') }} MotoServis Customer Portal

    </div>

</footer>

</body>
</html>