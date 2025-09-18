<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\ArtworkResource\Pages;
use App\Filament\Resources\ArtworkResource\RelationManagers;
use App\Models\Artwork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class ArtworkResource extends Resource
{
    protected static ?string $model = Artwork::class;

     protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Artworks';
 
    // Enable global search for this resource
       protected static bool $isGloballySearchable = true;
    
    // Define the main attribute to display in search results
    protected static ?string $recordTitleAttribute = 'description';

    public static function getGloballySearchableAttributes(): array
    {
        // Only include actual database columns, not accessors
        return ['description', 'remark', 'awstatus', 'type'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Order' => $record->order?->orderno ?? 'No Order',
            'Customer' => $record->order?->customer?->name ?? 'No Customer',
            'Status' => $record->awstatus,
            'Priority' => $record->priority,
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }

    // Modify the global search query to include relationships and search in related tables
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        $query = parent::getGlobalSearchEloquentQuery()->with(['order', 'order.customer']);

        // Add search capability for related tables
        $query->orWhereHas('order', function (Builder $query) {
            $query->where('orderno', 'like', '%' . request('search') . '%');
        });

        $query->orWhereHas('order.customer', function (Builder $query) {
            $query->where('name', 'like', '%' . request('search') . '%');
        });

        return $query;
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('artworks_order_id')
                    ->relationship('order', 'orderno')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('requiredqty')
                    ->numeric()
                    ->default(null),
                // Forms\Components\TextInput::make('jobrun')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('labelrepeat')
                //     ->numeric()
                //     ->default(null),
                Forms\Components\TextInput::make('printedqty')
                    ->numeric()
                    ->default(null),
                // Forms\Components\TextInput::make('media_id')
                //     ->numeric()
                //     ->default(null),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('awstatus')
                    ->required(),
                Forms\Components\Toggle::make('prepressstage'),
                // Forms\Components\TextInput::make('type'),
                Forms\Components\TextInput::make('priority')
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->maxLength(2048)
                    ->default(null),
                // Forms\Components\TextInput::make('artworktechnameID')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('artworks_media_id')
                //     ->numeric()
                //     ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('Done')
                    ->boolean(),
             Tables\Columns\TextColumn::make('description')
                ->searchable()
                ->limit(50)
                ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                    $state = $column->getState();
                    return strlen($state) > 50 ? $state : null;
                }),
              Tables\Columns\TextColumn::make('order_no')
                    ->label('Order No')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('order', function (Builder $query) use ($search) {
                            $query->where('orderno', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('artworks_order_id', $direction);
                    }),
                Tables\Columns\TextColumn::make('requiredqty')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('printedqty')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('remark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('awstatus'),
                
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('priority'),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                
            ])->defaultSort('updated_at', 'desc')
             ->striped()

            ->filters([
                  SelectFilter::make('prepressstage')
                    ->options([
                        '1' => 'Completed',
                        '0' => 'Pending',
                    ])
                    ->label('Prepress Stage')
                    ->attribute('prepressstage'),
                     SelectFilter::make('priority')
                ->options([
                    '1' => 'High',
                    '2' => 'Medium',
                    '3' => 'Low',
                    // Add more options if you have more priority levels
                ])
                ->label('Priority'),
                // ... any other filters you might have ...
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
            'index' => Pages\ListArtworks::route('/'),
            'create' => Pages\CreateArtwork::route('/create'),
            'view' => Pages\ViewArtwork::route('/{record}'),
            'edit' => Pages\EditArtwork::route('/{record}/edit'),
        ];
    }
}
