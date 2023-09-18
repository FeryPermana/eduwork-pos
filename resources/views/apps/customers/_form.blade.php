@extends('layouts.admin')

@section('header', 'Customers')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="my-5">
                <div class="row">
                    <div class="col-md-6">
                        <h3>{{ $method == 'update' ? 'Update Customer' : 'Create Customer' }}</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('apps.customers.index') }}"
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
                                class="form-label">Full Name</label>
                            <input type="text"
                                name="name"
                                class="form-control @error('name') border-danger @enderror"
                                id="name"
                                value="{{ old('name', @$customer->name) }}">
                            @error('name')
                                <div id="name"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_telp"
                                class="form-label">No. Telp</label>
                            <input type="number"
                                name="no_telp"
                                class="form-control @error('no_telp') border-danger @enderror"
                                id="no_telp"
                                value="{{ old('no_telp', @$customer->no_telp) }}">
                            @error('no_telp')
                                <div id="no_telp"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="address"
                                class="form-label">
                                Address
                            </label>
                            <textarea name="address"
                                id="address"
                                cols="30"
                                rows="5"
                                class="form-control @error('address') border-danger @enderror">{{ old('address', @$customer->address) }}</textarea>
                            @error('address')
                                <div id="address"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
