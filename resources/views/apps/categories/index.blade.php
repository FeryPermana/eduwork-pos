@extends('layouts.admin')

@section('header', 'Categories')
@section('content')
    <div id="controller">
        <div class="card">
            <div class="card-header bg-secondary">
                <form>
                    <div class="row">
                        <div class="col-1">
                            @php
                                $rows = [10, 50, 100, 500];
                            @endphp
                            <select name="row"
                                class="form-control custom-select"
                                onchange="this.form.submit()">
                                @foreach ($rows as $row)
                                    <option value="{{ $row }}"
                                        {{ @$_GET['row'] == $row ? 'selected' : '' }}>
                                        {{ $row }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-search">
                                <input type="text"
                                    class="form-control"
                                    name="search"
                                    placeholder="Search by name..."
                                    value="{{ @$_GET['search'] }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary"
                                type="submit"> <i class="fa fa-search me-2"></i> Search</button>
                        </div>
                        @can('categories.create')
                            <div class="col-md-5 d-flex justify-content-end">
                                <a href="{{ route('apps.categories.create') }}"
                                    class="btn btn-primary">Create Category</a>
                            </div>
                        @endcan
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-member"
                        class="table table-bordered table-striped w-full">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ increment($categories, $loop) }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <img src="{{ $category->image }}"
                                            alt=""
                                            width="40">
                                    </td>
                                    <td>
                                        @can('categories.edit')
                                            <a href="{{ route('apps.categories.edit', $category->id) }}"
                                                class="btn btn-warning btn-sm"> Edit</a>
                                        @endcan
                                        @can('categories.delete')
                                            <a href="#"
                                                class="btn btn-danger btn-sm"
                                                onclick="controller.deleteData(event, {{ $category->id }})">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-warning text-center">
                                            -- Category do not exist --
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $categories->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var actionUrl = '{{ url('apps/categories') }}';
            var apiUrl = '{{ url('apps/api/categories') }}';

            var controller = new Vue({
                el: '#controller',
                data: {
                    actionUrl,
                    apiUrl,
                },
                methods: {
                    deleteData(event, id) {
                        if (confirm('Are you sure')) {
                            $(event.target).parents('tr').remove();
                            axios.post(this.actionUrl + '/' + id, {
                                _method: 'DELETE'
                            }).then(response => {
                                location.reload();
                            });
                        }
                    },
                },
            });
        </script>
    @endpush
@endsection
