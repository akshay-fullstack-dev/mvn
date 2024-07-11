<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PushNotificationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Dispute\BulkDestroyDispute;
use App\Http\Requests\Admin\Dispute\DestroyDispute;
use App\Http\Requests\Admin\Dispute\IndexDispute;
use App\Http\Requests\Admin\Dispute\StoreDispute;
use App\Http\Requests\Admin\Dispute\UpdateDispute;
use App\Models\Dispute;
use App\Models\Notification;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DisputesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDispute $request
     * @return array|Factory|View
     */
    public function index(IndexDispute $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Dispute::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'booking_id', 'user_id', 'message', 'ticket_id', 'is_resolved', 'responsed_message', 'responsed_at'],

            // set columns to searchIn
            ['id', 'message','ticket_id']
        );
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.dispute.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.dispute.create');

        return view('admin.dispute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDispute $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDispute $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Dispute
        $dispute = Dispute::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/disputes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/disputes');
    }

    /**
     * Display the specified resource.
     *
     * @param Dispute $dispute
     * @throws AuthorizationException
     * @return void
     */
    public function show($dispute_id)
    {
        $dispute = Dispute::with(['booking', 'user'])->find($dispute_id);
        $this->authorize('admin.dispute.show', $dispute);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Dispute $dispute
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit($dispute_id)
    {
        $dispute = Dispute::with(['booking.booking_vendor', 'booking.customer_details', 'user',])->find($dispute_id);
        $this->authorize('admin.dispute.edit', $dispute);

        return view('admin.dispute.edit', [
            'dispute' => $dispute,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDispute $request
     * @param Dispute $dispute
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDispute $request, Dispute $dispute)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Dispute
        $dispute->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/disputes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/disputes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDispute $request
     * @param Dispute $dispute
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDispute $request, Dispute $dispute)
    {
        $dispute->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDispute $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDispute $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Dispute::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function changeStatus(Request $request, Dispute $dispute)
    {
        $resolve_status = $request->is_resolved ?? false;
        $dispute->is_resolved = $resolve_status;
        $dispute->save();
        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    public function changeResolveStatusStatus(Request $request)
    {
        $dispute = Dispute::findOrFail($request->despute_id);

        if ($request->status) {
            $dispute->is_resolved = $request->status;
            $notification_title = trans('dispute.dispute_success_notification_changes_title');
            $notification_description = trans('dispute.dispute_success_notification_changes_description');
            //  Mail::to($email)->send(new SendEmailNotify($notification_description));
            PushNotificationHelper::send(0, $dispute->user_id, $notification_title, $notification_description, Notification::disputeNotification);
        } else {
            $dispute->is_resolved = $request->status;
        }
        $dispute->responsed_message = $request->message;
        $dispute->responsed_at = Carbon::now();
        $dispute->save();

        return  redirect(url('admin/disputes'));
    }
}
