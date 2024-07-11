@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.dispute.actions.index'))

@section('body')

<dispute-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/disputes') }}'" inline-template>

    <div class="row">
        <div class="col">
            <div class="card">
                {{-- <div class="card-header">
                    <i class="fa fa-align-justify"></i> {{ trans('admin.dispute.actions.index') }}
                <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/disputes/create') }}"
                    role="button"><i class="fa fa-plus"></i>&nbsp;
                    {{ trans('admin.dispute.actions.create') }}</a>
            </div> --}}
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
                                    <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll"
                                        v-validate="''" data-vv-name="enabled" name="enabled_fake_element"
                                        @click="onBulkItemsClickedAllWithPagination()">
                                    <label class="form-check-label" for="enabled">
                                        #
                                    </label>
                                </th>

                                <th is='sortable' :column="'ticket_id'">Ticket ID</th>
                                <th is='sortable' :column="'booking_id'">
                                    {{ trans('admin.dispute.columns.booking_id') }}</th>
                                <th is='sortable' :column="'user_id'">{{ trans('admin.dispute.columns.user_id') }}
                                </th>
                                <th is='sortable' :column="'message'">{{ trans('admin.dispute.columns.message') }}
                                </th>
                                <th is='sortable' :column="'is_resolved'">
                                    {{ trans('admin.dispute.columns.is_resolved') }}</th>

                                <th></th>
                            </tr>
                            <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                <td class="bg-bulk-info d-table-cell text-center" colspan="7">
                                    <span
                                        class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }}
                                        @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary"
                                            @click="onBulkItemsClickedAll('/admin/disputes')"
                                            v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa"
                                                :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i>
                                            {{ trans('brackets/admin-ui::admin.listing.check_all_items') }}
                                            @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                            href="#" class="text-primary"
                                            @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>
                                    </span>

                                    <span class="pull-right pr-2">
                                        <button class="btn btn-sm btn-danger pr-3 pl-3"
                                            @click="bulkDelete('/admin/disputes/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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
                                        :name="'enabled' + item.id + '_fake_element'"
                                        @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                    <label class="form-check-label" :for="'enabled' + item.id">
                                    </label>
                                </td>
                                <td>@{{ item.ticket_id }}</td>
                                <td><a :href="item.booking_resource_url"
                                        title="Click here to see booking details">@{{ item.booking_id }}</a>
                                </td>
                                <td><a :href="item.user_resource_url"
                                        title="Click here to see user details">@{{ item.user_id }}</a>
                                </td>
                                <td>@{{ item.message }}</td>
                                <td>
                                    <a @click="addDisputeIdInForm(0,item.id)" data-toggle="modal"
                                        data-target="#exampleModal" v-if='item.is_resolved == 1'>
                                        <span class="btn btn-success btn-sm">Yes</span>
                                    </a>
                                    <a v-else data-toggle="modal" data-target="#exampleModal"
                                        @click="addDisputeIdInForm(1,item.id)">
                                        <span class="btn btn-danger btn-sm">No</span>
                                    </a>
                                </td>
                                <td>
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-spinner btn-info"
                                                :href="item.resource_url + '/edit'"
                                                title="{{ trans('brackets/admin-ui::admin.btn.edit') }}"
                                                role="button"><i class="fa fa-eye"></i></a>
                                        </div>
                                        <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i
                                                    class="fa fa-trash-o"></i></button>
                                        </form>
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
                        <a class="btn btn-primary btn-spinner" href="{{ url('admin/disputes/create') }}"
                            role="button"><i class="fa fa-plus"></i>&nbsp;
                            {{ trans('admin.dispute.actions.create') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</dispute-listing>
{{-- ------------------Model -------------------------- --}}
<!-- Modal -->
<div class="modal fade modal-custom" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p id="confirm_text">Change status message</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetForm()">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div>
                    <form method="get" name="reason_form" id="form" onsubmit="return validateReasonForm()"
                        action="{{ url('admin/disputes/change-resolve-status') }}">
                        <div class="modal-iiner-content">
                            <input type="hidden" name="despute_id" id="desputeId">
                            <input type="hidden" name="status" id="despute_status">
                            </span>Please enter the message for the user.</span>
                            <textarea type="text" name="message" id="myMessage" cols="40"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                onclick="resetForm()">Cancel</button>
                            <input type="submit" class="btn btn-primary" value="Change Status" id="change-status">
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection

@section('bottom-scripts')
<script src="{{ url('js/popup.js') }}" type="text/javascript">
</script>

@endsection
