<?php

namespace App\Enum;

class BookingEnum
{
	const SecondInOneHour = 3600;
	// Booking payment enums
	const BooingAmountPaid = 1;
	const BooingAmountNotPaid = 0;

	// vendor Booking traveling time
	const vendorTravellingTime = 30;

	const BookingConfirmed = 0;
	const VendorAssignedOrVendorAccepted = 1;
	const VendorOutForService = 2;
	const VendorStartedJob = 3;
	const VendorJobFinished = 4;
	const bookingCancelled = 5;
	const bookingRejected = 6;
	const VendorReachedLocation = 7;

	// booking type
	const NormalBooking = 0;
	const PackageBooking = 1;

	// admin booking commission in percentage
	const AdminBookingCommission = 12;
	const adminDeliveryCommission = 5; // in percentage


	// const BookingVendorRequest = 0;
	const UpcomingVendorBookingRequest = 0;
	const BookingVendorOngoingJobRequest = 1;
	const BookingCompletedOrCancelledRequest = 2;
	const VendorBookingRequests = 3;

	// DELIVERY CHARGES PRICE
	const DEFAULT_DELIVERY_CHARGES = 10;

	// booking actions
	const AcceptBooking = 1;
	const RejectBooking = 2;

	// payment mene refund status
	const PaymentNotRefunded = 0;
	const PaymentRefunded = 1;

	// payment settled status
	const PaymentSettled = 1;
	const PaymentNotSettled = 0;

	// booking half refund time
	const MinimumBookingTimeForRefundInHours = 2;

	// booking payment status
	const PaymentNotPending = 0;
	const PaymentPending = 1;

	const Maximum_time_difference_for_booking = 2;

	const BOOKING_CANCEL_CRONE_TIME_IN_MINUTES = 120;

	//reschedule minimum difference between booking time and reschedule time
	const RescheduleMinimumTimeInHours = 2;

	const DEFAULT_BOOKING_DISTANCE = 1;



	const FREE_DELIVERY_FOR_PACKAGE=0;
}
