@extends('layouts.admin')

@section('header', 'Products')
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
                    <div class="col-md-2">
                        <select name="category_id"
                            class="form-control">
                            <option value=""
                                selected>Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="filter"
                            class="btn btn-success">Filter</button>
                    </div>
                    @can('products.index')
                        <div class="col-md-8 d-flex justify-content-end">
                            <a href="{{ route('apps.products.create') }}"
                                class="btn btn-primary">Create Product</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-products"
                        class="table table-bordered table-striped w-full">
                        <thead>
                            <th>No</th>
                            <th>Title</th>
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th>Stock</th>
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
            var actionUrl = '{{ url('apps/products') }}';
            var apiUrl = '{{ url('apps/api/products') }}';

            var columns = [{
                    data: 'DT_RowIndex',
                    class: 'text-center',
                    orderable: true
                }, {
                    data: 'title',
                    class: 'text-center',
                    orderable: true
                }, {
                    data: 'buy_price',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'sell_price',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'stock',
                    class: 'text-center',
                    orderable: true
                },
                {
                    render: function(index, row, data, meta) {
                        return `
                        @can('products.edit')
                        <a href="/apps/products/${data.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                    @can('products.delete')
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
                        _this.table = $('#table-products').DataTable({
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
        <script>
            $('#filter').on('click', function() {
                let category_id = $('select[name=category_id]').val();

                if (category_id) {
                    controller.table.ajax.url(apiUrl + '?category_id=' + category_id).load();
                }
            })
        </script>
    @endpush
@endsection
