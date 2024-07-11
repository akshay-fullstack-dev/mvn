<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('shop_name'), 'has-success': fields.shop_name && fields.shop_name.valid }">
    <label for="shop_name" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.shop_name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.shop_name" v-validate="'required'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('shop_name'), 'form-control-success': fields.shop_name && fields.shop_name.valid}"
            id="shop_name" name="shop_name"
            placeholder="{{ trans('admin.spare-parts-shop-location.columns.shop_name') }}">
        <div v-if="errors.has('shop_name')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('shop_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('additional_shop_information'), 'has-success': fields.additional_shop_information && fields.additional_shop_information.valid }">
    <label for="additional_shop_information" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.additional_shop_information') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.additional_shop_information" v-validate="'required'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('additional_shop_information'), 'form-control-success': fields.additional_shop_information && fields.additional_shop_information.valid}"
            id="additional_shop_information" name="additional_shop_information"
            placeholder="{{ trans('admin.spare-parts-shop-location.columns.additional_shop_information') }}">
        <div v-if="errors.has('additional_shop_information')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('additional_shop_information') }}</div>
    </div>
</div>



<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('formatted_address'), 'has-success': fields.formatted_address && fields.formatted_address.valid }">
    <label for="formatted_address" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.formatted_address') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.formatted_address" @keyup="addAddress()" v-validate="''"
            @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('formatted_address'), 'form-control-success': fields.formatted_address && fields.formatted_address.valid}"
            id="formatted_address" name="formatted_address"
            placeholder="{{ trans('admin.spare-parts-shop-location.columns.formatted_address') }}">
        <div v-if="errors.has('formatted_address')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('formatted_address') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('city'), 'has-success': fields.city && fields.city.valid }">
    <label for="city" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.city') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city" v-validate="''" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('city'), 'form-control-success': fields.city && fields.city.valid}"
            id="city" name="city" placeholder="{{ trans('admin.spare-parts-shop-location.columns.city') }}">
        <div v-if="errors.has('city')" class="form-control-feedback form-text" v-cloak>@{{ errors . first('city') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('country'), 'has-success': fields.country && fields.country.valid }">
    <label for="country" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.country') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.country" v-validate="''" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('country'), 'form-control-success': fields.country && fields.country.valid}"
            id="country" name="country" placeholder="{{ trans('admin.spare-parts-shop-location.columns.country') }}">
        <div v-if="errors.has('country')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('country') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('postal_code'), 'has-success': fields.postal_code && fields.postal_code.valid }">
    <label for="postal_code" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.postal_code') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.postal_code" v-validate="''" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('postal_code'), 'form-control-success': fields.postal_code && fields.postal_code.valid}"
            id="postal_code" name="postal_code"
            placeholder="{{ trans('admin.spare-parts-shop-location.columns.postal_code') }}">
        <div v-if="errors.has('postal_code')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('postal_code') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('lat'), 'has-success': fields.lat && fields.lat.valid }">
    <label for="lat" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.lat') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lat" v-validate="'decimal'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('lat'), 'form-control-success': fields.lat && fields.lat.valid}"
            id="lat" name="lat" placeholder="{{ trans('admin.spare-parts-shop-location.columns.lat') }}" readonly>
        <div v-if="errors.has('lat')" class="form-control-feedback form-text" v-cloak>@{{ errors . first('lat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('long'), 'has-success': fields.long && fields.long.valid }">
    <label for="long" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.spare-parts-shop-location.columns.long') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.long" v-validate="'decimal'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('long'), 'form-control-success': fields.long && fields.long.valid}"
            id="long" name="long" placeholder="{{ trans('admin.spare-parts-shop-location.columns.long') }}" readonly>
        <div v-if="errors.has('long')" class="form-control-feedback form-text" v-cloak>@{{ errors . first('long') }}
        </div>
    </div>
</div>
