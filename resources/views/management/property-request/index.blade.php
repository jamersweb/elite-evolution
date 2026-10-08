@extends('management.layouts.master')
@section('title')
    Property Request - {{config('app.dashboard')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="headingwithcount text-capitalize">

                    {{$_GET['type']}} Request
                    <span class="count">{{count($data)}}</span></h2>
            </div>
        </div>
    </div>
    {{--    @if ($message = Session::get('success'))--}}
    {{--        <div class="alert alert-success">--}}
    {{--            <p>{{ $message }}</p>--}}
    {{--        </div>--}}
    {{--    @endif--}}

    <div class="card">
        <div class="body table-responsive">
            <table class="table " id="myTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    @if($_GET['type'] == 'listing')
                        <th>Type</th>

                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $prequest)
                    <tr>
                        <td>{{ $prequest->name }}</td>
                        <td>{{ $prequest->email }}</td>
                        <td>{{ $prequest->phone }}</td>
                        <td>{{ $prequest->address }}</td>
                        @if($_GET['type'] == 'listing')
                            <td>{{ $prequest->type }}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>


    </div>
@endsection
