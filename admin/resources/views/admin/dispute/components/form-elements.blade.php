<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('booking_id'), 'has-success': fields.booking_id && fields.booking_id.valid }">
    <label for="booking_id" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.dispute.columns.booking_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.booking_id" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('booking_id'), 'form-control-success': fields.booking_id && fields.booking_id.valid}"
            id="booking_id" name="booking_id" placeholder="{{ trans('admin.dispute.columns.booking_id') }}" readonly>
        <div v-if="errors.has('booking_id')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('booking_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('booking_id'), 'has-success': fields.booking_id && fields.booking_id.valid }">
    <label for="booking_id" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Ticket ID</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.ticket_id" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('booking_id'), 'form-control-success': fields.booking_id && fields.booking_id.valid}"
            id="booking_id" name="booking_id" placeholder="Ticket Id" readonly>
        <div v-if="errors.has('booking_id')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('booking_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.dispute.columns.user_name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" :value="form.user.first_name + form.user.last_name" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}"
            id="user_id" name="user_id" placeholder="{{ trans('admin.dispute.columns.user_name') }}" readonly>
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
    <label for="message" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.dispute.columns.message') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.message" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
            id="message" name="message" placeholder="{{ trans('admin.dispute.columns.message') }}" readonly>
        <div v-if="errors.has('message')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('message') }}
        </div>
    </div>
</div>

<template v-if="form.responsed_message">
    <div class="form-group row align-items-center"
        :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
        <label for="message" class="col-form-label text-md-right"
            :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Admin Message</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" :value="form.responsed_message" class="form-control"
                :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                id="message" readonly>
        </div>
    </div>

    <div class="form-group row align-items-center"
        :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
        <label for="message" class="col-form-label text-md-right"
            :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Admin Responded at</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" :value="form.responsed_at" class="form-control"
                :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                id="message" readonly>
        </div>
    </div>

</template>


<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
    <label for="message" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.dispute.columns.is_resolved') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <span class="btn btn-success btn-sm" v-if='form.is_resolved == 1'>Yes</span>
        <span v-else class="btn btn-danger btn-sm">No</span>
        <div v-if="errors.has('is_resolved')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('is_resolved') }}</div>
    </div>
</div>


{{-- Booking details card --}}
<div class="card">
    <div class="card-header">
        <i class="fa fa-info-circle"></i>
        Booking Details
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"> Booking ID</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" v-model="form.booking.id" class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"> Booking Start Date</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" v-model="form.booking.booking_start_time" class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"> Booking End Date</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" v-model="form.booking.booking_end_time" class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"> Created At</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" v-model="form.booking.created_at" class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
    </div>
    {{-- card body end --}}
</div>

{{-- Booking details card --}}
<div class="card">
    <div class="card-header">
        <i class="fa fa-info-circle"></i>
        Customer Details
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Customer name</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text"
                    :value="form.booking.customer_details.first_name + form.booking.customer_details.last_name"
                    class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Customer Email</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" :value="form.booking.customer_details.email" class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
    </div>
    {{-- card body end --}}
</div>
<div class="card">
    <div class="card-header">
        <i class="fa fa-info-circle"></i>
        Vendor Details
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Vendor name</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text"
                    :value="form.booking.booking_vendor.first_name + form.booking.booking_vendor.last_name"
                    class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="booking_date" class="col-form-label text-md-right"
                :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Vendor Email</label>
            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                <input type="text" :value="form.booking.booking_vendor.email" class="form-control"
                    :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
                    id="message" readonly>
            </div>
        </div>
    </div>
    {{-- card body end --}}
</div>
