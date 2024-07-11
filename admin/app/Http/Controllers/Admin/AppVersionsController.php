<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppVersion\BulkDestroyAppVersion;
use App\Http\Requests\Admin\AppVersion\DestroyAppVersion;
use App\Http\Requests\Admin\AppVersion\IndexAppVersion;
use App\Http\Requests\Admin\AppVersion\StoreAppVersion;
use App\Http\Requests\Admin\AppVersion\UpdateAppVersion;
use App\Models\AppPackage;
use App\Models\AppVersion;
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

class AppVersionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAppVersion $request
     * @return array|Factory|View
     */
    public function index(IndexAppVersion $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AppVersion::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'app_package_id', 'force_update', 'message', 'version', 'code', 'platform'],

            // set columns to searchIn
            ['id', 'message', 'code'],
            function ($query) use ($request) {
                $query->with(['app_packages']);
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

        return view('admin.app-version.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.app-version.create');
        $app_packages = AppPackage::get();
        if (!$app_packages->count() > 0)
            return redirect()->back()->withErrors(['App package not found.']);
        foreach ($app_packages as $package) {
            $package->bundle_id = $package->bundle_id . '  (' . $package->app_name . ')';
        }
        return view('admin.app-version.create', compact('app_packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAppVersion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAppVersion $request)
    {
        // Sanitize input

        $sanitized = $request->getSanitized($request);
        $already_exist_platform = AppVersion::where('app_package_id', $request->app_packages['id'])->where('version', $request->version)->where('platform', $request->platform)->first();
        if ($already_exist_platform) {
            $already_exist_platform->update($sanitized);
        } else {
            AppVersion::create($sanitized);
        }
        // Store the AppVersion;

        if ($request->ajax()) {
            return ['redirect' => url('admin/app-versions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/app-versions');
    }

    /**
     * Display the specified resource.
     *
     * @param AppVersion $appVersion
     * @throws AuthorizationException
     * @return void
     */
    public function show(AppVersion $appVersion)
    {
        // $this->authorize('admin.app-version.show', $appVersion);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AppVersion $appVersion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AppVersion $appVersion)
    {
        // $this->authorize('admin.app-version.edit', $appVersion);
        $app_packages = AppPackage::get();
        // dd($appVersion);
        $selected_app_package = AppPackage::where('id', $appVersion->app_package_id)->first();
        if (!$selected_app_package)
            return  redirect()->back()->withErrors(['App package not found.']);

        if (!$app_packages)
            return redirect()->back()->withErrors(['App package not found.']);
        foreach ($app_packages as $packages) {
            $packages->bundle_id = $packages->bundle_id . ' (' . $packages->app_name . ')';
        }
        $selected_app_package->bundle_id = $selected_app_package->bundle_id . ' (' . $selected_app_package->app_name . ')';
        $dataPre = json_encode(array_merge(['app_packages' => $selected_app_package], json_decode($appVersion, true)));

        return view(
            'admin.app-version.edit',
            compact('appVersion', 'app_packages', 'selected_app_package', 'dataPre',)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAppVersion $request
     * @param AppVersion $appVersion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAppVersion $request, AppVersion $appVersion)
    {
        // Sanitize input
        $sanitized = $request->getSanitized($request);

        $already_exist_platform = AppVersion::where('app_package_id', $sanitized['app_package_id'])->where('version', $request->version)->where('platform', $request->platform)->first();
        if ($already_exist_platform) {
            $appVersion->update($sanitized);
        } else {
            AppVersion::create($sanitized);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/app-versions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/app-versions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAppVersion $request
     * @param AppVersion $appVersion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAppVersion $request, AppVersion $appVersion)
    {
        $appVersion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAppVersion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAppVersion $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    AppVersion::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
