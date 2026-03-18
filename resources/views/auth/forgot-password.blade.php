<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen flex flex-col items-center justify-center p-6 text-slate-900">

    <div class="w-full max-w-[540px] bg-white border border-slate-200 rounded-2xl p-8 md:p-12 shadow-sm">

        <div class="flex items-center gap-3 mb-10">
            <div
                class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black tracking-tighter text-slate-900 uppercase italic">Atomic</h2>
        </div>

        <h1 class="text-4xl font-bold text-slate-900 mb-2 tracking-tight">
            Forgot password?
        </h1>

        <p class="text-slate-500 mb-8">
            Enter your email address and we’ll send you a link to reset your password.
        </p>

        @if (session('status'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-sm font-semibold text-emerald-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                    Email address
                </label>
                <input type="email" name="email" required autofocus placeholder="you@example.com"
                    class="w-full border border-slate-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-4 rounded-full font-bold text-lg hover:bg-indigo-700 shadow-md transition-all active:scale-95">
                Send Reset Link
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="underline text-indigo-600 font-bold hover:text-indigo-700">
                Back to login
            </a>
        </div>

    </div>

</body>

</html>
