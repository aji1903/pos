@extends('layouts.main')
@section('title', 'Data Levels')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title ?? '' }}</h5>
                        <div class='mt-4 mb-3'>
                            <div align='right' class='mb-3'>
                                <a class='btn btn-info'href='{{ route('levels.create') }}'>Add Levels</a>
                            </div>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAME LEVEL</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->level_name }}</td>
                                            <td>
                                                <a href='{{ route('levels.edit', $data->id) }}'
                                                    class='btn btn-secondary btn-sm'><i class='bi bi-pencil'></i>
                                                </a>
                                                <form class='d-inline' action='{{ route('levels.destroy', $data->id) }}'
                                                    method='post'>
                                                    @csrf
                                                    @method('delete')
                                                    <button type='submit' class='btn btn-danger btn-sm'><i
                                                            class='bi bi-trash'></i>
                                                </form>

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{--  <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Example Card</h5>
                        <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
                    </div>
                </div>

            </div>  --}}
        </div>
    </section>

@endsection
