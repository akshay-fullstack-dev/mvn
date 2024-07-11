<div class="form-group row align-items-center" :class="{'has-danger': errors.has('first_name'), 'has-success': fields.first_name && fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.first_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.first_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': fields.first_name && fields.first_name.valid}" id="first_name" name="first_name" placeholder="{{ trans('admin.user.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('first_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('last_name'), 'has-success': fields.last_name && fields.last_name.valid }">
    <label for="last_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.last_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.last_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('last_name'), 'form-control-success': fields.last_name && fields.last_name.valid}" id="last_name" name="last_name" placeholder="{{ trans('admin.user.columns.last_name') }}">
        <div v-if="errors.has('last_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('last_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.email') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.email" v-validate="'required|email'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.user.columns.email') }}">
        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
    </div>
</div>

<!-- <div class="form-group row align-items-center" :class="{'has-danger': errors.has('email_verified_at'), 'has-success': fields.email_verified_at && fields.email_verified_at.valid }">
    <label for="email_verified_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.email_verified_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.email_verified_at" :config="datetimePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('email_verified_at'), 'form-control-success': fields.email_verified_at && fields.email_verified_at.valid}" id="email_verified_at" name="email_verified_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('email_verified_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email_verified_at') }}</div>
    </div>
</div> -->

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone_number'), 'has-success': fields.phone_number && fields.phone_number.valid }">
    <label for="phone_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.phone_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone_number'), 'form-control-success': fields.phone_number && fields.phone_number.valid}" id="phone_number" name="phone_number" placeholder="{{ trans('admin.user.columns.phone_number') }}">
        <div v-if="errors.has('phone_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('country_iso_code'), 'has-success': fields.country_iso_code && fields.country_iso_code.valid }">
    <label for="country_iso_code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.country_iso_code') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.country_iso_code" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('country_iso_code'), 'form-control-success': fields.country_iso_code && fields.country_iso_code.valid}" id="country_iso_code" name="country_iso_code" placeholder="{{ trans('admin.user.columns.country_iso_code') }}">
        <div v-if="errors.has('country_iso_code')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('country_iso_code') }}</div>
    </div>
</div>

<!-- <div class="form-check row" :class="{'has-danger': errors.has('is_blocked'), 'has-success': fields.is_blocked && fields.is_blocked.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="is_blocked" type="checkbox" v-model="form.is_blocked" v-validate="''" data-vv-name="is_blocked"  name="is_blocked_fake_element">
        <label class="form-check-label" for="is_blocked">
            {{ trans('admin.user.columns.is_blocked') }}
        </label>
        <input type="hidden" name="is_blocked" :value="form.is_blocked">
        <div v-if="errors.has('is_blocked')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('is_blocked') }}</div>
    </div>
</div> -->
<!-- 
<div class="form-check row" :class="{'has-danger': errors.has('account_status'), 'has-success': fields.account_status && fields.account_status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="account_status" type="checkbox" v-model="form.account_status" v-validate="''" data-vv-name="account_status"  name="account_status_fake_element">
        <label class="form-check-label" for="account_status">
            {{ trans('admin.user.columns.account_status') }}
        </label>
        <input type="hidden" name="account_status" :value="form.account_status">
        <div v-if="errors.has('account_status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('account_status') }}</div>
    </div>
</div> -->

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('country_code'), 'has-success': fields.country_code && fields.country_code.valid }">
    <label for="country_code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.country_code') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.country_code" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('country_code'), 'form-control-success': fields.country_code && fields.country_code.valid}" id="country_code" name="country_code" placeholder="{{ trans('admin.user.columns.country_code') }}">
        <div v-if="errors.has('country_code')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('country_code') }}</div>
    </div>
</div>




<label class="col-form-label text-md-right border" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Address') }}</label> 


<div class="form-group  align-items-center" v-for="(input,k) in inputs" :key="k">
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type[k]'), 'has-success': form.type[k] && form.type[k].valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select name="type[k]" v-model="form.type[k]"  v-validate="'required'" @input="validate($event)" id="type[k]" class="form-control" :class="{'form-control-danger': errors.has('type[k]'), 'form-control-success': form.type[k] && form.type[k].valid}">
        <option value="0">Home</option>
        <option value="1">Office</option>
        <option value="2">Other</option>
        </select>
        <div v-if="errors.has('type[k]')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type[k]') }}</div>
    </div>
</div>
 
    

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city[k]'), 'has-success': form.city[k] && form.city[k].valid }">
<label for="city[k]" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('City') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
<input type="text" v-model="form.city[k]" v-validate="'required'" @input="validate($event)" class="form-control" 
:class="{'form-control-danger': errors.has('city[k]'), 'form-control-success': form.city[k] && form.city[k].valid}" id="city[k]" name="city[k]" placeholder="{{ trans('City') }}">
<div v-if="errors.has('city[k]')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city[k]') }}</div>
</div>
</div>

    <!-- <label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('City') }}</label>
    <input name="city[k]" v-model="form.city[k]" id="city[k]" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('country[k]'), 'has-success': form.country[k] && form.country[k].valid }">
