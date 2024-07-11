<?php

namespace App\Repositories;

use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IReferralPriceRepository;
use App\Models\ReferralAmount;

class ReferralPriceRepository extends GenericRepository implements IReferralPriceRepository
{
	public function model()
	{
		return ReferralAmount::class;
	}
	public function get_referral_amount()
	{
		return $this->model->first();
	}
}
