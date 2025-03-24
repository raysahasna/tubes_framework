<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\InputMask;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;



class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_pelanggan')
                ->label('Id Pelanggan')
                ->default(fn () => Pelanggan::getIdPelanggan()) // Ambil default dari method getIdPelanggan                
                ->required()
                ->readonly() // Membuat field menjadi read-only
                ,
                TextInput::make('nama_pelanggan')
                ->label('Nama Pelanggan')
                ->required()
                ->placeholder('Masukkan nama pelanggan') // Placeholder untuk membantu pengguna
            ,
                TextInput::make('no_telepon')
                ->label('No Telepon')
                ->required()
                ->tel() // Format input telepon
                ->placeholder('Masukkan no telepon')
            ,
                TextInput::make('email')
                ->label('Email')
                ->required()
                ->email() // Validasi sebagai email
                ->placeholder('Masukkan email pelanggan')
            ,
                Textarea::make('alamat')
                ->label('Alamat')
                ->required()
                ->placeholder('Masukkan alamat lengkap')
            ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_pelanggan'),
                TextColumn::make('nama_pelanggan'),
                TextColumn::make('no_telepon'),
                TextColumn::make('email'),
                TextColumn::make('alamat')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}