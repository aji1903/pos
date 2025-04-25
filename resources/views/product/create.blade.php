@extends('layouts.main')
@section('title', 'Add New product')
@section('content')
    <section class='section'>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='card'>
                    <div class='card-body'>
                        <div align='right' class='mt-3'>
                            <a href="{{ url()->previous() }}" class='btn btn-primary'>Back</a>
                        </div>
                        <h5 class='card-title'>Add New product </h5>
                        <form action='{{ route('product.store') }}' method='post' enctype='multipart/form-data'>
                            @csrf
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Product Name *</label>
                                <input type='text' class='form-control' name='product_name'
                                    placeholder='Enter Product Name' required>
                            </div>
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Category Name *</label>
                                <select name='category_id' id='' class='form-control'>
                                    <option value=''>Select One</option>
                                    @foreach ($categories as $category)
                                        <option value='{{ $category->id }}'>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Product Price *</label>
                                <input type='number' class='form-control' name='product_price'
                                    placeholder='Enter Product Price' required>
                            </div>
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Product Description *</label>
                                <input type='text' class='form-control' name='product_description'
                                    placeholder='Enter Product Description' required>
                            </div>
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Product Photo *</label>
                                <input type='file' class='form-control' name='product_photo'
                                    placeholder='EnterProduct Photo' required>
                            </div>
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Product Stock *</label>
                                <input type='number' class='form-control' name='product_stock'
                                    placeholder='Enter Product Stock' required>
                            </div>
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Status *</label>
                                <br>
                                Publish <input type='radio' name='is_active' value='1' checked>
                                Draft <input type='radio' name='is_active' value='0'>
                            </div>
                            <div class='mb-3'>
                                <button class='btn btn-success' type='submit'>Save</button>
                                <button class='btn btn-danger' type='reset'>Cancel</button>

                        </form>
                    </div>
                </div>
    </section>
@endsection
