@extends('layouts.main')
@section('title', 'Stock')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">


                        <h5 class="card-title">{{ $title ?? '' }}</h5>
                        <div class='mt-4 mb-3'>

                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Photo</th>
                                        <th>Category</th>
                                        <th>Name Product</th>
                                        <th>Price</th>
                                        <th>Stock</th>





                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td><img width='90'src="{{ asset('storage/' . $data->product_photo) }}">
                                            </td>


                                            <td>{{ $data->category->category_name }}</td>
                                            <td>{{ $data->product_name }}</td>
                                            <td>{{ $data->product_price }}</td>
                                            <td>{{ $data->product_stock ?? '-' }}</td>




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
