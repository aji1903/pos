@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Laporan Mingguan</h2>

        <div class="row mb-3">
            <div class="col-md-8">
                <form method="GET" action="{{ route('report.weekly') }}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{ $dt['startDate'] }}">
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{ $dt['endDate'] }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <a href="" class="btn btn-success">
                    Export Excel
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Periode: {{ \Carbon\Carbon::parse($dt['startDate'])->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($dt['endDate'])->format('d M Y') }}</h5>
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

        <div class="card mb-4">
            <div class="card-header">
                <h5>Grafik Pendapatan Harian</h5>
            </div>
            <div class="card-body">
                <canvas id="dailyChart" height="100"></canvas>
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
        var ctx = document.getElementById('dailyChart').getContext('2d');
        var dailyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(
                    $dailyData->pluck('date')->map(function ($date) {
                        return \Carbon\Carbon::parse($date)->format('d M');
                    }),
                ) !!},
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: {!! json_encode($dailyData->pluck('total')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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
    </script>
@endsection
@endsection
