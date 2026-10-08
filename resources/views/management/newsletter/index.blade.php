@extends('management.layouts.master')
@section('title')
    Newsletter Subscribers - {{config('app.dashboard')}}
@endsection
@section('content')

    <div class="container-fluid px-4">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title"> Newsletter Subscribers</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <div class="body table-responsive">
                            <table class="table" id="myTable">
                                <thead>
                                <tr>
                                    <th class="col-lg-3">Email</th>

                                    <th class="col-lg-3">Date</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $count=1
                                ?>
                                @foreach($data as $row)
                                    <tr>
                                        <td> {{$row->email}}</td>
                                        <td> {{$row->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                </form>



@endsection

