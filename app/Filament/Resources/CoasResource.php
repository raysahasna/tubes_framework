<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\CoasResource\Pages;
use App\Models\Coas;
use Illuminate\Database\Eloquent\Builder;

class CoasResource extends Resource
{
    protected static ?string $model = Coas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'COA';
    protected static ?string $pluralLabel = 'Chart of Accounts';
    protected static ?string $slug = 'coas'; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        TextInput::make('header_akun')
                            ->nullable()
                            ->maxLength(255)
                            ->placeholder('Masukkan header akun'),
                        
                        TextInput::make('kode_akun')
                            ->required()
                            ->placeholder('Masukkan kode akun')
                            ->unique('coas', 'kode_akun'), // Unik di tabel COAs

                        TextInput::make('nama_akun')
                            ->required()
                            ->label('Nama Akun')
                            ->placeholder('Masukkan nama akun')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('header_akun')
                    ->label('Header Akun')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('kode_akun')
                    ->label('Kode Akun')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('nama_akun')
                    ->label('Nama Akun')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoas::route('/'),
            'create' => Pages\CreateCoas::route('/create'),
            'edit' => Pages\EditCoas::route('/{record}/edit'),
        ];
    }
}
