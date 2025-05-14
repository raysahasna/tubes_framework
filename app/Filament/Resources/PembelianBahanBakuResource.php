<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianBahanBakuResource\Pages;
use App\Models\PembelianBahanBaku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Select, DatePicker, Repeater, TextInput, Card};
use Filament\Tables\Columns\{TextColumn};
use Illuminate\Support\Collection;

class PembelianBahanBakuResource extends Resource
{
    protected static ?string $model = PembelianBahanBaku::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pembelian Bahan Baku';
    protected static ?string $pluralLabel = 'Pembelian Bahan Baku';
    protected static ?string $navigationGroup = 'Transaksi'; // ✅ agar muncul di grup Transaksi

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make([
                Select::make('vendor_id')
                    ->relationship('vendor', 'nama')
                    ->label('Vendor')
                    ->required()
                    ->searchable(),

                DatePicker::make('tanggal')
                    ->label('Tanggal Pembelian')
                    ->required(),
            ]),

            Card::make([
                Repeater::make('details')
                    ->label('Detail Pembelian')
                    ->relationship()
                    ->schema([
                        Select::make('bahan_baku_id')
                            ->label('Bahan Baku')
                            ->relationship('bahanBaku', 'nama')
                            ->required()
                            ->searchable(),

                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->required(),

                        TextInput::make('harga_satuan')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])
                    ->columns(3)
                    ->required()
                    ->minItems(1),
            ]),

            Card::make([
                TextInput::make('total')
                    ->label('Total Pembelian')
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly()
                    ->dehydrated(true)
                    ->afterStateHydrated(function (callable $set, callable $get) {
                        $details = $get('details') ?? [];
                        $total = collect($details)->sum(fn ($item) =>
                            ($item['jumlah'] ?? 0) * ($item['harga_satuan'] ?? 0)
                        );
                        $set('total', $total);
                    }),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vendor.nama')->label('Vendor'),
                TextColumn::make('tanggal')->label('Tanggal')->date(),
                TextColumn::make('total')->label('Total')->money('IDR'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembelianBahanBakus::route('/'),
            'create' => Pages\CreatePembelianBahanBaku::route('/create'),
            'edit' => Pages\EditPembelianBahanBaku::route('/{record}/edit'),
        ];
    }
}
