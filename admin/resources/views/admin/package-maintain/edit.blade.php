@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.package-maintain.actions.edit', ['name' => $packageMaintain->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <package-maintain-form
                :action="'{{ $packageMaintain->resource_url }}'"
                :data="{{ $packageMaintain->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.package-maintain.actions.edit', ['name' => $packageMaintain->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.package-maintain.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </package-maintain-form>

        </div>
    
</div>

@endsection