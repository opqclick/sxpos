<?php

namespace App\Exports;

use App\Models\Sale;
use App\Models\Tax;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaletaxreportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $data = Sale::where('created_by', \Auth::user()->creatorId())->get();
        foreach ($data as $k => $Sale) {

            $datas = [];
            $datas['start_date'] = '';
            $datas['end_date'] = '';
            $datas['branch_id'] = '-1';
            $datas['cash_register_id'] = $Sale->cash_register_id;
            $datas['customer_id'] = $Sale->customer_id;

            $datas = Tax::getProductSaleTaxAnalysis($datas);



            $customername = Sale::customers($Sale->customer_id);

            unset($Sale->created_by, $Sale->updated_at, $Sale->invoice_id, $Sale->customer_id, $Sale->branch_id, $Sale->cash_register_id, $Sale->status);

            $data[$k]["name"] = $customername;
            $data[$k]["Product Tax"] = $datas['totalSaledTaxAmount'];
            $data[$k]["Grand Total"] = $datas['totalSaledSubTotal'];


        }
        return $data;


    }
    public function headings(): array
    {
        return [
            "Reference No",
            "Date",
            "Customer",
            "Product Tax",
            "Grand Total"
        ];

    }
}