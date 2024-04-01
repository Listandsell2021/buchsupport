<?php

namespace App\CommandProcess\Admin\Setting;


use App\Services\Admin\SettingService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetSettingsHandler implements Handler
{

    private SettingService $dbService;

    public function __construct(SettingService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $settings = $this->dbService->getAll();

        $newSettings = [];
        foreach ($settings as $setting) {
            $newSettings[$setting->key] = $setting->value;
        }

        return $newSettings;
    }
}
