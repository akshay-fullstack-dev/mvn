@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Vendor Bookings');

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> {{ trans('Bookings') }}
                </div>
                <div class="card-body" v-cloak>
                    <table name="booking-data" class="booking-data" id="booking-data">
                        <thead>
                            <tr>
                                <th>{{ trans('ID') }}</th>
                                <th>{{ trans('User Name') }}</th>
                                <th>{{ trans('Vendor Name') }}</th>
                                <th>{{ trans('Service Name') }}</th>
                                <th>{{ trans('Booking Start Time') }}</th>
                                <th>{{ trans('Booking End Time') }}</th>
                                <th>{{ trans('Booking Status') }}</th>
                                <th>{{ trans('Booking Type') }}</th>
                                <th>{{ trans('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->customer_details->first_name . ' ' . $item->customer_details->last_name }}
                                    </td>
                                    <td>{{ $item->booking_vendor->first_name . ' ' . $item->booking_vendor->last_name }}
                                    </td>
                                    <td>{{ $item->service->name }}</td>
                                    <td>{{ $item->booking_start_time }}</td>
                                    <td>{{ $item->booking_end_time }}</td>
                                    <td>
                                        @if ($item->booking_status == 0)
                                            Booking Confirmed
                                        @endif
                                        @if ($item->booking_status == 1)
                                            Vendor Assigned
                                        @endif
                                        @if ($item->booking_status == 2)
                                            Vendor Out For Service
                                        @endif
                                        @if ($item->booking_status == 3)
                                            Vendor Started Job
                                        @endif
                                        @if ($item->booking_status == 4)
                                            Vendor Job Finished
                                        @endif
                                        @if ($item->booking_status == 5)
                                            Booking Cancelled
                                        @endif
                                        @if ($item->booking_status == 6)
                                            Booking Rejected
                                        @endif
                                        @if ($item->booking_status == 7)
                                            Vendor Reached Location
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->booking_type == 0)
                                            Normal Booking
                                        @endif
                                        @if ($item->booking_type == 1)
                                            Package Booking
                                        @endif
                                    </td>
                                    <td>
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-spinner btn-info" href="/admin/bookings/{{ $item->id }}/view" title="{{ trans('View') }}"
                                                role="button"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            @endsection
            @section('bottom-scripts')
                <link rel="stylesheet" href="http://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
                <script>
                    $('#booking-data').DataTable({
                        columnDefs: [{
                                orderable: false,
                                targets: -1
                            },
                            {
                                orderable: false,
                                targets: -2
                            },
                        ],
                    });

                </script>
            @endsection
