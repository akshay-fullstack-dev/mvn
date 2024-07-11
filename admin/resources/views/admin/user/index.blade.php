@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.user.actions.index'))

@section('body')
@if (Session::has('flash_message'))

<div class="alert {{ Session::get('flash_type') }}">
    <h3>{{ Session::get('flash_message') }}</h3>
</div>

@endif
<user-listing :data="{{ $data->toJson() }}" :url="'{{ url($url) }}'" inline-template>

    <div class="row">
        <div class="col">
            <div class="card">

                <div class="card-header">
                    @if ($role == 'customer')
                    <i class="fa fa-align-justify"></i> {{ trans('Customer') }}
                    @endif
                    @if ($role == 'admin')
                    <i class="fa fa-align-justify"></i> {{ trans('Vendors') }}
                    @endif
                    @if ($showButton && $role == 'admin')
                    <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0"
                        href="{{ url('admin/users/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp;
                        {{ trans('New vendor') }}</a>
                    @endif
                </div>
                <div class="card-body" v-cloak>
                    <div class="card-block">
                        <form @submit.prevent="">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        <input class="form-control"
                                            placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}"
                                            v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary"
                                                @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp;
                                                {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-auto form-group ">
                                    <select class="form-control" v-model="pagination.state.per_page">

                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <table class="table table-hover table-listing">
                            <thead>
                                <tr>
                                    <th is='sortable' :column="'id'">{{ trans('admin.user.columns.id') }}</th>
                                    <th is='sortable' :column="'first_name'">
                                        {{ trans('admin.user.columns.first_name') }}
                                    </th>
                                    <th is='sortable' :column="'last_name'">{{ trans('admin.user.columns.last_name') }}
                                    </th>
                                    <th is='sortable' :column="'email'">{{ trans('admin.user.columns.email') }}</th>
                                    <th is='sortable' :column="'email_verified_at'">
                                        {{ trans('admin.user.columns.email_verified_at') }}
                                    </th>
                                    <th is='sortable' :column="'phone_number'">
                                        {{ trans('admin.user.columns.phone_number') }}
                                    </th>
                                    <th is='sortable' :column="'country_iso_code'">
                                        {{ trans('admin.user.columns.country_iso_code') }}
                                    </th>
                                    <th is='sortable' :column="'is_blocked'">
                                        {{ trans('admin.user.columns.is_blocked') }}
                                    </th>
                                    <th is='sortable' :column="'account_status'">
                                        {{ trans('admin.user.columns.account_status') }}
                                    </th>
                                    <th is='sortable' :column="'country_code'">
                                        {{ trans('admin.user.columns.country_code') }}
                                    </th>
                                    <th is='sortable' :column="'created_at'">
                                        {{ trans('admin.user.columns.created_at') }}
                                    </th>
                                </tr>
                                <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                    <td class="bg-bulk-info d-table-cell text-center" colspan="12">
                                        <span
                                            class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }}
                                            @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary"
                                                @click="onBulkItemsClickedAll('/admin/users')"
                                                v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa"
                                                    :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i>
                                                {{ trans('brackets/admin-ui::admin.listing.check_all_items') }}
                                                @{{ pagination . state . total }}</a> <span
                                                class="text-primary">|</span> <a href="#" class="text-primary"
                                                @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>
                                        </span>
                                        <span class="pull-right pr-2">
                                            <button class="btn btn-sm btn-danger pr-3 pl-3"
                                                @click="bulkDelete('/admin/users/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                        </span>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in collection" :key="item.id"
                                    :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                    <td><span v-if="item.admin_user"><i class="fa fa-star"></i></span>@{{ item . id }}
                                    </td>
                                    <td>@{{ item . first_name }}</td>
                                    <td>@{{ item . last_name }}</td>
                                    <td>@{{ item . email }}</td>
                                    <td>@{{ (item . email_verified_at) | datetime }}</td>
                                    <td>@{{ item . phone_number }}</td>
                                    <td>@{{ item . country_iso_code }}</td>

                                    <!-- <td>@{{ item . resource_url }}</td> -->
                                    <td v-if="item.is_blocked">
                                        <label class="switch switch-3d switch-danger">
                                            <input type="checkbox" class="switch-input delete-popup"
                                                v-model="collection[index].is_blocked"
                                                @change="toggleSwitch(item.resource_url, 'featured', collection[index])">
                                            <span class="switch-slider"></span>
                                        </label>
                                    </td>
                                    <td v-if="!item.is_blocked">
                                        <label class="switch switch-3d switch-danger" :for="item.id"
                                            onclick="myFunction(this)" data-toggle="modal" data-target="#exampleModal">
                                            <span class="switch-slider"></span>
                                        </label>
                                    </td>
                                    <!-- <td><input type="text" name="reason" id="abc" :value="item.id"></td> -->
                                    <td v-if="item.account_status==0">No action</td>
                                    <td v-if="item.account_status==1">Under review</td>
                                    <td v-if="item.account_status==2">Verified</td>
                                    <td v-if="item.account_status==3">Not approved</td>
                                    <td>@{{ item . country_code }}</td>
                                    <td>@{{ item . created_at }}</td>

                                    <td>
                                        <div class="row no-gutters">
                                            <div class="col-auto"
                                                v-if="(item.user_documents).length > 0 && item.account_status==2">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                    :href="item.resource_url + '/showDocument'"
                                                    title="{{ trans('Vendor document') }}" role="button"><i
                                                        class="fa fa-address-card"></i></a>
                                            </div>
                                            <div class="col-auto" v-if="item.is_blocked || item.account_status==3">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                    :href="item.resource_url + '/showReason'"
                                                    title="{{ trans('Reason') }}" role="button"><i
                                                        class="fa fa-comments"></i></a>
                                            </div>

                                            @if ($role == 'admin')
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                    :href="item.resource_url + '/bookings'"
                                                    title="{{ trans('Bookings') }}" role="button"><i
                                                        class="fa fa-ticket"></i></a>
                                            </div>
                                            @endif
                                            @if ($role == 'customer')
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                    :href="item.resource_url + '/userBookings'"
                                                    title="{{ trans('Bookings') }}" role="button"><i
                                                        class="fa fa-ticket"></i></a>
                                            </div>
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                    :href="item.resource_url + '/userVehicles'"
                                                    title="{{ trans('Vehicles') }}" role="button"><i
                                                        class="fa fa-car"></i></a>
                                            </div>
                                            @endif

                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                    :href="item.resource_url + '/viewDetails'"
                                                    title="{{ trans('Details') }}" role="button"><i
                                                        class="fa fa-eye"></i></a>
                                            </div>
                                            <div class="col-auto" v-if="(item.user_services).length > 0 ">
                                                <a class="btn btn-sm btn-spinner btn-info"
                                                    :href="item.resource_url + '/enrollService'"
                                                    title="{{ trans('enroll service') }}" role="button"><i
                                                        class="fa fa-server"></i></a>
                                            </div>
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
                            <a class="btn btn-primary btn-spinner" href="{{ url('admin/users/create') }}"
                                role="button"><i class="fa fa-plus"></i>&nbsp;
                                {{ trans('admin.user.actions.create') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</user-listing>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to block this vendor ?

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>

                <form method="get" name="reason_form" onsubmit="return validateReasonForm()"
                    action="{{ url('/admin/users/block') }}">
                    <input type="hidden" name="userid" id="userId">
                    {{ csrf_field() }}
                    </span>Please Enter Reason For Block</span>
                    <input type="text" name="reason">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Yes, Block">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="{{ url('js/popup.js') }}" type="text/javascript"></script>
@endsection
