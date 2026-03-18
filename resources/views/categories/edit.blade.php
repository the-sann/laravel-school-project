@extends('layouts.app')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10">
        <div class="max-w-2xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Category</h2>
                    <p class="text-gray-500 text-sm mt-1">Update category information</p>
                </div>

                <a href="{{ route('categories.index') }}"
                    class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">
                    Back
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('categories.update', $category) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Category Name
                        </label>
                        <input type="text" name="name"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500"
                            value="{{ old('name', $category->name) }}">
                        @error('name')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('categories.index') }}"
                            class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
