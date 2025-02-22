<?php

use App\Models\Menu;

function addDays($numOfDays, $date = null)
{
    $date = $date ? strtotime($date) : time();
    return date('Y-m-d', strtotime("+$numOfDays days", $date));
}

function subDays($numOfDays, $date = null)
{
    $date = $date ? strtotime($date) : time();
    return date('Y-m-d', strtotime("-$numOfDays days", $date));
}
function numOfDay($date)
{
    return date('d', strtotime($date));
}
function numOfMonth($date)
{
    return date('m', strtotime($date));
}
function numOfYear($date)
{
    return date('Y', strtotime($date));
}
function getDay($date)
{
    return date('l', strtotime($date));
}
function getMonth($date)
{
    return date('F', strtotime($date));
}
function getYear($date)
{
    return date('Y', strtotime($date));
}
function currentDate()
{
    return date('Y-m-d');
}
function timeStamp($date = null)
{
    $date = $date ? strtotime($date) : time();
    return  strtotime($date);
}
function currentTimeStamp()
{
    return date('Y-m-d H:i:s');
}
function dateFormat($date)
{
    return date('d F, Y', strtotime($date));
}
function dateFormatForDatabase($date)
{
    return date('Y-m-d', strtotime($date));
}
function dateForForm($date)
{
    return date('d-m-Y', strtotime($date));
}
function time24HoursFormat($time)
{
    return date('H:i:s', strtotime($time));
}
function time12HoursFormat($time)
{
    return date('h:i:s A', strtotime($time));
}
function logTime($time)
{
    return date('h:i A', strtotime($time));
}
function dateTime($date)
{
    return date('d F,Y h:i A', strtotime($date));
}
function dayWithDate($date)
{
    return date('d F, Y, l', strtotime($date));
}
function getActiveMenuClass($routeName)
{
    return (url()->full() == route($routeName ?? '')) ? 'active' : '';
}

function getYesNoBadge($status)
{
    return ($status == 'Active') ? 'badge-success text-dark' : 'badge-danger text-dark';
}
function getYesNoColor($status)
{
    return ($status == 'Active') ? 'text-success' : 'text-danger';
}

function getStatusBadge($status)
{
    if ($status == 'Active')
        return 'badge-success ';
    if ($status == 'Inactive')
        return 'badge-warning';
    if ($status == 'Deleted')
        return 'badge-danger ';
}


function getStatusText($status)
{
    if ($status == 'Active') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Inactive') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-yellow-300 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Deleted') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Pending') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Approved') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Rejected') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'In') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Out') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Present') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Absent') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">' . $status . '</span>';
    } elseif ($status == 'Backward') {
        return '<span class="px-2 py-1 text-xs font-semibold text-white rounded-full bg-amber-500">' . $status . '</span>';
    } else {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-gray-500 rounded-full">' . $status . '</span>';
    }
}
function yesNoTextWithBadge($status)
{
    if ($status == 1) {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Yes</span>';
    } elseif ($status == 0) {
        return '<span class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">No</span>';
    }
}

function getLinkLabel($linkText = null, $icon = null, $class = null)
{
    return '<span title="' . $linkText . '" class="' . $class . '  " >' . $icon . ' ' . $linkText . '</span>';
}

function getStatusChangeBtn($status)
{
    if ($status == 'Active')
        return 'btn-secondary ';
    if ($status == 'Inactive')
        return 'btn-success';
}
function getApproveBtn()
{
    return 'btn-success';
}
function getRejectBtn()
{
    return 'btn-danger';
}
function getApproveIcon()
{
    return 'check-circle';
}
function getRejectIcon()
{
    return 'x-circle';
}
function getStatusChangeIcon($status)
{
    return ($status == 'Active') ? "x-circle" : "check-circle";
}
function priceFormat($amount)
{
    return number_format($amount, 2);
}

function getDaysNumber()
{
    return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
}
function getRandomColor()
{
    return '#' . substr(str_shuffle("0123456789ABCDEF"), 0, 6);
}

function regeneratePagination($datas, $total, $perPage, $currentPage)
{
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
        $datas,
        $total,
        $perPage,
        $currentPage,
        ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
    );


    $query = request()->query();

    $paginator->appends($query);

    return $paginator;
}


function getDataFrom($datas)
{
    return ($datas->currentPage() - 1) * $datas->perPage() + 1;
}

function getDataTo($datas)
{
    return min(getDataFrom($datas) + $datas->perPage() - 1, $datas->total());
}

function rowClass($key)
{
    return (($key % 2) ? "even-row" : "odd-row");
}

function imageNotFound()
{
    return asset('/app-assets/images/no-image.png');
}

function getSideMenus()
{
    return Menu::with('childrens')
        ->whereNull('deleted_at')
        ->where('status', 'Active')
        ->whereNull('parent_id')
        ->orderBy('sorting', 'asc')
        ->selectRaw('id,name,icon,route,permission_name')
        ->get();
}


function successResponse($message, $redirectUrl = null)
{
    if ($redirectUrl) {
        return redirect()->route($redirectUrl)->withSuccess($message);
    } else {
        return back()->withSuccess($message);
    }
}

function errorResponse($message, $redirectUrl = null)
{
    if ($redirectUrl) {
        return redirect()->route($redirectUrl)->withErrors($message);
    } else {
        return back()->withErrors($message);
    }
}

function warningResponse($message, $redirectUrl = null)
{
    if ($redirectUrl) {
        return redirect()->route($redirectUrl)->withWarning($message);
    } else {
        return back()->withWarning($message);
    }
}

function getPermissionName($value)
{
    return str_replace('-', ' ', strtolower($value));
}
function monthList()
{
    return [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];
}

function yearsBetween($minYear, $maxYear)
{
    $years = [];

    for ($year = $minYear; $year <= $maxYear; $year++) {
        $years[] = $year;
    }
    return $years;
}

function camelCaseToSmallLetters($words)
{
    return strtolower(preg_replace_callback('/(?<!\b)[A-Z]/', function ($match) {
        return '_' . strtolower($match[0]);
    }, $words));
}

function camelCaseToUpperLetters($str)
{
    return ucfirst(str_replace(['_', '-'], '', lcfirst(ucwords($str, '_-'))));
}

function camelCaseVariable($string)
{
    $words = explode(' ', ucwords(strtolower($string)));
    $firstWord = array_shift($words);
    return lcfirst($firstWord) . implode('', $words);
}

function camelCase($str) {
    return lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $str))));
}
