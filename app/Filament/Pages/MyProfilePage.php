<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Jeffgreco13\FilamentBreezy\Pages\MyProfilePage as MyProfilePageBase;

class MyProfilePage extends MyProfilePageBase
{
    use HasPageShield;
}
