@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.booking.actions.index'))

@section('body')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="row justify-content-md-between">
                        @if ($spare_part_shops->count()>0)
                        <div class="col col-lg-7 col-xl-5 form-group">
                            <div class="input-group ">
                                <form action="{{url('admin/bookings')}}" method="get">
                                    <select class="form-control" name=shop_id>
                                        <option value="" {{ request()->get('shop_id')==null?'selected':"" }}>
                                            Select Shop
                                        </option>
                                        @foreach ($spare_part_shops as $shops)
                                        <option value="{{$shops->id}}"
                                            {{ request()->get('shop_id')==$shops->id?'selected':"" }}>
                                            {{$shops->shop_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </span>
                                </form>
                            </div>
                            @endif
                        </div>
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
                            @if($data->count()>0)
                            @foreach ($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->customer_details->first_name??""}}</td>
                                <td>{{!empty($item->booking_vendor) ?$item->booking_vendor->first_name . ' '.$item->booking_vendor->last_name??"":''}}
                                </td>
                                <td>{{ $item->service?$item->service->name:"" }}</td>
                                <td>{{ $item->booking_vehicle->model }}</td>
                                <td>{{$item->booking_start_time}}</td>
                                <td>{{$item->booking_end_time}}</td>
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
                                    @else
                                    Invalid status
                                    @endif
                                </td>
                                <td>
                                    @if ($item->booking_type == 0)
                                    {{ trans('booking.normal_booking') }}
                                    @else
                                    {{ trans('booking.package_booking') }}
                                    @endif
                                </td>
                                <td>{{ $item->addition_info }}</td>
                                <td>
                                    <a class="btn btn-sm btn-spinner btn-info" href="{{$item->resource_url.'/view'}}"
                                        title="{{ trans('View') }}" role="button"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($data->count()>0)
                    <div class="row">
                        <div class="col-sm">
                            <span>Displaying items from {{ $data->toArray()['from'] }} to
                                {{  $data->toArray()['to'] }} of total {{ $data->toArray()['total'] }} items.</span>
                        </div>
                        <div class="col-sm-auto">
                            {{$data->links()}}
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div> @endsection
