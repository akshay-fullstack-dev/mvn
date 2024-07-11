<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserDocument\BulkDestroyUserDocument;
use App\Http\Requests\Admin\UserDocument\DestroyUserDocument;
use App\Http\Requests\Admin\UserDocument\IndexUserDocument;
use App\Http\Requests\Admin\UserDocument\StoreUserDocument;
use App\Http\Requests\Admin\UserDocument\UpdateUserDocument;
use App\Models\UserDocument;
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

class UserDocumentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexUserDocument $request
     * @return array|Factory|View
     */
    public function index(IndexUserDocument $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(UserDocument::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'document_name', 'document_number', 'front_image', 'back_image', 'document_type', 'document_status', 'message'],

            // set columns to searchIn
            ['id', 'document_name', 'document_number', 'front_image', 'back_image', 'message']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.user-document.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.user-document.create');

        return view('admin.user-document.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserDocument $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreUserDocument $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the UserDocument
        $userDocument = UserDocument::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/user-documents'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/user-documents');
    }

    /**
     * Display the specified resource.
     *
     * @param UserDocument $userDocument
     * @throws AuthorizationException
     * @return void
     */
    public function show(UserDocument $userDocument)
    {
        $this->authorize('admin.user-document.show', $userDocument);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UserDocument $userDocument
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(UserDocument $userDocument)
    {
        $this->authorize('admin.user-document.edit', $userDocument);


        return view('admin.user-document.edit', [
            'userDocument' => $userDocument,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserDocument $request
     * @param UserDocument $userDocument
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateUserDocument $request, UserDocument $userDocument)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values UserDocument
        $userDocument->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/user-documents'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/user-documents');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUserDocument $request
     * @param UserDocument $userDocument
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyUserDocument $request, UserDocument $userDocument)
    {
        $userDocument->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyUserDocument $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyUserDocument $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    UserDocument::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
