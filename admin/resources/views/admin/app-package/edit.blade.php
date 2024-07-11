@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.app-package.actions.edit', ['name' => $appPackage->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <app-package-form
                :action="'{{ $appPackage->resource_url }}'"
                :data="{{ $appPackage->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.app-package.actions.edit', ['name' => $appPackage->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.app-package.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </app-package-form>

        </div>
    
</div>

@endsection