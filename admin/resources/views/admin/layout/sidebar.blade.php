<link href="{{ url('/css/custom.css') }}" rel="stylesheet" />
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-globe"></i> {{ trans('Vendors') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/services') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.service.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/customer') }}"><i class="nav-icon icon-book-open"></i> Customer</a></li>
           <!-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/user-documents') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('Vendor Documents') }}</a></li> -->
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/vendor-requested-services') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.vendor-requested-service.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/coupons') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.coupon.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/delivery-charges') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.delivery-charge.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/bookings') }}"><i class="nav-icon icon-magnet"></i> {{ trans('admin.booking.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/app-packages') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.app-package.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/app-versions') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.app-version.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/service-categories') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.service-category.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/spare-parts-shop-locations') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.spare-parts-shop-location.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/referral-amounts') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.referral-amount.title') }}</a></li>

           <li class="nav-item"><a class="nav-link" href="{{ url('admin/my-earnings') }}"><i class="nav-icon fa fa-dollar"></i>
            {{ trans('admin.my_earing.title') }}</a></li>

           {{-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/disputes') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.dispute.title') }}</a></li> --}}
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/packages') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.package.title') }}</a></li>
           {{-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/package-maintains') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.package-maintain.title') }}</a></li> --}}
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
