<?php

use Illuminate\Support\Facades\File;

if (!function_exists('isInProduction')) {
    function isInProduction(): bool
    {
        return config('app.env') == 'production';
    }
}

if (!function_exists('getAuthAdmin')) {
    function getAuthAdmin(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $auth = auth('admin')->user() ?? request()->user();
        return $auth ?? null;
    }
}

if (!function_exists('getAdminId')) {
    function getAdminId(): int
    {
        return getAuthAdmin() ? (int) getAuthAdmin()->id : (request()->user() ? request()->user()->id : 0);
    }
}

if (!function_exists('getAdminRoleId')) {
    function getAdminRoleId(): int
    {
        return getAuthAdmin() ? (int) getAuthAdmin()->role_id : 0;
    }
}

if (!function_exists('isAuthSuperAdmin')) {
    function isAuthSuperAdmin(): bool
    {
        return getAuthAdmin() && getAuthAdmin()->auth_role == \App\DataHolders\Enum\AuthRole::getSuperAdminRole();
    }
}


if (!function_exists('getAdminAuthRole')) {
    function getAdminAuthRole(): string
    {
        return getAuthAdmin() ? getAuthAdmin()->auth_role : '';
    }
}

if (!function_exists('isAuthSalesperson')) {
    function isAuthSalesperson(): bool
    {
        return getAdminAuthRole() == \App\DataHolders\Enum\AuthRole::salesperson->name;
    }
}


if (!function_exists('getPermissionsByAdminRoleId')) {
    function getPermissionsByAdminRoleId()
    {
        $roles = \App\Models\AdminPermission::where('role_id', getAdminId())->get();

        if ($roles->count() == 0) {
            return [];
        }

        return $roles->pluck('permission')->toArray();
    }
}


if (!function_exists('getAuthCustomer')) {
    function getAuthCustomer()
    {
        return auth('web')->user();
    }
}

if (!function_exists('getCustomerId')) {
    function getCustomerId(): int
    {
        return getAuthCustomer() ? (int) getAuthCustomer()->id : 0;
    }
}


if (!function_exists('getAdminPermissions')) {
    function getAdminPermissions($default = [])
    {
        return session('auth_user_permissions', $default);
    }
}

if (!function_exists('setAdminPermissions')) {
    function setAdminPermissions(array $permissions): void
    {
        session()->put('auth_user_permissions', $permissions);
    }
}

if (!function_exists('setAutomaticallyAdminPermissions')) {
    function setAutomaticallyAdminPermissions(): void
    {
        setAdminPermissions(getPermissionsByAdminRoleId());
    }
}

if (!function_exists('hasAdminPermissions')) {
    function hasAdminPermissions(): bool
    {
        return session()->has('auth_user_permissions');
    }
}


if (!function_exists('hasInput')) {
    function hasInput($input)
    {
        return strlen((string) $input) > 0;
    }
}

if (!function_exists('hasArrayInput')) {
    function hasArrayInput($input): bool
    {
        return is_array($input) && count($input) > 0;
    }
}

if (!function_exists('roundNumber')) {
    function roundNumber($number, $precision = 2): float
    {
        return round((float) $number, $precision);
    }
}

if (!function_exists('_dd')) {
    function _dd(...$args)
    {
        if (!headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }
        call_user_func_array('dd', $args);
    }
}

if (!function_exists('getPerPageTotal')) {
    function getPerPageTotal($default = 15)
    {
        $perPage = request()->has('per_page') ? (int) request()->get('per_page') : $default;

        return $perPage > 0 ? $perPage : $default;
    }
}


if (!function_exists('getCurrentDateTime')) {
    function getCurrentDateTime(): string
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('getModelTimestampFormat')) {
    function getModelTimestampFormat(): string
    {
        return config('buch.base_mode_timestamp_format');
    }
}

if (!function_exists('getMailTemplate')) {
    function getMailTemplate(string $path): string
    {
        if (\Illuminate\Support\Facades\File::exists(getMailLayoutStoragePath($path)) && !\Illuminate\Support\Facades\File::isDirectory(getMailLayoutStoragePath($path))) {
            return file_get_contents(getMailLayoutStoragePath($path));
        }
        return '';
    }
}

if (!function_exists('getMailLayoutStoragePath')) {
    function getMailLayoutStoragePath($path = ''): string
    {
        return resource_path('views/mail/dynamic/'.$path);
    }
}


if (!function_exists('arrayGroupBy')) {
    function arrayGroupBy($data, $key): array
    {
        $result = array();
        foreach ($data as $element) {
            $result[$element[$key]][] = $element;
        }
        return $result;
    }
}

