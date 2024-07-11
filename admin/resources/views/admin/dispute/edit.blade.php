@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.dispute.actions.edit', ['name' => $dispute->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <dispute-form
                :action="'{{ $dispute->resource_url }}'"
                :data="{{ $dispute->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <i class="fa fa-eye"></i>Detail
                    </div>

                    <div class="card-body">
                        @include('admin.dispute.components.form-elements')
                    </div>
                    
                    
                    {{-- <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div> --}}
                    
                </form>

        </dispute-form>

        </div>
    
</div>

@endsection