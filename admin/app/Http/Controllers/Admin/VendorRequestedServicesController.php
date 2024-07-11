<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\PushNotificationHelper;
use App\Mail\SendEmailNotify;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\VendorRequestedService\BulkDestroyVendorRequestedService;
use App\Http\Requests\Admin\VendorRequestedService\DestroyVendorRequestedService;
use App\Http\Requests\Admin\VendorRequestedService\IndexVendorRequestedService;
use App\Http\Requests\Admin\VendorRequestedService\StoreVendorRequestedService;
use App\Http\Requests\Admin\VendorRequestedService\UpdateVendorRequestedService;
use App\Http\Requests\Admin\VendorRequestedService\emailRequest;
use App\Models\VendorRequestedService;
use App\Models\Service;
use App\Models\User;
use App\Models\Notification;
use App\Models\Vendor_requested_service_inclusion;
use App\Models\ServiceInclusion;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Models\Media;

class VendorRequestedServicesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVendorRequestedService $request
     * @return array|Factory|View
     */
    public function index(IndexVendorRequestedService $request)
    {
        $request['orderDirection'] = 'desc';
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VendorRequestedService::class)->modifyQuery(function ($query) {
            $query->with('user', 'serviceCategory', 'vendorRequestedServiceInclusion')->latest();
        })->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'name', 'description', 'price', 'approx_time', 'service_category_id', 'spare_parts'],

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
        //dd($data);
        //exit;

        return view('admin.vendor-requested-service.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.vendor-requested-service.create');

        return view('admin.vendor-requested-service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVendorRequestedService $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVendorRequestedService $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the VendorRequestedService
        $vendorRequestedService = VendorRequestedService::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/vendor-requested-services'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/vendor-requested-services');
    }

    /**
     * Display the specified resource.
     *
     * @param VendorRequestedService $vendorRequestedService
     * @throws AuthorizationException
     * @return void
     */
    public function show(VendorRequestedService $vendorRequestedService)
    {
        $this->authorize('admin.vendor-requested-service.show', $vendorRequestedService);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VendorRequestedService $vendorRequestedService
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VendorRequestedService $vendorRequestedService)
    {
        $this->authorize('admin.vendor-requested-service.edit', $vendorRequestedService);


        return view('admin.vendor-requested-service.edit', [
            'vendorRequestedService' => $vendorRequestedService,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVendorRequestedService $request
     * @param VendorRequestedService $vendorRequestedService
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVendorRequestedService $request, VendorRequestedService $vendorRequestedService)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values VendorRequestedService
        $vendorRequestedService->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vendor-requested-services'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/vendor-requested-services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVendorRequestedService $request
     * @param VendorRequestedService $vendorRequestedService
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVendorRequestedService $request, VendorRequestedService $vendorRequestedService)
    {
        $vendorRequestedService->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVendorRequestedService $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVendorRequestedService $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VendorRequestedService::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    public function approve(Request $req)
    {
        $serviceData = VendorRequestedService::find($req->service_id);
        $serviceinclude = Vendor_requested_service_inclusion::where('requested_service_id', $req->service_id)->get();
        // $serviceExist=Service::where('name', $serviceData->name)->first();
        $mediaItems = $serviceData->getMedia();
        $serviceDataInsert = Service::create([
            'name' => $serviceData->name,
            'description' => $serviceData->description,
            'image' => 'null',
            'dealer_price' => $serviceData->price ?? 0,
            'service_category_id' => $serviceData->service_category_id,
            'price' => $serviceData->price,
            'approx_time' => $serviceData->approx_time,
            'spare_parts' => $serviceData->spare_parts,
        ]);
        foreach ($serviceinclude as $service) {
            $serviceInclude = ServiceInclusion::create([
                'name' => $service->name,
                'service_id' => $serviceDataInsert->id,
            ]);
            foreach ($serviceinclude as $service) {
                $serviceInclude = ServiceInclusion::create([
                    'name' => $service->name,
                    'service_id' => $serviceDataInsert->id,
                ]);
            }
            // transfer the media
            $mediaItems = $serviceData->getMedia();
            if ($mediaItems->count()) {
                foreach ($mediaItems as $media) {
                    $media->model_id = $serviceDataInsert->id;
                    $media->model_type = Service::class;
                    $media->save();
                }
            }
            $deleteService = VendorRequestedService::where('id', $req->service_id)->delete();
            $deleteInclude = Vendor_requested_service_inclusion::where('requested_service_id', $req->service_id)->delete();

            //user which request for service
            $user = User::where('id', $req->s_user_id)->get();
            $email = $user['0']->email;
            if ($serviceDataInsert) {
                $notification_title = trans('message.service_approve', ['name' => $serviceData->name]);
                $notification_description = trans('message.service_desc_approve', ['name' => $serviceData->name, 'vendor' => $user[0]->first_name]);
                //  Mail::to($email)->send(new SendEmailNotify($notification_description));
                PushNotificationHelper::send(0, $req->s_user_id, $notification_title, $notification_description, Notification::generalNotification);
                return redirect('/admin/vendor-requested-services');
            } else {
                echo "not insert";
            }
        }
    }
    public function disapprove(Request $req)
    {
        $serviceData = VendorRequestedService::where('id', $req->service_id)->get();
        $serviceDelete = VendorRequestedService::where('id', $req->service_id)->delete();
        $deleteInclude = Vendor_requested_service_inclusion::where('requested_service_id', $req->service_id)->delete();
        $user = User::where('id', $req->disapprove_user_id)->get();
        $email = $user['0']->email;
        if ($serviceDelete) {
            $notification_title = trans('message.service_reject', ['name' => $serviceData['0']->name]);
            $notification_description = trans('message.service_desc_reject', ['name' => $serviceData['0']->name, 'vendor' => $user[0]->first_name]);
            //  Mail::to($email)->send(new SendEmailNotify($notification_description));
            PushNotificationHelper::send(0, $req->disapprove_user_id, $notification_title, $notification_description, Notification::generalNotification);
            return redirect('/admin/vendor-requested-services');
        } else {
            return redirect('/admin/vendor-requested-services');
        }
    }
}
