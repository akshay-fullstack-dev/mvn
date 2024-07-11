<div class="form-group row align-items-center" :class="{'has-danger': errors.has('coupon_name'), 'has-success': fields.coupon_name && fields.coupon_name.valid }">
  <label for="coupon_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.coupon_name') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.coupon_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('coupon_name'), 'form-control-success': fields.coupon_name && fields.coupon_name.valid}" id="coupon_name" name="coupon_name" placeholder="{{ trans('admin.coupon.columns.coupon_name') }}">
    <div v-if="errors.has('coupon_name')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('coupon_name') }}</div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('coupon_code'), 'has-success': fields.coupon_code && fields.coupon_code.valid }">
  <label for="coupon_code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.coupon_code') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.coupon_code" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('coupon_code'), 'form-control-success': fields.coupon_code && fields.coupon_code.valid}" id="coupon_code" name="coupon_code" placeholder="{{ trans('admin.coupon.columns.coupon_code') }}" readonly>
    <div v-if="errors.has('coupon_code')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('coupon_code') }}</div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('coupon_description'), 'has-success': fields.coupon_description && fields.coupon_description.valid }">
  <label for="coupon_description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.coupon_description') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.coupon_description" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('coupon_description'), 'form-control-success': fields.coupon_description && fields.coupon_description.valid}" id="coupon_description" name="coupon_description" placeholder="{{ trans('admin.coupon.columns.coupon_description') }}">
    <div v-if="errors.has('coupon_description')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('coupon_description') }}</div>
  </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('coupon_type'), 'has-success': fields.coupon_type && fields.coupon_type.valid }">

  {{-- <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
    <input class="form-check-input" id="coupon_type" type="checkbox" v-model="form.coupon_type" v-validate="''" data-vv-name="coupon_type" name="coupon_type_fake_element">
    <label class="form-check-label" for="coupon_type">
      {{ trans('admin.coupon.columns.coupon_type') }}
  </label>
  <input type="hidden" name="coupon_type" :value="form.coupon_type">
  <div v-if="errors.has('coupon_type')" class="form-control-feedback form-text" v-cloak>
    @{{ errors.first('coupon_type') }}</div>
</div>
</div> --}}

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('coupon_type'), 'has-success': fields.coupon_type && fields.coupon_type.valid }">
  <label for="coupon_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.coupon_type') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <select v-model="form.coupon_type" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('coupon_type'), 'form-control-success': fields.coupon_type && fields.coupon_type.valid}" id="coupon_type" name="coupon_type">
      <option value="0">Percentage</option>
      <option value="1">Fixed</option>
    </select>
    <div v-if="errors.has('coupon_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('coupon_type') }}</div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('coupon_discount'), 'has-success': fields.coupon_discount && fields.coupon_discount.valid }">
  <label for="coupon_discount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.coupon_discount') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.coupon_discount" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('coupon_discount'), 'form-control-success': fields.coupon_discount && fields.coupon_discount.valid}" id="coupon_discount" name="coupon_discount" placeholder="{{ trans('admin.coupon.columns.coupon_discount') }}">
    <div v-if="errors.has('coupon_discount')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('coupon_discount') }}</div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('coupon_min_amount'), 'has-success': fields.coupon_min_amount && fields.coupon_min_amount.valid }">
  <label for="coupon_min_amount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.coupon_min_amount') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.coupon_min_amount" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('coupon_min_amount'), 'form-control-success': fields.coupon_min_amount && fields.coupon_min_amount.valid}" id="coupon_min_amount" name="coupon_min_amount" placeholder="{{ trans('admin.coupon.columns.coupon_min_amount') }}">
    <div v-if="errors.has('coupon_min_amount')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('coupon_min_amount') }}</div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('coupon_max_amount'), 'has-success': fields.coupon_max_amount && fields.coupon_max_amount.valid }">
  <label for="coupon_max_amount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.coupon_max_amount') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.coupon_max_amount" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('coupon_max_amount'), 'form-control-success': fields.coupon_max_amount && fields.coupon_max_amount.valid}" id="coupon_max_amount" name="coupon_max_amount" placeholder="{{ trans('admin.coupon.columns.coupon_max_amount') }}">
    <div v-if="errors.has('coupon_max_amount')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('coupon_max_amount') }}</div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('start_date'), 'has-success': fields.start_date && fields.start_date.valid }">
  <label for="start_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.start_date') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <div class="input-group input-group--custom">
      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
      <datetime v-model="form.start_date" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('start_date'), 'form-control-success': fields.start_date && fields.start_date.valid}" id="start_date" name="start_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
    </div>
    <div v-if="errors.has('start_date')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('start_date') }}</div>
  </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('end_date'), 'has-success': fields.end_date && fields.end_date.valid }">
  <label for="end_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.end_date') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <div class="input-group input-group--custom">
      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
      <datetime v-model="form.end_date" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('end_date'), 'form-control-success': fields.end_date && fields.end_date.valid}" id="end_date" name="end_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}">
      </datetime>
    </div>
    <div v-if="errors.has('end_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('end_date') }}
    </div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('maximum_per_customer_use'), 'has-success': fields.maximum_per_customer_use && fields.maximum_per_customer_use.valid }">
  <label for="maximum_per_customer_use" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.maximum_per_customer_use') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.maximum_per_customer_use" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('maximum_per_customer_use'), 'form-control-success': fields.maximum_per_customer_use && fields.maximum_per_customer_use.valid}" id="maximum_per_customer_use" name="maximum_per_customer_use" placeholder="{{ trans('admin.coupon.columns.maximum_per_customer_use') }}">
    <div v-if="errors.has('maximum_per_customer_use')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('maximum_per_customer_use') }}</div>
  </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('maximum_total_use'), 'has-success': fields.maximum_total_use && fields.maximum_total_use.valid }">
  <label for="maximum_total_use" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.maximum_total_use') }}</label>
  <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.maximum_total_use" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('maximum_total_use'), 'form-control-success': fields.maximum_total_use && fields.maximum_total_use.valid}" id="maximum_total_use" name="maximum_total_use" placeholder="{{ trans('admin.coupon.columns.maximum_total_use') }}">
    <div v-if="errors.has('maximum_total_use')" class="form-control-feedback form-text" v-cloak>
      @{{ errors.first('maximum_total_use') }}</div>
  </div>
</div>



{{-- <div class="form-group row align-items-center" :class="{'has-danger': errors.has('users_id'), 'has-success': fields.users_id && fields.users_id.valid }">
  <label for="users_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.coupon.columns.users_id') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
  <input type="text" v-model="form.users_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('users_id'), 'form-control-success': fields.users_id && fields.users_id.valid}" id="users_id" name="users_id" placeholder="{{ trans('admin.coupon.columns.users_id') }}">
  <div v-if="errors.has('users_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('users_id') }}
  </div>
</div>
</div> --}}
