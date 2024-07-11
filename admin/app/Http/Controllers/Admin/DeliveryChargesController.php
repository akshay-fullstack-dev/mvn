<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryCharge\BulkDestroyDeliveryCharge;
use App\Http\Requests\Admin\DeliveryCharge\DestroyDeliveryCharge;
use App\Http\Requests\Admin\DeliveryCharge\IndexDeliveryCharge;
use App\Http\Requests\Admin\DeliveryCharge\StoreDeliveryCharge;
use App\Http\Requests\Admin\DeliveryCharge\UpdateDeliveryCharge;
use App\Models\DeliveryCharge;
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

class DeliveryChargesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDeliveryCharge $request
     * @return array|Factory|View
     */
    public function index(IndexDeliveryCharge $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(DeliveryCharge::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'customer_delivery_charge', 'vendor_delivery_charge'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.delivery-charge.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.delivery-charge.create');

        return view('admin.delivery-charge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDeliveryCharge $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDeliveryCharge $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the DeliveryCharge
        $deliveryCharge = DeliveryCharge::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/delivery-charges'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/delivery-charges');
    }

    /**
     * Display the specified resource.
     *
     * @param DeliveryCharge $deliveryCharge
     * @throws AuthorizationException
     * @return void
     */
    public function show(DeliveryCharge $deliveryCharge)
    {
        $this->authorize('admin.delivery-charge.show', $deliveryCharge);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DeliveryCharge $deliveryCharge
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(DeliveryCharge $deliveryCharge)
    {
        $this->authorize('admin.delivery-charge.edit', $deliveryCharge);


        return view('admin.delivery-charge.edit', [
            'deliveryCharge' => $deliveryCharge,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDeliveryCharge $request
     * @param DeliveryCharge $deliveryCharge
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDeliveryCharge $request, DeliveryCharge $deliveryCharge)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values DeliveryCharge
        $deliveryCharge->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/delivery-charges'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/delivery-charges');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDeliveryCharge $request
     * @param DeliveryCharge $deliveryCharge
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDeliveryCharge $request, DeliveryCharge $deliveryCharge)
    {
        $deliveryCharge->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDeliveryCharge $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDeliveryCharge $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DeliveryCharge::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
