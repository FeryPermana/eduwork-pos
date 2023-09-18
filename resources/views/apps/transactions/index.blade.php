@extends('layouts.admin')

@section('header', '')
@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('apps.transactions.addToCart') }}"
                            method="POST">
                            @csrf

                            <button type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#selectModal">Select Product</button>
                            <div class="my-3">
                                <input type="hidden"
                                    class="form-control text-center"
                                    id="product-id"
                                    value=""
                                    name="product_id">
                                <input type="hidden"
                                    class="form-control text-center"
                                    id="sell-price"
                                    value=""
                                    name="sell_price">
                                <label class="form-label fw-bold">Product Name</label><input type="text"
                                    class="form-control text-center"
                                    id="product-name"
                                    disabled
                                    placeholder="Select Product"
                                    fdprocessedid="oji4g">
                            </div>
                            <div class="my-3">
                                <label class="form-label fw-bold">Qty</label><input type="number"
                                    class="form-control text-center"
                                    name="qty"
                                    placeholder="Qty"
                                    min="1"
                                    fdprocessedid="oji4g">
                            </div>
                            <div class="my-3">
                                <button type="submit"
                                    class="btn btn-warning">Add Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <form action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="my-3">
                                        <label class="form-label fw-bold">Cashier</label>
                                        <input type="text"
                                            class="form-control"
                                            disabled
                                            value="{{ auth()->user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="my-3">
                                        <label class="form-label fw-bold">Customer</label>
                                        <select name="customer_id"
                                            id="customer_id"
                                            class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ @$_GET['customer_id'] == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped"
                            id="table-transaction">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carts as $cart)
                                    <tr>
                                        <td><a href="#"
                                                class="btn btn-danger"
                                                onclick="controller.deleteData(event, {{ $cart->id }})"><i
                                                    class="fa fa-trash"></i></a></td>
                                        <td>{{ $cart->product->title }}</td>
                                        <td>{{ rupiahFormat($cart->product->sell_price) }}</td>
                                        <td>{{ $cart->qty }}</td>
                                        <td>{{ $cart->qty * $cart->product->sell_price }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="text-center">
                                                --Product cart not found--
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="4"
                                        class="text-right">Total</td>
                                    <td>{{ rupiahFormat($carts_total) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="my-3">
                                    <label class="form-label fw-bold">Discount (Rp)</label>
                                    <input type="number"
                                        class="form-control"
                                        id="discount"
                                        required
                                        value="0"
                                        onchange="controller.setDiscount()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="my-3">
                                    <label class="form-label fw-bold">Pay (Rp)</label>
                                    <input type="number"
                                        class="form-control"
                                        id="cash"
                                        value=""
                                        onchange="controller.setChange()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4>GRAND TOTAL</h4>
                            <h4 id="grand_total">{{ rupiahFormat($carts_total) }}</h4>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4>CHANGE</h4>
                            <h4 id="change"></h4>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button"
                                class="btn btn-primary"
                                style="width: 100%;"
                                onclick="controller.storeTransaction()">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade"
        id="selectModal"
        tabindex="-1"
        aria-labelledby="selectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="selectModalLabel">Product</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered"
                        id="table-products"
                        style="width: 100%;">
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
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
        var actionUrl = '{{ url('apps/transactions') }}';
        var apiUrl = '{{ url('apps/api-product/transactions') }}';

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
                    <a href="#" class="btn btn-warning btn-sm" onclick="controller.selectProduct(event, ${data.id}, '${data.title}', '${data.sell_price}')">Select</a>
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
                cash: 0,
                discount: 0,
                grandtotal: `{{ $carts_total }}`,
                cash: 0,
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
                selectProduct(event, id, name, sell_price) {
                    $('#product-id').val(id);
                    $('#product-name').val(name);
                    $('#sell-price').val(sell_price);

                    $('#selectModal').modal("hide");
                },
                setDiscount() {
                    let lastprice = `{{ $carts_total }}` - $('#discount').val();
                    const rupiah = lastprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    this.grandtotal = lastprice;
                    $('#grand_total').text(`Rp. ${rupiah}`);
                },
                setChange() {
                    let change = $('#cash').val() - this.grandtotal;
                    console.log(change);
                    const cash = change.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    this.cash = change;
                    $('#change').text(`Rp. ${cash}`);
                },
                deleteData(event, id) {
                    if (confirm('Are you sure')) {
                        axios.post(this.actionUrl + '/destroyCart/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            $(event.target).parents('tr').remove();
                        });
                    }
                },
                storeTransaction(event, id) {
                    if (confirm('Are you sure')) {
                        axios.post('transactions/store', {
                            _method: 'POST',
                            customer_id: $('#customer_id').val(),
                            discount: $('#discount').val(),
                            grand_total: this.grandtotal,
                            cash: $('#cash').val(),
                            change: this.cash,

                        }).then(response => {
                            setTimeout(() => {
                                //print
                                window.open(
                                    `/apps/transactions/print?invoice=${response.data.data.invoice}`,
                                    "_blank"
                                );

                                //reload page
                                location.reload();
                            }, 50);
                        }).catch(function(error) {
                            alert('ada kesalahan !!');
                        });
                    }
                },
            }
        });
    </script>
@endpush
