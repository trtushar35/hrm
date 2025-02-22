<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class LibraryService
{
    protected $icons =  [
        "activity" => "<i data-feather='activity'></i>",
        "airplay" => "<i data-feather='airplay'></i>",
        "alert-circle" => "<i data-feather='alert-circle'></i>",
        "alert-octagon" => "<i data-feather='alert-octagon'></i>",
        "alert-triangle" => "<i data-feather='alert-triangle'></i>",
        "align-center" => "<i data-feather='align-center'></i>",
        "align-justify" => "<i data-feather='align-justify'></i>",
        "align-left" => "<i data-feather='align-left'></i>",
        "align-right" => "<i data-feather='align-right'></i>",
        "anchor" => "<i data-feather='anchor'></i>",
        "aperture" => "<i data-feather='aperture'></i>",
        "archive" => "<i data-feather='archive'></i>",
        "arrow-down-circle" => "<i data-feather='arrow-down-circle'></i>",
        "arrow-down-left" => "<i data-feather='arrow-down-left'></i>",
        "arrow-down-right" => "<i data-feather='arrow-down-right'></i>",
        "arrow-down" => "<i data-feather='arrow-down'></i>",
        "arrow-left-circle" => "<i data-feather='arrow-left-circle'></i>",
        "arrow-left" => "<i data-feather='arrow-left'></i>",
        "arrow-right-circle" => "<i data-feather='arrow-right-circle'></i>",
        "arrow-right" => "<i data-feather='arrow-right'></i>",
        "arrow-up-circle" => "<i data-feather='arrow-up-circle'></i>",
        "arrow-up-left" => "<i data-feather='arrow-up-left'></i>",
        "arrow-up-right" => "<i data-feather='arrow-up-right'></i>",
        "arrow-up" => "<i data-feather='arrow-up'></i>",
        "at-sign" => "<i data-feather='at-sign'></i>",
        "award" => "<i data-feather='award'></i>",
        "bar-chart-2" => "<i data-feather='bar-chart-2'></i>",
        "bar-chart" => "<i data-feather='bar-chart'></i>",
        "battery-charging" => "<i data-feather='battery-charging'></i>",
        "battery" => "<i data-feather='battery'></i>",
        "bell-off" => "<i data-feather='bell-off'></i>",
        "bell" => "<i data-feather='bell'></i>",
        "bluetooth" => "<i data-feather='bluetooth'></i>",
        "bold" => "<i data-feather='bold'></i>",
        "book-open" => "<i data-feather='book-open'></i>",
        "book" => "<i data-feather='book'></i>",
        "bookmark" => "<i data-feather='bookmark'></i>",
        "box" => "<i data-feather='box'></i>",
        "briefcase" => "<i data-feather='briefcase'></i>",
        "calendar" => "<i data-feather='calendar'></i>",
    ];

    public function icons()
    {
        return $this->icons;
    }

    public function addAndListRoutes()
    {

        $routes = Route::getRoutes();

        $routeKeywords = ['index', 'create'];

        $filteredRoutes = [];
        foreach ($routes as $route) {
            $name = $route->getName();
            foreach ($routeKeywords as $keyword) {
                if (strpos($name, $keyword) !== false) {
                    $filteredRoutes[] = [
                        'name' => $name,
                        'methods' => $route->methods(),
                        'uri' => $route->uri(),
                        'action' => $route->getAction(),
                    ];
                    break;
                }
            }
        }
        return $filteredRoutes;
    }

    public function maritalStatuses()
    {
        return ['Single', 'Married', 'Divorced', 'Widowed'];
    }
    public function bloodGroups()
    {
        return ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    }
    public function genders()
    {
        return ['Male', 'Female', 'Other'];
    }

    public function getDataTypes()
    {
        return ['String', 'Decimal', 'Integer', 'UnsignedBigInteger', 'BigInteger', 'TinyInteger', 'Boolean','Enum','Image','File','Date','Time','DateTime',];
    }
}
