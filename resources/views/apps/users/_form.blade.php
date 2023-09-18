@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="my-5">
                <div class="row">
                    <div class="col-md-6">
                        <h3>{{ $method == 'update' ? 'Update User' : 'Create User' }}</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('apps.users.index') }}"
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
                            <label class="fw-bold">Full Name</label>
                            <input class="form-control @error('name') border-danger @enderror"
                                name="name"
                                type="text"
                                value="{{ old('name', @$user->name) }}"
                                placeholder="Full Name">
                            @error('name')
                                <div id="name"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Email Address</label>
                            <input class="form-control @error('email') border-danger @enderror"
                                name="email"
                                type="email"
                                value="{{ old('email', @$user->email) }}"
                                placeholder="Email Address">
                            @error('email')
                                <div id="name"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Password</label>
                            <input class="form-control @error('password') border-danger @enderror"
                                name="password"
                                type="password"
                                placeholder="Password">
                            @error('password')
                                <div id="name"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Password Confirmation</label>
                            <input class="form-control @error('password_confirmation') border-danger @enderror"
                                name="password_confirmation"
                                type="password"
                                value="{{ old('password_confirmation', @$user->password_confirmation) }}"
                                placeholder="Password Confirmation">
                            @error('password_confirmation')
                                <div id="name"
                                    class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="fw-bold">Roles</label>
                            <br>
                            @foreach ($roles as $role)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="roles"
                                        {{ old('roles', @$user->roles[0]->id) == $role->id ? 'checked' : '' }}
                                        value="{{ $role->name }}"
                                        id="check-{{ $role->id }}">
                                    <label class="form-check-label"
                                        for="check-{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                            @error('roles')
                                <div id="name"
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
