<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Produk; // Ensure this matches your model name
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_produk')
                    ->default(fn () => Produk::getKodeProduk())
                    ->label('Kode Produk')
                    ->required()
                    ->readonly(),
                TextInput::make('nama_produk')
                    ->required()
                    ->placeholder('Masukkan Nama Produk'),
                TextInput::make('harga_produk')
                    ->required()
                    ->numeric() // Ensure it's a number
                    ->minValue(0)
                    ->placeholder('Masukkan Harga Produk')
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('harga_produk', number_format((int) str_replace('.', '', $state), 0, ',', '.'))
                    ),
                FileUpload::make('foto')
                    ->directory('foto')
                    ->required(),
                TextInput::make('stok')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('Masukkan Stok Produk'),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(5) // Assume rating is between 0 to 5
                    ->placeholder('Masukkan Rating Produk'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('kode_produk')
                ->label('Kode Produk')
                ->searchable(),
            TextColumn::make('nama_produk')
                ->label('Nama Produk')
                ->searchable()
                ->sortable(),
            TextColumn::make('harga_produk')
                ->label('Harga Produk')
                ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                ->extraAttributes(['class' => 'text-right'])
                ->sortable(),
            ImageColumn::make('foto')
                ->label('Foto')
                ->extraAttributes(['class' => 'img-thumbnail']),
            TextColumn::make('stok')
                ->label('Stok')
                ->formatStateUsing(fn ($state) => $state > 0 ? "✔ $state" : "✖ Habis"),
            TextColumn::make('rating')
                ->label('Rating')
                ->formatStateUsing(fn ($state) => 
                    str_repeat('★', $state) . str_repeat('☆', 5 - $state) . " ($state dari 5)"
                ),
    

            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relationships here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
