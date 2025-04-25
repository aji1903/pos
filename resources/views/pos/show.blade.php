@extends('layouts.main')
@section('title', 'Order Detail')
@section('content')
    <section class='section'>

        <div class='row'>
            <div class="col-lg-12">
                <div class="card-header d-flex justify-content-between align-item-center">
                    <h3 class='card-title'>{{ $title ?? '' }}</h3>
                    <div align='right' class='mt-3'>
                        <a href="{{ url()->previous() }}" class='btn btn-primary'>Back</a>
                        <a href='{{ route('print', $orders->id) }}' class='btn btn-success'>
                            <i class='bi bi-printer'></i></a>
                    </div>
                </div>



            </div>
            <div class='col-lg-5'>
                <div class='card mt-3'>
                    <div class='card-body'>
                        <h5 class='card-title'>Order </h5>
                        <table class='table table-bordered table-striped'>

                            <tr>
                                <th>Order Code</th>
                                <td>{{ $orders->order_code ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{ $orders->order_date ?? '' }}</td>

                            </tr>
                            <tr>
                                <th>Order Status</th>
                                <td>{{ $orders->order_status ?? '' }}</td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class='col-lg-12'>
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>Order Details </h5>

                        <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <td>Foto</td>
                                    <td>Produk</td>
                                    <td>Qty</td>
                                    <td>Price</td>
                                    <td>Subtotal</td>
                                    <td>Status</td>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetails as $key => $orderDetail)
                                    <tr>
                                        <td>{{ $key += 1 }}</td>
                                        <td><img src="{{ asset('storage/' . $orderDetail->product->product_photo) }}"
                                                alt='' width='70'></td>
                                        <td>{{ $orderDetail->product->product_name }}</td>
                                        <td>{{ $orderDetail->qty }}</td>
                                        <td>Rp. {{ number_format($orderDetail->order_price) }}</td>
                                        <td>Rp. {{ number_format($orderDetail->order_subtotal) }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan='2'>Grand Total</th>
                                    <td align='right' colspan='3'>
                                        <span class='grandtotal'>Rp. {{ number_format($orders->order_amount) }}</span>
                                        {{--  <input type='hidden' class='form-control' name='grandtotal'>  --}}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
