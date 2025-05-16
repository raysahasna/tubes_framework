<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BahanbakuResource\Pages;
use App\Filament\Resources\BahanbakuResource\RelationManagers;
use App\Models\Bahanbaku;
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

class BahanbakuResource extends Resource
{
    protected static ?string $model = Bahanbaku::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('id_bahan_baku')
                ->default(fn () => Bahanbaku::getKodebahanbaku()) // Generate ID otomatis
                ->label('ID Bahan Baku')
                ->required()
                ->readonly(),

            TextInput::make('nama')
                ->label('Nama Bahan Baku')
                ->required()
                ->placeholder('Masukkan nama bahan baku'),

            TextInput::make('satuan')
                ->label('satuan')
                ->required()
                ->placeholder('Masukkan satuan'),

            TextInput::make('harga_satuan')
                ->label('harga satuan')
                ->required()
                ->placeholder('Masukkan harga satuan'),

            TextInput::make('stok')
                ->label('stok')
                ->required()
                ->placeholder('Masukkan stok'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id_bahan_baku')
                ->label('ID bahan baku')
                ->searchable(),

            TextColumn::make('nama')
                ->label('Nama Bahan Baku')
                ->searchable(),

            TextColumn::make('satuan')
                ->label('Satuan')
                ->sortable(),

            TextColumn::make('harga_satuan')
                ->label('Harga Satuan')
                ->searchable(),

            TextColumn::make('stok')
                ->label('Stok'),
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
            'index' => Pages\ListBahanbakus::route('/'),
            'create' => Pages\CreateBahanbaku::route('/create'),
            'edit' => Pages\EditBahanbaku::route('/{record}/edit'),
        ];
    }
}