if (!function_exists('getCurrentDate')) {
    function getCurrentDate(): string
    {
        return date('Y-m-d');
    }
}

if (!function_exists('getGlobalDate')) {
    function getGlobalDate($date): string
    {
        return date(getGlobalDateFormat(), strtotime($date));
    }
}

if (!function_exists('getDateByLocale')) {
    function getDateByLocale($date = ''): string
    {
        if ($date == '') {
            return date(getLocaleDateFormat());
        }

        return date(getLocaleDateFormat(), strtotime($date));
    }
}

if (!function_exists('getDateInGermany')) {
    function getDateInGermany($date): string
    {
        return date(getGermanDateFormat(), strtotime($date));
    }
}

if (!function_exists('getLocaleDateFormat')) {
    function getLocaleDateFormat(): string
    {
        return isGermanyLocale() ? getGermanDateFormat() : getGlobalDateFormat();
    }
}

if (!function_exists('getGermanDateFormat')) {
    function getGermanDateFormat(): string
    {
        return 'd.m.Y';
    }
}

if (!function_exists('getGlobalDateFormat')) {
    function getGlobalDateFormat(): string
    {
        return 'Y-m-d';
    }
}

if (!function_exists('getLocale')) {
    function getLocale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('isGermanyLocale')) {
    function isGermanyLocale(): string
    {
        return getLocale() == 'de';
    }
}

if (!function_exists('getNumberInGermanFormat')) {
    function getNumberInGermanFormat($number, $decimalPlace = 2): string
    {
        return number_format($number, $decimalPlace, ',', '.');
    }
}

if (!function_exists('trimTrailingZeroes')) {
    function trimTrailingZeroes($nbr) {
        return str_contains($nbr, '.') ? rtrim(rtrim($nbr,'0'),'.') : $nbr;
    }
}

if (!function_exists('getProductCondition')) {
    function getProductCondition($conditionNo): string
    {
        $conditionLabel = '';
        foreach (config('buch.product_conditions') as $condition) {
            if ($condition['value'] === (int)$conditionNo) {
                $conditionLabel = $condition['label'];
            }
        }

        if ($conditionLabel != '') {
            return $conditionLabel;
        }

        return config('buch.product_condition_default');
    }
}


if (!function_exists('getAdminReceiverMail')) {
    function getAdminReceiverMail(): string
    {
        return config('mail.receiver');
    }
}

if (!function_exists('getCustomerInvoiceStorageRelativePath')) {
    function getCustomerInvoiceStorageRelativePath($path = ''): string
    {
        return config('buch.invoice_storage_folder'). ($path !== '' ? '/'.$path : '');
    }
}

if (!function_exists('getCustomerInvoiceStorageAbsolutePath')) {
    function getCustomerInvoiceStorageAbsolutePath($path = ''): string
    {
        return storage_path('app/'). getCustomerInvoiceStorageRelativePath($path);
    }
}

if (!function_exists('getAdminCommissionStorageRelativePath')) {
    function getAdminCommissionStorageRelativePath($path = ''): string
    {
        return config('buch.admin_commission_storage_folder'). ($path !== '' ? '/'.$path : '');
    }
}
if (!function_exists('getAdminCommissionStorageAbsolutePath')) {
    function getAdminCommissionStorageAbsolutePath($path = ''): string
    {
        return storage_path('app/'). getAdminCommissionStorageRelativePath($path);
    }
}

if (!function_exists('getPaymentReminderStorageRelativePath')) {
    function getPaymentReminderStorageRelativePath($path = ''): string
    {
        return config('buch.payment_reminder_storage_folder'). ($path !== '' ? '/'.$path : '');
    }
}

if (!function_exists('getPaymentReminderStorageAbsolutePath')) {
    function getPaymentReminderStorageAbsolutePath($path = ''): string
    {
        return storage_path('app/'). getPaymentReminderStorageRelativePath($path);
    }
}

if (!function_exists('getCustomerUidSpaced')) {
    function getCustomerUidSpaced($customerUid): string
    {
        return chunk_split(trim($customerUid), 4, ' ');
    }
}

if (!function_exists('removeSpace')) {
    function removeSpace(string $string): string
    {
        return trim(str_replace(' ', '', $string));
    }
}

if (!function_exists('getUserIdByUid')) {
    function getUserIdByUid(string $uid): string|null
    {
        $user = \App\Models\User::where('uid', removeSpace($uid))->first();
        return $user ? $user->id : null;
    }
}

if (!function_exists('getCurrencySymbol')) {
    function getCurrencySymbol(): string
    {
        return '&euro;';
    }
}

