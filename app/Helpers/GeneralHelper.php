<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class GeneralHelper
{
    public static function getAppName(): string
    {
        $appName = config("app.name") ?? "";
        $formattedAppName = Str::of($appName)->replace("_", " ");
        return ucwords($formattedAppName);
    }
}
