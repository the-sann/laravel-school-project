@vite('resources/css/app.css')

@extends('layouts.app')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10 py-10">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Product Inventory</h1>
                <p class="text-slate-500 text-sm mt-1">Manage your products, pricing, and stock levels.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('products.create') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-sm shadow-indigo-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Product
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
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
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
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

            @if ($products->isEmpty())
                <div class="py-20 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-slate-900">No products found</h3>
                    <p class="mt-1 text-sm text-slate-500">Get started by creating a new product.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
