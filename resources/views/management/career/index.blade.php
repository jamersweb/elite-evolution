@extends('management.layouts.master')
@section('title')
    Career  {{config('app.dashboard')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="headingwithcount text-capitalize">

                    Career Request
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
                    <th>Cover</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $prequest)
                    <tr>
                        <td>
                            <a style="color:#BC9C5B;" href="{{url('admin/career',$prequest->id)}}">{{ $prequest->name }}</a>
                        </td>
                        <td>{{ $prequest->cover}}</td>
                        <td>{{date('d-M-Y h:i A',strtotime($prequest->created_at))}}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>


    </div>
@endsection
