@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="mb-0">Post Details</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back to list</a>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning">Edit</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="fw-semibold mb-2">{{ $product->name }}</h4>
                <p class="text-muted" style="white-space: pre-line;">{{ $product->price }}</p>
                <p class="text-muted" style="white-space: pre-line;">{{ $product->description }}</p>
            </div>
        </div>
    </div>
@endsection
