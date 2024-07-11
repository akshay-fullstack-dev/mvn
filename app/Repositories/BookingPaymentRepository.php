<?php

namespace App\Repositories;
use App\Enum\BookingEnum;
use App\Models\BookingPayment;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IBookingPaymentRepository;


class BookingPaymentRepository extends GenericRepository implements IBookingPaymentRepository
{
	public function model()
	{
		return BookingPayment::class;
	}
	
}
