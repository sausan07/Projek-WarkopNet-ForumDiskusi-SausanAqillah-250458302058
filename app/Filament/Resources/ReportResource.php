<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages\ManageReports;
use App\Models\Report;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;

    protected static ?string $navigationLabel = 'Reports';

    public static function form(Schema $schema): Schema {

        return $schema
            ->components([
                Textarea::make('reason')
                    ->label('Alasan Pelaporan')
                    ->required()
                    ->disabled()        //admin cm bisa baca, ga bisa edit
                    ->columnSpanFull(),
                
                //mengubah status report
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending')
                    ->helperText('Ubah status report'),
            ]);
    }


    public static function table(Table $table): Table {

        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                
                //username dari relasi user
                TextColumn::make('user.username')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),
                    
                //konten yang dilaporkan
                TextColumn::make('reported_content')
                    ->label('Konten Dilaporkan')

                    //sesuai kondisi
                    ->getStateUsing(function ($record) {

                        //thread
                        if ($record->thread_id && $record->thread) {
                            return '[Thread] ' . Str::limit($record->thread->title, 50);

                        //post/komen
                        } elseif ($record->post_id && $record->post) {
                            return '[Comment] ' . Str::limit($record->post->content, 50);
                        }

                        return '[Kosong]';
                    })

                    //searching tabel lain
                    ->searchable(['threads.title', 'posts.content'])
                    ->wrap(),
                    
                //alasan pelaporan
                TextColumn::make('reason')
                    ->label('Alasan')
                    ->limit(30) //tampilin 30 karakter
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),
                
                //status report
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dilaporkan')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
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
            'index' => ManageReports::route('/'),
        ];
    }
}