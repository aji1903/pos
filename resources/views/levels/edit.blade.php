@extends('layouts.main')
@section('title', 'Add New Levels')
@section('content')
    <section class='section'>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>Edit Levels </h5>
                        <form action='{{ route('levels.update', $edit->id) }}' method='post'>
                            @csrf
                            @method('put')
                            <div class='mb-3'>
                                <label for='' class='col-form-label'>Level Name *</label>
                                <input type='text' class='form-control' name='level_name' placeholder='Enter Level Name'
                                    required value='{{ $edit->level_name }}'>
                            </div>
                            <div class='mb-3'>
                                <button class='btn btn-primary' type='submit'>Save</button>

                                <a href="{{ url()->previous() }}" class='btn btn-danger'>Back</a>
                        </form>
                    </div>
                </div>
    </section>
@endsection
