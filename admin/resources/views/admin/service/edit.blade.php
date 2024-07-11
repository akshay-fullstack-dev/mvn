@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.service.actions.edit', ['name' => $service->name]))

@section('body')
{{--  @php
    echo "<pre>";
        print_r($newinc->toArray());
        echo "</pre>";die;
@endphp  --}}
    <div class="container-xl">
        <div class="card">

            <service-form
                :action="'{{ $service->resource_url }}'"
                :data="{{ $dataPre }}"
                v-cloak
                inline-template>
                <form class="form-horizontal form-create" method="post" @submit="modifyData(2)" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.service.actions.edit', ['name' => $service->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.service.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </service-form>

        </div>
    
</div>

@endsection