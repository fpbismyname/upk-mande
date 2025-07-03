<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class GeneralHelper
{
    public static function getAppName(): string
    {
        $appName = config("app.name") ?? "";
        $formattedAppName = Str::of($appName)->replace(["_", "-"], " ")->toString();
        return ucwords($formattedAppName);
    }
    public static function UpperCase($value)
    {
        return Str::of($value)->replace(['-', "_"], ' ')->ucfirst()->toString();
    }
    public static function SnakeCase($value)
    {
        return Str::of($value)->replace(['-', "_"], ' ')->snake()->toString();
    }
    public static function LowerCase($value)
    {
        return Str::of($value)->replace(['-', "_"], ' ')->lower()->toString();
    }
    public static function Contains($value, $contains)
    {
        return Str::of($value)->contains($contains);
    }
    public static function Equals($value, $contains)
    {
        return $value === $contains;
    }
    public static function formatDate($value)
    {
        return Carbon::parse($value)->format('d/M/y h:i');
    }
    public static function isIsoDateString($value)
    {
        return is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $value);
    }
    public static function currentRouteName($type = null)
    {
        if ($type === 'name') {
            return Route::currentRouteName();
        } else {
            return "/" . Route::getCurrentRoute()->uri();
        }
    }
}
