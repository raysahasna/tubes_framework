<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianBahanBakuResource\Pages;
use App\Filament\Resources\PembelianBahanBakuResource\RelationManagers;
use App\Models\BahanBaku;
use App\Models\PembelianBahanBaku;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembelianBahanBakuResource extends Resource
{
    protected static ?string $model = PembelianBahanBaku::class;

    protected static ?string $navigationGroup = 'Transaksi'; // <-- ini mengelompokkannya

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart'; // atau ikon sesuai keinginan

    protected static ?string $navigationLabel = 'Pembelian Bahan Baku'; // label menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_nota')
    ->label('No. Nota/Surat Jalan/Faktur')
    ->default(PembelianBahanBaku::generateNoFakturPembelian())
    ->required()
    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_transaksi')
                    ->label('Tanggal Transaksi')
                    ->required(),
                Forms\Components\Select::make('supplier_id')
                    ->label('Nama Supplier')
                    ->relationship('supplier', 'nama_supplier')
                    ->searchable()
                    ->preload()
                    ->required(),
                Repeater::make('detailPembelian')
                    ->label('Detail Pembelian')
                    ->schema([
                        Select::make('bahan_baku_id')
                            ->label('Nama Barang')
                            ->options(BahanBaku::all()->pluck('nama', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $bahanBaku = BahanBaku::find($state);
                                if ($bahanBaku) {
                                    $set('harga_satuan', $bahanBaku->harga);
                                    $set('satuan', $bahanBaku->satuan);
                                } else {
                                    $set('harga_satuan', null);
                                    $set('satuan', null);
                                }
                            }),
                        TextInput::make('qty')
                            ->label('Qty')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->reactive()
                            ->afterStateUpdated(function ($get, $set) {
                                $set('total', $get('qty') * $get('harga_satuan'));
                            }),
                        TextInput::make('satuan')
                            ->label('Satuan')
                            ->disabled(),
                        TextInput::make('harga_satuan')
                            ->label('Harga (Rp.)')
                            ->disabled(),
                        TextInput::make('total')
                            ->label('Total (Rp.)')
                            ->disabled(),
                    ])
                    ->addActionLabel('Tambah Item')
                    ->deleteAction(function (\Filament\Forms\Components\Actions\Action $action) {
                        return $action->label('Hapus Item');
                    })
                    ->orderable()
                    ->defaultItems(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_nota')
                    ->label('No. Nota')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_transaksi')
                    ->label('Tanggal Transaksi')
                    ->date()
                    ->sortable(),
                TextColumn::make('supplier.nama_supplier')
                    ->label('Nama Supplier')
                    ->searchable()
                    ->sortable(),
                // Kita akan menampilkan detail pembelian sebagai JSON untuk kesederhanaan di tabel
                // Anda bisa membuat Relation Manager jika ingin tampilan yang lebih interaktif
                TextColumn::make('detailPembelian')
                    ->label('Detail Pembelian')
                    ->formatStateUsing(fn ($state): string => json_encode($state, JSON_PRETTY_PRINT))
                    ->wrap(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListPembelianBahanBakus::route('/'),
            'create' => Pages\CreatePembelianBahanBaku::route('/create'),
            'edit' => Pages\EditPembelianBahanBaku::route('/{record}/edit'),
        ];
    }
}