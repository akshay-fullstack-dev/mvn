@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.delivery-charge.actions.edit', ['name' => $deliveryCharge->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <delivery-charge-form
                :action="'{{ $deliveryCharge->resource_url }}'"
                :data="{{ $deliveryCharge->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.delivery-charge.actions.edit', ['name' => $deliveryCharge->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.delivery-charge.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </delivery-charge-form>

        </div>
    
</div>

@endsection