@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.spare-parts-shop-location.actions.edit', ['name' => $sparePartsShopLocation->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <spare-parts-shop-location-form :action="'{{ $sparePartsShopLocation->resource_url }}'"
                :data="{{ $sparePartsShopLocation->toJson() }}" v-cloak inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action"
                    novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i>
                        {{ trans('admin.spare-parts-shop-location.actions.edit', ['name' => $sparePartsShopLocation->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.spare-parts-shop-location.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

            </spare-parts-shop-location-form>

        </div>

    </div>
    <script type="application/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhVkQkkSCAz6VaoO3UwadmlI5RMqyDa5E&libraries=places&callback=initMap">
    </script>

@endsection
