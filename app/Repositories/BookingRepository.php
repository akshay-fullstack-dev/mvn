<?php

namespace App\Repositories;

use App\Enum\BookingEnum;
use App\Models\Booking;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IBookingRepository;
use Carbon\Carbon;

class BookingRepository extends GenericRepository implements IBookingRepository
{
    public function model()
    {
        return Booking::class;
    }
    public function checkVendorBookings(array $booking_dates, $vendor_id, object $vendor_service, $exclude_booking_id = null)
    {
        $booking_time = explode(':', $vendor_service->time);
        foreach ($booking_dates as $date) {
            $vendor_bookings = $this->model->where(['vendor_id' => $vendor_id]);
            $booking_start_time_with_traveling_time = Carbon::parse($date)->addMinutes(-BookingEnum::vendorTravellingTime);
            $booking_end_time_with_travelling_time = Carbon::parse($booking_start_time_with_traveling_time)
                ->addHours($booking_time[0])
                ->addMinutes($booking_time[1]);
            // $booking_time_with_traveling_time = Carbon::parse($date)->addMinutes(BookingEnum::vendorTravellingTime);
            $vendor_bookings->where(function ($query) use ($booking_start_time_with_traveling_time, $booking_end_time_with_travelling_time) {
                $query->where(function ($query) use ($booking_start_time_with_traveling_time) {
                    $query->where('booking_start_time', '<=', $booking_start_time_with_traveling_time)->where('booking_end_time', '>=', $booking_start_time_with_traveling_time);
                });
                $query->orWhere(function ($query) use ($booking_end_time_with_travelling_time) {
                    $query->where('booking_start_time', '<=', $booking_end_time_with_travelling_time)->where('booking_end_time', '>=', $booking_end_time_with_travelling_time);
                });
            });
            if ($exclude_booking_id != null) {
                $vendor_bookings->where('id', '!=', $exclude_booking_id);
            }
            $vendor_bookings = $vendor_bookings->notIncludedCancelledAndRejectedBookings()->get();
            if ($vendor_bookings->count() > 0) {
                return $date;
            }

            unset($vendor_bookings);
        }
        return false;
    }

    // public function getActive

    public function getBookingWithDetails($where, $item_per_page, $date = null, $booking_status = null)
    {
        $booking_details = $this->model->where($where)->with(['service', 'booking_payment', 'booking_status_history']);
        if ($date != null) {
            $booking_details->whereDate('booking_start_time', '=', $date);
        }

        // add booking filters according to requested booking types
        if (!is_null($booking_status)) {
            if ($booking_status == BookingEnum::UpcomingVendorBookingRequest) {
                $booking_details->upcomingBookings();
            }
            if ($booking_status == BookingEnum::BookingCompletedOrCancelledRequest) {
                $booking_details->completedOrCancelledBookings();
            }

            if ($booking_status == BookingEnum::VendorBookingRequests) {
                $booking_details->requestedBookings();
            }
            if ($booking_status == BookingEnum::BookingVendorOngoingJobRequest) {
                $booking_details->ongoingBookings();
            }
        }
        return $booking_details->latestBookings()->paginate($item_per_page);
    }

    public function getBooking($where, $single_booking = true)
    {
        $bookings = $this->model->where($where)->with(['service', 'booking_payment', 'booking_status_history']);
        if ($single_booking) {
            $bookings =  $bookings->first();
        } else {
            $bookings = $bookings->get();
        }
        return $bookings;
    }
    public function getVendorOngoingBookings($vendor_id)
    {
        return $this->model->where('vendor_id', $vendor_id)->with('customer_details')->ongoingBookings()->get();
    }
    public function getRequestedService($where)
    {
        return $this->model->where($where)->requestedBookings()->first();
    }
    public function getActiveBooking($where)
    {
        return $this->model->where($where)->activeVendorService()->first();
    }

    public function checkOtherActiveBooking($vendor_id, $booking_id)
    {
        return $this->model->where('vendor_id', $vendor_id)->ongoingBookings()->where('id', '!=', $booking_id)->get();
    }
    public function cancelAvailableBooking($where)
    {
        return $this->model->where($where)->cancelableBookings()->first();
    }
    public function getAllCompletedBookings($auth_vendor, $vendorCompletedBookingRequest)
    {
        return $auth_vendor->vendor_bookings()->completedBookings()->whereDate('booking_start_time', '>=', $vendorCompletedBookingRequest->start_date)->whereDate('booking_start_time', '<=', $vendorCompletedBookingRequest->end_date)->get();
    }

    //get user all registered purchased packages from booking's table using auth id
    public function getAllUserBookPackages($id)
    {

        return $this->model->where('user_id', $id)
            ->where('package_id', '!=', 0)
            ->with(
                'packages.package_services.service',
                'booking_vehicle',
                'booking_bills',
                'booking_vendor',
                'booking_payment',
                'booking_status_history',
                'customer_details'
            )->paginate(1);
    }

    public function updateBooking($where, $data)
    {
        return $this->model->where($where)->update($data);
    }
}
