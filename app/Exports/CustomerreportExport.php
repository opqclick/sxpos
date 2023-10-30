<?php

namespace App\Exports;

use App\Models\Customer;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Sale;


class CustomerreportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        //
        $data = Customer::where('created_by', \Auth::user()->creatorId())->get();

        foreach ($data as $k => $Customer) {

            $Sale = Sale::where('customer_id', $Customer->id)->get()->pluck('id');



            $datas = [];

            $datas['start_date'] = '';
            $datas['end_date'] = '';
            $datas['branch_id'] = '-1';
            $datas['cash_register_id'] = '-1';
            $datas['customer_id'] = $Customer->id;

            $datas = Customer::getCustomerSalesAnalysis($datas);

            unset($Customer->created_by, $Customer->updated_at, $Customer->created_at, $Customer->id, $Customer->address, $Customer->city, $Customer->state, $Customer->country, $Customer->zipcode, $Customer->is_active);

            $data[$k]["Total Sales"] = $datas['totalSoldQuantity'];
            $data[$k]["Total Amount"] = $datas['totalSoldPrice'];
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