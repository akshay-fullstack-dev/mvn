<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\BulkDestroyCoupon;
use App\Http\Requests\Admin\Coupon\DestroyCoupon;
use App\Http\Requests\Admin\Coupon\IndexCoupon;
use App\Http\Requests\Admin\Coupon\StoreCoupon;
use App\Http\Requests\Admin\Coupon\UpdateCoupon;
use App\Models\Coupon;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CouponsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCoupon $request
     * @return array|Factory|View
     */
    public function index(IndexCoupon $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Coupon::class)->modifyQuery(function ($query) {
            $query->where('users_id', '=', null);
        })->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['coupon_code', 'coupon_discount', 'coupon_max_amount', 'coupon_min_amount', 'coupon_name', 'coupon_type', 'end_date', 'id', 'maximum_per_customer_use', 'maximum_total_use', 'start_date', 'users_id', 'coupon_description'],

            // set columns to searchIn
            ['coupon_code', 'coupon_name', 'id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.coupon.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.coupon.create');

        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCoupon $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCoupon $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Coupon
        $coupon = Coupon::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/coupons'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/coupons');
    }

    /**
     * Display the specified resource.
     *
     * @param Coupon $coupon
     * @throws AuthorizationException
     * @return void
     */
    public function show(Coupon $coupon)
    {
        $this->authorize('admin.coupon.show', $coupon);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Coupon $coupon
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('admin.coupon.edit', $coupon);


        return view('admin.coupon.edit', [
            'coupon' => $coupon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCoupon $request
     * @param Coupon $coupon
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCoupon $request, Coupon $coupon)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Coupon
        $coupon->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/coupons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/coupons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCoupon $request
     * @param Coupon $coupon
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCoupon $request, Coupon $coupon)
    {
        $coupon->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCoupon $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCoupon $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Coupon::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
