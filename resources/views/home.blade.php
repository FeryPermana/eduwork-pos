@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-8">
                    @can('dashboard.sales_chart')
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header"><span class="font-weight-bold"><i class="fa fa-chart-bar"></i> SALES CHART 7
                                    DAYS</span></div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px;max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
                <div class="col-md-4">
                    @can('dashboard.sales_today')
                        <div class="card border-0 rounded-3 shadow border-top-info mb-4">
                            <div class="card-header"><span class="font-weight-bold"><i class="fa fa-chart-line"></i> SALES
                                    TODAY</span></div>
                            <div class="card-body"><strong>{{ $count_sales_today }}</strong> SALES
                                <hr>
                                <h5 class="fw-bold">{{ rupiahFormat($sum_sales_today) }}</h5>
                            </div>
                        </div>
                    @endcan
                    @can('dashboard.profits_today')
                        <div class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header"><span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PROFITS
                                    TODAY</span></div>
                            <div class="card-body">
                                <h5 class="fw-bold">{{ rupiahFormat($sum_profits_today) }}</h5>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @can('dashboard.best_selling_product')
                        <div class="card border-0 rounded-3 shadow border-top-warning">
                            <div class="card-header"><span class="font-weight-bold"><i class="fa fa-chart-pie"></i> BEST SELLING
                                    PRODUCT</span></div>
                            <div class="card-body">
                                <canvas id="myDoughnutChart"
                                    width="400"
                                    height="400"></canvas>
                            </div>
                        </div>
                    @endcan
                </div>
                <div class="col-md-6">
                    @can('dashboard.product_stock')
                        <div class="card border-0 rounded-3 shadow border-top-danger">
                            <div class="card-header"><span class="font-weight-bold"><i class="fa fa-box-open"></i> PRODUCT
                                    STOCK < 10</span>
                            </div>
                            <div class="card-body">
                                <div>
                                    <ol class="list-group list-group-numbered">
                                        @forelse ($products_limit_stock as $pls)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">{{ $pls->title }}</div>
                                                    <div class="text-muted">Category : {{ $pls->category->name }}</div>
                                                </div><span class="badge bg-danger rounded-pill">{{ $pls->stock }}</span>
                                            </li>
                                        @empty
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="alert alert-warning">
                                                    Empty Product Limit Stock
                                                </div>
                                            </li>
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        var data_bar = '{!! json_encode($data_bar) !!}';
        var label_bar = '{!! json_encode($label_bar) !!}';
        var product = '{!! json_encode($product) !!}';
        var total = '{!! json_encode($total) !!}';

        function generateRandomColor() {
            const letters = "0123456789ABCDEF";
            let color = "#";
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        $(document).ready(function() {
            // Get a reference to the canvas element
            var ctx = document.getElementById('barChart').getContext('2d');

            // Define your data
            var data = {
                labels: JSON.parse(label_bar),
                datasets: [{
                    label: 'Sales Chart',
                    data: JSON.parse(data_bar),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1,
                }, ],
            };

            // Create the bar chart
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });

            // Get a reference to the canvas element
            var ctx = document.getElementById('myDoughnutChart').getContext('2d');

            // Define your data
            var data = {
                labels: JSON.parse(product),
                datasets: [{
                    data: JSON.parse(total),
                    backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1,
                }, ],
            };

            // Create the doughnut chart
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    // Add your options here
                },
            });
        });
    </script>
@endpush
