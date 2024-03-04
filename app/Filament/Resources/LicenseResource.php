<?php

namespace App\Filament\Resources;

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchase;
use App\Filament\Resources\LicenseResource\Pages;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use function Clue\StreamFilter\fun;

class LicenseResource extends Resource
{
    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $model = License::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ResourceLinkColumn::make(
                    'assignment.user.email', fn (License $record) => route('filament.admin.resources.purchase-assignments.edit', $record->assignment)
                )->searchable(),
                TextColumn::make('key')
                    ->copyable()
                    ->icon('heroicon-o-document-duplicate')
                    ->iconPosition(IconPosition::After)
                    ->searchable(),
                TextColumn::make('satis_authentication_count')->sortable(),
                TextColumn::make('expires_at')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLicenses::route('/'),
            'create' => Pages\CreateLicense::route('/create'),
            'edit' => Pages\EditLicense::route('/{record}/edit'),
        ];
    }
}
