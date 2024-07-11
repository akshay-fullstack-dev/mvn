@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.booking.actions.index'))

@section('body')

<booking-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/bookings') }}'" inline-template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body" v-cloak>
                    <div class="card-block">
                        <div class="row justify-content-md-between">
                            @if ($spare_part_shops->count()>0)
                            <div class="col col-lg-7 col-xl-5 form-group">
                                <div class="input-group ">
                                    <form action="{{url('admin/bookings/select_shop')}}" method="get">
                                        <select class="form-control" name=shop_id>
                                            @php
                                                echo request()->get('shop_id');die;
                                            @endphp
                                            <option value="" {{ request()->get('shop_id')==null?'selected':"" }}>
                                                Select
                                                Shop
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
                            {{-- <form @submit.prevent="">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        <input class="form-control"
                                            placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}"
                            v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i
                                        class="fa fa-search"></i>&nbsp;
                                    {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                            </span>
                        </div>
                    </div>
                </div>
                </form> --}}

                <table class="table table-hover table-listing">
                    <thead>
                        <tr>
                            <th class="bulk-checkbox">
                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll"
                                    v-validate="''" data-vv-name="enabled" name="enabled_fake_element"
                                    @click="onBulkItemsClickedAllWithPagination()">
                                <label class="form-check-label" for="enabled">
                                    #
                                </label>
                            </th>

                            <th is='sortable' :column="'id'">{{ trans('admin.booking.columns.id') }}</th>
                            <th is='sortable' :column="'user_id'">{{ trans('admin.booking.columns.user_id') }}
                            </th>
                            <th is='sortable' :column="'vendor_id'">
                                {{ trans('admin.booking.columns.vendor_id') }}
                            </th>
                            <th is='sortable' :column="'service_id'">
                                {{ trans('admin.booking.columns.service_id') }}
                            </th>
                            <th is='sortable' :column="'vehicle_id'">
                                {{ trans('admin.booking.columns.vehicle_id') }}
                            </th>
                            <th is='sortable' :column="'booking_start_time'">
                                {{ trans('admin.booking.columns.booking_start_time') }}
                            </th>
                            <th is='sortable' :column="'booking_end_time'">
                                {{ trans('admin.booking.columns.booking_end_time') }}
                            </th>
                            <th is='sortable' :column="'booking_status'">
                                {{ trans('admin.booking.columns.booking_status') }}
                            </th>
                            <th is='sortable' :column="'booking_type'">
                                {{ trans('admin.booking.columns.booking_type') }}
                            </th>
                            <th is='sortable' :column="'addition_info'">
                                {{ trans('admin.booking.columns.addition_info') }}
                            </th>
                            <th>{{ trans('admin.booking.columns.action') }}</th>

                            <th></th>
                        </tr>
                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                            <td class="bg-bulk-info d-table-cell text-center" colspan="16">
                                <span
                                    class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }}
                                    @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary"
                                        @click="onBulkItemsClickedAll('/admin/bookings')"
                                        v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa"
                                            :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i>
                                        {{ trans('brackets/admin-ui::admin.listing.check_all_items') }}
                                        @{{ pagination . state . total }}</a> <span class="text-primary">|</span> <a
                                        href="#" class="text-primary"
                                        @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>
                                </span>
                                <span class="pull-right pr-2">
                                    <button class="btn btn-sm btn-danger pr-3 pl-3"
                                        @click="bulkDelete('/admin/bookings/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                </span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in collection" :key="item.id"
                            :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                            <td class="bulk-checkbox">
                                <input class="form-check-input" :id="'enabled' + item.id" type="checkbox"
                                    v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"
                                    :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)"
                                    :disabled="bulkCheckingAllLoader">
                                <label class="form-check-label" :for="'enabled' + item.id">
                                </label>
                            </td>
                            <td>@{{ item . id }}</td>
                            <td>@{{ item . customer_details . first_name + ' ' + item . customer_details . last_name }}
                            </td>
                            <td>@{{ item . booking_vendor . first_name + ' ' + item . booking_vendor . last_name }}
                            </td>
                            <td>@{{ item . service ?. name }}</td>
                            <td>@{{ item . booking_vehicle . model }}</td>
                            <td>@{{ (item . booking_start_time) | datetime }}</td>
                            <td>@{{ (item . booking_end_time) | datetime }}</td>
                            <td>
                                <span v-if="item . booking_status==0">{{ trans('booking.0') }}</span>
                                <span v-if="item . booking_status==1">{{ trans('booking.1') }}</span>
                                <span v-if="item . booking_status==2">{{ trans('booking.2') }}</span>
                                <span v-if="item . booking_status==3">{{ trans('booking.3') }}</span>
                                <span v-if="item . booking_status==4">{{ trans('booking.4') }}</span>
                                <span v-if="item . booking_status==5">{{ trans('booking.5') }}</span>
                                <span v-if="item . booking_status==6">{{ trans('booking.6') }}</span>
                                <span v-if="item . booking_status==7">{{ trans('booking.7') }}</span>
                            </td>
                            <td>
                                <span v-if="item . booking_type==0">{{ trans('booking.normal_booking') }}</span>
                                <span v-else>{{ trans('booking.package_booking') }}</span>
                            </td>
                            <td>@{{ item . addition_info }}</td>
                            <td>
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/view'"
                                            title="{{ trans('View') }}" role="button"><i class="fa fa-eye"></i></a>
                                    </div>
                                    {{-- <form class="col"
                                                    @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i
                                        class="fa fa-trash-o"></i></button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="row" v-if="pagination.state.total > 0">
                    <div class="col-sm">
                        <span
                            class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                    </div>
                    <div class="col-sm-auto">
                        <pagination></pagination>
                    </div>
                </div>
                <div class="no-items-found" v-if="!collection.length > 0">
                    <i class="icon-magnifier"></i>
                    <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                    <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                    <a class="btn btn-primary btn-spinner" href="{{ url('admin/bookings/create') }}" role="button"><i
                            class="fa fa-plus"></i>&nbsp;
                        {{ trans('admin.booking.actions.create') }}</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</booking-listing>

@endsection
