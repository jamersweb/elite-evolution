@extends('management.layouts.master')
@section('title')
    Leads  - {{config('app.dashboard')}}
@endsection
@section('content')

    <style>
        button.btn.btn-signature {
            height: 50px !important;
            width: 100%;
            border-radius: 8px !important;
            text-align: center !important;
            justify-content: center;
        }
        button.btn.btn-signature:hover{
            background: black !important;
            color: white !important;
        }
    </style>
<form action="{{route('lead.index')}}" method="get">
    <div class="row m-0 pb-md-3 pb-3">
        <div class="col-md-3 col-12">
            <select class="field-text px-md-2 px-2" name="status" aria-label="Default select example">
                <option selected value="">Lead Status</option>
                <option {{isset($_GET['status']) == 1 ? 'selected' : '' }} value="1">New</option>
                <option {{isset($_GET['status']) == 2 ? 'selected' : '' }} value="2">Converted</option>
                <option {{isset($_GET['status']) == 3 ? 'selected' : '' }} value="3">Qualified</option>
                <option {{isset($_GET['status']) == 4 ? 'selected' : '' }} value="4">Proposal Sent</option>
                <option {{isset($_GET['status']) == 5 ? 'selected' : '' }} value="5">Contacted</option>
                <option {{isset($_GET['status']) == 7 ? 'selected' : '' }} value="7">Disqualified</option>
            </select>
        </div>
        <div class="col-md-3 col-12">
            <input type="text" name="id" class="field-text px-md-2 px-2" placeholder="Lead ID">
        </div>
        <div class="col-md-3 pr-0 col-12">
            <select class="field-text px-md-2 px-2" name="country" aria-label="Default select example">
                <option selected value=""> Country</option>
                <option {{isset($_GET['country']) == "United Arab Emirates" ? 'selected' : '' }} value="United Arab Emirates">United Arab Emirates</option>
                <option {{isset($_GET['country']) == "United Kingdom" ? 'selected' : '' }} value="United Kingdom">United Kingdom</option>
            </select>

        </div>

    </div>

    <div class="row m-0 pb-md-3 pb-3">
        <div class="col-md-3 col-12">
            <input type="text"  name="mobile" value="{{isset($_GET['mobile']) ? $_GET['mobile'] : '' }}" class="field-text px-md-2 px-2" placeholder="Mobile">
        </div>
        <div class="col-md-3 col-12">
            <input type="text" name="email" value="{{isset($_GET['email']) ? $_GET['email'] : '' }}" class="field-text px-md-2 px-2" placeholder="Email">
        </div>
        <div class="col-md-3 col-12 pr-0">
            <select class="field-text px-md-2 px-2"  name="property_type" aria-label="Default select example">
                <option selected value="">Property Type*</option>

                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Apartment' ? 'selected' : ''}} value="Apartment">Apartment</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Villa' ? 'selected' : ''}} value="Villa">Villa</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Townhouse' ? 'selected' : ''}} value="Townhouse">Townhouse</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Hotel Apartment' ? 'selected' : ''}} value="Hotel Apartment">Hotel Apartments</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Duplex' ? 'selected' : ''}} value="Duplex">Duplex</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Penthouse' ? 'selected' : ''}} value="Penthouse">Penthouse</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Mansion' ? 'selected' : ''}} value="Mansion">Mansion</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Office' ? 'selected' : ''}} value="Office">Office</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Residential Plot' ? 'selected' : ''}} value="Residential Plot">Residential Plot</option>
                <option {{isset($_GET['property_type']) && $_GET['property_type'] == 'Commercial Plot' ? 'selected' : ''}} value="Commercial Plot">Commercial Plot</option>

            </select>

        </div>
        <div class="col-md-3 col-12 pr-0">
            <button class="btn btn-signature" type="submit">Search</button>
        </div>

    </div>

</form>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="headingwithcount">Leads <span class="count">{{count($leads)}}</span></h2>
            </div>
            <div class="pull-right">
                @can('leads-create')
                    <a class="btn-icon" href="{{ route('lead.create') }}">+</a>
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
            <thead class="pb-md-3 py-3 px-md-3 px-3">
            <tr>
                <th>
                    Name
                </th>
                <th>
                  Email / Phone
                </th>
                <th>
                  Type
                </th>
                <th>
                    Property Type
                </th>
                <th>
                  Time-Frame
                </th>
                <th>
                    Quality
                </th>
                <th>
                    Status
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($leads as $key => $role)
                <tr>
{{--                    <td>{{ ++$i }}</td>--}}
                    <td>
                        <a href="{{route('lead.edit',$role->id)}}">
                            {{ $role->firstname.' '.$role->lastname }}
                        </a>
                    </td>
                    <td>{{ $role->email }} <br> {{ $role->phone }}</td>
                    <td class="text-capitalize">{{ $role->type }} <br> {{ $role->land_type }}</td>
                    <td>{{ $role->property_type }}</td>
                    <td>{{ $role->time_frame }}</td>
                    <td>{{ $role->quality }} Star</td>
                    <td>
                        <button class="badge badge-secondary">
                        @if($role->status == 1)
                            New
                        @elseif($role->status == 2)
                            Converted
                        @elseif($role->status == 3)
                            Qualified
                        @elseif($role->status == 4)
                            Proposal Sent
                        @elseif($role->status == 5)
                            Contacted
                        @elseif($role->status == 7)
                            Disqualified
                        @endif
                        </button>
                    </td>

                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


</div>


{{--    {!! $roles->render() !!}--}}
@endsection
