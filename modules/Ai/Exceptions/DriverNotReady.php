<?php

namespace Modules\Ai\Exceptions;

class DriverNotReady extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct("DRIVER_NOT_READY", $code, $previous);
    }


}
