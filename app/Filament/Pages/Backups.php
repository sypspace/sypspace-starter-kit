<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as PagesBackups;

class Backups extends PagesBackups
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-m-server-stack';
}
