<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        <h1 class="text-4xl font-bold text-slate-900 mb-2 tracking-tight">Create an account</h1>
        <p class="text-slate-500 mb-8">
            Already have an account?
            <a href="{{ route('login') }}" class="underline text-indigo-600 font-bold hover:text-indigo-700">Log in</a>
        </p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Full Name"
                    class="w-full border border-slate-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" required placeholder="email@example.com"
                    class="w-full border border-slate-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400">
            </div>

            <div>
                <div class="flex justify-between mb-2">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wide">Password</label>
                    <button type="button" id="togglePassword"
                        class="text-sm text-indigo-600 font-bold hover:underline">Show</button>
                </div>
                <input type="password" id="password" name="password" required
                    class="w-full border border-slate-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide"
                    for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password"
                    class="w-full border border-slate-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-4 rounded-full font-bold text-lg hover:bg-indigo-700 shadow-md transition-all active:scale-95">
                Register
            </button>
        </form>
    </div>

    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        toggleBtn.addEventListener('click', () => {
            const isPassword = password.type === 'password';

            password.type = isPassword ? 'text' : 'password';
            confirmPassword.type = isPassword ? 'text' : 'password';

            toggleBtn.textContent = isPassword ? 'Hide' : 'Show';
        });
    </script>
</body>

</html>
