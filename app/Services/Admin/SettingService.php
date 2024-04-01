<?php

namespace App\Services\Admin;

use App\Models\Setting;
use Illuminate\Support\Collection;

class SettingService
{

    public function getAll()
    {
        return Setting::all();
    }


    /**
     * Update Setting
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function update(string $key, string $value)
    {
        Setting::where('key', $key)->update(['value' => $value]);
    }

    /**
     * Get Setting Keys
     *
     * @return Collection
     */
    public function getSettingKeys(): Collection
    {
        return Setting::select('key')->get()->pluck('key');
    }


}
