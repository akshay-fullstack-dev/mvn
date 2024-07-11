<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}"
            id="name" name="name" placeholder="{{ trans('admin.service.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('serviceCategory'), 'has-success': fields.serviceCategory && fields.serviceCategory.valid }">
    <label for="serviceCategory" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-version.columns.category') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.serviceCategory" :name="serviceCategory" :options="{{ $serviceCategory->toJson() }}"
            placeholder="{{ trans('admin.app-version.columns.app_package_id') }}" label="name" track-by="id"
            id="serviceCategory" name="serviceCategory" :multiple="false">
        </multiselect>
        <div v-if="errors.has('serviceCategory')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('serviceCategory') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
    <label for="description" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.description" v-validate="'required'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('description'), 'form-control-success': fields.description && fields.description.valid}"
            id="description" name="description" placeholder="{{ trans('admin.service.columns.description') }}">
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('description') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('price'), 'has-success': fields.price && fields.price.valid }">
    <label for="price" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.labour_price') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.price" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('price'), 'form-control-success': fields.price && fields.price.valid}"
            id="price" name="price" placeholder="{{ trans('admin.service.columns.labour_price') }}">
        <div v-if="errors.has('price')" class="form-control-feedback form-text" v-cloak>@{{ errors . first('price') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('approx_time'), 'has-success': fields.approx_time && fields.approx_time.valid }">
    <label for="approx_time" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.approx_time') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
            <datetime v-model="form.approx_time" :config="timePickerConfig" v-validate="'required|date_format:HH:mm:ss'"
                class="flatpickr"
                :class="{'form-control-danger': errors.has('approx_time'), 'form-control-success': fields.approx_time && fields.approx_time.valid}"
                id="approx_time" name="approx_time"
                placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_time') }}"></datetime>
        </div>
        <div v-if="errors.has('approx_time')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('approx_time') }}</div>
    </div>
</div>

{{-- add spare part in the service api --}}
<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('spare_parts'), 'has-success': fields.spare_parts && fields.spare_parts.valid }">
    <label for="spare_parts" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.spare_part') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea type="text" v-model="form.spare_parts" rows="10" v-validate="" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('spare_parts'), 'form-control-success': fields.spare_parts && fields.spare_parts.valid}"
            id="spare_parts" name="spare_parts"
            placeholder="{{ trans('admin.service.columns.spare_part') }}"></textarea>
        <div v-if="errors.has('spare_parts')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('spare_parts') }}
        </div>
    </div>
</div>
{{-- spare part time --}}
<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('spare_part_price'), 'has-success': fields.spare_part_price && fields.spare_part_price.valid }">
    <label for="price" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.spare_part_price') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.spare_part_price"  @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('spare_part_price'), 'form-control-success': fields.spare_part_price && fields.spare_part_price.valid}"
            id="spare_part_price" name="spare_part_price" placeholder="{{ trans('admin.service.columns.spare_part_price') }}">
        <div v-if="errors.has('spare_part_price')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('spare_part_price') }}
        </div>
    </div>
</div>
<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('dealer_price'), 'has-success': fields.dealer_price && fields.dealer_price.valid }">
    <label for="price" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.dealer_price') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.dealer_price" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('dealer_price'), 'form-control-success': fields.dealer_price && fields.dealer_price.valid}"
            id="dealer_price" name="dealer_price" placeholder="{{ trans('admin.service.columns.dealer_price') }}">
        <div v-if="errors.has('dealer_price')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('dealer_price') }}
        </div>
    </div>
</div>

@if ($mode == 'create')
<div class="form-group row align-items-center" v-for="(input,k) in inputs" :key="k">
    <label class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('whats included') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" v-model="inputs[k].whatsincluded" name="whatsincludednew[k]">
    </div>
    <span>
        <i class="fa fa-minus-circle" @click="remove(k)" v-show="k || ( !k && inputs.length > 1)"></i>
        <i class="fa fa-plus-circle" @click="add(k)" v-show="k == inputs.length-1"></i>
    </span>
</div>
@endif
@if ($mode == 'edit')
@if ($newinc->count() > 0)
{{-- @{{ this . inputs }} --}}
<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('approx_time'), 'has-success': fields.approx_time && fields.approx_time.valid }"
    v-for="(input,k) in inputs " :key="k">
    <label :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Whats included') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <template v-if="form.whatsincluded[k] == null">
            <input type="text" class="form-control" v-model="inputs[k].whatsincluded" name="whatsincludednew[k]">
        </template>
        <template v-else>
            <input type="text" class="form-control" v-model="form.whatsincluded[k].name" name="whatsincluded[k]">
        </template>

    </div>
    <span>
        <i class="fa fa-minus-circle" @click="remove(k)" v-show="k || ( !k && inputs.length > 1)"></i>
        <i class="fa fa-plus-circle" @click="add(k)" v-show="k == inputs.length-1"></i>
    </span>
</div>
@endif
@endif
<div class="card">
    @if ($mode === 'edit')
    @include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => $service->getMediaCollection('cover'),
    'media' => $service->getThumbs200ForCollection('cover'),
    'label' => 'Photos'
    ])
    @else
    @include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => app(App\Models\Service::class)->getMediaCollection('cover'),
    'label' => 'Photos'
    ])
    @endif
</div>