<label for="country[k]" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Country') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
<input type="text" v-model="form.country[k]" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('country[k]'), 'form-control-success': form.country[k] && form.country[k].valid}" id="country[k]" name="country[k]" placeholder="{{ trans('Country') }}">
<div v-if="errors.has('country[k]')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('country[k]') }}</div>
</div>
</div>

    <!-- <label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Country') }}</label>
    <input name="country[k]" v-model="form.country[k]"  id="country[k]" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('formatted_address[k]'), 'has-success': input.formatted_address[k] && input.formatted_address[k].valid }">
<label for="formatted_address[k]" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Formatted Address') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
<input type="text" name="formatted_address[k]" :v-model="input.formatted_address['+k+']" :id="'formatted_address['+k+']'" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('formatted_address[k]'), 'form-control-success': input.formatted_address[k] && input.formatted_address[k].valid}" placeholder="{{ trans('Formatted address') }}">
<div v-if="errors.has('formatted_address[k]')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('formatted_address[k]') }}</div>
</div>
</div>

    <!-- <label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Formatted Address') }}</label>
    <input name="formatted_address[k]" :v-model="input.formatted_address['+k+']" class="formatted_address" :id="'formatted_address['+k+']'" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('additional_info[k]'), 'has-success': form.additional_info[k] && form.additional_info[k].valid }">
<label for="additional_info[k]" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Additional_info') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
<input type="text" name="additional_info[k]" v-model="form.additional_info[k]" id="additional_info[k]" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('additional_info[k]'), 'form-control-success': form.additional_info[k] && form.additional_info[k].valid}"  placeholder="{{ trans('Additional info') }}">
<div v-if="errors.has('additional_info[k]')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('additional_info[k]') }}</div>
</div>
</div>
<!-- 
    <label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Additional Info') }}</label>
    <input name="additional_info[k]" v-model="form.additional_info[k]" id="additional_info[k]" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div class="form-group row align-items-center">
<label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Latitude') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
<input type="text" name="latitude[k]" :v-model="input.latitude['+k+']" :id="'latitude['+k+']'" v-validate="'required'" class="form-control" placeholder="{{ trans('Latitude') }}">
</div>
</div>

    <!-- <label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Latitude') }}</label>
    <input name="latitude[k]" :v-model="input.latitude['+k+']" :id="'latitude['+k+']'" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div class="form-group row align-items-center" >
<label  class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('longitude') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
<input type="text" name="longitude[k]" :v-model="input.longitude['+k+']" :id="'longitude['+k+']'" v-validate="'required'" class="form-control" placeholder="{{ trans('Longitude') }}">
</div>
    <i class="fa fa-minus-circle" @click="remove(k)" v-show="k || ( !k && inputs.length > 1)"></i><p> </p>
    <i class="fa fa-plus-circle" @click="add(k)" v-show="k == inputs.length-1 && inputs.length < 3"></i>
</div>

    <!-- <label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Longitude') }}</label>
    <input name="longitude[k]" :v-model="input.longitude['+k+']" :id="'longitude['+k+']'" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->
    
    

</div>

<!-- <div class="form-group row align-items-center">
    <label for="country_code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.country_code') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.admin_user" v-validate="'required'" @input="validate($event)" class="form-control"  id="admin_user" name="admin_user" placeholder="{{ trans('admin.user.columns.country_code') }}">

    </div>
</div> -->

<label class="col-form-label text-md-right border" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Driving licence') }}</label>
<div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('docNumber'), 'has-success': fields.docNumber && fields.docNumber.valid }">
    <label for="docNumber" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Document number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.docNumber" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('docNumber'), 'form-control-success': fields.docNumber && fields.docNumber.valid}" id="docNumber" name="docNumber" placeholder="{{ trans('Document Number') }}">
        <div v-if="errors.has('docNumber')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('docNumber') }}</div>
    </div>
</div>


<!-- <label class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Document Number') }}</label>
<input name="doctype1" v-model="form.doctype1" id="doctype1" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="m-auto" >
@include('brackets/admin-ui::admin.includes.media-uploader', [
'mediaCollection' => app(App\Models\User::class)->getMediaCollection('licence'),
'label' => 'Photos'
])
    <!-- <input type="text" class="form-control" v-model="form.doc[k]" name="doc[k]"> -->
   
</div>
</div>

<div>
<label class="col-form-label text-md-right border" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Education certificate') }}</label>
<!-- <input name="doctype2" v-model="form.doctype2" id="doctype2" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="m-auto" >
@include('brackets/admin-ui::admin.includes.media-uploader', [
'mediaCollection' => app(App\Models\User::class)->getMediaCollection('education'),
'label' => 'Photos'
])
    <!-- <input type="text" class="form-control" v-model="form.doc[k]" name="doc[k]"> -->
   
</div>
</div>

<div>
<label class="col-form-label text-md-right border" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Other certificate  ') }}</label>
<!-- <input name="doctype3" v-model="form.doctype3" id="doctype3" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" value=""> -->

<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="m-auto" >
@include('brackets/admin-ui::admin.includes.media-uploader', [
'mediaCollection' => app(App\Models\User::class)->getMediaCollection('other'),
'label' => 'Photos'
])
    <!-- <input type="text" class="form-control" v-model="form.doc[k]" name="doc[k]"> -->
   
</div>
</div>