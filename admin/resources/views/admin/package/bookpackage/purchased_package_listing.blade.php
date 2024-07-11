@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.package.actions.index'))

@section('body')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body" v-cloak>
                <div class="card-block">
                    <table class="table table-hover table-listing">
                        <thead>
                            <tr>
                                <th>{{ trans('admin.package.id') }}</th>
                                <th>{{ trans('admin.package.user_name') }}</th>
                                <th>{{ trans('admin.package.package_name') }}</th>
                                <th>{{ trans('admin.package.order_id') }}</th>
                                <th>{{ trans('admin.package.package_bookings') }}</th>
                                <th>{{ trans('admin.package.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($package->purchased_package->count() > 0)
                            @foreach ($package->purchased_package as $purchased_package)
                            <tr>
                                <td>{{$purchased_package->id}}</td>
                                <td><a href="{{url('admin/customer').'/'.$purchased_package->user_id."/viewDetails"}}">{{$purchased_package->user_id}}</a>
                                </td>
                                <td>{{$purchased_package->package_id}}</td>
                                <td>{{$purchased_package->order_id}}</td>
                                <td><a class=" btn btn-sm btn-spinner btn-info"
                                        href={{url('admin/packages/order-bookings/'.$purchased_package->order_id)}}>
                                        <span
                                            class="text-success">{{$purchased_package->booking_by_order_id->count()}}</span>
                                        <i class="nav-icon icon-magnet"></i></a></td>
                                <td>
                                    <div class="row no-gutters">
                                        <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i
                                                    class="fa fa-trash-o"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
