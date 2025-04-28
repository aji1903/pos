@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Laporan Harian - {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('report.daily') }}">
                    <div class="input-group">
                        <input type="date" name="date" class="form-control" value="{{ $date }}">
                        <button type="submit" class="btn btn-primary">Filter</button>
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
                    <div class="col-md-6">
                        <h5>Total Transaksi: {{ $totalTransactions }}</h5>
                    </div>
                    <div class="col-md-6">
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
                                <th>No</th>
                                <th>Kode Order</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $order->order['order_code'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order['order_date'])->format('d/m/Y H:i') }}</td>
                                    <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#orderDetailModal{{ $order['id'] }}">
                                            Lihat
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="orderDetailModal{{ $order['id'] }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Order: {{ $order['order_code'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Produk</th>
                                                            <th>Qty</th>
                                                            <th>Harga</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orders as $detail)
                                                            <tr>
                                                                <td>{{ $detail->product->product_name }}</td>
                                                                <td>{{ $detail->qty }}</td>
                                                                <td>Rp
                                                                    {{ number_format($detail->order_price, 0, ',', '.') }}
                                                                </td>
                                                                <td>Rp
                                                                    {{ number_format($detail->order_subtotal, 0, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="3">Total</th>
                                                            <th>Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
