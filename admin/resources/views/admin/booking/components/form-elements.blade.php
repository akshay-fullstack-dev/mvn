<div class="form-group row align-items-center" :class="{'has-danger': errors.has('order_id'), 'has-success': fields.order_id && fields.order_id.valid }">
    <label for="order_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.order_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.order_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('order_id'), 'form-control-success': fields.order_id && fields.order_id.valid}" id="order_id" name="order_id" placeholder="{{ trans('admin.booking.columns.order_id') }}">
        <div v-if="errors.has('order_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('order_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.booking.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('vendor_id'), 'has-success': fields.vendor_id && fields.vendor_id.valid }">
    <label for="vendor_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.vendor_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.vendor_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('vendor_id'), 'form-control-success': fields.vendor_id && fields.vendor_id.valid}" id="vendor_id" name="vendor_id" placeholder="{{ trans('admin.booking.columns.vendor_id') }}">
        <div v-if="errors.has('vendor_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('vendor_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('service_id'), 'has-success': fields.service_id && fields.service_id.valid }">
    <label for="service_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.service_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.service_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('service_id'), 'form-control-success': fields.service_id && fields.service_id.valid}" id="service_id" name="service_id" placeholder="{{ trans('admin.booking.columns.service_id') }}">
        <div v-if="errors.has('service_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('service_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('address_id'), 'has-success': fields.address_id && fields.address_id.valid }">
    <label for="address_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.address_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.address_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('address_id'), 'form-control-success': fields.address_id && fields.address_id.valid}" id="address_id" name="address_id" placeholder="{{ trans('admin.booking.columns.address_id') }}">
        <div v-if="errors.has('address_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('payment_id'), 'has-success': fields.payment_id && fields.payment_id.valid }">
    <label for="payment_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.payment_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.payment_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('payment_id'), 'form-control-success': fields.payment_id && fields.payment_id.valid}" id="payment_id" name="payment_id" placeholder="{{ trans('admin.booking.columns.payment_id') }}">
        <div v-if="errors.has('payment_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('payment_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('package_id'), 'has-success': fields.package_id && fields.package_id.valid }">
    <label for="package_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.package_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.package_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('package_id'), 'form-control-success': fields.package_id && fields.package_id.valid}" id="package_id" name="package_id" placeholder="{{ trans('admin.booking.columns.package_id') }}">
        <div v-if="errors.has('package_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('package_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('vehicle_id'), 'has-success': fields.vehicle_id && fields.vehicle_id.valid }">
    <label for="vehicle_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.vehicle_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.vehicle_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('vehicle_id'), 'form-control-success': fields.vehicle_id && fields.vehicle_id.valid}" id="vehicle_id" name="vehicle_id" placeholder="{{ trans('admin.booking.columns.vehicle_id') }}">
        <div v-if="errors.has('vehicle_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('vehicle_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('booking_start_time'), 'has-success': fields.booking_start_time && fields.booking_start_time.valid }">
    <label for="booking_start_time" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.booking_start_time') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.booking_start_time" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('booking_start_time'), 'form-control-success': fields.booking_start_time && fields.booking_start_time.valid}" id="booking_start_time" name="booking_start_time" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('booking_start_time')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_start_time') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('booking_end_time'), 'has-success': fields.booking_end_time && fields.booking_end_time.valid }">
    <label for="booking_end_time" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.booking_end_time') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.booking_end_time" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('booking_end_time'), 'form-control-success': fields.booking_end_time && fields.booking_end_time.valid}" id="booking_end_time" name="booking_end_time" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('booking_end_time')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_end_time') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('booking_status'), 'has-success': fields.booking_status && fields.booking_status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="booking_status" type="checkbox" v-model="form.booking_status" v-validate="''" data-vv-name="booking_status"  name="booking_status_fake_element">
        <label class="form-check-label" for="booking_status">
            {{ trans('admin.booking.columns.booking_status') }}
        </label>
        <input type="hidden" name="booking_status" :value="form.booking_status">
        <div v-if="errors.has('booking_status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_status') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('booking_type'), 'has-success': fields.booking_type && fields.booking_type.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="booking_type" type="checkbox" v-model="form.booking_type" v-validate="''" data-vv-name="booking_type"  name="booking_type_fake_element">
        <label class="form-check-label" for="booking_type">
            {{ trans('admin.booking.columns.booking_type') }}
        </label>
        <input type="hidden" name="booking_type" :value="form.booking_type">
        <div v-if="errors.has('booking_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('booking_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('addition_info'), 'has-success': fields.addition_info && fields.addition_info.valid }">
    <label for="addition_info" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.booking.columns.addition_info') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.addition_info" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('addition_info'), 'form-control-success': fields.addition_info && fields.addition_info.valid}" id="addition_info" name="addition_info" placeholder="{{ trans('admin.booking.columns.addition_info') }}">
        <div v-if="errors.has('addition_info')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('addition_info') }}</div>
    </div>
</div>


