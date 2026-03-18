<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside
            class="w-72 bg-slate-900 text-slate-300 flex flex-col shadow-2xl border-r border-slate-800 h-screen sticky top-0 z-50">

            <div class="p-8 border-b border-slate-800/50 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div
                        class="h-9 w-9 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-black tracking-tight text-white uppercase italic">Atomic</h2>
                </div>
            </div>

            <div class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar overflow-x-hidden">
                <p class="px-4 text-[11px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Main Menu</p>

                <nav class="space-y-1">
                    @foreach ($navs as $nav)
                        @php
                            $isActive = request()->url() == url($nav['url']);
                        @endphp

                        <a href="{{ $nav['url'] }}"
                            class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 relative
                {{ $isActive
                    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                    : 'hover:bg-slate-800 hover:text-white' }}">

                            @if ($isActive)
                                <span
                                    class="absolute left-0 w-1 h-6 bg-white rounded-r-full shadow-[0_0_8px_white]"></span>
                            @endif

                            <svg class="w-5 h-5 mr-3 {{ $isActive ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }} transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h8m-8 6h16" />
                            </svg>

                            <span class="font-medium text-sm tracking-wide">
                                {{ $nav['title'] }}
                            </span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="p-4 mt-auto border-t border-slate-800/50 bg-slate-900 flex-shrink-0">
                <div class="flex items-center p-3 rounded-xl bg-slate-800/40 border border-slate-700/50">
                    <div
                        class="h-10 w-10 rounded-lg bg-slate-700 flex items-center justify-center font-bold text-white border border-slate-600 flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 truncate">Administrator</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-auto m-0">
                        @csrf
                        <button type="submit" class="p-2 text-slate-500 hover:text-red-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #334155;
                /* slate-700 */
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #475569;
                /* slate-600 */
            }
        </style>


        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>

</html>
