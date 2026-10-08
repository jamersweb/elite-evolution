@extends('management.layouts.master')
@section('title')
    Property Request - {{config('app.dashboard')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="headingwithcount text-capitalize">

                    {{$data->name}}'s Career Request
                </h2>
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
           <p>Name: <br> {{$data->name}}</p>
           <p>Email:<br> {{$data->email}}</p>
           <p>Phone:<br> {{$data->phone}}</p>
           <p>Cover:<br> {{$data->cover}}</p>
            <p>
                Resume:<br>
                <a style="color:#BC9C5B;" download href="{{asset('images/media/resume'.'/'.$data->resume)}}"> {{$data->resume}}</a>
            </p>
            <div class="text-right">
                <h6>Date / Time</h6>
                <p class="m-0">{{date('d-M-Y H:i A',strtotime($data->created_at))}}</p>
            </div>
        </div>


    </div>
@endsection
