<div class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-document.columns.user_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.user_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('user_id'), 'form-control-success': fields.user_id && fields.user_id.valid}" id="user_id" name="user_id" placeholder="{{ trans('admin.user-document.columns.user_id') }}">
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('document_name'), 'has-success': fields.document_name && fields.document_name.valid }">
    <label for="document_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-document.columns.document_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.document_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('document_name'), 'form-control-success': fields.document_name && fields.document_name.valid}" id="document_name" name="document_name" placeholder="{{ trans('admin.user-document.columns.document_name') }}">
        <div v-if="errors.has('document_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('document_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('document_number'), 'has-success': fields.document_number && fields.document_number.valid }">
    <label for="document_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-document.columns.document_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.document_number" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('document_number'), 'form-control-success': fields.document_number && fields.document_number.valid}" id="document_number" name="document_number" placeholder="{{ trans('admin.user-document.columns.document_number') }}">
        <div v-if="errors.has('document_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('document_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('front_image'), 'has-success': fields.front_image && fields.front_image.valid }">
    <label for="front_image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-document.columns.front_image') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.front_image" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('front_image'), 'form-control-success': fields.front_image && fields.front_image.valid}" id="front_image" name="front_image" placeholder="{{ trans('admin.user-document.columns.front_image') }}">
        <div v-if="errors.has('front_image')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('front_image') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('back_image'), 'has-success': fields.back_image && fields.back_image.valid }">
    <label for="back_image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-document.columns.back_image') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.back_image" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('back_image'), 'form-control-success': fields.back_image && fields.back_image.valid}" id="back_image" name="back_image" placeholder="{{ trans('admin.user-document.columns.back_image') }}">
        <div v-if="errors.has('back_image')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('back_image') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('document_type'), 'has-success': fields.document_type && fields.document_type.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="document_type" type="checkbox" v-model="form.document_type" v-validate="''" data-vv-name="document_type"  name="document_type_fake_element">
        <label class="form-check-label" for="document_type">
            {{ trans('admin.user-document.columns.document_type') }}
        </label>
        <input type="hidden" name="document_type" :value="form.document_type">
        <div v-if="errors.has('document_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('document_type') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('document_status'), 'has-success': fields.document_status && fields.document_status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="document_status" type="checkbox" v-model="form.document_status" v-validate="''" data-vv-name="document_status"  name="document_status_fake_element">
        <label class="form-check-label" for="document_status">
            {{ trans('admin.user-document.columns.document_status') }}
        </label>
        <input type="hidden" name="document_status" :value="form.document_status">
        <div v-if="errors.has('document_status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('document_status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
    <label for="message" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-document.columns.message') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.message" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}" id="message" name="message" placeholder="{{ trans('admin.user-document.columns.message') }}">
        <div v-if="errors.has('message')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('message') }}</div>
    </div>
</div>


