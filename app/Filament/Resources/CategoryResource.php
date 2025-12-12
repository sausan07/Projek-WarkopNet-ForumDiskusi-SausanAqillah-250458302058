<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages\ManageCategories;
use App\Models\Category;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    //model
    protected static ?string $model = Category::class;
    //icon
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;
    //judul
    protected static ?string $recordTitleAttribute = 'name';
    //form create/edit
    public static function form(Schema $schema): Schema {
        return $schema
        ->components([
            //kategori
            TextInput::make('name')
                ->required(),

            //slug kategori
            TextInput::make('slug')
                ->required(),
        ]);
    }
    //nampilin daftar kategori
    public static function table(Table $table): Table 
    {
        return $table
            //title utama
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('name')

            //kolom dalam tabel
            ->columns([
                //kategori
                TextColumn::make('name')
                    ->searchable(), // bisa dicari

                //slug kategori
                TextColumn::make('slug')
                    ->searchable(),

                //tanggal dibuat
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            //hapus satuan
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            //hapus banyk data
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(), 
                ]),
            ]);
    }

    public static function getPages(): array {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }
}
