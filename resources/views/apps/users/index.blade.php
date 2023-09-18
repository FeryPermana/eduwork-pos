@extends('layouts.admin')

@section('header', 'Users')
@section('content')
    <div id="controller">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="input-group mb-3">
                        @can('users.create')
                            <a href="/apps/users/create"
                                class="btn btn-primary"> <i class="fa fa-plus-circle me-2"></i> Create
                                Users</a>
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
                                <th scope="col">Full Name</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Role</th>
                                <th scope="col"
                                    style="width:20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <p>{{ $role->name }}</p>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @can('users.edit')
                                            <a href="/apps/users/{{ $user->id }}/edit"
                                                class="btn btn-success btn-sm me-2"> Edit
                                            </a>
                                        @endcan
                                        @can('users.delete')
                                            <a href="#"
                                                class="btn btn-danger btn-sm"
                                                onclick="controller.deleteData(event, {{ $user->id }})">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var actionUrl = '{{ url('apps/users') }}';
            var apiUrl = '{{ url('apps/api/users') }}';

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
