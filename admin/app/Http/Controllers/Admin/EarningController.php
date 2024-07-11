<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPayment;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EarningController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSparePartsShopLocation $request
     * @return array|Factory|View
     */
    public function index(Request $request)
    {
        $request->start_date = $request->start_date ? Carbon::parse($request->start_date)->format("Y-m-d") : Carbon::now()->addDays(-60)->format("Y-m-d");
        $request->end_date = $request->end_date ? Carbon::parse($request->end_date)->format("Y-m-d") : Carbon::now()->format("Y-m-d");
        $graph_booking_data = [];
        $total_earned_amount = 0;
        $completed_bookings = Booking::whereDate('booking_start_time', '>=', $request->start_date)->whereDate('booking_end_time', "<=", $request->end_date)->completedBookings()->with('payment')->orderBy('booking_start_time', 'ASC')->get();
        if (!$completed_bookings->count() > 0) {
            return view('admin.my-earning.index', compact('graph_booking_data', 'request', 'total_earned_amount'));
        }
        foreach ($completed_bookings as $booking) {
            $booking_date = Carbon::parse($booking->booking_start_time)->format('d M Y');
            if (isset($graph_booking_data[$booking_date])) {
                $amount_to_add = $booking->payment->basic_service_charge_received_by_admin + $booking->payment->delivery_charge_received_by_vendor + $booking->payment->spare_part_price;
                $graph_booking_data[$booking_date]
                    += $amount_to_add;
                $total_earned_amount += $amount_to_add;
            } else {
                $amount_to_add = $booking->payment->basic_service_charge_received_by_admin + $booking->payment->delivery_charge_received_by_vendor + $booking->payment->spare_part_price;
                $graph_booking_data[$booking_date] = $amount_to_add;
                $total_earned_amount += $amount_to_add;
            }
        }
        return view('admin.my-earning.index', compact('graph_booking_data', 'request', 'total_earned_amount'));
    }
}
