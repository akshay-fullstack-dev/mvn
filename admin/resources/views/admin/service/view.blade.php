@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.service.actions.View', ['name' => $service->name]))

@section('body')
{{--  @php
    echo "<pre>";
        print_r($newinc->toArray());
        echo "</pre>";die;
@endphp  --}}
<?php 
// print_r($serviceCategory);
// die();
$temp = App\Models\ServiceCategory::find($service->service_category_id);
?>
<div class="container-xl">
    <div class="card">

        <service-form :action="'{{ $service->resource_url }}'" :data="{{ $dataPre }}" v-cloak inline-template>
            <form class="form-horizontal form-create" method="post" @submit="modifyData(2)" @submit.prevent="onSubmit"
                :action="action" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    View
                </div>


                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="name" class="col-form-label text-md-right"
                            :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.name') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)"
                                class="form-control aa" id="name" name="name"
                                placeholder="{{ trans('admin.service.columns.name') }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="serviceCategory" class="col-form-label text-md-right"
                            :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-version.columns.category') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

                            <input type="text" class="form-control aa" id="serviceCategory" name="serviceCategory"
                                value="{{$temp->name}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label for="description" class="col-form-label text-md-right"
                        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.description') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                        <input type="text" v-model="form.description" v-validate="'required'" @input="validate($event)"
                            class="form-control"
                            :class="{'form-control-danger': errors.has('description'), 'form-control-success': fields.description && fields.description.valid}"
                            id="description" name="description"
                            placeholder="{{ trans('admin.service.columns.description') }}" readonly>
                        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>
                            @{{ errors . first('description') }}</div>
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label for="price" class="col-form-label text-md-right"
                        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.labour_price') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                        <input type="text" v-model="form.price" v-validate="'required'" @input="validate($event)"
                            class="form-control"
                            :class="{'form-control-danger': errors.has('price'), 'form-control-success': fields.price && fields.price.valid}"
                            id="price" name="price" placeholder="{{ trans('admin.service.columns.price') }}" readonly>
                        <div v-if="errors.has('price')" class="form-control-feedback form-text" v-cloak>
                            @{{ errors . first('price') }}
                        </div>
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label for="approx_time" class="col-form-label text-md-right"
                        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.approx_time') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                        <div class="input-group input-group--custom">
                            <input type="text" v-model="form.approx_time" v-validate="'required'"
                                @input="validate($event)" class="form-control cc" id="approx_time" name="approx_time"
                                value="{{$service->about_time}}" readonly>
                        </div>
                        <div v-if="errors.has('approx_time')" class="form-control-feedback form-text" v-cloak>
                            @{{ errors . first('approx_time') }}</div>
                    </div>
                </div>
                {{-- spare part time --}}
                <div class="form-group row align-items-center"
                    :class="{'has-danger': errors.has('spare_part_price'), 'has-success': fields.spare_part_price && fields.spare_part_price.valid }">
                    <label for="price" class="col-form-label text-md-right"
                        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.spare_part_price') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                        <input type="text" v-model="form.spare_part_price" v-validate="'required'"
                            @input="validate($event)" class="form-control"
                            :class="{'form-control-danger': errors.has('spare_part_price'), 'form-control-success': fields.spare_part_price && fields.spare_part_price.valid}"
                            id="spare_part_price" name="spare_part_price"
                            placeholder="{{ trans('admin.service.columns.spare_part_price') }}" readonly>
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
                        <input type="text" v-model="form.dealer_price" v-validate="'required'" @input="validate($event)"
                            class="form-control"
                            :class="{'form-control-danger': errors.has('dealer_price'), 'form-control-success': fields.dealer_price && fields.dealer_price.valid}"
                            id="dealer_price" name="dealer_price"
                            placeholder="{{ trans('admin.service.columns.dealer_price') }}" readonly>
                        <div v-if="errors.has('dealer_price')" class="form-control-feedback form-text" v-cloak>
                            @{{ errors . first('dealer_price') }}
                        </div>
                    </div>
                </div>

                {{-- add spare part in the service api --}}
                <div class="form-group row align-items-center">
                    <label for="spare_parts" class="col-form-label text-md-right"
                        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service.columns.spare_part') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                        <textarea type="text" v-model="form.spare_parts" rows="10" v-validate=""
                            @input="validate($event)" class="form-control"
                            :class="{'form-control-danger': errors.has('spare_parts'), 'form-control-success': fields.spare_parts && fields.spare_parts.valid}"
                            id="spare_parts" name="spare_parts"
                            placeholder="{{ trans('admin.service.columns.spare_part') }}" readonly></textarea>
                        <div v-if="errors.has('spare_parts')" class="form-control-feedback form-text" v-cloak>
                            @{{ errors . first('spare_parts') }}
                        </div>
                    </div>
                </div>
                <div class="form-group row align-items-center" v-for="(input,k) in inputs" :key="k">
                    <label class="col-form-label text-md-right"
                        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('whats included') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                        <input type="text" class="form-control" v-model="inputs[k].whatsincluded"
                            name="whatsincludednew[k]" readonly>
                    </div>
                </div>
            </form>

        </service-form>

    </div>

</div>

@endsection
