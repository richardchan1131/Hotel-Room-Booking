<?php
function isPro()
{
    if (class_exists('\App\Pro\Pro')) {
        return \App\Pro\Pro::isPro();
    }
    return false;
}

function isProEnable()
{
    if (class_exists('\App\Pro\Pro')) {
        return \App\Pro\Pro::isEnable();
    }
    return false;
}

function proVersion()
{
    return config('pro.version');
}
