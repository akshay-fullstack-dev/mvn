<?php

namespace App\Exceptions\Api_v1;

// namespace App\Exceptions;

use Exception;
use stdClass;

class ResponseHandle extends Exception
{
    public function render($request, Exception $exception)
    {

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 0,
                'message' => trans($this->lang_path . 'un_authorized_action'),
                'data' => new stdClass()
            ], 401);
        }
        return parent::render($request, $exception);
    }
}
