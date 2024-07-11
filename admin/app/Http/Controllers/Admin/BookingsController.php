<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ShopEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\BulkDestroyBooking;
use App\Http\Requests\Admin\Booking\DestroyBooking;
use App\Http\Requests\Admin\Booking\IndexBooking;
use App\Http\Requests\Admin\Booking\StoreBooking;
use App\Http\Requests\Admin\Booking\UpdateBooking;
use App\Models\Booking;
use App\Models\SparePartsShopLocation;
use App\Models\User;
use App\Traits\LocationTrait;
use Brackets\AdminListing\Facades\AdminListing;
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

class BookingsController extends Controller
{
    use LocationTrait;

    /**
     * Display a listing of the resource.
     *
     * @param IndexBooking $request
     * @return array|Factory|View
     */
    public function index(IndexBooking $request)
    {
        $spare_part_shops = SparePartsShopLocation::get();
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Booking::class)->processRequestAndGet(
            // pass the request with params
            $request,
            // set columns to query
            ['id', 'order_id', 'user_id', 'vendor_id', 'service_id', 'address_id', 'payment_id', 'package_id', 'vehicle_id', 'booking_start_time', 'booking_end_time', 'booking_status', 'booking_type', 'addition_info'],

            // set columns to searchIn
            ['id', 'order_id', 'addition_info'],
            function ($query) {
                $query->with(['customer_details', 'booking_vendor', 'service', 'booking_vehicle'])->latest();
            }
        );
        
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.booking.index', ['data' => $data, 'spare_part_shops' => $spare_part_shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.booking.create');

        return view('admin.booking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBooking $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBooking $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Booking
        $booking = Booking::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/bookings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/bookings');
    }

    /**
     * Display the specified resource.
     *
     * @param Booking $booking
     * @throws AuthorizationException
     * @return void
     */
    public function show(Booking $booking)
    {
        $this->authorize('admin.booking.show', $booking);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Booking $booking
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Booking $booking)
    {
        $this->authorize('admin.booking.edit', $booking);


        return view('admin.booking.edit', [
            'booking' => $booking,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBooking $request
     * @param Booking $booking
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBooking $request, Booking $booking)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Booking
        $booking->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/bookings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/bookings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBooking $request
     * @param Booking $booking
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBooking $request, Booking $booking)
    {
        $booking->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBooking $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBooking $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Booking::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function view($booking_id)
    {
        $booking = Booking::where('id', $booking_id)->with('customer_details', 'booking_status_history', 'booking_payment', 'booking_vendor.userAddresses', 'service', 'booking_vehicle.vehicle_company', 'booking_bills')->first();
        return view('admin.booking.view', compact('booking'));
    }

    public function selectedShop(Request $request)
    {
        $spare_part_shops = SparePartsShopLocation::get();
        // if there is no booking set
        if (!$request->shop_id) {
            $data =  Booking::with(['customer_details', 'booking_vendor', 'service', 'booking_vehicle'])->paginate(20);
            return view('admin.booking.listing_with_nearest_shop_location', ['data' => $data, 'spare_part_shops' => $spare_part_shops]);
        }
        $shop = SparePartsShopLocation::where('id', $request->shop_id)->first();
        if (!$shop) {
            return view('admin.booking.listing_with_nearest_shop_location', ['data' => collect(), 'spare_part_shops' => $spare_part_shops]);
        }
        $vendor_near_shop = $this->getUserWithinRadius($shop->lat, $shop->long, ShopEnum::ShopSearchingRadius);
        if (!$vendor_near_shop) {
            return view('admin.booking.listing_with_nearest_shop_location', ['data' => collect(), 'spare_part_shops' => $spare_part_shops]);
        }
        unset($shop);
        $vendor_near_shop = User::select('id')->whereIn('id', $vendor_near_shop)->has('vendorBookings')->get();
        if (!$vendor_near_shop->count() > 0) {
            return view('admin.booking.listing_with_nearest_shop_location', ['data' => collect(), 'spare_part_shops' => $spare_part_shops]);
        }
        $data = Booking::whereIn('vendor_id', $vendor_near_shop->pluck('id')->toArray())->with(['customer_details', 'booking_vendor', 'service', 'booking_vehicle'])->paginate(20);
        if (!$data->count() > 0) {
            return view('admin.booking.listing_with_nearest_shop_location', ['data' => collect(), 'spare_part_shops' => $spare_part_shops]);
        }
        $data->withPath('?shop_id=' . $request->shop_id);
        return view('admin.booking.listing_with_nearest_shop_location', compact('data', 'spare_part_shops'));
    }
}
