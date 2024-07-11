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
                    @include('admin.package.components.form-elements')

                    @include('brackets/admin-ui::admin.includes.media-uploader', [
                    'mediaCollection' => $package->getMediaCollection('cover'),
                    'media' => $package->getThumbs200ForCollection('cover'),
                    'label' => 'Photos'
                    ])
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
