<?php

namespace App\Filament\Resources\SupplyResource\Pages;

use App\Filament\Resources\SupplyResource;
use App\Models\Cash;
use App\Models\Product;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSupply extends CreateRecord
{
    protected static string $resource = SupplyResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
{
        $product = Product::where('id',$data['product_id'])
        ->first();
        $product->update(['stock' => $product->stock+$data['amount']]);
        $data['total'] = $data['amount'] * (float) ($product->price)-0.30;
        $data['user_id'] = auth()->id();

        $cash = Cash::where('id',1)
        ->first();
        $cash->update(['full_money' => $cash->full_money-$data['total']]);


    return $data;
}
}
