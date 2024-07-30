<?php

namespace Modules\Ai\Drivers;
abstract class AiDriver
{

    protected $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    abstract function generate($message, $options = []);
}
