<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;

use Maatwebsite\Excel\Concerns\WithHeadings;

class StockanalysisExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $data = Product::where('created_by', \Auth::user()->creatorId())->get();

        foreach ($data as $k => $Product) {
         
            unset($Product->created_by, $Product->updated_at, $Product->created_at, $Product->slug, $Product->sku, $Product->purchase_price, $Product->sale_price, $Product->description, $Product->tax_id, $Product->unit_id, $Product->category_id, $Product->brand_id, $Product->image, $Product->product_type);



        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "Stock ID",
            "Product Name",
            "Quantity"
        ];

    }
}