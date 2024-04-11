<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CleanStorageFolders extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:storage_folders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean storage folders';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        File::cleanDirectory(storage_path('app/public/user_profile'));
        $this->info('User profile storage cleared');

        /*File::cleanDirectory(storage_path('app/public/products'));
        $this->info('Products storage cleared');*/

        File::cleanDirectory(storage_path('app/lead_contracts'));
        $this->info('Lead contracts storage cleared');

        File::cleanDirectory(storage_path('app/lead_documents'));
        $this->info('Lead documents storage cleared');

        File::cleanDirectory(storage_path('app/customer_contracts'));
        $this->info('Customer contract storage cleared');

        File::cleanDirectory(storage_path('app/order_contracts'));
        $this->info('Order contract storage cleared');

        File::cleanDirectory(storage_path('app/customer_invoices'));
        $this->info('Customer invoice storage cleared');

        File::cleanDirectory(storage_path('app/admin_commissions'));
        $this->info('Admin commission storage cleared');

        File::cleanDirectory(storage_path('app/user_profile'));
        $this->info('User profile storage cleared');

        File::cleanDirectory(storage_path('app/payment_reminders'));
        $this->info('Payment reminder storage cleared');
    }
}
