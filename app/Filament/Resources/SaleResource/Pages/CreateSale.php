<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Cash;
use App\Models\Product;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
        $product = Product::where('id',$data['product_id'])
        ->first();
        $product->update(['stock' => $product->stock-$data['amount']]);
        $data['total'] = $data['amount'] * (float) $product->price;
        $data['user_id'] = auth()->id();

        $cash = Cash::where('id',1)
        ->first();
        $cash->update(['full_money' => $cash->full_money+$data['total']]);


    return $data;
}
}
