@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Laporan Bulanan</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('report.monthly') }}">
                    <div class="row">
                        <div class="col-md-5">
                            <select name="month" class="form-select">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->monthName }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select name="year" class="form-select">
                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="" class="btn btn-success">
                    Export Excel
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Bulan: {{ \Carbon\Carbon::create()->month($month)->monthName }} {{ $year }}</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Total Transaksi: {{ $totalTransactions }}</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Total Pendapatan: Rp {{ number_format($totalAmount, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>



        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah Transaksi</th>
                                <th>Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $groupedOrders = $orders->groupBy(function ($item) {
                                    return \Carbon\Carbon::parse($item->order_date)->format('Y-m-d');
                                });
                            @endphp

                            @foreach ($groupedOrders as $date => $dailyOrders)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</td>
                                    <td>{{ $dailyOrders->count() }}</td>
                                    <td>Rp {{ number_format($dailyOrders->sum('order_amount'), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(range(1, \Carbon\Carbon::create($year, $month, 1)->daysInMonth)) !!},
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: {!! json_encode(array_fill(0, 31, 0)) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Update chart data with actual values
        var dailyData = {!! json_encode($dailyData->keyBy('day')) !!};
        monthlyChart.data.datasets[0].data = monthlyChart.data.labels.map(function(day) {
            return dailyData[day] ? dailyData[day].total : 0;
        });
        monthlyChart.update();
    </script>
@endsection
@endsection
