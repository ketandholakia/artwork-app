<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;


class ArtworksRelationManager extends RelationManager
{
    protected static string $relationship = 'artworks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                
                Action::make('edit')
    ->url(fn (Post $record): string => route('posts.edit', $record))
    ->openUrlInNewTab()

Action::make('delete')
    


                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
