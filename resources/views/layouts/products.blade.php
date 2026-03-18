@vite('resources/css/app.css')
<div>
    <nav class=" flex justify-between items-center p-4 bg-[#fffafa] border-b border-gray-200">
        <a href="/products">
            <div class="text-2xl font-bold text-gray-800">
                Products</div>
        </a>
        <a href="{{ route('products.create') }}"
            class="text-sm bg-[#00b7ff] text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
            Create Product
        </a>

    </nav>
</div>
