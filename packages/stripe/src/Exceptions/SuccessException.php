<?php

namespace  IntersoftStripe\Exceptions;

use Exception;
use Throwable;

class SuccessException extends Exception implements Throwable
{
    protected $data;
    protected $statusCode;
    public function __construct(string $message, array $data = [], $statusCode = 0)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }

    public function getData()
    {
        return $this->data;
    }
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
