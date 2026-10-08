@extends('management.layouts.master')
@section('title')
    Developers - {{config('app.dashboard')}}
@endsection
@section('content')
    <style>
        .select-dropdown>div {
            margin-bottom: 15px;
        }

        .select-dropdown>div select {
            width: 100%;
            border-radius: 10px;
            background-color: transparent;
            padding: 10px;
            border-color: #BC9C5B;
            color: #858383;
        }

        .bedroom-range p {
            display: flex;
            justify-content: space-between;
            display: flex;
            color: #858383;
        }

        .bedroom-range {
            color: #858383;
        }

        .bedroom-range>div {
            display: flex;
            color: #858383;
        }

        .bedroom-range>div input {
            background: transparent;
            border: none;
            margin: 10px 0 !important;
        }
        .table-property tbody tr{
            background-color: #F5F5F5 !important;
        }
        .table-property tbody tr td{
            padding-block: 10px !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 margin-tb my-3">
            <div class="pull-left">
                <h2 class="headingwithcount">Developers <span class="count">
                        {{count($developer)}}
                    </span></h2>
            </div>
            <div class="pull-right">

                @can('developer-create')
                    <a class="btn-icon" href="{{ route('developer.create') }}">+</a>
                @endcan
            </div>
        </div>
    </div>
    {{-- @if ($message = Session::get('success'))--}}
    {{-- <div class="alert alert-success">--}}
    {{-- <p>{{ $message }}</p>--}}
    {{-- </div>--}}
    {{-- @endif--}}

    <div class="card">
        <div class="body table-responsive">
            <table class="table table-property" id="myTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($developer as $developers)
                    <tr>
                        <td>{{$developers->name}}</td>
                        <td>
                            @if($developers->status == 1)
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="21" viewBox="0 0 28 21" fill="none">
                                    <path d="M1 10.8182L9.125 19L27 1" stroke="#BC9C5B" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            @else
                                <img src="{{asset('management/wrong.png')}}" alt="">
                            @endif
                        </td>
                        <td>
                            @can('developer-edit')
                                <a class="btn bg-blue btn-circle" href="{{route('developer.edit',$developers->id)}}">

                                    <i class="fas fa-pen" href=""></i>
                                </a>
                            @endcan
                            @can('developer-delete')
                                <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#exampleModalCenter{{$developers->id}}">
                                    <i class="fas fa-trash">  </i>
                                </button>



                                <div class="modal fade" id="exampleModalCenter{{$developers->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Delete
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure want to proceed this action?                                           </div>
                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-danger waves-effect"
                                                        data-dismiss="modal">Close</button>
                                                <form action="{{route('developer.destroy',$developers->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-info waves-effect">Delete</button>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>


    </div>


    {{-- {!! $roles->render() !!}--}}
@endsection
