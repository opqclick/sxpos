<?php

namespace App\Http\Controllers;

use App\Mail\CustomerCreate;
use App\Models\CustomerDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Plan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use App\Models\Utility;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Customer')) {
            $customers = Customer::where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'DESC')->get();

            return view('customers.index')->with('customers', $customers);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('Create Customer')) {
            return view('customers.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Customer')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'email' => 'required|email|max:100|unique:customers,email,NULL,id,created_by,' . Auth::user()->getCreatedBy(),
                    'phone_number' => 'required|min:10|max:15',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            if (!empty($request->email)) {
                $customer_has_mail = Customer::Where('email', $request->email)->count();
                if ($customer_has_mail != 0) {
                    return redirect()->back()->with('error', __('The email has already been taken.'));
                }
            }

            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();

            $total_customer = Customer::where('created_by', '=', $user->getCreatedBy())->count();

            // $plan = Plan::find($user->plan_id);

            // if ($plan->max_customers == -1 || $total_customer < $plan->max_customers) {
                $customer['name']         = $request->name;
                $customer['email']        = $request->email;
                $customer['phone_number'] = $request->phone_number;
                $customer['address']      = $request->address;
                $customer['city']         = $request->city;
                $customer['state']        = $request->state;
                $customer['country']      = $request->country;
                $customer['zipcode']      = $request->zipcode;
                $customer['is_active']    = 1;
                $customer['created_by']   = $user->getCreatedBy();

                $customer = Customer::create($customer);

                try {
                    $customer->type = 'Customer';

                    $uArr = [
                        'app_name'  =>env('APP_NAME'),
                        'app_url'=> env('APP_URL'),
                        'customer_name' => $request->name,
                        'customer_email' =>$request->email,
                        'customer_phone_number' =>$request->phone_number,
                        'customer_address' =>$request->address,
                        'customer_country'=> $request->country,
                        'customer_zipcode'=> $request->zipcode,
                      ];

                    //   Mail::to($customer->email)->send(new CustomerCreate($customer));
                      $resp = Utility::sendEmailTemplate('new_customer', [$customer->id => $customer->email], $uArr);
                //    dd($resp);

                } catch (\Exception $e) {

                    $smtp_error = "<br><span class='text-danger'>" . __('E-Mail has been not sent due to SMTP configuration') . '</span>';
                }

                $setting  = Utility::settings(\Auth::user()->creatorId());
                if (isset($setting['twilio_customer_notification']) && $setting['twilio_customer_notification'] == 1) {
                    // $msg = __("New User created by") . ' ' . \Auth::user()->name . '.';
                    $uArr = [
                        'customer_name' => $request->name,
                        'customer_email' =>$request->email,
                        'customer_phone_number' =>$request->phone_number,
                        'user_name'  => \Auth::user()->name,

                    ];
                    // dd($request->phone_number,'new_customer',$uArr);
                    Utility::send_twilio_msg($request->phone_number,'new_customer',$uArr);
                }

                // Webhook
                $module = 'New Customer';
                $webhook =  Utility::webhookSetting($module,$user->created_by);
                if ($webhook) {
                    $parameter = json_encode($customer);
                    // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                    $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                    if ($status == true) {
                        return redirect()->route('customers.index')->with('success', __('customer successfully created!') . ((isset($smtp_error)) ? $smtp_error : ''));
                    } else {
                        return redirect()->back()->with('error', __('Webhook call failed.'));
                    }
                }

                return redirect()->route('customers.index')->with('success', __('Customer added successfully.') . ((isset($smtp_error)) ? $smtp_error : ''));
            // } else {
            //     return redirect()->back()->with('error', __('Your customer limit is over, Please upgrade plan.'));
            // }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Customer $customer)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Customer $customer)
    {
        if (Auth::user()->can('Edit Customer')) {
            $documents = CustomerDocument::where('customer_id', $customer->id)->get();
            return view('customers.edit', compact('customer', 'documents'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Customer $customer)
    {
        if (Auth::user()->can('Edit Customer')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'email' => 'required|email|max:100|unique:customers,email,' . $customer->id . ',id,created_by,' . Auth::user()->getCreatedBy(),
                    'phone_number' => 'required|min:10|max:15',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $customer['name']         = $request->name;
            $customer['email']        = $request->email;
            $customer['phone_number'] = $request->phone_number;
            $customer['address']      = $request->address;
            $customer['city']         = $request->city;
            $customer['state']        = $request->state;
            $customer['country']      = $request->country;
            $customer['zipcode']      = $request->zipcode;
            $customer->save();

            return redirect()->back()->with('success', __('Customer updated successfully.'));
//            return redirect()->route('customers.index')->with('success', __('Customer updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function createDocument($id)
    {
        if (Auth::user()->can('Edit Customer')) {
            $customer = Customer::find($id);
            $types = CustomerDocument::TYPES;
            return view('customers.create_document', compact('customer', 'types'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function storeDocument(Request $request, $id)
    {
        if (Auth::user()->can('Edit Customer')) {
            $customer = Customer::find($id);

            $validator = Validator::make(
                $request->all(),
                [
                    'description' => 'required',
                    'type' => 'required',
                    //'file' => 'required',
                    'expiration_date' => 'required',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $document = new CustomerDocument();
            $document->customer_id = $customer->id;
            $document->description = $request->description;
            $document->type = $request->type;
            $document->expiration_date = $request->expiration_date;
            $document->created_by = Auth::user()->getCreatedBy();

            if (isset($request->capture_file) && ($request->capture_file != '') && ($request->capture_file != null)) {

                $ext = explode('/', mime_content_type($request->capture_file))[1];
                $fileNameToStore = 'capture_'.rand(1000,9999).'_' . time() . '.' . $ext;
                $logo_path = 'customer-document/';

                Storage::disk('local')->put($logo_path . $fileNameToStore, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->capture_file)));

                $document->file = $logo_path.$fileNameToStore;
            } elseif ($request->hasFile('upload_file')) {
                $filenameWithExt = $request->file('upload_file')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('upload_file')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir        = 'customer-document/';
                $path = Utility::upload_file($request, 'upload_file', $fileNameToStore, $dir, []);

                if ($path['flag'] == 1) {
                    $url = $path['url'];
                    $document->file = $url;
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

            $document->save();
            return redirect()->back()->with(['success' => 'Document successfully uploaded']);

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function editDocument($id, $did)
    {
        if (Auth::user()->can('Edit Customer')) {
            $customer = Customer::find($id);
            $types = CustomerDocument::TYPES;
            $document = CustomerDocument::find($did);
            return view('customers.edit_document', compact('customer', 'types', 'document'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function updateDocument(Request $request, $id, $did)
    {
        if (Auth::user()->can('Edit Customer')) {
            $customer = Customer::find($id);

            $validator = Validator::make(
                $request->all(),
                [
                    'description' => 'required',
                    'type' => 'required',
                    'expiration_date' => 'required',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $document = CustomerDocument::where('customer_id', $customer->id)->where('id', $did)->first();
            if(empty($document)) {
                return redirect()->back()->with('error', __('Document not found'));
            }

            $document->description = $request->description;
            $document->type = $request->type;
            $document->expiration_date = $request->expiration_date;
            $document->status = $request->status ?? 1;
            $document->created_by = Auth::user()->getCreatedBy();

            if (isset($request->capture_file) && ($request->capture_file != '') && ($request->capture_file != null)) {

                $ext = explode('/', mime_content_type($request->capture_file))[1];
                $fileNameToStore = 'capture_'.rand(1000,9999).'_' . time() . '.' . $ext;
                $logo_path = 'customer-document/';

                Storage::disk('local')->put($logo_path . $fileNameToStore, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->capture_file)));

                $document->file = $logo_path.$fileNameToStore;
            } elseif ($request->hasFile('upload_file')) {
                $filenameWithExt = $request->file('upload_file')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('upload_file')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir        = 'customer-document/';
                $path = Utility::upload_file($request, 'upload_file', $fileNameToStore, $dir, []);

                if ($path['flag'] == 1) {
                    $url = $path['url'];
                    $document->file = $url;
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

            /*if ($request->hasFile('file')) {
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('file')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir        = 'customer-document/';
                $path = Utility::upload_file($request, 'file', $fileNameToStore, $dir, []);

                if ($path['flag'] == 1) {
                    $url = $path['url'];
                    $document->file = $url;
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }*/
            $document->save();
            return redirect()->back()->with(['success' => 'Document successfully updated']);

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function deleteDocument($id, $did)
    {
        if (Auth::user()->can('Edit Customer')) {
            $customer = Customer::find($id);
            $document = CustomerDocument::where('customer_id', $customer->id)->where('id', $did)->first();
            if(empty($document)) {
                return redirect()->back()->with('error', __('Document not found'));
            }

            $document->delete();

            return redirect()->back()->with('success', __('Document successfully deleted'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Customer $customer)
    {
        if (Auth::user()->can('Delete Customer')) {
            $customer->delete();

            return redirect()->route('customers.index')->with('success', __('Customer successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function searchCustomers(Request $request)
    {
        try {
            if (Auth::user()->can('Manage Customer')) {
                $customers = [];
                $search = $request->search;
                if ($request->ajax() && isset($search) && !empty($search)) {
                    $customers = Customer::select('id as value', 'name as label', 'email')
                        ->where('is_active', '=', 1)
                        ->where('created_by', '=', Auth::user()->getCreatedBy())
                        ->where(function ($q) use ($search) {
                            $q->where('name', 'LIKE', '%' . $search . '%')
                                ->orWhere('email', 'LIKE', '%' . $search . '%')
                                ->orWhere('phone_number', 'LIKE', '%' . $search . '%');
                        })
                        ->get()->map(function ($customer) {
                            //check expired document
                            $customer->expired_document = CustomerDocument::where('customer_id', $customer->value)
                                ->where('status', 1)
                                ->where('expiration_date', '<', date('Y-m-d'))
                                ->count();
                            return $customer;
                        });

                    return json_encode($customers);
                }

                return $customers;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Permission Denied",
                ]);
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function getCustomerEmail(Request $request)
    {
        if (Auth::user()->can('Manage Customer')) {
            $customer_email = [];
            if ($request->ajax()) {
                $customer_email = Customer::select(DB::Raw('IFNULL( email , "" ) as email'))->where('is_active', '=', 1)->where('customers.id', '=', $request->id)->where('customers.created_by', '=', Auth::user()->getCreatedBy())->get();

                return json_encode($customer_email);
            }

            return $customer_email;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function export()
    {
        $name = 'customer_' . date('Y-m-d i:h:s');
        $data = Excel::download(new CustomerExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }

    public function importFile()
    {
        return view('customers.import');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt,xlsx',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $customers = (new CustomerImport())->toArray(request()->file('file'))[0];

        $totalCustomer = count($customers) - 1;
        $errorArray    = [];
        for ($i = 1; $i <= count($customers) - 1; $i++) {
            $customer = $customers[$i];

            $customerByEmail = Customer::where('email', $customer[1])->first();

            if (!empty($customerByEmail)) {
                $customerData = $customerByEmail;
            } else {
                $customerData = new Customer();
                // $customerData->customer_id      = $this->customerNumber();
            }

            $customerData->name             = $customer[0];
            $customerData->email            = $customer[1];
            $customerData->phone_number     = $customer[2];
            $customerData->address          = $customer[3];
            $customerData->city             = $customer[4];
            $customerData->state            = $customer[5];
            $customerData->country          = $customer[6];
            $customerData->zipcode          = $customer[7];
            $customerData->is_active        = 1;
            $customerData->created_by       = \Auth::user()->getCreatedBy();

            if (empty($customerData)) {
                $errorArray[] = $customerData;
            } else {
                $customerData->save();
            }
        }

        $errorRecord = [];
        if (empty($errorArray)) {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalCustomer . ' ' . 'record');


            foreach ($errorArray as $errorData) {

                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }
}
