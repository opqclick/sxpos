<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\ProductsReturn;
use App\Models\ReturnedItems;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductreturnExport;
use App\Models\Utility;

class ProductsReturnController extends Controller
{
    public function index()
    {
        $returns = ProductsReturn::where('created_by', Auth::user()->getCreatedBy())
            ->orderBy('id', 'DESC')
            ->get();
        return view('productsreturns.index', compact('returns'));
    }

    public function create()
    {
        $user_id = Auth::user()->getCreatedBy();

        $vendors = Vendor::where('created_by', $user_id)->pluck('name', 'id');
        $vendors->prepend(__('Walk-in Vendors'), 0);
        $vendors->prepend(__('Select Vendor'), '');

        $customers = Customer::where('created_by', $user_id)->pluck('name', 'id');
        $customers->prepend(__('Walk-in Customers'), 0);
        $customers->prepend(__('Select Customer'), '');

        return view('productsreturns.create', compact('vendors', 'customers'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->getCreatedBy();

        $validator = Validator::make(
            $request->all(),
            [
                'date' => 'required|date|after_or_equal:' . date('d-m-Y'),
                'reference_no' => 'required',
                'vendor_id' => 'required',
                'customer_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if ($request->has('product') && $request->has('quantity')) {
            $products   = $request->product;
            $quantities = $request->quantity;

            $pr               = new ProductsReturn();
            $pr->date         = date('Y-m-d', strtotime($request->date));
            $pr->reference_no = $request->reference_no;
            $pr->vendor_id    = $request->vendor_id;
            $pr->customer_id  = $request->customer_id;
            $pr->return_note  = $request->return_note;
            $pr->staff_note   = $request->staff_note;
            $pr->created_by   = $user_id;
            $pr->save();

            if (count($products) == count($quantities)) {
                for ($i = 0; $i < count($products); $i++) {
                    $product_id = $products[$i];
                    $quantity   = (int)$quantities[$i];

                    $product = Product::whereId($product_id)->where('created_by', $user_id)->first();

                    $tax   = ($product->taxes == null) ? 0 : (int)$product->taxes->percentage;
                    $price = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;

                    $original_quantity = ($product == null) ? 0 : (int)$product->quantity;

                    // $product_quantity = $original_quantity - $quantity;

                    if($request->type == 1){

                        $product_quantity = $original_quantity + $quantity;
                    }
                    if($request->type == 2){

                        $product_quantity = $original_quantity - $quantity;
                    }



                    if ($product != null && !empty($product) && $product_quantity >= 0) {
                        Product::where('id', $product_id)->update(['quantity' => $product_quantity]);
                    }

                    $tax_id = Product::tax_id($product_id);

                    $ri             = new ReturnedItems();
                    $ri->return_id  = $pr->id;
                    $ri->product_id = $product_id;
                    $ri->price      = $price;
                    $ri->quantity   = $quantity;
                    $ri->tax_id     = $tax_id;
                    $ri->tax        = $tax;
                    $ri->save();
                }


                $setting  = Utility::settings(\Auth::user()->creatorId());
                if (isset($setting['twilio_return_notification']) && $setting['twilio_return_notification'] == 1) {
                    // $msg = __("New User created by") . ' ' . \Auth::user()->name . '.';
                    
                    // $ret = ReturnedItems::where('return_id', '=', $pr->id)->first();
                    $customer = Customer::where('id', '=', $request->customer_id)->first();
                    $vendor = Vendor::where('id', '=', $request->vendor_id)->first();

                    $uArr = [
                        // 'reference_number' => $request->reference_no,
                        'customer_name' => $customer->name,
                        'vendor_name' => $vendor->name,
                        'return_note' => $request->return_note,
                        'staff_note' => $request->staff_note,
                        'user_name'  => \Auth::user()->name,
                        
                    ];
                    // dd($uArr);
                    if(isset($request->customer_id) && isset($request->vendor_id)){

                        Utility::send_twilio_msg($customer->phone_number,'new_return',$uArr);
                        Utility::send_twilio_msg($vendor->phone_number,'new_return',$uArr);
                    }
                }

                // Webhook
                $module = 'New Return';
                $webhook =  Utility::webhookSetting($module);
                if ($webhook) {
                    $parameter = json_encode($pr);
                    // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                    $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                    if ($status == true) {
                        return redirect()->route('productsreturn.index')->with('success', __('Products returned successfully!'));
                    } else {
                        return redirect()->back()->with('error', __('Webhook call failed.'));
                    }
                }

                return redirect()->route('productsreturn.index')->with('success', __('Products returned successfully.'));
            }
        } else {
            return redirect()->back()->with('error', __('Please add some products!'));
        }
    }

    public function show(ProductsReturn $productsreturn)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(ProductsReturn $productsreturn)
    {
        $user_id = Auth::user()->getCreatedBy();

        $vendors = Vendor::where('created_by', $user_id)->pluck('name', 'id');
        $vendors->prepend(__('Walk-in Vendors'), 0);
        $vendors->prepend(__('Select Vendor'), '');

        $customers = Customer::where('created_by', $user_id)->pluck('name', 'id');
        $customers->prepend(__('Walk-in Customers'), 0);
        $customers->prepend(__('Select Customer'), '');

        if (Auth::user()->can('Edit Returns')) {
            return view('productsreturns.edit', compact('productsreturn', 'vendors', 'customers'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, ProductsReturn $productsreturn)
    {
        $user_id = Auth::user()->getCreatedBy();

        $validator = Validator::make(
            $request->all(),
            [
                'date' => 'required|date|after_or_equal:' . date('d-m-Y'),
                'reference_no' => 'required',
                'vendor_id' => 'required',
                'customer_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }


        if ($request->has('product') && $request->has('quantity')) {
            $products   = $request->product;
            $quantities = $request->quantity;

            $productsreturn->date         = date('Y-m-d', strtotime($request->date));
            $productsreturn->reference_no = $request->reference_no;
            $productsreturn->vendor_id    = $request->vendor_id;
            $productsreturn->customer_id  = $request->customer_id;
            $productsreturn->return_note  = $request->return_note;
            $productsreturn->staff_note   = $request->staff_note;
            $productsreturn->save();

            if (count($products) == count($quantities)) {
                ReturnedItems::where('return_id', $productsreturn->id)->delete();

                for ($i = 0; $i < count($products); $i++) {
                    $product_id = $products[$i];
                    $quantity   = (int)$quantities[$i];

                    $product = Product::whereId($product_id)->where('created_by', $user_id)->first();

                    $tax   = ($product->taxes == null) ? 0 : (int)$product->taxes->percentage;
                    $price = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;

                    $original_quantity = ($product == null) ? 0 : (int)$product->quantity;

                    $product_quantity = $original_quantity - $quantity;

                    if ($product != null && !empty($product) && $product_quantity >= 0) {
                        Product::where('id', $product_id)->update(['quantity' => $product_quantity]);
                    }

                    $tax_id = Product::tax_id($product_id);

                    $ri             = new ReturnedItems();
                    $ri->return_id  = $productsreturn->id;
                    $ri->product_id = $product_id;
                    $ri->price      = $price;
                    $ri->quantity   = $quantity;
                    $ri->tax_id     = $tax_id;
                    $ri->tax        = $tax;
                    $ri->save();
                }

                return redirect()->route('productsreturn.index')->with('success', __('Products return updated successfully.'));
            }
        } else {
            return redirect()->back()->with('error', __('Please add some products!'));
        }
    }

    public function destroy(ProductsReturn $productsreturn)
    {
        if (Auth::user()->can('Delete Returns')) {
            ReturnedItems::where('return_id', $productsreturn->id)->delete();

            $productsreturn->delete();

            return redirect()->route('productsreturn.index')->with('success', __('Products return deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function returnedItems(Request $request)
    {
        $return_id = $request->id;
        if (Auth::user()->can('Manage Product') && $request->ajax() && isset($return_id) && !empty($return_id)) {
            $items = ReturnedItems::select('returned_items.*', 'products.name as productname')
                ->join('products', 'products.id', '=', 'returned_items.product_id')
                ->where('products.created_by', '=', Auth::user()->getCreatedBy())
                ->where('returned_items.return_id', '=', $return_id)
                ->get();

            foreach ($items as $key => $item) {
                $subtotal = $item->price * $item->quantity;
                $tax      = ($subtotal * $item->tax) / 100;

                $items[$key]['subtotal'] = $subtotal + $tax;
            }
            $data['items'] = $items;

            echo json_encode($data);
        }
    }
    public function export()
    {
        $name = 'Productreturn_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ProductreturnExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }
}
