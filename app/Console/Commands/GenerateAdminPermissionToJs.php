<?php

namespace App\Console\Commands;

use App\DataHolders\Enum\AdminPermission;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateAdminPermissionToJs extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin_permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Permission Js';


    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissions = AdminPermission::onlyNames();
        $filePath = "../buchspa/storage/data/AdminPermissions.js";

        $this->makeDirectory($filePath);
        $this->files->put(base_path($filePath), 'export default '.json_encode($permissions, JSON_PRETTY_PRINT));

        $this->info('File generated!');
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname(base_path($path)))) {
            $this->files->makeDirectory(dirname(base_path($path)), 0755, true, true);
        }

        return $path;
    }


}
