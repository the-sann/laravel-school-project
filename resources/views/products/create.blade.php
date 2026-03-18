@extends('layouts.app')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10 ">
        <div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Create Product</h2>
                    <p class="text-gray-500 mt-1">Fill in the details to add a new item to your inventory.</p>
                </div>

                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all shadow-sm group">
                    <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to list
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <form action="{{ route('products.store') }}" method="POST" class="p-8 md:p-10 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        {{-- Product Name --}}
                        <div class="group">
                            <label
                                class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-indigo-600 transition-colors">
                                Product Name
                            </label>
                            <input type="text" name="name"
                                class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none placeholder-gray-400"
                                placeholder="e.g. Premium Wireless Headphones" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-xs mt-2 font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- SKU --}}
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                SKU
                            </label>
                            <input type="text" name="sku"
                                class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/30 focus:ring-2 focus:ring-indigo-500"
                                placeholder="e.g. PRD-001" value="{{ old('sku') }}">
                            @error('sku')
                                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Price --}}
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Price</label>
                                <input type="number" step="0.01" name="price"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/30 focus:ring-2 focus:ring-indigo-500"
                                    value="{{ old('price') }}">
                                @error('price')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Stock --}}
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Stock</label>
                                <input type="number" name="stock"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/30 focus:ring-2 focus:ring-indigo-500"
                                    value="{{ old('stock', 0) }}">
                                @error('stock')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Category
                                </label>

                                <select name="category_id"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/30 focus:ring-2 focus:ring-indigo-500">

                                    <option value="">-- Select Category --</option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Supplier --}}
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Supplier
                                </label>

                                <select name="supplier_id"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/30 focus:ring-2 focus:ring-indigo-500">

                                    <option value="">-- Optional --</option>

                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                        </div>

                        {{-- Description --}}
                        <div class="group">
                            <label
                                class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-indigo-600 transition-colors">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none placeholder-gray-400 resize-none"
                                placeholder="Provide a detailed description of the product...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-50">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white px-6 py-3.5 rounded-xl font-bold text-sm hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 transition-all shadow-lg shadow-indigo-200 active:scale-[0.98]">
                            Save Product
                        </button>

                        <a href="{{ route('products.index') }}"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3.5 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