if (!function_exists('getCompanyLogoUrl')) {
    function getCompanyLogoUrl(): string
    {
        return asset('assets/admin/images/logo.svg');
    }
}

if (!function_exists('getCompanyLogoPath')) {
    function getCompanyLogoPath(): string
    {
        return public_path('assets/admin/images/logo.svg');
    }
}

if (!function_exists('isDate')) {
    function isDate($dateString): bool
    {
        return strtotime($dateString);
    }
}

if (!function_exists('getMonths')) {
    function getMonths(): array
    {
        return (is_array(trans('admin.months')) && count( (array) trans('admin.months') ) > 0) ? (array) trans('admin.months') : (array) config('buch.months');
    }
}

function getInvoiceNo(string $year, int $incrementalNo = 0): string
{
    if ($incrementalNo == 0) {
        $incrementalNo = (new \App\Services\Admin\InvoiceService)->getIncrementalNo($year);
    }

    return $year.sprintf("%05d", $incrementalNo);
}


function getSettingTemplate($template, $strings): string
{
    $keys = [];
    $values = [];
    foreach ($strings as $key => $value) {
        $keys[] = '{'.$key.'}';
        $values[] = $value;
    }

    return str_replace($keys, $values, $template);
}

function getGenderValue($gender): string
{
    if ($gender == \App\DataHolders\Enum\Gender::male->name) {
        return 'Herr';
    }

    if ($gender == \App\DataHolders\Enum\Gender::female->name) {
        return 'Frau';
    }

    return 'Herr';
}


function getCurrencyPrice(float $price, $space = 1): string
{
    return getNumberInGermanFormat($price).($space ? ' ' : '').getCurrencySymbol();
}

function getInvoicePriceWithCharge(float $price): float
{
    return (float) ($price + 10);
}


function getCustomerWithGender(string $gender, string $username): string
{
    return ($gender == \App\DataHolders\Enum\Gender::male ? 'Herrn' : 'Frau').' '.$username;
}

function getCompanyName()
{
    $companyName = \App\Libraries\Settings\Setting::get('company_name');

    return $companyName ?: config('app.name');
}

function createFolderIfNotExist(string $path): void
{
    if (!File::isDirectory($path)) {
        File::makeDirectory($path);
    }
}

function getAdminCommissionNo(string $incrementalNo): string
{
    return getCurrentDate().'__'.\Illuminate\Support\Str::random(4).$incrementalNo;
}

function getCancelledInvoiceNo(string $incrementalNo, string $invoiceNo): string
{
    return $incrementalNo.'_'.$invoiceNo;
}

function getCancelledInvoiceFileName(string $invoiceNo): string
{
    return 'storno_'.$invoiceNo.'.pdf';
}

function getPaymentReminderFileName(string $invoiceNo): string
{
    return 'pr_'.$invoiceNo.'.pdf';
}

function getPaymentWarningFileName(string $invoiceNo): string
{
    return 'pw_'.$invoiceNo.'.pdf';
}


if (!function_exists('getAverageProductCondition')) {
    function getAverageProductCondition($conditionCount): float|int
    {
        return ($conditionCount/5);
    }
}

if (!function_exists('trimUserId')) {
    function trimUserId($userId): string
    {
        return str_replace(' ', '', $userId);
    }
}

if (!function_exists('getProductStorageUrl')) {
    function getProductStorageUrl($media = '')
    {
        return url('/storage').DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$media;
    }
}
if (!function_exists('getDummyImageUrl')) {
    function getDummyImageUrl()
    {
        return url('assets/frontend/images/300_400.png');
    }
}
if (!function_exists('getCustomerLoginUrl')) {
    function getCustomerLoginUrl()
    {
        return url('login');
    }
}

if (!function_exists('getSingleLetterFirstName')) {
    function getSingleLetterFirstName($name)
    {
        $array = explode(" ", (string) $name);
        $lastIndex = (count($array) - 1);
        $new_name = '';
        foreach ($array as $index => $characters) {
            if ($index == $lastIndex) {
                $new_name .= ' '.ucwords(substr($characters, 0, 1)).".";
            } else {
                $new_name = $new_name." ".ucwords($characters);
            }
        }
        return $new_name;
    }
}

if (!function_exists('getAbsoluteInvoiceLogoPath')) {
    function getAbsoluteInvoiceLogoPath(): string
    {
        return public_path('assets/admin/images/invoice_logo.png');
    }
}

if (!function_exists('getFileSizeInKb')) {
    function getFileSizeInKb(int $size): int
    {
        return intval($size/1024);
    }
}


if (!function_exists('getAppName')) {
    function getAppName(): string
    {
        return (string) config('app.name');
    }
}

