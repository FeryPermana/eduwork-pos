@extends('layouts.admin')

@section('header', 'Customers')
@section('content')
    @push('styles')
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assest/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush
    <div id="controller">
        <div class="card">
            <div class="card-header bg-secondary">
                <div class="row">
                    @can('customers.create')
                        <div class="col-md-12 d-flex justify-content-end">
                            <a href="{{ route('apps.customers.create') }}"
                                class="btn btn-primary">Create Customer</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-customers"
                        class="table table-bordered table-striped w-full">
                        <thead>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>No. Telp</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script>
            var actionUrl = '{{ url('apps/customers') }}';
            var apiUrl = '{{ url('apps/api/customers') }}';

            var columns = [{
                    data: 'DT_RowIndex',
                    class: 'text-center',
                    orderable: true
                }, {
                    data: 'name',
                    class: 'text-center',
                    orderable: true
                }, {
                    data: 'no_telp',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'address',
                    class: 'text-center',
                    orderable: true
                },
                {
                    render: function(index, row, data, meta) {
                        return `
                        @can('customers.edit')
                        <a href="/apps/customers/${data.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('customers.delete')
                        <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</a>
                        @endcan
                    `;
                    },
                    orderable: false,
                    width: '200px',
                    class: 'text-center'
                },
            ];

            var controller = new Vue({
                el: '#controller',
                data: {
                    datas: [],
                    data: {},
                    actionUrl,
                    apiUrl,
                },
                mounted: function() {
                    this.datatable();
                },
                methods: {
                    datatable() {
                        const _this = this;
                        _this.table = $('#table-customers').DataTable({
                            ajax: {
                                url: _this.apiUrl,
                                type: 'GET',
                            },
                            columns: columns
                        }).on('xhr', function() {
                            _this.datas = _this.table.ajax.json().data;
                        });
                    },
                    deleteData(event, id) {
                        if (confirm('Are you sure')) {
                            $(event.target).parents('tr').remove();
                            axios.post(this.actionUrl + '/' + id, {
                                _method: 'DELETE'
                            }).then(response => {
                                _this.table.ajax.reload();
                            });
                        }
                    },
                }
            });
        </script>
    @endpush
@endsection
