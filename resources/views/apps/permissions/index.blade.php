@extends('layouts.admin')

@section('header', 'Permissions')
@section('content')
    <div id="controller">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="input-group mb-3">

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
                                <th scope="col"
                                    style="width:50%">Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $permissions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
