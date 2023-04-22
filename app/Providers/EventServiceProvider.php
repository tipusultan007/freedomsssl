<?php

namespace App\Providers;

use App\Models\DailyCollection;
use App\Models\DailyLoan;
use App\Models\SavingsCollection;
use App\Observers\DailyCollectionObserver;
use App\Observers\DailyLoanObserver;
use App\Observers\SavingsCollectionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /*DailyCollection::observe(DailyCollectionObserver::class);
        SavingsCollection::observe(SavingsCollectionObserver::class);
        DailyLoan::observe(DailyLoanObserver::class);*/
    }
}
