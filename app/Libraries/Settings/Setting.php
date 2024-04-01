<?php

namespace App\Libraries\Settings;


use Illuminate\Support\Facades\Cache;

class Setting
{
    use Helpers;

    private static string $sessionKey = 'buch_setting';


    /**
     * Setting All
     *
     * @return array
     */
    public static function all(): array
    {
        return Cache::rememberForever(self::$sessionKey, function () {
            $settings = \App\Models\Setting::select('key', 'value')->get();
            $data = [];
            foreach ($settings as $setting) {
                $data[$setting->key] = $setting->value;
            }
            return $data;
        });
    }


    /**
     * Get Setting
     *
     * @param $key
     * @return false|mixed
     */
    public static function get($key): mixed
    {
        return in_array($key, self::all()) ? self::all()[$key] : false;
    }


    /**
     * Set Setting
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value): bool
    {
        if (in_array($key, self::all())) {
            \App\Models\Setting::where('key', $key)->update(['value' => $value]);
            self::reset();
            return true;
        }
        return false;
    }


    /**
     * Setting Reset
     *
     * @return void
     */
    public static function reset(): void
    {
        Cache::delete(self::$sessionKey);
    }


    /**
     * Get Vat Percentage
     *
     * @return float|int
     */
    public static function getVatPercentage(): float|int
    {
        return self::get('vat_percentage') ? self::get('vat_percentage') : config('buch.vat_percentage');
    }


}