<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\OrderStatsWidget;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->label('Export Excel')
                ->color('success')
                ->exports([
                    ExcelExport::make('table')->fromTable(),
                    ExcelExport::make('all')->fromModel(),
                ]),
        ];
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            OrderStatsWidget::class,
        ];
    }
}

