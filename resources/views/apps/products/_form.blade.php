@extends('layouts.admin')

@section('header', 'Products')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>{{ $method == 'update' ? 'Update Product' : 'Create Product' }}</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('apps.products.index') }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ $url }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($method == 'update')
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title"
                                    class="form-label">Name</label>
                                <input type="text"
                                    name="title"
                                    class="form-control @error('title') border-danger @enderror"
                                    id="title"
                                    value="{{ old('title', @$product->title) }}">
                                @error('title')
                                    <div id="title"
                                        class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description"
                                    class="form-label">Description</label>
                                <textarea name="description"
                                    class="form-control @error('description') border-danger @enderror"
                                    id="description">{{ old('description', @$product->description) }}</textarea>
                                @error('description')
                                    <div id="description"
                                        class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="buy_price"
                                    class="form-label">Buy Price</label>
                                <input type="number"
                                    name="buy_price"
                                    class="form-control @error('buy_price') border-danger @enderror"
                                    id="buy_price"
                                    value="{{ old('buy_price', @$product->buy_price) }}">
                                @error('buy_price')
                                    <div id="buy_price"
                                        class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sell_price"
                                    class="form-label">Sell Price</label>
                                <input type="number"
                                    name="sell_price"
                                    class="form-control @error('sell_price') border-danger @enderror"
                                    id="sell_price"
                                    value="{{ old('sell_price', @$product->sell_price) }}">
                                @error('sell_price')
                                    <div id="sell_price"
                                        class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="stock"
                                    class="form-label">Stock</label>
                                <input type="number"
                                    name="stock"
                                    class="form-control @error('stock') border-danger @enderror"
                                    id="stock"
                                    value="{{ old('stock', @$product->stock) }}">
                                @error('stock')
                                    <div id="stock"
                                        class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id"
                                    class="form-label">Category</label>
                                <select name="category_id"
                                    id="category_id"
                                    class="form-control @error('stock') border-danger @enderror">
                                    <option value=""
                                        selected>-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', @$product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div id="category_id"
                                        class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <input type="file"
                                        name="image"
                                        class="dropify"
                                        data-default-file="{{ @$product ? @$product->image : 'file' }}">
                                    @error('image')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
