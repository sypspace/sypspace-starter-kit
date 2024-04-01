<?php

namespace App\Livewire;

use Jeffgreco13\FilamentBreezy\Livewire\TwoFactorAuthentication;

class TwoFactorAuthenticationComponent extends TwoFactorAuthentication
{
    protected string $view = "livewire.my-profile.two-factor-authentication-component";

    public static $sort = 3;

}
