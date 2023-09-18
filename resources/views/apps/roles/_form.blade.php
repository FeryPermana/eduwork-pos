@extends('layouts.admin')

@section('header', 'Roles')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>{{ $method == 'update' ? 'Update Role' : 'Create Role' }}</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('apps.roles.index') }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ $url }}"
                    method="post">
                    @csrf
                    @if ($method == 'update')
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="fw-bold">Role Name</label>
                        <input class="form-control @error('name') border-danger @enderror"
                            name="name"
                            type="text"
                            placeholder="Role Name"
                            value="{{ old('name', @$role->name) }}">

                        @error('name')
                            <div id="name"
                                class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <div class="mb-3">
                        <label class="fw-bold">Permissions</label>
                        <br>
                        @php
                            $array_permis = [];
                            foreach ($role->permissions as $permis) {
                                $array_permis[] = $permis->name;
                            }
                        @endphp
                        @foreach ($permissions as $permission)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="checkbox"
                                    id="{{ $permission->name }}"
                                    name="permissions[]"
                                    value="{{ $permission->name }}"
                                    {{ in_array($permission->name, $array_permis) ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="{{ $permission->name }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary shadow-sm rounded-sm"
                                type="submit">Save</button>
                            <button class="btn btn-warning shadow-sm rounded-sm ms-3"
                                type="reset">RESET</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
