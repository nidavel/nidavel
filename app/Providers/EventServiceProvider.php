<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\PostPublished;
use App\Events\PagePublished;
use App\Events\PostDeleted;
use App\Events\PageDeleted;
use App\Events\PostRestored;
use App\Events\PageRestored;
use App\Listeners\ExportPostPublished;
use App\Listeners\ExportPostsPublished;
use App\Listeners\ExportPagePublished;
use App\Listeners\DeleteExportedPostDeleted;
use App\Listeners\DeleteExportedPageDeleted;
use App\Listeners\UpdateTags;

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
        PostPublished::class => [
            ExportPostPublished::class,
            UpdateTags::class,
            ExportPostsPublished::class
        ],
        PagePublished::class => [
            ExportPagePublished::class
        ],
        PostDeleted::class => [
            DeleteExportedPostDeleted::class
        ],
        PageDeleted::class => [
            DeleteExportedPageDeleted::class
        ],
        PostRestored::class => [
            ExportPostPublished::class
        ],
        PageRestored::class => [
            ExportPagePublished::class
        ],
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
