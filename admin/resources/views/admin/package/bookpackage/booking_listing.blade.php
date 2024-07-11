@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.booking.actions.index'))

@section('body')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body" v-cloak>
                <div class="card-block">
                    <div class="row justify-content-md-between">
                    </div>
                    <table class="table table-hover table-listing">
                        <thead>
                            <tr>
                                <th>{{ trans('admin.booking.columns.id') }}</th>
                                <th>{{ trans('admin.booking.columns.user_id') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.vendor_id') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.service_id') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.vehicle_id') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.booking_start_time') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.booking_end_time') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.booking_status') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.booking_type') }}
                                </th>
                                <th>
                                    {{ trans('admin.booking.columns.addition_info') }}
                                </th>
                                <th>{{ trans('admin.booking.columns.action') }}</th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($bookings->count()>0)
                            @foreach ($bookings as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->customer_details->first_name . ' ' . $item->customer_details->last_name }}
                                </td>
                                <td>@if (isset($item->booking_vendor))
                                    {{ $item->booking_vendor->first_name .' ' . $item->booking_vendor->last_name }}
                                    @endif
                                </td>
                                <td>{{ $item->service?$item->service->name:"" }}</td>
                                <td>{{ $item->booking_vehicle->model }}</td>
                                <td>{{ ($item->booking_start_time)}}</td>
                                <td>{{ ($item->booking_end_time)}}</td>
                                <td>
                                    @if ($item->booking_status == 0)
                                    {{ trans('booking.0') }}
                                    @elseif($item->booking_status == 1)
                                    {{ trans('booking.1') }}
                                    @elseif($item->booking_status == 2)
                                    {{ trans('booking.2') }}
                                    @elseif($item->booking_status == 3)
                                    {{ trans('booking.3') }}
                                    @elseif($item->booking_status == 4)
                                    {{ trans('booking.4') }}
                                    @elseif($item->booking_status == 5)
                                    {{ trans('booking.5') }}
                                    @elseif($item->booking_status == 6)
                                    {{ trans('booking.6') }}
                                    @elseif($item->booking_status == 7)
                                    {{ trans('booking.7') }}
                                    @endif
                                </td>
                                <td>{{ trans('booking.package_booking') }}</td>
                                <td>{{$item->addition_info }}</td>
                                <td>
                                    <div class="row no-gutters">
                                        <button type="button"
                                            class="btn btn-primary @php echo $item->vendor_id != null ? " disabled":''
                                            @endphp" id="assign-vendor" onclick="add_vendor(this)"
                                            data-vendor-id="{{ $item->vendor_id }}" data-id="{{ $item->id }}"
                                            data-order-id="{{$item->order_id}}"
                                            data-url={{url("/admin/packages/get-booking-vendor/$item->id")}}>
                                            <i class="fa fa-user-o"></i>
                                        </button>
                                        <a class="btn btn-sm btn-spinner btn-info"
                                            href="{{url('admin/bookings')}}/{{$item->id}}/view"
                                            title="{{ trans('View') }}" role="button"><i class="fa fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if (!$bookings->count() > 0)
                    <div class="no-items-found">
                        <i class="icon-magnifier"></i>
                        <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                        <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                        <a class="btn btn-primary btn-spinner" href="{{ url('admin/bookings/create') }}"
                            role="button"><i class="fa fa-plus"></i>&nbsp;
                            {{ trans('admin.booking.actions.create') }}</a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- vendor Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Vendor :- <small id="booking-order-id"></small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/packages/assign-vendor')}}" method="get">
                    <input type="hidden" name="booking_id" class="form-check-input" id="vendor-booking-id">
                    <input type="hidden" name="order_id" class="form-check-input" id="vendor-order-id">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Vendor</label>
                        <select name="vendor_id" class="form-control form-select form-select-lg mb-3" id="vendor-select"
                            aria-label=".form-select-lg example"></select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="assign-vendor-submit" type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom-scripts')
@parent
<script src="{{ asset('js/custom.js')}}"></script>
@endsection
