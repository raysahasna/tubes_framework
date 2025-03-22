<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_pegawai')
                    ->default(fn () => Pegawai::getKodePegawai()) // Generate ID otomatis
                    ->label('ID Pegawai')
                    ->required()
                    ->readonly(),

                TextInput::make('nama')
                    ->label('Nama Pegawai')
                    ->required()
                    ->placeholder('Masukkan nama pegawai'),

                TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->required()
                    ->placeholder('Masukkan jabatan'),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->placeholder('Masukkan email'),

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
                TextColumn::make('id_pegawai')
                    ->label('ID Pegawai')
                    ->searchable(),

                TextColumn::make('nama')
                    ->label('Nama Pegawai')
                    ->searchable(),

                TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
