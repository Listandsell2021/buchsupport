<?php

namespace App\CommandProcess\Admin\Administrator;


use App\Helpers\Config\ContractDocConfig;
use App\Services\Admin\AdminService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadAdminCommissionDocumentHandler implements Handler
{
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @throws ValidationException
     */
    public function handle(Command $command)
    {
        $commission = $this->adminService->getCommissionById($command->commissionId);


        if (!$commission) {
            throw ValidationException::withMessages(['commission_id' => trans('Admin commission not found')]);
        }

        $filePath = Storage::path(getAdminCommissionStorageRelativePath($commission->document));

        if (!File::exists($filePath)) {
            throw ValidationException::withMessages(['commission_id' => trans('Admin commission file not found')]);
        }

        return response()->download($filePath, $commission->document);
    }
}
