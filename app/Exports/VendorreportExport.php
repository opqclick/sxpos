<?php

namespace App\Exports;

use App\Models\Vendor;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class VendorreportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $data = Vendor::where('created_by', \Auth::user()->creatorId())->get();

        foreach ($data as $k => $vendor) {
            $purchase = Purchase::where('vendor_id', $vendor->id)->get()->pluck('id');


            $datas = [];

            $datas['start_date'] = '';
            $datas['end_date'] = '';
            $datas['branch_id'] = '-1';
            $datas['cash_register_id'] = '-1';
            $datas['vendor_id'] = $vendor->id;

            $datas = Vendor::getVendorPurchasedAnalysis($datas);
         
            unset($vendor->created_by, $vendor->updated_at, $vendor->created_at, $vendor->id, $vendor->address, $vendor->city, $vendor->state, $vendor->country, $vendor->zipcode, $vendor->is_active);
            $data[$k]["Total Sales"] = $datas['totalPurchasedQuantity'];
            $data[$k]["Total Amount"] = $datas['totalPurchasedPrice'];
        }

        return $data;
    }
    public function headings(): array
    {
        return [
            "Name",
            "Email Address",
            "Phone Number",
            "Total Sales",
            "Total Amount"
        ];

    }
}