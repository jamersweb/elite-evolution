@extends('management.layouts.master')
@section('title')
    Users - {{config('app.dashboard')}}
@endsection


@section('content')

    <div class="container-fluid px-4">
{{--        <h1 class="heading_font">Registration</h1>--}}
{{--        <form>--}}
{{--            <div class="row m-0">--}}
{{--                <div class="col-lg-4 p-0">--}}
{{--                    <input type="text" name="" id="" placeholder="Name" class="input-field py-md-2 pl-3 text-color">--}}
{{--                </div>--}}
{{--                <div class="col-lg-4">--}}
{{--                    <input type="number" name="" id="" placeholder="Phone" class="input-field py-md-2 mx-md-2 pl-3 text-color">--}}
{{--                </div>--}}
{{--                <div class="col-lg-4">--}}
{{--                    <input type="text" name="" id="" placeholder="RERA No" class="input-field  py-md-2 pl-3 text-color">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
        <div class="row d-none">
            <div class="col-12 ">
                <div class="card">
                    <div class="body propertyTask">
                        <a href="{{route('property.index')}}?status=sale">pending <span>0</span></a>
                    </div>
                </div>
            </div>

        </div>
        <h2 class="headingwithcount my-md-3 heading_font">Users <span class="count">46</span></h2>
        <div class="card px-md-3">
            <div class="header">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        {{--                <div class="pull-left">--}}
                        {{--                    <h2>Users Management aijaz</h2>--}}
                        {{--                </div>--}}
                        <div class="pull-right">
                            <a class="btn-icon" href="{{ route('users.create') }}">+</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body">
                <table class="table" id="myTable">
                    <thead>
                    <tr>
{{--                        <th>No</th>--}}
                        <th>Name</th>
                        <th>Email</th>
                            <th>Status</th>
                        <th>Email Verify</th>
                        <th>Roles</th>
                        <th>Phone</th>
                        <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $user)
                        <tr>
{{--                            <td class="heading_font">{{ ++$i }}</td>--}}
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            
                            
                             <td>
                                 @if ($user->status == 'active')
                                 <label class="badge badge-success" data-toggle="modal"
                                           data-target="#active_inactive">{{$user->status}}</label>
                                 @else
                                  <label class="badge badge-danger" data-toggle="modal"
                                           data-target="#active_inactive">{{$user->status}}</label>
                                 @endif
                             </td>
                            @if ($user->is_varified == 1)
                                <td><label class="badge badge-info" data-toggle="modal"
                                           data-target="#active_inactive">Varified</label>
                                </td>
                            @else
                                <td><label class="badge badge-danger" data-toggle="modal"
                                           data-target="#active_inactive">Not Varified</label>
                                </td>
                            @endif
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                        <label class="badge-success p-2">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <p>{{ $user->phone }}</p>
                            </td>
                            <td class="heading_font">
                                {{--                        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>--}}

                                @can('user-edit')
                                <a class="btn bg-black waves-effect waves-light" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                @endcan
                                    @can('user-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    {{--    {!! $data->render() !!}--}}
@endsection
