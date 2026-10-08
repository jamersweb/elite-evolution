@extends('management.layouts.master')
@section('title')
    Roles - {{config('app.dashboard')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="headingwithcount">Roles <span class="count">{{count($roles)}}</span></h2>
            </div>
            <div class="pull-right">
                @can('role-create')
                    <a class="btn-icon" href="{{ route('roles.create') }}"> + </a>
                @endcan
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
                <th>No</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                            @can('role-edit')
                        <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                            @endcan
                        @if($role->id != 1)
                        @can('role-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


</div>


    {!! $roles->render() !!}
@endsection
