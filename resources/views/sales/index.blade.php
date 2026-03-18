@extends('layouts.app')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10 py-10">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Sale Orders</h1>
                <p class="text-slate-500 text-sm mt-1">
                    Track customer orders and item details.
                </p>
            </div>

            <a href="{{ route('sales.create') }}"
                class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-sm shadow-indigo-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Sale Order
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500">
                            <th class="px-6 py-4">Order Date</th>
                            <th class="px-6 py-4">PO Number</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4 text-right">Unit Price</th>
                            <th class="px-6 py-4 text-right">Qty</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($orders as $order)
                            @foreach ($order->items ?? [] as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-5 text-slate-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($order->sale_date)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-5 font-semibold text-slate-900 whitespace-nowrap">
                                        {{ $order->po_number }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        {{ $order->customer->name ?? 'Walk-in' }}
                                    </td>
                                    <td class="px-6 py-5 font-mono text-indigo-600 whitespace-nowrap">
                                        {{ $item->product->category->name ?? 'No Category' }}
                                    </td>
                                    <td class="px-6 py-5 text-right whitespace-nowrap">
                                        ${{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-5 text-right whitespace-nowrap">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-5 text-right font-semibold text-indigo-600 whitespace-nowrap">
                                        ${{ number_format($item->quantity * $item->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-5 text-right align-middle">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- Edit Sale Order --}}
                                            <a href="{{ route('sales.edit', $order) }}"
                                                class="flex items-center justify-center p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                                title="View Sale Order">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            {{-- View Sale Order --}}

                                            {{-- <a href="{{ route('sales.show', $order) }}"
                                                class="flex items-center justify-center p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all"
                                                title="Edit Sale Order">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a> --}}

                                            {{-- Delete Sale Order --}}
                                            <form action="{{ route('sales.destroy', $order) }}" method="POST"
                                                onsubmit="return confirm('Permanently delete this sale order?')"
                                                class="inline-flex m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center justify-center p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                    title="Delete Sale Order">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-6 text-center text-slate-400">
                                    No sale orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
