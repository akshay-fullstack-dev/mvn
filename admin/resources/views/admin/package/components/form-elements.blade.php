<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}"
            id="name" name="name" placeholder="{{ trans('admin.package.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
    <label for="description" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea type="text" v-model="form.description" v-validate="''" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('description'), 'form-control-success': fields.description && fields.description.valid}"
            id="description" name="description"
            placeholder="{{ trans('admin.package.columns.description') }}"></textarea>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('description') }}</div>
    </div>
</div>

<div class="form-check row"
    :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="status" type="checkbox" v-model="form.status" v-validate="''"
            data-vv-name="status" name="status_fake_element">
        <label class="form-check-label" for="status">
            {{ trans('admin.package.columns.status') }}
        </label>
        <input type="hidden" name="status" :value="form.status">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('normal_price'), 'has-success': fields.normal_price && fields.normal_price.valid }">
    <label for="normal_price" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.normal_price') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.normal_price" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('normal_price'), 'form-control-success': fields.normal_price && fields.normal_price.valid}"
            id="normal_price" name="normal_price" placeholder="{{ trans('admin.package.columns.normal_price') }}">
        <div v-if="errors.has('normal_price')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('normal_price') }}</div>
    </div>
</div>
<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('dealer_price'), 'has-success': fields.dealer_price && fields.dealer_price.valid }">
    <label for="dealer_price" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.dealer_price') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.dealer_price" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('dealer_price'), 'form-control-success': fields.dealer_price && fields.dealer_price.valid}"
            id="dealer_price" name="dealer_price" placeholder="{{ trans('admin.package.columns.dealer_price') }}">
        <div v-if="errors.has('dealer_price')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('dealer_price') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('booking_gap'), 'has-success': fields.booking_gap && fields.booking_gap.valid }">
    <label for="booking_gap" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.booking_gap') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.booking_gap" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('booking_gap'), 'form-control-success': fields.booking_gap && fields.booking_gap.valid}"
            id="booking_gap" name="booking_gap" placeholder="{{ trans('admin.package.columns.booking_gap') }}">
        <div v-if="errors.has('booking_gap')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('booking_gap') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('no_of_times'), 'has-success': fields.no_of_times && fields.no_of_times.valid }">
    <label for="no_of_times" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.no_of_times') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.no_of_times" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('no_of_times'), 'form-control-success': fields.no_of_times && fields.no_of_times.valid}"
            id="no_of_times" name="no_of_times"
            placeholder="{{ trans('admin.package.columns.no_of_times_placeholder') }}">
        <div v-if="errors.has('no_of_times')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('no_of_times') }}</div>
    </div>
</div>
<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('sparepartdescription'), 'has-success': fields.sparepartdescription && fields.sparepartdescription.valid }">
    <label for="sparepartdescription" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.sparepartdescription') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea v-model="form.sparepartdescription" v-validate="''" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('sparepartdescription'), 'form-control-success': fields.sparepartdescription && fields.sparepartdescription.valid}"
            id="sparepartdescription" name="sparepartdescription"
            placeholder="{{ trans('admin.package.columns.sparepartdescription') }}"></textarea>
        <div v-if="errors.has('sparepartdescription')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('sparepartdescription') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('start_date'), 'has-success': fields.start_date && fields.start_date.valid }">
    <label for="start_date" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.start_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.start_date" :config="datetimePickerConfig"
                v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr"
                :class="{'form-control-danger': errors.has('start_date'), 'form-control-success': fields.start_date && fields.start_date.valid}"
                id="start_date" name="start_date"
                placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('start_date')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('start_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('end_date'), 'has-success': fields.end_date && fields.end_date.valid }">
    <label for="end_date" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.end_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.end_date" :config="datetimePickerConfig"
                v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr"
                :class="{'form-control-danger': errors.has('end_date'), 'form-control-success': fields.end_date && fields.end_date.valid}"
                id="end_date" name="end_date"
                placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('end_date')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('end_date') }}</div>
    </div>
</div>
<div class="form-group row align-items-center" v-if="form.selected_service.length > 0"
    :class="{'has-danger': errors.has('end_date'), 'has-success': fields.end_date && fields.end_date.valid }">
    <label for="end_date" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.selected_service') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <template v-for="(service, index) in form.selected_service">
                <input class="input-group input-group--custom" :value="service.name" type="text" readonly><span
                    class="fa fa-minus-circle" @click="removeSelectedService(index)"></span>
            </template>
        </div>
        <div v-if=" errors.has('end_date')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('end_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" v-if="form.available_service.length > 0"
    :class="{'has-danger': errors.has('end_date'), 'has-success': fields.end_date && fields.end_date.valid }">
    <label for="end_date" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.package.columns.select_service') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <select class="input-group-addon" name="service">
                <option v-for="(service, index) in form.available_service" @click="onSelectServiceChange(service)"
                    :value="service.id">@{{service.name}}
                </option>
            </select>
        </div>
        <div v-if="errors.has('end_date')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('end_date') }}</div>
    </div>
</div>
