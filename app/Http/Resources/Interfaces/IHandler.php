<?php

namespace App\Http\Resources\Interfaces;

interface IHandler
{
	public function transformModel($content);
}
