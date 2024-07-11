<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('app_packages'), 'has-success': fields.app_packages && fields.app_packages.valid }">
    <label for="app_packages" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-version.columns.app_package_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.app_packages" :name="app_packages" :options="{{ json_encode($app_packages) }}"
            placeholder="Select Package" label="bundle_id" track-by="id" id="app_packages" :multiple="false">
        </multiselect>
        <div v-if="errors.has('app_packages')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('app_packages') }}</div>
    </div>
</div>


<div class="form-check row"
    :class="{'has-danger': errors.has('force_update'), 'has-success': fields.force_update && fields.force_update.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="force_update" type="checkbox" v-model="form.force_update" v-validate="''"
            data-vv-name="force_update" name="force_update_fake_element">
        <label class="form-check-label " for="force_update">
            {{ trans('admin.app-version.columns.force_update') }}
        </label>
        <input type="hidden" name="force_update" :value="form.force_update">
        <div v-if="errors.has('force_update')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('force_update') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
    <label for="message" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-version.columns.message') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.message" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('message'), 'form-control-success': fields.message && fields.message.valid}"
            id="message" name="message" placeholder="{{ trans('admin.app-version.columns.message') }}">
        <div v-if="errors.has('message')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('message') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('version'), 'has-success': fields.version && fields.version.valid }">
    <label for="version" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-version.columns.version') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.version" v-validate="'required|decimal'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('version'), 'form-control-success': fields.version && fields.version.valid}"
            id="version" name="version" placeholder="{{ trans('admin.app-version.columns.version') }}">
        <div v-if="errors.has('version')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('version') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('code'), 'has-success': fields.code && fields.code.valid }">
    <label for="code" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-version.columns.code') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.code" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('code'), 'form-control-success': fields.code && fields.code.valid}"
            id="code" name="code" placeholder="{{ trans('admin.app-version.columns.code') }}">
        <div v-if="errors.has('code')" class="form-control-feedback form-text" v-cloak>@{{ errors . first('code') }}
        </div>
    </div>
</div>

<div class="form-check row align-items-center"
    :class="{'has-danger': errors.has('platform'), 'has-success': fields.platform && fields.platform.valid }">
    <label for="code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.app-version.columns.platform') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-2' : 'col-md-8 col-xl-8'">
        <select v-model="form.platform" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('platform'), 'form-control-success': fields.platform && fields.platform.valid}" id="platform" name="platform" placeholder="{{ trans('admin.excercise.columns.platform') }}">
            <option>--Select--</option>
            <option value="0">Android</option>
            <option value="1">IOS</option>
        </select>

    </div>
    <div v-if="errors.has('platform')" class="form-control-feedback form-text" v-cloak>
        @{{ errors . first('platform') }}
    </div>

</div>
