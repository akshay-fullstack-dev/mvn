@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.vendor-requested-service.actions.edit', ['name' => $vendorRequestedService->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <vendor-requested-service-form
                :action="'{{ $vendorRequestedService->resource_url }}'"
                :data="{{ $vendorRequestedService->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.vendor-requested-service.actions.edit', ['name' => $vendorRequestedService->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.vendor-requested-service.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </vendor-requested-service-form>

        </div>
    
</div>

@endsection