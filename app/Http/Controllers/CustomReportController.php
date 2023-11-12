<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CashRegister;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomReportController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->getCreatedBy();
        $branches = Branch::where('created_by', $user_id)->get();
        $brands = Brand::where('created_by', $user_id)->get();
        return view('reports.custom.index')->with(compact('branches', 'brands'));
    }

    public function showCashRegisterSaleReport(Request $request)
    {
        $branch_id = $request->branch;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $cash_register_id = $request->cash_register;
        $user_id = Auth::user()->getCreatedBy();

        $pm_amounts = [];
        foreach (Sale::PAYMENT_METHODS as $key => $value) {
            $pm_amounts[$key] = 0;
        }

        $sales = Sale::with('items')
            ->where('cash_register_id', $cash_register_id)
            ->where('branch_id', $branch_id)
            ->whereBetween('created_at', [$from_date, $to_date])
            ->get();

        foreach ($sales as $sale) {
            $pm_amounts[$sale->payment_method] += $sale->getTotal();
        }

        $cashier = CashRegister::where('id', $cash_register_id)->first();

        $branches = Branch::where('created_by', $user_id)->get();
        return view('reports.custom.cash_register_sale_report')->with(compact(
            'branch_id',
            'from_date',
            'to_date',
            'branches',
            'cashier',
            'pm_amounts',
            'sales'
        ));
    }


    public function showServiceWiseReport(Request $request)
    {
        $brand_id = $request->brand;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $user_id = Auth::user()->getCreatedBy();

        $product_ids = Product::where('brand_id', $brand_id)->pluck('id')->toArray();

        $sales = Sale::with('items')
            ->whereHas('items', function ($query) use ($product_ids) {
                $query->whereIn('product_id', $product_ids);
            })
            ->whereBetween('created_at', [$from_date, $to_date])
            ->get();

        $number_of_payments = 0;
        $total_amount_of_payments = 0;

        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                if(!in_array($item->product_id, $product_ids)) {
                    continue;
                }
                $subtotal = $item->price * $item->quantity;
                $tax      = ($subtotal * $item->tax) / 100;
                $total_amount_of_payments += $subtotal + $tax;
                $number_of_payments++;
            }
        }

        $branches = Branch::where('created_by', $user_id)->get();
        return view('reports.custom.service_wise_sale_report')->with(compact(
            'from_date',
            'to_date',
            'branches',
            'sales',
            'number_of_payments',
            'total_amount_of_payments'
        ));
    }
}
