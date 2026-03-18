@extends('layouts.app')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Customers</h2>
                <p class="text-gray-500 text-sm mt-1">Manage customer information</p>
            </div>

            <a href="{{ route('customers.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow">
                + Add Customer
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b">
                    <tr class="text-xs font-bold uppercase text-slate-500">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Phone</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Address</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $customer->name }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $customer->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $customer->email ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $customer->address ?? '-' }}
                            </td>
                            {{-- Actions --}}
                            <td class="px-6 py-5 text-right align-middle">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('customers.edit', $customer) }}"
                                        class="flex items-center justify-center p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                        title="Edit Customer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                        onsubmit="return confirm('Permanently delete this customer?')"
                                        class="inline-flex m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                            title="Delete Customer">
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

                    @if ($customers->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-slate-400">
                                No customers found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
