<?php

namespace App\Filament\Resources;

use App\Filament\Exports\KeuanganExporter;
use Filament\Forms;
use Filament\Tables;
use App\Models\Keuangan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KeuanganResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KeuanganResource\RelationManagers;

class KeuanganResource extends Resource
{
    protected static ?string $model = Keuangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        DatePicker::make('tanggal'),
                        Select::make('tipe')
                            ->options([
                                'pemasukan' => 'Pemasukan',
                                'pengeluaran' => 'Pengeluaran'
                            ]),
                        TextInput::make('jumlah')
                            ->numeric(),
                        RichEditor::make('deksripsi')
                            ->label('Deskripsi'),
                        Select::make('kategori_id')
                            ->label('Kategori Keuangan')
                            ->relationship('kategori', 'nama')

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(KeuanganExporter::class)
        ])
            ->columns([
                TextColumn::make('tanggal')->date(),
                TextColumn::make('tipe'),
                TextColumn::make('jumlah')->money('IDR', true),
                TextColumn::make('deksripsi')
                ->label('Deskripsi')
                ->html(),
                TextColumn::make('kategori.nama'),
            ])
            ->filters([
                SelectFilter::make('tipe')
                    ->options([
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran'
                    ])
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
            'index' => Pages\ListKeuangans::route('/'),
            'create' => Pages\CreateKeuangan::route('/create'),
            'edit' => Pages\EditKeuangan::route('/{record}/edit'),
        ];
    }
}
