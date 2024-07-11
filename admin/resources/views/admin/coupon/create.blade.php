@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.coupon.actions.create'))

@section('body')@php
$data =['coupon_code'=>Str::random(6)];
@endphp
<div class="container-xl">
  <div class="card">
    <coupon-form :action="'{{ url('admin/coupons') }}'" :data="{{ json_encode($data) }}" v-cloak inline-template>
      <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
        <div class="card-header">
          <i class="fa fa-plus"></i> {{ trans('admin.coupon.actions.create') }}
        </div>
        <div class="card-body">
          @include(' admin.coupon.components.form-elements') </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary" :disabled="submiting">
            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
            {{ trans('brackets/admin-ui::admin.btn.save') }}
          </button>
        </div>

      </form>

    </coupon-form>

  </div>

</div>


@endsection
