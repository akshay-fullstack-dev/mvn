<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Package\BulkDestroyPackage;
use App\Http\Requests\Admin\Package\DestroyPackage;
use App\Http\Requests\Admin\Package\IndexPackage;
use App\Http\Requests\Admin\Package\StorePackage;
use App\Http\Requests\Admin\Package\UpdatePackage;
use App\Models\Booking;
use App\Models\Package;
use App\Models\PackageMaintain;
use App\Models\Service;
use App\Models\UserService;
use App\Models\User;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PackagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPackage $request
     * @return array|Factory|View
     */
    public function index(IndexPackage $request)
    {
        // create and AdminListing instance for a specific model and
        $packages = AdminListing::create(Package::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'description', 'status', 'booking_gap', 'start_date', 'end_date', 'no_of_times', 'normal_price', 'dealer_price'],

            // set columns to searchIn
            ['id', 'name', 'description'],
            function ($query) {
                $query->with(['purchased_package'])->latest();
            }
        );

        if ($packages->count() > 0) {
            foreach ($packages as $single_package) {
                $single_package->package_bookings = $single_package->purchased_package->count();
            }
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $packages->pluck('id'),
                ];
            }
            return ['data' => $packages];
        }
        // dd($data);
        return view('admin.package.index', ['data' => $packages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $package = collect(['available_service' => $this->getServices(), 'selected_service' => [], 'change_service_url' => url('admin/')]);
        // $this->authorize('admin.package.create');
        return view('admin.package.create', compact('package'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePackage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePackage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Package
        $package = Package::create($sanitized);
        if ($request->selected_service) {
            $package->package_services()->insert($this->get_package_service_insert_table_data($request, $package->id));
        }

        if ($request->ajax()) {
            return ['redirect' => url('admin/packages'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/packages');
    }

    /**
     * Display the specified resource.
     *
     * @param Package $package
     * @throws AuthorizationException
     * @return void
     */
    public function show(Package $package)
    {
        // $selected_service = ($package->package_services->count()>0)?$this->get_another_vendor_services($package->package_services->pluck('service_id')->toArray()):[]);

        // $selected_service=
        // $selected_service = ($package->package_services->count()>0)?$this->get_another_vendor_services($package->package_services->pluck('service_id')->toArray()):[]);
        $package->available_service = $this->getServices();
        $this->authorize('admin.package.show', $package);

        // TODO your code goes here
    }
    private function get_package_service_insert_table_data($request, $package_id)
    {
        $insert_data = [];
        $current_time = Carbon::now()->format('Y-m-d H:i:s');
        foreach ($request->selected_service as $selected_service) {
            $insert_data[] = [
                'package_id' => $package_id,
                'service_id' => $selected_service['id'],
                'created_at' => $current_time,
                'updated_at' => $current_time,
            ];
        }
        return $insert_data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Package $package
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Package $package)
    {
        // print_r($package);
        // die();
        $package->change_service_url = url('/admin');
        if ($package->package_services->count() > 0) {
            // dd('s');
            $selected_service = $package->package_services->pluck('service_id')->toArray();
            $package->selected_service = Service::whereIn('id', $selected_service)->get();
            $package->available_service = $this->get_another_vendor_services($selected_service);
        } else {
            // dd('h');
            $selected_service = $package->package_services->pluck('service_id')->toArray();
            $package->selected_service = Service::whereIn('id', $selected_service)->get();
            $package->available_service = $this->getServices();
        }
        // dd($package);
        return view('admin.package.edit', [
            'package' => $package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePackage $request
     * @param Package $package
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePackage $request, Package $package)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Package
        $package->update($sanitized);
        if ($request->selected_service) {
            $package->package_services()->delete();
            $package->package_services()->insert($this->get_package_service_insert_table_data($request, $package->id));
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/packages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/packages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPackage $request
     * @param Package $package
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPackage $request, Package $package)
    {
        $package->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPackage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPackage $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Package::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    private function getServices()
    {
        $service_vendor = UserService::get();
        if (!$service_vendor->count() > 0) {
            return [];
        }
        $vendor_service_ids = UserService::whereIn('user_id', $service_vendor->pluck('user_id')->toArray())->get();
        if (!$vendor_service_ids) {
            return [];
        }
        $all_services = Service::whereIn('id', $vendor_service_ids->pluck('service_id')->unique()->toArray())->get();
        if (!$vendor_service_ids->count()) {
            return [];
        }
        return $all_services;
    }

    /**
     * this function is used to fetch the service from the backend
     * this function is a ajax call and be called from the admin panel
     *
     * @param Request $request
     * @return void
     */
    public function get_filter_bookings(Request $request)
    {
        if (!$request->selected_service) {
            return $this->getServices();
        }
        $selected_services = array_column($request->selected_service, 'id');
        return $this->get_another_vendor_services($selected_services);
    }

    private function get_another_vendor_services($selected_services_ids)
    {
        $service_vendor = UserService::whereIn('service_id', $selected_services_ids)->get();
        if (!$service_vendor->count() > 0) {
            return [];
        }
        $vendor_service_ids = UserService::whereIn('user_id', $service_vendor->pluck('user_id')->toArray())->get();
        if (!$vendor_service_ids) {
            return [];
        }

        $all_services = Service::whereIn('id', $vendor_service_ids->pluck('service_id')->unique()->toArray())->whereNotIn('id', $selected_services_ids)->get();
        if (!$vendor_service_ids->count()) {
            return [];
        }
        return $all_services;
    }

    public function packageBooking($package_id)
    {
        $package = Package::with('purchased_package.booking_by_order_id')->findOrFail($package_id);
        return view('admin/package/bookpackage/purchased_package_listing', ['package' => $package]);
    }

    public function bookingsByOrderId($order_id)
    {
        $bookings = Booking::where('order_id', $order_id)->with(['customer_details', 'service', 'booking_vendor', 'booking_vehicle'])->get();
        return view('admin.package.bookpackage.booking_listing', ['bookings' => $bookings]);
    }

    public function getBookingVendor($booking_id)
    {
        $booking = Booking::where('id', $booking_id)->with('service_vendor')->first();
        if (!$booking->count() > 0) {
            return [];
        }
        $vendor_ids = $booking->service_vendor->pluck('user_id')->toArray();
        $vendors = User::whereIn('id', $vendor_ids)->adminVendor()->get();
        if (!$vendors->count() > 0) {
            return [];
        }
        return $vendors;
    }

    public function assignVendor(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        if (!$booking) {
            return response([]);
        }
        if ($booking->vendor_id != null) {
            return "vendor already assigned";
        }
        $booking->vendor_id = $request->vendor_id;
        $booking->save();
        return redirect("admin/packages/order-bookings/$request->order_id");
    }
}
