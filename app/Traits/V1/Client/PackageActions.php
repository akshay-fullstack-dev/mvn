<?php

namespace App\Traits\V1\Client;

use App\Http\Requests\V1\ClientRequests\Package\BookPackage;
use App\Http\Requests\V1\ClientRequests\Package\CancelPackageBooking;
use App\Http\Requests\V1\ClientRequests\Package\PackageListRequest;
use App\Services\Interfaces\Client\IPackageServices;
use Request;

trait PackageActions
{
    private $authService;

    public function __construct(IPackageServices $clientService)
    {
        $this->clientService = $clientService;
    }
    public function index(PackageListRequest $packageListRequest)
    {
        return $this->clientService->index($packageListRequest);
    }
    public function bookPackage(BookPackage $bookpackages)
    {

        return $this->clientService->bookPackage($bookpackages);
    }
    public function getUserAllPurchasedPackageList(Request $request)
    {

        return $this->clientService->getUserAllPurchasedPackageList($request);
    }
    public function cancelBooking(CancelPackageBooking $request)
    {
        return $this->clientService->cancelBooking($request);
    }
}
