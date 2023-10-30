<?php

namespace App\Exports;

use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Tax;



use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PurchasetaxreportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //


        $data = Purchase::where('created_by', \Auth::user()->creatorId())->get();
        foreach ($data as $k => $Purchase) {



            $datas = [];
            $datas['start_date'] = '';
            $datas['end_date'] = '';
            $datas['branch_id'] = '-1';
            $datas['cash_register_id'] = $Purchase->cash_register_id;
            $datas['vendor_id'] = $Purchase->vendor_id;

            $datas = Tax::getProductPurchaseTaxAnalysis($datas);
                    
            $vendorname = Purchase::vendors($Purchase->vendor_id);
            unset($Purchase->created_by, $Purchase->updated_at, $Purchase->invoice_id, $Purchase->branch_id, $Purchase->cash_register_id, $Purchase->status, $Purchase->vendor_id);


            $data[$k]["Vendor"] = $vendorname;
            $data[$k]["Product Tax"] = $datas['totalPurchasedTaxAmount'];
            $data[$k]["Grand Total"] = $datas['totalPurchasedSubTotal'];
        }




        return $data;
    }
    public function headings(): array
    {
        return [
            "Reference No",
            "Date",
            "Vendor",
            "Product Tax",
            "Grand Total"
        ];

    }
}