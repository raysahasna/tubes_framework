<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuplierResource\Pages;
use App\Filament\Resources\SuplierResource\RelationManagers;
use App\Models\Suplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class SuplierResource extends Resource
{
    protected static ?string $model = Suplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('id_suplier')
                ->default(fn () => Suplier::getKodesuplier()) // Generate ID otomatis
                ->label('ID Suplier')
                ->required()
                ->readonly(),

            TextInput::make('nama')
                ->label('Nama Suplier')
                ->required()
                ->placeholder('Masukkan nama Suplier'),

            TextInput::make('no_telp')
                ->label('Nomor Telepon')
                ->required()
                ->mask('9999-9999-9999') // Format nomor telepon
                ->placeholder('Masukkan nomor telepon'),

            TextInput::make('alamat')
                ->label('Alamat')
                ->required()
                ->placeholder('Masukkan alamat'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id_suplier')
                ->label('ID suplier')
                ->searchable(),

            TextColumn::make('nama')
                ->label('Nama Pegawai')
                ->searchable(),

            TextColumn::make('no_telp')
                ->label('No. Telepon'),

            TextColumn::make('alamat')
                ->label('Alamat'),
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
            'index' => Pages\ListSupliers::route('/'),
            'create' => Pages\CreateSuplier::route('/create'),
            'edit' => Pages\EditSuplier::route('/{record}/edit'),
        ];
    }
}
