<?php

namespace App\Providers;

use App\DataHolders\Enum\AdminPermission;
use App\DataHolders\Enum\AuthRole;
use App\Models\Admin;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        $adminPermissions = AdminPermission::onlyNames();
        foreach ($adminPermissions as $permission) {
            Gate::define($permission, function () use ($permission) {
                return in_array($permission, getAdminPermissions());
            });
        }

    }

}
