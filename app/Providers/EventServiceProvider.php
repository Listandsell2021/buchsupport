<?php

namespace App\Providers;


use App\Events\Admin\LeadNewCustomerRequest;
use App\Events\Admin\LeadNoteAdded;
use App\Events\Admin\LeadStatusUpdated;
use App\Events\Admin\NewLeadsCreated;
use App\Listeners\Admin\CreateNewCustomerRequestNotification;
use App\Listeners\Admin\RegisterLeadNoteAddedActivity;
use App\Listeners\Admin\RegisterLeadStatusUpdatedActivity;
use App\Listeners\Admin\RegisterLeadsCreatedActivity;
use App\Listeners\Admin\SendNewCustomerRequestMailToAdmin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LeadNewCustomerRequest::class => [
            CreateNewCustomerRequestNotification::class,
            SendNewCustomerRequestMailToAdmin::class,
        ],
        NewLeadsCreated::class => [
            RegisterLeadsCreatedActivity::class
        ],
        LeadStatusUpdated::class => [
            RegisterLeadStatusUpdatedActivity::class
        ],
        LeadNoteAdded::class => [
            RegisterLeadNoteAddedActivity::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
