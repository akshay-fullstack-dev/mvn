<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageMaintain\BulkDestroyPackageMaintain;
use App\Http\Requests\Admin\PackageMaintain\DestroyPackageMaintain;
use App\Http\Requests\Admin\PackageMaintain\IndexPackageMaintain;
use App\Http\Requests\Admin\PackageMaintain\StorePackageMaintain;
use App\Http\Requests\Admin\PackageMaintain\UpdatePackageMaintain;
use App\Models\PackageMaintain;
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

class PackageMaintainsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPackageMaintain $request
     * @return array|Factory|View
     */
    public function index(IndexPackageMaintain $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(PackageMaintain::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'package_id', 'user_id', 'order_id', 'transaction_id', 'amount'],

            // set columns to searchIn
            ['id', 'order_id', 'transaction_id', 'amount']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.package-maintain.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.package-maintain.create');

        return view('admin.package-maintain.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePackageMaintain $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePackageMaintain $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the PackageMaintain
        $packageMaintain = PackageMaintain::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/package-maintains'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/package-maintains');
    }

    /**
     * Display the specified resource.
     *
     * @param PackageMaintain $packageMaintain
     * @throws AuthorizationException
     * @return void
     */
    public function show(PackageMaintain $packageMaintain)
    {
        $this->authorize('admin.package-maintain.show', $packageMaintain);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PackageMaintain $packageMaintain
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(PackageMaintain $packageMaintain)
    {
        $this->authorize('admin.package-maintain.edit', $packageMaintain);


        return view('admin.package-maintain.edit', [
            'packageMaintain' => $packageMaintain,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePackageMaintain $request
     * @param PackageMaintain $packageMaintain
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePackageMaintain $request, PackageMaintain $packageMaintain)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values PackageMaintain
        $packageMaintain->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/package-maintains'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/package-maintains');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPackageMaintain $request
     * @param PackageMaintain $packageMaintain
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPackageMaintain $request, PackageMaintain $packageMaintain)
    {
        $packageMaintain->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPackageMaintain $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPackageMaintain $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    PackageMaintain::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
