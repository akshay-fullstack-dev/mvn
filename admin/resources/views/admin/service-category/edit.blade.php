@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.service-category.actions.edit', ['name' => $serviceCategory->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <service-category-form
                :action="'{{ $serviceCategory->resource_url }}'"
                :data="{{ $serviceCategory->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.service-category.actions.edit', ['name' => $serviceCategory->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.service-category.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </service-category-form>

        </div>
    
</div>

@endsection