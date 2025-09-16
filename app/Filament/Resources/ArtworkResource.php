<?php

namespace App\Filament\Resources;

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

class ArtworkResource extends Resource
{
    protected static ?string $model = Artwork::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
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
                Tables\Columns\IconColumn::make('prepressstage')
                    ->boolean(),
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
                //
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
