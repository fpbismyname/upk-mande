<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class GeneralHelper
{
    public static $pagination = 5;
    public static function getAppName($type = null): string
    {
        $appName = config("app.name") ?? "";
        $formattedAppName = Str::of($appName)->replace(["_", "-"], " ")->ucfirst()->toString();
        if ($type === 'welcome') {
            $description = "Selamat datang di $formattedAppName.";
            return $description;
        }
        if ($type === 'desc') {
            $description = "Unit Pengelolaan Kegiatan - Kecamatan Mande";
            return $description;
        }
        return $formattedAppName;
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
    public static function Replace($value, $beforeReplace, $afterReplace)
    {
        return Str::of($value)->replace($beforeReplace, $afterReplace)->ucfirst();
    }
    public static function Equals($value, $contains)
    {
        return $value === $contains;
    }
    public static function formatDate($value)
    {
        return Carbon::parse($value)->format('d/M/y h:i');
    }
    public static function formatPersentage($value)
    {
        return "$value%";
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
    public static function formatRupiah($value)
    {
        return "Rp " . number_format($value, 0, ',', '.');
    }
    public static function routeAction($routeName, $id, $action)
    {
        if ($action) {
            return !$routeName ?: route("$routeName.$action", [GeneralHelper::SnakeCase($routeName) => $id]);
        }
        return !$routeName ?: route("$routeName.$action");
    }
}
