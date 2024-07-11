<?php

namespace App\Repositories\Interfaces;

interface IReferralPriceRepository extends IGenericRepository
{
  public function get_referral_amount();
}
