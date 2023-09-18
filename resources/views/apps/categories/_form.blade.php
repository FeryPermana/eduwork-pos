@extends('layouts.admin')

@section('header', 'Categories')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="my-5">
                <div class="row">
                    <div class="col-md-6">
                        <h3>{{ $method == 'update' ? 'Update Category' : 'Create Category' }}</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('apps.categories.index') }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
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
                            <label for="name"
                                class="form-label">Name</label>
                            <input type="text"
                                name="name"
                                class="form-control @error('name') border-danger @enderror"
                                id="name"
                                value="{{ old('name', @$category->name) }}">
                            @error('name')
                                <div id="name"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description"
                                class="form-label">Description</label>
                            <textarea name="description"
                                class="form-control @error('description') border-danger @enderror"
                                id="description">{{ old('description', @$category->description) }}</textarea>
                            @error('description')
                                <div id="description"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                <input type="file"
                                    name="image"
                                    class="dropify"
                                    data-default-file="{{ @$category ? @$category->image : 'file' }}">
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
@endsection
