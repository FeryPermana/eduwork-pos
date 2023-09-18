@extends('layouts.admin')

@section('header', 'Sales')
@section('content')
    <div id="controller">
        <div class="card border-0 rounded-3 shadow border-top-purple">
            <div class="card-header"><span class="font-weight-bold"><i class="fa fa-chart-bar"></i> REPORT SALES</span></div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3"><label class="form-label fw-bold">START DATE</label><input type="date"
                                    class="form-control"
                                    name="start_date"
                                    value="{{ @$_GET['start_date'] }}"
                                    required></div><!--v-if-->
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3"><label class="form-label fw-bold">END DATE</label><input type="date"
                                    class="form-control"
                                    name="end_date"
                                    value="{{ @$_GET['end_date'] }}"
                                    required></div><!--v-if-->
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3"><label class="form-label fw-bold text-white">*</label><button type="submit"
                                    class="btn btn-primary border-0 shadow w-100"><i class="fa fa-filter"></i> FILTER
                                </button></div>
                        </div>
                    </div>
                </form><!--v-if-->

                <div class="export text-end mb-3">
                    <a href="/apps/sales/export?start_date={{ @$_GET['start_date'] }}&end_date={{ @$_GET['end_date'] }}"
                        class="btn btn-success btn-md border-0 shadow me-3"><i class="fa fa-file-excel"></i> EXCEL</a>
                    <a href="/apps/sales/pdf?start_date={{ @$_GET['start_date'] }}&end_date={{ @$_GET['end_date'] }}"
                        class="btn btn-secondary btn-md border-0 shadow"><i class="fa fa-file-pdf"></i> PDF</a>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: #e6e6e7">
                            <th scope="col">Date</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Cashier</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <td>{{ formatTanggalIndoWithTime($sale->created_at) }}</td>
                                <td class="text-center">{{ $sale->invoice }}</td>
                                <td>{{ $sale->cashier->name }}</td>
                                <td>{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                                <td class="text-end">Rp. {{ rupiahFormat($sale->grand_total) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p class="text-center">-- Not Found --</p>
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="4"
                                class="text-end fw-bold"
                                style="background-color: #e6e6e7">
                                TOTAL
                            </td>
                            <td class="text-end fw-bold"
                                style="background-color: #e6e6e7">
                                Rp. {{ rupiahFormat($total) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
