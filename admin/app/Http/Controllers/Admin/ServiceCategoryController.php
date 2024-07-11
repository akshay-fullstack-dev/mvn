<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceCategory\BulkDestroyServiceCategory;
use App\Http\Requests\Admin\ServiceCategory\DestroyServiceCategory;
use App\Http\Requests\Admin\ServiceCategory\IndexServiceCategory;
use App\Http\Requests\Admin\ServiceCategory\StoreServiceCategory;
use App\Http\Requests\Admin\ServiceCategory\UpdateServiceCategory;
use App\Models\ServiceCategory;
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

class ServiceCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexServiceCategory $request
     * @return array|Factory|View
     */
    public function index(IndexServiceCategory $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ServiceCategory::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'description'],

            // set columns to searchIn
            ['id', 'name', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.service-category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.service-category.create');
        $mode = 'create';
        return view('admin.service-category.create', compact('mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreServiceCategory $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreServiceCategory $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ServiceCategory
        $serviceCategory = ServiceCategory::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/service-categories'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/service-categories');
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceCategory $serviceCategory
     * @throws AuthorizationException
     * @return void
     */
    public function show(ServiceCategory $serviceCategory)
    {
        $this->authorize('admin.service-category.show', $serviceCategory);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceCategory $serviceCategory
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        // $this->authorize('admin.service-category.edit', $serviceCategory);

        return view('admin.service-category.edit', [
            'serviceCategory' => $serviceCategory,
            'mode' => 'edit',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServiceCategory $request
     * @param ServiceCategory $serviceCategory
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateServiceCategory $request, ServiceCategory $serviceCategory)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ServiceCategory
        $serviceCategory->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/service-categories'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/service-categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyServiceCategory $request
     * @param ServiceCategory $serviceCategory
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyServiceCategory $request, ServiceCategory $serviceCategory)
    {
        $services = $serviceCategory->services()->get();
        if ($services->count() > 0) {
            if ($request->ajax()) {
                return response(['message' => 'Cannot delete this category. It has some service linked.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            return response(['message' => 'Cannot delete this category. It has some service linked.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $serviceCategory->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }
    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyServiceCategory $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyServiceCategory $request): Response
    {
        $isSomeEntriesNotDeleted = false;
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) use ($request) {
                    $service_category =  ServiceCategory::whereIn('id', $bulkChunk)->first();
                    $services  =  $service_category->services()->delete();
                    if (!$services->count() > 0) {
                        if ($request->ajax()) {
                            $service_category->services()->delete();
                            $service_category->delete();
                        } else {
                            $isSomeEntriesNotDeleted = true;
                        }
                    }
                    // TODO your code goes here
                });
        });

        if ($isSomeEntriesNotDeleted) {
            return response(['message' => 'Some categories are not deleted.It has some categories attached to is']);
        } else {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }
    }
}
