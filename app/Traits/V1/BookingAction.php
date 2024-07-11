<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Booking\BookingDetailsRequest;
use App\Http\Requests\V1\Booking\BookServiceRequest;
use App\Http\Requests\V1\Booking\ChangeBookingStatusRequest;
use App\Http\Requests\V1\Booking\CheckVendorAvailabilityRequest;
use App\Http\Requests\V1\Booking\GetVendorLocationRequest;
use App\Http\Requests\V1\Booking\RescheduleBookingRequest;
use App\Http\Requests\V1\Booking\ServiceActionRequest;
use App\Http\Requests\V1\Booking\VendorBookingDetailsRequest;
use App\Http\Requests\V1\Booking\VendorCompletedBookingRequest;
use App\Http\Requests\V1\Service\UploadBillsRequest;
use App\Services\Interfaces\IBookingServices;
use Illuminate\Http\Request;

trait BookingAction
{
	private $bookingService;

	public function __construct(IBookingServices  $bookingService)
	{
		$this->bookingService = $bookingService;
	}
	public function bookService(BookServiceRequest $request)
	{
		return 	$this->bookingService->bookService($request);
	}
	public function checkVendorAvailability(CheckVendorAvailabilityRequest $request)
	{
		return 	$this->bookingService->checkVendorAvailability($request);
	}

	public function getBookingDetail(BookingDetailsRequest $request)
	{
		return $this->bookingService->getBookingDetail($request);
	}

	public function getBookingHistory(Request $request)
	{
		return $this->bookingService->getBookingHistory($request);
	}
	public function getVendorBookingHistory(VendorBookingDetailsRequest $request)
	{
		return $this->bookingService->getVendorBookingHistory($request);
	}
	public function uploadBills(UploadBillsRequest $request)
	{
		return $this->bookingService->uploadBills($request);
	}
	public function bookingAction(ServiceActionRequest $request)
	{
		return $this->bookingService->bookingAction($request);
	}
	public function changeBookingStatus(ChangeBookingStatusRequest $request)
	{
		return $this->bookingService->changeBookingStatus($request);
	}
	public function getVendorLocation(GetVendorLocationRequest $request)
	{
		return $this->bookingService->getVendorLocation($request);
	}
	public function rescheduleBooking(RescheduleBookingRequest $request)
	{
		return $this->bookingService->rescheduleBooking($request);
	}
	public function getAllCompletedBookings(VendorCompletedBookingRequest $vendorCompletedBookingRequest)
	{
		return $this->bookingService->getAllCompletedBookings($vendorCompletedBookingRequest);
	}

	public function raiseDispute(){
		echo "hello";die;
	}
}
