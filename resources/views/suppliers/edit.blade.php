@extends('layouts.app')

@section('content')
    {{-- Changed to max-w-full to ensure it uses all available space provided by the parent --}}
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header: Using flex-row to keep it tight at the top --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Supplier</h2>
                <p class="text-gray-500 text-sm mt-1">Modify the contact information for <span
                        class="font-semibold text-indigo-600">{{ $supplier->name }}</span></p>
            </div>

            <a href="{{ route('suppliers.index') }}"
                class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        {{-- Form Container: shadow-xl for depth, border-gray-100 for a softer look --}}
        <div class="bg-white w-full rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="p-6 md:p-10 space-y-8">
                @csrf
                @method('PUT')

                {{-- Full Width Section --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Supplier Name</label>
                    <input type="text" name="name"
                        class="w-full px-4 py-4 rounded-xl border-gray-300 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none text-lg"
                        value="{{ old('name', $supplier->name) }}" placeholder="Enter legal company name">
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

                {{-- Responsive Grid Section --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Phone Number</label>
                        <input type="text" name="phone"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            value="{{ old('phone', $supplier->phone) }}" placeholder="+1 (555) 000-0000">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Email Address</label>
                        <input type="email" name="email"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            value="{{ old('email', $supplier->email) }}" placeholder="contact@company.com">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Business
                            Address</label>
                        <input type="text" name="address"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            value="{{ old('address', $supplier->address) }}" placeholder="Street, City, Country">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t border-gray-50">
                    <a href="{{ route('suppliers.index') }}"
                        class="inline-flex justify-center items-center px-8 py-3.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">
                        Discard Changes
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center items-center px-10 py-3.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-200 active:scale-[0.98] transition-all">
                        Update Supplier Details
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
