<div class="form-group row align-items-center" :class="{'has-danger': errors.has('customer_delivery_charge'), 'has-success': fields.customer_delivery_charge && fields.customer_delivery_charge.valid }">
    <label for="customer_delivery_charge" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.delivery-charge.columns.customer_delivery_charge') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.customer_delivery_charge" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('customer_delivery_charge'), 'form-control-success': fields.customer_delivery_charge && fields.customer_delivery_charge.valid}" id="customer_delivery_charge" name="customer_delivery_charge" placeholder="{{ trans('admin.delivery-charge.columns.customer_delivery_charge') }}">
        <div v-if="errors.has('customer_delivery_charge')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('customer_delivery_charge') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('vendor_delivery_charge'), 'has-success': fields.vendor_delivery_charge && fields.vendor_delivery_charge.valid }">
    <label for="vendor_delivery_charge" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.delivery-charge.columns.vendor_delivery_charge') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.vendor_delivery_charge" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('vendor_delivery_charge'), 'form-control-success': fields.vendor_delivery_charge && fields.vendor_delivery_charge.valid}" id="vendor_delivery_charge" name="vendor_delivery_charge" placeholder="{{ trans('admin.delivery-charge.columns.vendor_delivery_charge') }}">
        <div v-if="errors.has('vendor_delivery_charge')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('vendor_delivery_charge') }}</div>
    </div>
</div>


