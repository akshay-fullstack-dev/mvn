<div class="form-group row align-items-center" :class="{'has-danger': errors.has('package_id'), 'has-success': fields.package_id && fields.package_id.valid }">
    <label for="package_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package-maintain.columns.package_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.package_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('package_id'), 'form-control-success': fields.package_id && fields.package_id.valid}" id="package_id" name="package_id" placeholder="{{ trans('admin.package-maintain.columns.package_id') }}">
        <div v-if="errors.has('package_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('package_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package-maintain.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.package-maintain.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('order_id'), 'has-success': fields.order_id && fields.order_id.valid }">
    <label for="order_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package-maintain.columns.order_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.order_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('order_id'), 'form-control-success': fields.order_id && fields.order_id.valid}" id="order_id" name="order_id" placeholder="{{ trans('admin.package-maintain.columns.order_id') }}">
        <div v-if="errors.has('order_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('order_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('transaction_id'), 'has-success': fields.transaction_id && fields.transaction_id.valid }">
    <label for="transaction_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package-maintain.columns.transaction_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.transaction_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('transaction_id'), 'form-control-success': fields.transaction_id && fields.transaction_id.valid}" id="transaction_id" name="transaction_id" placeholder="{{ trans('admin.package-maintain.columns.transaction_id') }}">
        <div v-if="errors.has('transaction_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('transaction_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('amount'), 'has-success': fields.amount && fields.amount.valid }">
    <label for="amount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package-maintain.columns.amount') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.amount" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('amount'), 'form-control-success': fields.amount && fields.amount.valid}" id="amount" name="amount" placeholder="{{ trans('admin.package-maintain.columns.amount') }}">
        <div v-if="errors.has('amount')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('amount') }}</div>
    </div>
</div>


