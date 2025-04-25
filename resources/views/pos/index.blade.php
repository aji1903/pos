@extends('layouts.main')
@section('title', 'Orders')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title ?? '' }}</h5>
                        <div class='mt-4 mb-3'>
                            <div align='right' class='mb-3'>
                                <a class='btn btn-info'href='{{ route('pos.create') }}'>Add pos</a>
                            </div>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Order Code</th>
                                        <th>Order Date</th>
                                        <th>Amount</th>
                                        <th>Change</th>
                                        <th>Payment</th>


                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->order_code }}</td>
                                            <td>{{ $data->order_date }}</td>
                                            <td>{{ $data->order_amount }}</td>
                                            <td>{{ $data->order_change }}</td>
                                            <td>{{ $data->payment_amount }}</td>


                                            <td>{{ $data->order_status ? 'Paid' : 'Unpaid' }}</td>
                                            <td>
                                                <a href='{{ route('pos.show', $data->id) }}'
                                                    class='btn btn-secondary btn-sm'>
                                                    <i class='bi bi-eye'></i>
                                                </a>
                                                <a href='' class='btn btn-success btn-sm'>
                                                    <i class='bi bi-printer'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Example Card</h5>
                        <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
                    </div>
                </div>

            </div>
        </div>

    </section>

@endsection
