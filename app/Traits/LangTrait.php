<?php

namespace App\Traits;

use Symfony\Component\CssSelector\Exception\InternalErrorException;

trait LangTrait
{
	private function getMessage($message, $additional_data = [])
	{
		if (!isset($this->lang))
			throw new InternalErrorException('language file not found');
		return trans($this->lang . '.' . $message, $additional_data);
	}
}
