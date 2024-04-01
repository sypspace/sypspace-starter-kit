<?php

namespace App\Livewire;


use App\Enums\Gender;
use App\Models\User;
use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;

use function Filament\Support\is_app_url;

class PersonalInfoComponent extends MyProfileComponent
{
    protected string $view = "livewire.my-profile.personal-info-component";

    public static $sort = 1;

    public ?array $data = [];
 
    public $user;

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();
        
        $this->form->fill($data);
    }

    public function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        
        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Account Detail')
                    ->description('Registered user access used for login.')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required()
                            ->disabledOn('edit')
                            ->helperText('If you have any issues with this email and would like to change it, please contact the Administrator.'),
                    ])
                    ->aside(),
                Section::make('Personal Information')
                    ->description('Manage your personal information.')
                    ->relationship('profile')
                    ->schema([
                        FileUpload::make('avatar_url')
                            ->label('Avatar')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->circleCropper()
                            ->directory('avatars')
                            ->removeUploadedFileButtonPosition('right'),
                        Radio::make('gender')
                            ->options(Gender::class)
                            ->inline()
                            ->inlineLabel(false),
                        DatePicker::make('birthdate'),
                        TextInput::make('phone')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    ])
                    ->aside(),
            ])
            ->operation('edit')
            ->model($this->getUser())
            ->statePath('data');
    }

    public function submit()
    {
        try {
            $data = $this->form->getState();

            $this->handleRecordUpdate($this->getUser(), $data);
            
            // Notification::make()
            //     ->title('Profile updated')
            //     ->success()
            //     ->sendToDatabase($this->getUser());

            $this->redirect('my-profile', navigate: FilamentView::hasSpaMode() && is_app_url('my-profile'));
        } catch (\Throwable $th) {
            Notification::make()
                ->title('Failed to update.')
                ->danger()
                ->send();
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(User $record, array $data): User
    {
        // $profile = array_filter($data['profile']);
        
        // if (is_array($profile))
        //     $record->profile()->associate($profile);

        $record->update($data);
        
        return $record;
    }

}
