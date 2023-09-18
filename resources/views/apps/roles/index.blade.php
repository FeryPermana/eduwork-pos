@extends('layouts.admin')

@section('header', 'Products')
@section('content')
    <div id="controller">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="input-group mb-3">
                        @can('roles.create')
                            <a href="/apps/roles/create"
                                class="btn btn-primary"> <i class="fa fa-plus-circle me-2"></i> Create
                                Roles</a>
                        @endcan

                        <input type="text"
                            class="form-control"
                            name="search"
                            placeholder="search by role name...">

                        <button class="btn btn-primary"
                            type="submit"> <i class="fa fa-search me-2"></i> Search</button>

                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Role Name</th>
                                <th scope="col"
                                    style="width:50%">Permissions</th>
                                <th scope="col"
                                    style="width:20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $permission)
                                            <span class="badge badge-primary shadow border-0 ms-2 mb-2">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @can('roles.edit')
                                            <a href="/apps/roles/{{ $role->id }}/edit"
                                                class="btn btn-success btn-sm me-2"> Edit
                                            </a>
                                        @endcan
                                        @can('roles.delete')
                                            <a href="#"
                                                class="btn btn-danger btn-sm"
                                                onclick="controller.deleteData(event, {{ $role->id }})">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $roles->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var actionUrl = '{{ url('apps/roles') }}';
            var apiUrl = '{{ url('apps/api/roles') }}';

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
