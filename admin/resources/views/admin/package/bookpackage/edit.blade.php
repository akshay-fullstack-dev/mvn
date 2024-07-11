<?php
echo '<pre>';
print_r($data);
die();
?>

@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.package.actions.edit', ['name' => $package->name]))

@section('body')
<div class="container-xl">
    <div class="card">

        <package-form :action="'{{ $package->resource_url }}'" :data="{{ $package->toJson() }}" v-cloak inline-template>

            <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action"
                novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i> {{ trans('admin.package.actions.edit', ['name' => $package->name]) }}
                </div>

                <div class="card-body">
                <div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="packagename" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Package Name</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.packages.name" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.packages.name && fields.packages.name.valid}"
            id="packagesname" name="packagesname" placeholder="{{ trans('admin.package.columns.name') }}">
        <div v-if="errors.has('packagesname')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('packagesname') }}</div>
    </div>
</div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </package-form>

    </div>

</div>

@endsection
