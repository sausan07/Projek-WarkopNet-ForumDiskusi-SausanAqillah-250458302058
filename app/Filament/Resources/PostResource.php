<?php

namespace App\Filament\Resources;


use App\Filament\Resources\PostResource\Pages\ManagePosts;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\SelectFilter;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleOvalLeftEllipsis;
    
    protected static ?string $navigationLabel = 'Posts/Replies';
    
    protected static ?string $modelLabel = 'Post/Reply';
    
    protected static ?string $pluralModelLabel = 'Posts/Replies';
    
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //ambil relasi "user" dan menampilkan field "username"
                Select::make('user_id')
                    ->label('Username')
                    ->relationship('user', 'username') //ngehubungin ke relasi user
                    ->required()
                    ->searchable()
                    ->preload(),
                //ambil relasi "thread" dan menampilkan title thread
                Select::make('thread_id')
                    ->label('Thread')
                    ->relationship('thread', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),

                //isi postingan
                Textarea::make('content')
                    ->label('Content')
                    ->required()
                    ->rows(5)        //tinggi textarea
                    ->columnSpanFull(), //memenuhi 1 baris form

                //status post
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'deleted' => 'Deleted',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                //id post
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                //username dari relasi user
                TextColumn::make('user.username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),

                //judul thread
                TextColumn::make('thread.title')
                    ->label('Thread')
                    ->limit(40) //batasi panjang text
                    ->searchable()
                    ->sortable(),

                //dipotong supaya tidak panjang
                TextColumn::make('content')
                    ->label('Content')
                    ->limit(60)
                    ->searchable()
                    ->wrap(),

                //status dengan warna
                TextColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'deleted',
                    ]),

                //jumlah likes
                TextColumn::make('likes_count')
                    ->label('Likes')
                    ->counts('likes')
                    ->sortable(),
            ])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePosts::route('/'),
        ];
    }
}