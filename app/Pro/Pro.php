<?php

namespace App\Pro;

final class Pro
{
    public static function isPro()
    {
        return defined('BC_IS_PRO') and BC_IS_PRO;
    }

    public static function isEnable()
    {
        return config('pro.enable');
    }

}
