@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.vendor-requested-service.actions.index'))

@section('body')


<vendor-requested-service-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/vendor-requested-services') }}'"
    inline-template>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> {{ trans('admin.vendor-requested-service.actions.index') }}
                    <!-- <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/vendor-requested-services/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.vendor-requested-service.actions.create') }}</a> -->
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
                                    <th class="bulk-checkbox">
                                        <input class="form-check-input" id="enabled" type="checkbox"
                                            v-model="isClickedAll" v-validate="''" data-vv-name="enabled"
                                            name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                        <label class="form-check-label" for="enabled">
                                            #
                                        </label>
                                    </th>

                                    <th is='sortable' :column="'id'">
                                        {{ trans('admin.vendor-requested-service.columns.id') }}</th>
                                    <th is='sortable' :column="'first_name  '">{{ trans('Vendor\'s name') }}</th>
                                    <th is='sortable' :column="'email'">{{ trans('Vendor\'s email') }}</th>
                                    <th is='sortable' :column="'name'">{{ trans('Service Name') }}</th>
                                    <th is='sortable' :column="'name'">
                                        {{ trans('admin.service.columns.category_name') }}</th>
                                    <th is='sortable' :column="'description'">
                                        {{ trans('admin.vendor-requested-service.columns.description') }}</th>
                                    <th is='sortable' :column="'price'">
                                        {{ trans('admin.vendor-requested-service.columns.price') }}</th>
                                    <th is='sortable' :column="'approx_time'">
                                        {{ trans('admin.vendor-requested-service.columns.approx_time') }}</th>
                                    <th is='sortable' :column="'approx_time'">
                                        {{ trans('admin.vendor-requested-service.columns.spare_parts') }}</th>
                                    <th is='sortable' :column="'approx_time'">{{ trans('Include') }}</th>

                                    <th></th>
                                </tr>
                                <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                    <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                        <span
                                            class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }}
                                            @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary"
                                                @click="onBulkItemsClickedAll('/admin/vendor-requested-services')"
                                                v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa"
                                                    :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i>
                                                {{ trans('brackets/admin-ui::admin.listing.check_all_items') }}
                                                @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                href="#" class="text-primary"
                                                @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>
                                        </span>

                                        <span class="pull-right pr-2">
                                            <button class="btn btn-sm btn-danger pr-3 pl-3"
                                                @click="bulkDelete('/admin/vendor-requested-services/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                        </span>

                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in collection" :key="item.id"
                                    :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                    <td class="bulk-checkbox">
                                        <input class="form-check-input" :id="'enabled' + item.id" type="checkbox"
                                            v-model="bulkItems[item.id]" v-validate="''"
                                            :data-vv-name="'enabled' + item.id"
                                            :name="'enabled' + item.id + '_fake_element'"
                                            @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                        <label class="form-check-label" :for="'enabled' + item.id"></label>
                                    </td>
                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.user[0]?.first_name}}</td>
                                    <td>@{{ item.user[0]?.email}}</td>
                                    <td>@{{ item.name }}</td>
                                    <td>@{{ item.service_category?.name }}</td>
                                    <td>@{{ item.description }}</td>
                                    <td>@{{ item.price }}</td>
                                    <td>@{{ item.approx_time | time }}</td>
                                    <td>@{{ item.spare_parts}}</td>
                                    <td><span v-for="include in item.vendor_requested_service_inclusion"
                                            :key="include.name">@{{ include.name}},</span>..</td>

                                    <td>
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-info" title="{{ trans('Approve') }}"
                                                    data-toggle="modal" data-target="#approveModal" :for="item.id"
                                                    :id="item.user_id" onclick="approveService(this)" role="button"><i
                                                        class="fa fa-check"></i></a>
                                            </div>
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-info" title="{{ trans('Disapprove') }}"
                                                    data-toggle="modal" data-target="#disapproveModal" :for="item.id"
                                                    :id="item.user_id" onclick="disapproveService(this)"
                                                    role="button"><i class="fa fa-window-close    "></i></a>
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
                            <a class="btn btn-primary btn-spinner"
                                href="{{ url('admin/vendor-requested-services/create') }}" role="button"><i
                                    class="fa fa-plus"></i>&nbsp;
                                {{ trans('admin.vendor-requested-service.actions.create') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</vendor-requested-service-listing>

<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Do you really want to approve this service ?
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>
                <form method="get" action="{{url('/admin/vendor-requested-services/approve')}}">
                    <input type="hidden" name="service_id" id="serviceId">
                    <input type="hidden" name="s_user_id" id="sUserId">
                    {{ csrf_field() }}
                    </span></span>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Yes, Approve">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="disapproveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>

                <form method="get" name="reason_form" onsubmit="return validateDisapproveForm()"
                    action="{{url('/admin/vendor-requested-services/disapprove')}}">
                    <input type="hidden" name="service_id" id="dis_serviceId">
                    <input type="hidden" name="disapprove_user_id" id="disapproveUserId">
                    {{ csrf_field() }}
                    </span> please mention reason for disapprove?</span>
                    <input type="text" name="reason">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Disapprove">
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
