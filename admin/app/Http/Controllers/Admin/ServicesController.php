<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\BulkDestroyService;
use App\Http\Requests\Admin\Service\DestroyService;
use App\Http\Requests\Admin\Service\IndexService;
use App\Http\Requests\Admin\Service\StoreService;
use App\Http\Requests\Admin\Service\UpdateService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceInclusion;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use stdClass;

class ServicesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexService $request
     * @return array|Factory|View
     */
    public function index(IndexService $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Service::class)->modifyQuery(function ($query) {
            $query->with('serviceInclusion', 'service_categories')->latest();
        })->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'description', 'price', 'approx_time', 'service_category_id', 'spare_parts'],

            // set columns to searchIn
            ['id', 'name', 'description', 'price'],
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        // dd($data);
        return view('admin.service.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.service.create');
        $serviceCategory = ServiceCategory::all();
        return view('admin.service.create', [
            'mode' => 'create',
            'serviceCategory' =>  $serviceCategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreService $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreService $request)
    {

        //Sanitize input
        $sanitized = $request->getSanitized();
        if ($request->dealer_price && $request->dealer_price <= $request->spare_part_price + $request->price) {
            $response = json_decode('{"message":"Invalid Dealer price.","errors":{"dealer_price":["Dealer price should be greater then the sum of labour and spare part price."]}}', true);
            return response($response, 400);
        }
        // Store the Service
        $service = Service::create($sanitized);
        // update whats included in the service panel
        if ($request->newwhatsincluded && !empty($request->newwhatsincluded) && $request->newwhatsincluded[0]['whatsincluded']) {
            $service->serviceInclusion()->createMany($this->getIncludedData($request->newwhatsincluded, $service->id));
        }
        // CREATE SERVICE INCLUDE
        if ($request->ajax()) {
            return ['redirect' => url('admin/services'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/services');
    }

    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @throws AuthorizationException
     * @return void
     */
    public function show(Service $service)
    {
        return view('admin.service.show', compact('service'));

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Service $service)
    {

        // $this->authorize('admin.service.edit', $service);
        $include = ServiceInclusion::where('service_id', $service->id)->get();
        $service->whatsincluded = $include;
        $counted = $include->count();
        $service_categories = ServiceCategory::get();
        $dataPre = json_encode(array_merge(['serviceCategory' => $service->service_categories], json_decode($service, true)));
        return view('admin.service.edit', [
            'newinc' => $include,
            'service' => $service,
            'serviceCategory' =>  $service_categories,
            'mode' => 'edit',
            'dataPre' => $dataPre,
            'counted' => $counted
        ]);
        // dd($include);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateService $request
     * @param Service $service
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateService $request, Service $service)
    {
        if ($request->dealer_price && $request->dealer_price <= $request->spare_part_price + $request->price) {
            $response = json_decode('{"message":"Invalid Dealer price.","errors":{"dealer_price":["Dealer price should be greater then the sum of labour and spare part price."]}}', true);
            return response($response, 400);
        }
        $already_existed_service = Service::whereName($request->name)->where('id', '!=', $service->id)->first();
        if ($already_existed_service) {
            $error = new stdClass();
            $error->name = "The name has already been taken.";
            $data = ['message' => 'Service name already taken.', 'errors' => $error];
            return response($data, 422);
        }

        $sanitized = $request->getSanitized();
        // Update changed values Service
        $service->update($sanitized);

        // update whats included in the service panel
        if ($request->newwhatsincluded && !empty($request->newwhatsincluded)) {
            $service->serviceInclusion()->delete();
            $service->serviceInclusion()->createMany($this->getIncludedData($request->newwhatsincluded, $service->id));
        }
        if ($request->ajax()) {
            return [
                'redirect' => url('admin/services'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }
    }

    private function getIncludedData($newWhatsIncluded, $service_id)
    {
        $return_data = [];
        foreach ($newWhatsIncluded as $singleWhatsIncluded) {
            $return_data[] = [
                'name' => $singleWhatsIncluded['whatsincluded'],
                'service_id' => $service_id,
                'created_at' => Carbon::now()
            ];
        }
        return $return_data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyService $request
     * @param Service $service
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyService $request, Service $service)
    {
        $service->delete();
        $deleteService = ServiceInclusion::where('service_id', $service->id)->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyService $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyService $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Service::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function view_cont(Service $service)
    {

        $include = ServiceInclusion::where('service_id', $service->id)->get();

        $service->whatsincluded = $include;
        $counted = $include->count();
        $service_categories = ServiceCategory::get();
        $dataPre = json_encode(array_merge(['serviceCategory' => $service->service_categories], json_decode($service, true)));
        return view('admin.service.view ', [
            'newinc' => $include,
            'service' => $service,
            'serviceCategory' =>  $service_categories,
            'mode' => 'edit',
            'dataPre' => $dataPre,
            'counted' => $counted
        ]);
    }
}
