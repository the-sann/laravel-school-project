<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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

        <div class="flex  items-center gap-3 mb-10">
            <div
                class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black tracking-tighter text-slate-900 uppercase italic">Atomic</h2>

        </div>
        <hr>

        <h1 class="text-4xl font-bold text-slate-900 mb-2 tracking-tight">Log in</h1>
        <p class="text-slate-500 mb-8">
            Need an account? <a href="{{ route('register') }}"
                class="underline text-indigo-600 font-semibold hover:text-indigo-700">Create an account</a>
        </p>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" id="email" placeholder="e.g. joey@example.com"
                    class="w-full border border-slate-300 p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-xl transition-all placeholder:text-slate-400">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wide">Password</label>
                    <button type="button" id="togglePassword"
                        class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        <span id="toggleText">Show</span>
                    </button>
                </div>
                <input type="password" id="password" name="password"
                    class="w-full border border-slate-300 p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-xl transition-all">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="keep-logged"
                    class="w-5 h-5 border-slate-300 rounded accent-indigo-600 cursor-pointer">
                <label for="keep-logged" class="text-sm font-semibold text-slate-700 cursor-pointer">Keep me logged
                    in</label>
            </div>

            <button type="submit"
                class="w-full sm:w-auto bg-indigo-600 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-indigo-700 transition-all shadow-md active:scale-95">
                Log in
            </button>
        </form>

        <div class="mt-10 pt-6 border-t border-slate-100 flex flex-wrap gap-x-6 gap-y-3">
            <a href="#" class="text-indigo-600 underline font-semibold text-sm hover:text-indigo-700">Forgot
                username?</a>
            <a href="{{ route('password.request') }}"
                class="text-indigo-600 underline font-semibold text-sm hover:text-indigo-700">Forgot password?</a>
            <a href="#" class="text-indigo-600 underline font-semibold text-sm w-full hover:text-indigo-700">Can't
                log in?</a>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const toggleText = document.getElementById('toggleText');
        const passwordInput = document.getElementById('password');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleText.textContent = isPassword ? 'Hide' : 'Show';
        });
    </script>
</body>

</html>
