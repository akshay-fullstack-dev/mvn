<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReferralAmount\BulkDestroyReferralAmount;
use App\Http\Requests\Admin\ReferralAmount\DestroyReferralAmount;
use App\Http\Requests\Admin\ReferralAmount\IndexReferralAmount;
use App\Http\Requests\Admin\ReferralAmount\StoreReferralAmount;
use App\Http\Requests\Admin\ReferralAmount\UpdateReferralAmount;
use App\Models\ReferralAmount;
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

class ReferralAmountsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexReferralAmount $request
     * @return array|Factory|View
     */
    public function index(IndexReferralAmount $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ReferralAmount::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'referral_amount'],

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

        return view('admin.referral-amount.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.referral-amount.create');

        return view('admin.referral-amount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReferralAmount $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreReferralAmount $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ReferralAmount
        $referralAmount = ReferralAmount::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/referral-amounts'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/referral-amounts');
    }

    /**
     * Display the specified resource.
     *
     * @param ReferralAmount $referralAmount
     * @throws AuthorizationException
     * @return void
     */
    public function show(ReferralAmount $referralAmount)
    {
        // $this->authorize('admin.referral-amount.show', $referralAmount);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReferralAmount $referralAmount
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ReferralAmount $referralAmount)
    {
        // $this->authorize('admin.referral-amount.edit', $referralAmount);


        return view('admin.referral-amount.edit', [
            'referralAmount' => $referralAmount,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReferralAmount $request
     * @param ReferralAmount $referralAmount
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateReferralAmount $request, ReferralAmount $referralAmount)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ReferralAmount
        $referralAmount->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/referral-amounts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/referral-amounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyReferralAmount $request
     * @param ReferralAmount $referralAmount
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyReferralAmount $request, ReferralAmount $referralAmount)
    {
        $referralAmount->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyReferralAmount $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyReferralAmount $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ReferralAmount::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
