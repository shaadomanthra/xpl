<?php

namespace PacketPrep\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use PacketPrep\Policies\UserPolicy;
use PacketPrep\Policies\RolePolicy;
use PacketPrep\Policies\DocsPolicy;
use PacketPrep\User;
use PacketPrep\Models\User\Role;
use PacketPrep\Models\Content\Doc;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Doc::class => DocsPolicy::class,
        \PacketPrep\Models\Content\Chapter::class => \PacketPrep\Policies\ChapterPolicy::class,
        \PacketPrep\Models\System\Update::class => \PacketPrep\Policies\UpdatePolicy::class,
        \PacketPrep\Models\System\Finance::class => \PacketPrep\Policies\FinancePolicy::class,
        \PacketPrep\Models\System\Goal::class => \PacketPrep\Policies\GoalPolicy::class,
        \PacketPrep\Models\System\Report::class => \PacketPrep\Policies\ReportPolicy::class,
        \PacketPrep\Models\Social\Blog::class => \PacketPrep\Policies\BlogPolicy::class,
        \PacketPrep\Models\Social\Social::class => \PacketPrep\Policies\SocialPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
