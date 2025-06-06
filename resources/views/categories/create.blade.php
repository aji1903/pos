@extends('layouts.main')
@section('title', 'Add New Categories')
@section('content')
    <section class='section'>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>Add New Categories </h5>
                        <form action='{{ route('categories.store') }}' method='post'>
                            @csrf
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Category Name *</label>
                                <input type='text' class='form-control' name='category_name'
                                    placeholder='Enter Category Name' required>
                            </div>
                            <div class='mb-3'>
                                <button class='btn btn-primary' type='submit'>Save</button>
                                {{--  <button class='' type='reset'>Cancel</button>  --}}
                                <a href="{{ url()->previous() }}" class='btn btn-danger'>Back</a>
                        </form>
                    </div>
                </div>
    </section>
@endsection
