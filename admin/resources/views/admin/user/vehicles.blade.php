@extends('brackets/admin-ui::admin.layout.default')

@section('title',"Vendor Bookings");

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">

                <div class="card-header">

                <i class="fa fa-align-justify"></i> {{ trans('Vehicles') }}

                </div>
                <div class="card-body" v-cloak>
                    <table name="vehicles-data" class="vehicles-data" id="vehicles-data">
                        <thead>
                            <tr>
                                <th >{{ trans('Company') }}</th>
                                <th >{{ trans('Model') }}</th>
                                <th>{{ trans('Engine') }}</th>
                                <th>{{ trans('Year') }}</th>
                                <th>{{ trans('Purchased Year') }}</th>
                                <th >{{ trans('VIN Number') }}</th>
                                <th>{{ trans('Insurance Company Name') }}</th>
                                <th >{{ trans('Insurance Policy Number') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicles as $item)
                            <?php
                            $vehicleDetail = $item->vehicle;
                            $vehicleCompany = $vehicleDetail->vehicle_company;
                            ?>
                                <tr>
                                <td>{{$vehicleCompany->make}}</td>
                                <td>{{$vehicleDetail->model}}</td>
                                <td>{{ (float)$vehicleDetail->displ * 1000}}</td>
                                <td>{{$vehicleDetail->year}}</td>
                                <td>{{$item->purchased_year}}</td>
                                <td>{{$item->vin_number}}</td>
                                <td>{{$item->insurance_company_name}}</td>
                                <td>{{$item->insurance_policy_number}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


@endsection
@section('bottom-scripts')
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>

    $('#vehicles-data').DataTable({
        columnDefs: [
            { orderable: false, targets: -1 },
            { orderable: false, targets: -2 },
            ],
     });
    </script>
@endsection
