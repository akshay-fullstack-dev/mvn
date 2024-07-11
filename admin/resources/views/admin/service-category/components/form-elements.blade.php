<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-category.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}"
            id="name" name="name" placeholder="{{ trans('admin.service-category.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors . first('name') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
    <label for="description" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-category.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea name="" id="" cols="30" rows="10" v-model="form.description" v-validate="'required'"
            @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('description'), 'form-control-success': fields.description && fields.description.valid}"
            id="description" name="description"
            placeholder="{{ trans('admin.service-category.columns.description') }}"></textarea>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>
            @{{ errors . first('description') }}</div>
    </div>
</div>
<div class="form-group row align-item-center">
    <label for="description" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-category.columns.image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        @if ($mode === 'edit')
            @include('brackets/admin-ui::admin.includes.media-uploader', [
            'mediaCollection' => $serviceCategory->getMediaCollection('cover'),
            'media' => $serviceCategory->getThumbs200ForCollection('cover'),
            'label' => 'Photos'
            ])
        @else
            @include('brackets/admin-ui::admin.includes.media-uploader', [
            'mediaCollection' => app(App\Models\ServiceCategory::class)->getMediaCollection('cover'),
            'label' => 'Photos',
            ])
        @endif
    </div>
</div>
