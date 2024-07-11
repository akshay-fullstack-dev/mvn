@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.referral-amount.actions.edit', ['name' => $referralAmount->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <referral-amount-form
                :action="'{{ $referralAmount->resource_url }}'"
                :data="{{ $referralAmount->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.referral-amount.actions.edit', ['name' => $referralAmount->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.referral-amount.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </referral-amount-form>

        </div>
    
</div>

@endsection