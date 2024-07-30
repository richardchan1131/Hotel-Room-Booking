<?php

namespace Modules\Ai\Exceptions;

class APIReachLimit extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct("API_REACH_LIMIT", $code, $previous);
    }
}
