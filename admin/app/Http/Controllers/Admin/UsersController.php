<?php

namespace App\Http\Controllers\Admin;

use App\Enum\UserEnum;
use App\Http\Controllers\Controller;
use App\Helpers\PushNotificationHelper;
use App\Models\Notification;
use App\Mail\SendEmailNotify;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\User\BulkDestroyUser;
use App\Http\Requests\Admin\User\DestroyUser;
use App\Http\Requests\Admin\User\IndexUser;
use App\Http\Requests\Admin\User\StoreUser;
use App\Http\Requests\Admin\User\UpdateUser;
use App\Models\User;
use App\Models\Media;
use App\Models\UserDocument;
use App\Models\Reason;
use App\Models\UserAddress;
use App\Models\UserTempAddress;
use App\Models\UserTempInfo;
use App\Models\Service;
use App\Models\TempUserDocument;
use App\Models\Booking;
use App\Models\CustomerModel;
use App\Models\UserVehicles;
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

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexUser $request
     * @return array|Factory|View
     */
    public function index(IndexUser $request)
    {
        $request['orderDirection'] = 'desc';
        $url = 'admin/users';
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(User::class)->modifyQuery(function ($query) {
            $query->where('role', '=', 1)->with('userDocuments')->with('userServices');
        })->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'last_name', 'email', 'email_verified_at', 'phone_number', 'country_iso_code', 'is_blocked', 'admin_user', 'account_status', 'country_code', 'created_at'],

            // set columns to searchIn
            ['id', 'first_name', 'last_name', 'email', 'phone_number', 'country_iso_code', 'country_code']
        );


        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        $showButton = true;
        foreach ($data as $da) {
            if ($da->admin_user == 1) {
                $showButton = false;
                break;
            }
        }
        return view('admin.user.index', ['data' => $data, 'showButton' => $showButton, 'role' => 'admin', 'url' => $url]);
    }

    public function customerIndex(IndexUser $request)
    {

        $request['orderDirection'] = 'desc';
        $url = 'admin/customer';
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CustomerModel::class)->modifyQuery(function ($query) {
            $query->where('role', '=', 2)->with('userDocuments')->with('userServices');
        })->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'last_name', 'email', 'email_verified_at', 'phone_number', 'country_iso_code', 'is_blocked', 'admin_user', 'account_status', 'country_code', 'created_at'],

            // set columns to searchIn
            ['id', 'first_name', 'last_name', 'email', 'phone_number', 'country_iso_code', 'country_code']
        );


        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        $showButton = true;
        foreach ($data as $da) {
            if ($da->admin_user == 1) {
                $showButton = false;
                break;
            }
        }
        // echo '<pre>';
        // print_r($data->toJson());
        // echo '</pre>';
        // exit();
        return view('admin.user.index', ['data' => $data, 'showButton' => $showButton, 'role' => 'customer', 'url' => $url]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.user.create');

        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreUser $request)
    {
        $adminUser = User::where([
            'admin_user' => '1',
        ])->first();

        if ($adminUser == null) {
            $sanitized = $request->getSanitized();
            $sanitized['admin_user'] = '1';
            $sanitized['role'] = '1';
            $sanitized['account_status'] = '2';
            // Store the User
            $no_of_address = Count($request->city);

            $user = User::create($sanitized);


            if (!empty($request->city) && !empty($request->country) && !empty($request->formatted_address[0])) {
                for ($i = 0; $i < count($request->type); $i++) {
                    UserAddress::updateOrCreate(
                        ['user_id' => $user->id, 'type' => $request->type[$i]],
                        ['city' => $request->city[$i], 'country' => $request->country[$i], 'formatted_address' => $request->formatted_address[$i]['formatted_address'], 'additional_info' => $request->additional_info[$i], 'latitude' => $request->latitude[$i]['latitude'], 'longitude' => $request->longitude[$i]['longitude']]
                    );
                }
            }

            //update  doc Number in media table
            Media::where([
                'model_type' => 'App\Models\User',
                'model_id' => $user->id,
                'collection_name' => 'licence',
            ])->update(['doc_number' => $request->docNumber]);

            //for licence
            $licenceData = Media::where([
                'model_type' => 'App\Models\User',
                'model_id' => $user->id,
                'collection_name' => 'licence',
            ])->get();

            $i = 1; //i used for cehcking whether the image is first or second

            foreach ($licenceData as $licence) {
                if ($i == 1) //if first the image is front image
                {
                    UserDocument::updateOrCreate(
                        ['user_id' => $user->id, 'document_type' => 1, 'document_name' => $licence->collection_name],
                        ['front_image' => $licence->file_name, 'document_number' => NULL, 'document_status' => 1, 'message' => 'admin user', 'document_number' => $licence->doc_number]
                    );
                } else //if seocnd the image is back image
                {
                    UserDocument::updateOrCreate(
                        ['user_id' => $user->id, 'document_type' => 1, 'document_name' => $licence->collection_name],
                        ['back_image' => $licence->file_name]
                    );
                }
                $i++;
            }

            //for eduction
            $education = Media::where([
                'model_type' => 'App\Models\User',
                'model_id' => $user->id,
                'collection_name' => 'education',
            ])->get();

            UserDocument::updateOrCreate(
                ['user_id' => $user->id, 'document_type' => 2, 'front_image' => $education['0']->file_name],
                ['document_name' => $education['0']->collection_name, 'document_number' => NULL, 'document_status' => 1, 'message' => 'admin user']
            );


            //for other
            $other = Media::where([
                'model_type' => 'App\Models\User',
                'model_id' => $user->id,
                'collection_name' => 'other',
            ])->get();

            UserDocument::updateOrCreate(
                ['user_id' => $user->id, 'document_type' => 3, 'front_image' => $other['0']->file_name],
                ['document_name' => $other['0']->collection_name, 'document_number' => NULL, 'document_status' => 1, 'message' => 'admin user']
            );
        } else {
        }



        if ($request->ajax()) {
            return ['redirect' => url('admin/users'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @throws AuthorizationException
     * @return void
     */
    public function show(User $user)
    {
        $this->authorize('admin.user.show', $user);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(User $user)
    {
        $this->authorize('admin.user.edit', $user);


        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateUser $request, User $user)
    {

        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values User
        $user->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/users'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUser $request
     * @param User $user
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyUser $request, User $user)
    {
        $user->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyUser $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyUser $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    User::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function block(Request $req)
    {
        $user = User::find($req->userid);

        $res_done = Reason::updateOrCreate(
            ['user_id' => $req->userid, 'type' => 1],
            ['reason' => $req->reason]
        );

        $b_done = $user->update(['is_blocked' => 1]);

        if ($b_done && $res_done) {
            $notification_title = trans('message.block', ['name' => 'Account']);
            $notification_description = trans('message.desc_block', ['vendor' => $user->first_name]);
            // Mail::to($user->email)->send(new SendEmailNotify($notification_description));
            PushNotificationHelper::send(0, $user->id, $notification_title, $notification_description, Notification::generalNotification);
            return redirect('/admin/users');
        }
    }

    public function approve(Request $req)
    {
        $user = User::find($req->approveid);
        $delete = 0;
        $insert = 0;

        if (isset($req->approve)) {
            $document = User::find($user->id)->tempDoc;
            $address = User::find($user->id)->tempAdd;
            $info = User::find($user->id)->tempInfo;
            $reason = User::find($user->id)->reasons;
            if (!empty($document['0'])) {
                $del = UserDocument::where('user_id', $user->id)->delete();
            };
            foreach ($document as $data) {
                $insert = UserDocument::updateOrCreate(
                    ['user_id' => $data->user_id, 'document_type' => $data->document_type],
                    ['document_name' => $data->document_name, 'document_number' => $data->document_number, 'front_image' => $data->front_image, 'back_image' => $data->back_image, 'document_type' => $data->document_type, 'document_status' => 1, 'message' => $data->message]
                );

                $delete = DB::table('temp_user_documents')->delete($data->id);
            }
            if (!empty($reason['0'])) {
                $add_delete = Reason::where('user_id', $user->id)->where('type', 2)->delete();
            };
            if (!empty($address['0'])) {
                foreach ($address as $data) {
                    $add_done = UserAddress::updateOrCreate(
                        ['user_id' => $data->user_id, 'type' => $data->type],
                        ['city' => $data->city, 'country' => $data->country, 'formatted_address' => $data->formatted_address, 'additional_info' => $data->additional_info, 'latitude' => $data->latitude, 'longitude' => $data->longitude]
                    );
                    $add_delete = UserTempAddress::where('user_id', $user->id)->delete();
                }
            };
            if (!empty($info['0'])) {
                $info_done = User::where('id', $user->id)->update(['first_name' => $info[0]->first_name, 'last_name' => $info[0]->last_name]);
                $info_delete = UserTempInfo::where('user_id', $user->id)->delete();
            };
            //User verified and approved
            $done = $user->update([
                'account_status' => 2
            ]);
            if ($delete || $insert || $done) {
                $notification_title = trans('message.title_approve', ['name' => 'Account']);
                $notification_description = trans('message.desc_approve', ['name' => 'account', 'vendor' => $user->first_name]);
                // Mail::to($user->email)->send(new SendEmailNotify($notification_description));
                PushNotificationHelper::send(0, $user->id, $notification_title, $notification_description, Notification::generalNotification);
                return redirect('/admin/users');
            }
        }
    }
    public function reject(Request $req)
    {

        $user = User::find($req->rejectid);
        $document = User::find($user->id)->tempDoc;
        $address = User::find($user->id)->tempAdd;
        $info = User::find($user->id)->tempInfo;
        $res_done = Reason::updateOrCreate(
            ['user_id' => $req->rejectid, 'type' => 2],
            ['reason' => $req->reason]
        );

        if (!empty($document['0'])) {
            TempUserDocument::where('user_id', $user->id)->delete();
        }
        if (!empty($address['0'])) {
            UserTempAddress::where('user_id', $user->id)->delete();
        }
        if (!empty($info['0'])) {
            UserTempInfo::where('user_id', $user->id)->delete();
        }
        $done = $user->update(['account_status' => 3]);
        if ($done) {

            $notification_title = trans('message.title_reject', ['name' => 'Account']);
            $notification_description = trans('message.desc_reject', ['name' => 'account', 'vendor' => $user->first_name]);
            // Mail::to($user->email)->send(new SendEmailNotify($notification_description));
            PushNotificationHelper::send(0, $user->id, $notification_title, $notification_description, Notification::generalNotification);
            return redirect('/admin/users');
        }
    }
    public function viewDetails(User $user)
    {

        $data = User::find($user->id);
        $document = User::find($user->id)->tempDoc;
        $address = User::find($user->id)->tempAdd;
        $info = User::find($user->id)->tempInfo;
        $orgAddress = User::find($user->id)->userAddresses;
        return view('admin.user.details', ['data' => $data, 'document' => $document, 'address' => $address, 'info' => $info, 'orgAddress' => $orgAddress]);
    }
    public function showReason(User $user)
    {
        $data = User::find($user->id);
        $reason = User::find($user->id)->reasons;
        return view('admin.user.showreason', ['data' => $data, 'reason' => $reason]);
    }
    public function showDocument(User $user)
    {
        $data = User::find($user->id);
        $doc = User::find($user->id)->userDocuments;
        return view('admin.user.showDocument', ['data' => $data, 'document' => $doc]);
    }
    public function enrollService(User $user)
    {
        $serviceList = array();
        $data = User::find($user->id);
        $userService = User::find($user->id)->userServices;
        $serviceList = Service::whereIn('id', $userService->pluck('service_id'))->get();
        return view('admin.user.enrollService', ['data' => $data, 'services' => $serviceList]);
    }

    public function bookings(User $user)
    {
        $booking = Booking::where('vendor_id', '=', $user->id)->get();

        return view('admin.user.booking', [
            'booking' => $booking,
        ]);
    }

    public function userBookings(User $user)
    {
        if ($user->role == UserEnum::user_vendor)
            $booking = Booking::where('vendor_id', '=', $user->id)->with('service', 'customer_details')->get();
        else
            $booking = Booking::where('user_id', '=', $user->id)->with('service', 'customer_details')->get();
        return view('admin.user.booking', compact('booking'));
    }

    public function userVehicles(User $user)
    {
        $vehicles = UserVehicles::where('user_id', '=', $user->id)->with('vehicle.vehicle_company')->get();

        return view('admin.user.vehicles', [
            'vehicles' => $vehicles,
        ]);
    }
}
