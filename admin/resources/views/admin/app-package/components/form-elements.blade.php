<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bundle_id'), 'has-success': fields.bundle_id && fields.bundle_id.valid }">
    <label for="bundle_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-package.columns.bundle_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.bundle_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('bundle_id'), 'form-control-success': fields.bundle_id && fields.bundle_id.valid}" id="bundle_id" name="bundle_id" placeholder="{{ trans('admin.app-package.columns.bundle_id') }}">
        <div v-if="errors.has('bundle_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bundle_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('app_name'), 'has-success': fields.app_name && fields.app_name.valid }">
    <label for="app_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-package.columns.app_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.app_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('app_name'), 'form-control-success': fields.app_name && fields.app_name.valid}" id="app_name" name="app_name" placeholder="{{ trans('admin.app-package.columns.app_name') }}">
        <div v-if="errors.has('app_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('app_name') }}</div>
    </div>
</div>


