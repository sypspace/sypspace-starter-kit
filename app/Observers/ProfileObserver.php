<?php

namespace App\Observers;

use App\Enums\Gender;
use App\Models\Profile;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ProfileObserver
{
    /**
     * Handle the Profile "created" event.
     */
    public function created(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "updated" event.
     */
    public function updated(Profile $profile): void
    {
        // Show on bell notification
        Notification::make()
            ->title('Your profile was recently updated.')
            ->success()
            ->sendToDatabase(auth()->user());

        // Flash notification on web
        Notification::make()
            ->title('Profile updated.')
            ->success()
            ->send();
    }

    /**
     * Handle the Profile "deleted" event.
     */
    public function deleted(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "restored" event.
     */
    public function restored(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "force deleted" event.
     */
    public function forceDeleted(Profile $profile): void
    {
        //
    }
}
