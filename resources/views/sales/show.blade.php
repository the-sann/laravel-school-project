@extends('layouts.app')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Sale Order</h2>
                <p class="text-slate-500 text-sm mt-1">Update sale order details and items.</p>
            </div>

            <a href="{{ route('sales.index') }}"
                class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                ← Back to list
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('sales.update', $sale) }}" method="POST" class="p-8 md:p-12 space-y-10">
                @csrf
                @method('PUT')

                {{-- SO Info --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- PO Number --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">PO Number</label>
                        <input type="text" name="po_number"
                            class="w-full px-5 py-4 rounded-2xl border-slate-200 bg-slate-50 cursor-not-allowed"
                            value="{{ $sale->po_number }}" readonly>
                    </div>

                    {{-- Customer --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Customer</label>
                        <select name="customer_id"
                            class="w-full px-5 py-4 rounded-2xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
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
                            value="{{ $sale->sale_date->format('Y-m-d') }}">
                    </div>
                </div>

                {{-- Items --}}
                <div>
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-widest mb-4">Order Items</h3>

                    <div id="items-container" class="space-y-4">
                        @foreach ($sale->items as $index => $item)
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 item-row">
                                {{-- Product --}}
                                <select name="items[{{ $index }}][product_id]"
                                    class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 product-select">
                                    <option value="">Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->sku }} — {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Quantity --}}
                                <input type="number" name="items[{{ $index }}][qty]"
                                    class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 qty-input"
                                    value="{{ $item->quantity }}" placeholder="Qty" min="1">

                                {{-- Total Price --}}
                                <input type="text" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-100 item-total"
                                    value="{{ number_format($item->quantity * $item->product->price, 2) }}" readonly>

                                {{-- Remove --}}
                                <button type="button"
                                    class="remove-item px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all"
                                    {{ $index === 0 ? 'disabled' : '' }}>
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-item"
                        class="mt-4 px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all">
                        + Add Item
                    </button>

                    {{-- Grand Total --}}
                    <div class="mt-6 text-right">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-widest mr-4">Grand Total:</label>
                        <span id="grand-total"
                            class="text-xl font-bold text-indigo-600">${{ number_format($sale->items->sum(fn($i) => $i->quantity * $i->product->price), 2) }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 pt-6">
                    <button type="submit"
                        class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        Update Sale Order
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
        let itemIndex = {{ $sale->items->count() }};

        function updateItemTotal(row) {
            const productSelect = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.qty-input');
            const totalInput = row.querySelector('.item-total');

            const price = parseFloat(productSelect.selectedOptions[0]?.dataset.price || 0);
            const qty = parseInt(qtyInput.value) || 0;

            totalInput.value = (price * qty).toFixed(2);

            updateGrandTotal();
        }

        function updateGrandTotal() {
            const totalInputs = document.querySelectorAll('.item-total');
            let grandTotal = 0;

            totalInputs.forEach(input => {
                grandTotal += parseFloat(input.value) || 0;
            });

            document.getElementById('grand-total').innerText = '$' + grandTotal.toFixed(2);
        }

        // Add new item
        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('items-container');

            const row = document.createElement('div');
            row.classList.add('grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-4', 'item-row');

            row.innerHTML = `
        <select name="items[${itemIndex}][product_id]" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 product-select">
            <option value="">Product</option>
            @foreach ($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                {{ $product->sku }} — {{ $product->name }}
            </option>
            @endforeach
        </select>

        <input type="number" name="items[${itemIndex}][qty]" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-50 qty-input" placeholder="Qty">

        <input type="text" class="px-4 py-3 rounded-xl border-slate-200 bg-slate-100 item-total" value="0.00" readonly>

        <button type="button" class="remove-item px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all">Remove</button>
    `;

            container.appendChild(row);
            itemIndex++;
        });

        // Remove item
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
                updateGrandTotal();
            }
        });

        // Update total on quantity or product change
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input')) {
                updateItemTotal(e.target.closest('.item-row'));
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                updateItemTotal(e.target.closest('.item-row'));
            }
        });
    </script>
@endsection
