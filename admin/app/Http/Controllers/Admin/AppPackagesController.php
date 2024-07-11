<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppPackage\BulkDestroyAppPackage;
use App\Http\Requests\Admin\AppPackage\DestroyAppPackage;
use App\Http\Requests\Admin\AppPackage\IndexAppPackage;
use App\Http\Requests\Admin\AppPackage\StoreAppPackage;
use App\Http\Requests\Admin\AppPackage\UpdateAppPackage;
use App\Models\AppPackage;
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

class AppPackagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAppPackage $request
     * @return array|Factory|View
     */
    public function index(IndexAppPackage $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AppPackage::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'bundle_id', 'app_name'],

            // set columns to searchIn
            ['id', 'bundle_id', 'app_name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.app-package.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.app-package.create');

        return view('admin.app-package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAppPackage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAppPackage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AppPackage
        $appPackage = AppPackage::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/app-packages'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/app-packages');
    }

    /**
     * Display the specified resource.
     *
     * @param AppPackage $appPackage
     * @throws AuthorizationException
     * @return void
     */
    public function show(AppPackage $appPackage)
    {
        // $this->authorize('admin.app-package.show', $appPackage);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AppPackage $appPackage
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AppPackage $appPackage)
    {
        // $this->authorize('admin.app-package.edit', $appPackage);


        return view('admin.app-package.edit', [
            'appPackage' => $appPackage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAppPackage $request
     * @param AppPackage $appPackage
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAppPackage $request, AppPackage $appPackage)
    {
        // {"message":"The given data was invalid.","errors":{"bundle_id":["The bundle id must be an integer."]}}
        // Sanitize input
        $already_added_package = AppPackage::where('bundle_id', $request->bundle_id)->where('id', '!=', $appPackage->id)->first();
        if ($already_added_package) {
            if ($request->ajax()) {
                $response = ['message' => 'The Bundle id already exist.', 'errors' => ["bundle_id" => " "]];
                return response($response, 422);
            }
        }
        // return redirect('admin/app-packages');
        $sanitized = $request->getSanitized();

        // Update changed values AppPackage
        $appPackage->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/app-packages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/app-packages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAppPackage $request
     * @param AppPackage $appPackage
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAppPackage $request, AppPackage $appPackage)
    {
        $appPackage->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAppPackage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAppPackage $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    AppPackage::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
