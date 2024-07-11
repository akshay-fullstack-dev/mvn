<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SparePartsShopLocation\BulkDestroySparePartsShopLocation;
use App\Http\Requests\Admin\SparePartsShopLocation\DestroySparePartsShopLocation;
use App\Http\Requests\Admin\SparePartsShopLocation\IndexSparePartsShopLocation;
use App\Http\Requests\Admin\SparePartsShopLocation\StoreSparePartsShopLocation;
use App\Http\Requests\Admin\SparePartsShopLocation\UpdateSparePartsShopLocation;
use App\Models\SparePartsShopLocation;
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

class SparePartsShopLocationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSparePartsShopLocation $request
     * @return array|Factory|View
     */
    public function index(IndexSparePartsShopLocation $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SparePartsShopLocation::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'shop_name', 'additional_shop_information', 'country', 'formatted_address', 'city', 'postal_code', 'lat', 'long'],

            // set columns to searchIn
            ['id', 'shop_name', 'additional_shop_information', 'country', 'formatted_address', 'city', 'postal_code']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.spare-parts-shop-location.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.spare-parts-shop-location.create');

        return view('admin.spare-parts-shop-location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSparePartsShopLocation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSparePartsShopLocation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the SparePartsShopLocation
        $sparePartsShopLocation = SparePartsShopLocation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/spare-parts-shop-locations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/spare-parts-shop-locations');
    }

    /**
     * Display the specified resource.
     *
     * @param SparePartsShopLocation $sparePartsShopLocation
     * @throws AuthorizationException
     * @return void
     */
    public function show(SparePartsShopLocation $sparePartsShopLocation)
    {
        $this->authorize('admin.spare-parts-shop-location.show', $sparePartsShopLocation);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SparePartsShopLocation $sparePartsShopLocation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SparePartsShopLocation $sparePartsShopLocation)
    {
        // $this->authorize('admin.spare-parts-shop-location.edit', $sparePartsShopLocation);


        return view('admin.spare-parts-shop-location.edit', [
            'sparePartsShopLocation' => $sparePartsShopLocation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSparePartsShopLocation $request
     * @param SparePartsShopLocation $sparePartsShopLocation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSparePartsShopLocation $request, SparePartsShopLocation $sparePartsShopLocation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SparePartsShopLocation
        $sparePartsShopLocation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/spare-parts-shop-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/spare-parts-shop-locations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySparePartsShopLocation $request
     * @param SparePartsShopLocation $sparePartsShopLocation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySparePartsShopLocation $request, SparePartsShopLocation $sparePartsShopLocation)
    {
        $sparePartsShopLocation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySparePartsShopLocation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySparePartsShopLocation $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SparePartsShopLocation::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
