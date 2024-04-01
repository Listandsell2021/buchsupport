<?php

namespace App\CommandProcess\Admin\Setting;


use App\DataHolders\Enum\SettingType;
use App\Libraries\Settings\Setting;
use App\Services\Admin\SettingService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateSettingsHandler implements Handler
{
    private SettingService $dbService;

    public function __construct(SettingService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $settings = $this->dbService->getAll();
        $settingKeys = $this->dbService->getSettingKeys();

        foreach ($command->data as $key => $value) {
            if ($settingKeys->contains($key)) {
                $this->dbService->update($key, $this->getValueType($settings, $key, $value));
            }
        }
        Setting::reset();
    }

    private function getValueType($settings, $key, $value): string
    {
        $selectedSetting = null;
        foreach ($settings as $setting) {
            if ($setting->key === $key) {
                $selectedSetting = $setting;
            }
        }

        if ($selectedSetting) {

            if ($selectedSetting->type === SettingType::integer->name) {
                return (int) $value;
            }

            if ($selectedSetting->type === SettingType::float->name) {
                return (float) $value;
            }

            if ($selectedSetting->type === SettingType::boolean->name) {
                return (int) ((bool) $value);
            }

            if ($selectedSetting->type === SettingType::array->name) {
                return json_encode((array) $value, 1);
            }

        }

        return (string) $value;
    }

}
