@extends('layouts.app')

@section('content')
    <main class="flex-1 min-h-screen bg-[#F6F6F4] px-8">

        <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-[#241C15] tracking-tight">Dashboard</h1>
            </div>

            <div class="flex items-center gap-6">
                <span class="text-[#241C15] font-semibold text-sm">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                        class="group flex items-center gap-2 px-3 py-2 text-sm font-semibold text-gray-500 hover:text-red-600 rounded-lg transition-colors">
                        <div class=" rounded-md group-hover:bg-red-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                        </div>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="mb-8 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-sm font-semibold text-gray-400 uppercase tracking-widest">System Dashboard</p>
            <h1 class="text-4xl font-extrabold mt-2">
                <span class="text-gray-900">Hello, </span>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-500">
                    {{ auth()->user()->name }}
                </span>
            </h1>
            <div class="mt-3 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
                <span class="text-xs font-bold text-gray-500 uppercase">Account Active</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <a href="/products">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Products</p>
                    <h2 class="text-2xl font-bold text-green-600">{{ $totalProducts }}</h2>
                </div>
            </a>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">
                    Available Stock
                </p>
                <h2 class="text-2xl font-bold text-yellow-600">
                    {{ number_format($availableStock) }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sale Amount</p>
                <h2 class="text-2xl font-bold text-indigo-600">${{ number_format($totalRevenue, 2) }}</h2>
                @if ($pendingRevenue > 0)
                    <p class="text-red-500 text-xs mt-2 font-medium">Pending: ${{ number_format($pendingRevenue, 2) }}</p>
                @endif
            </div>
        </div>


        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 max-h-[430px] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-20">
                <h2 class="text-lg font-bold text-[#241C15]">Recent Products</h2>
                <a href="/products"> <button class="text-sm font-semibold text-[#007C89] hover:underline">View
                        All</button></a>
            </div>

            <table class="w-full text-left border-collapse">
                <thead class="sticky top-[72px] bg-slate-50 z-10">
                    <tr class="bg-slate-50/50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Product Info
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">
                            Category</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Price</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">In-Stock</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Description</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Suppliers</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($products as $product)
                        <tr class="group hover:bg-slate-50/80 transition-colors">
                            {{-- Product Info --}}
                            <td class="px-6 py-5 align-middle">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ substr($product->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-900 leading-none">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-xs text-slate-400 mt-1">
                                            SKU: {{ $product->sku }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-5 text-center align-middle">
                                <span
                                    class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>

                            {{-- Price --}}
                            <td class="px-6 py-5 align-middle">
                                <span class="text-sm font-semibold text-slate-900">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </td>
                            {{-- Stock --}}
                            <td class="px-6 py-5 align-middle">
                                @if ($product->stock > 10)
                                    <span class="text-green-600 font-bold">{{ $product->stock }}</span>
                                @elseif ($product->stock > 0)
                                    <span class="text-yellow-600 font-bold">{{ $product->stock }}</span>
                                @else
                                    <span class="text-red-600 font-bold">Out</span>
                                @endif
                            </td>

                            {{-- Description --}}
                            <td class="px-6 py-5 align-middle">
                                {{-- Changed text-xl to text-sm for consistency --}}
                                <p class="text-sm text-slate-500 max-w-xs truncate" title="{{ $product->description }}">
                                    {{ $product->description }}
                                </p>
                            </td>
                            {{-- Supplier --}}
                            <td class="px-6 py-5 align-middle">
                                <span class="text-sm text-slate-700">
                                    {{ $product->supplier->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-5 text-right align-middle">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="flex items-center justify-center p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                        title="Edit Product">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('Permanently delete this product?')"
                                        class="inline-flex m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                            title="Delete Product">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
@endsection
