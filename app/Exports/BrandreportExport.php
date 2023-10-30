<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandreportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $data = Brand::where('created_by', \Auth::user()->creatorId())->get();


        foreach ($data as $k => $brand) {

            $datas = [];
            $datas['start_date'] = '';
            $datas['end_date'] = '';
            $datas['branch_id'] = '-1';
            $datas['cash_register_id'] = '-1';
            $datas['brand_id'] = $brand->id;

            $datas = Brand::getProductBrandAnalysis($datas);

            unset($brand->created_by, $brand->updated_at, $brand->created_at, $brand->slug);


            $data[$k]["Purchased Quantity"] = $datas['totalPurchasedQuantity'];
            $data[$k]["Sold Quantity"] = $datas['totalSoldQuantity'];
            $data[$k]["Purchased Price"] = $datas['totalPurchasedPrice'];
            $data[$k]["Sold Price"] = $datas['totalSoldPrice'];
            $data[$k]["Profit/Loss"] = $datas['totalProfitOrLoss'];

        }

        return $data;

    }

    public function headings(): array
    {
        return [
            "Id",
            "Name",
            "Purchased Quantity",
            "Sold Quantity",
            "Purchased Price",
            "Sold Price",
            "Profit/Loss",
        ];

    }
}