<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Category;


class CategoryreportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $data = Category::where('created_by', \Auth::user()->creatorId())->get();

        foreach ($data as $k => $Category) {


            $datas = [];
            $datas['start_date'] = '';
            $datas['end_date'] = '';
            $datas['branch_id'] = '-1';
            $datas['cash_register_id'] = '-1';
            $datas['category_id'] = $Category->id;

            $datas = Category::getProductCategoryAnalysis($datas);



            unset($Category->created_by, $Category->updated_at, $Category->created_at, $Category->slug);


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
            "Profit/Loss"
        ];
    }
}