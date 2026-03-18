@extends('layouts.app')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Create Sale Order</h2>
                <p class="text-slate-500 text-sm mt-1">Enter sale order details and items.</p>
            </div>

            <a href="{{ route('sales.index') }}"
                class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                ← Back to list
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('sales.store') }}" method="POST" class="p-8 md:p-12 space-y-10">
                @csrf

                {{-- SO Info --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- PO Number --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">PO Number</label>
                        <input type="text" name="po_number"
                            class="w-full px-5 py-4 rounded-2xl border-slate-200 bg-slate-50 cursor-not-allowed"
                            value="{{ 'SO-' . str_pad(optional(\App\Models\Sale::latest('id')->first())->id + 1 ?? 1, 4, '0', STR_PAD_LEFT) }}"
                            readonly>
                    </div>

                    {{-- Customer --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Customer</label>
                        <select name="customer_id"
                            class="w-full px-5 py-4 rounded-2xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sale Date --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Sale Date</label>
                        <input type="date" name="sale_date"
                            class="w-full px-5 py-4 rounded-2xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none"
                            value="{{ old('sale_date', now()->toDateString()) }}">
                    </div>
                </div>

                {{-- Items --}}
                <div>
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-widest mb-4">Order Items</h3>

                    <div id="items-container" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 item-row">
                            <select name="items[0][product_id]"
                                class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 product-select">
                                <option value="">Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->sku }} — {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="number" name="items[0][qty]"
                                class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 qty-input" placeholder="Qty"
                                min="1">

                            <input type="text" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 item-total"
                                placeholder="Total" readonly>

                            <button type="button"
                                class="remove-item px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all"
                                disabled>Remove</button>
                        </div>
                    </div>

                    <button type="button" id="add-item"
                        class="mt-4 px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all">
                        + Add Item
                    </button>

                    {{-- Grand Total --}}
                    <div class="mt-6 text-right">
                        <span class="font-bold text-slate-700">Grand Total: $</span>
                        <span id="grand-total" class="font-bold text-indigo-600">0.00</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 pt-6">
                    <button type="submit"
                        class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        Save Sale Order
                    </button>

                    <a href="{{ route('sales.index') }}"
                        class="px-10 py-4 text-sm font-bold text-slate-600 bg-slate-100 rounded-2xl hover:bg-slate-200 transition-all">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        let itemIndex = 1;

        function updateTotals() {
            let grandTotal = 0;
            document.querySelectorAll('#items-container .item-row').forEach(row => {
                const product = row.querySelector('.product-select');
                const qty = row.querySelector('.qty-input');
                const totalField = row.querySelector('.item-total');

                const price = parseFloat(product.selectedOptions[0]?.dataset.price || 0);
                const quantity = parseInt(qty.value || 0);
                const total = price * quantity;

                totalField.value = total.toFixed(2);
                grandTotal += total;
            });

            document.getElementById('grand-total').innerText = grandTotal.toFixed(2);
        }

        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('items-container');
            const row = document.createElement('div');
            row.classList.add('grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-4', 'item-row');

            row.innerHTML = `
        <select name="items[${itemIndex}][product_id]" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 product-select">
            <option value="">Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->sku }} — {{ $product->name }}</option>
            @endforeach
        </select>

        <input type="number" name="items[${itemIndex}][qty]" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 qty-input" placeholder="Qty" min="1">

        <input type="text" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 item-total" placeholder="Total" readonly>

        <button type="button" class="remove-item px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all">Remove</button>
    `;

            container.appendChild(row);
            itemIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
                updateTotals();
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input') || e.target.classList.contains('product-select')) {
                updateTotals();
            }
        });

        // Initialize totals on page load
        updateTotals();
    </script>
@endsection
