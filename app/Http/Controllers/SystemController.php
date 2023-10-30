<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Mail\EmailTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;
use App\Models\Webhook;
use Artisan;
use Illuminate\Support\Facades\File;

class SystemController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Store Settings')) {
            $settings = Utility::settings();
            $languages = Utility::languages();
            $EmailTemplates = EmailTemplate::all();
            $webhooks = Webhook::where('created_by', \Auth::user()->id)->get();
            return view('settings.index', compact('settings', 'languages','EmailTemplates','webhooks'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Store Settings')) {
            if($request->logo_dark)
            {
                $request->validate(
                    [
                        'logo_dark' => 'image',
                    ]
                );
                $logoName = 'logo-dark.png';
                $dir = 'uploads/logo/';
                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];

                $path = Utility::upload_file($request,'logo_dark',$logoName,$dir,$validation);
                if($path['flag'] == 1){
                    $logo_dark = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }

            }

            if($request->logo_light)
            {
                $request->validate(
                    [
                        'logo_light' => 'image',
                    ]
                );
                $lightlogoName = 'logo-light.png';


                $dir = 'uploads/logo/';
                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];

                $path = Utility::upload_file($request,'logo_light',$lightlogoName,$dir,$validation);
                if($path['flag'] == 1){
                    $logo_light = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }


                // $path     = $request->file('logo_light')->storeAs('uploads/logo/', $lightlogoName);
            }

            if($request->favicon)
            {
                $request->validate(
                    [
                        'favicon' => 'image',
                    ]
                );
                $favicon = 'favicon.png';


                $dir = 'uploads/logo/';
                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];

                $path = Utility::upload_file($request,'favicon',$favicon,$dir,$validation);
                if($path['flag'] == 1){
                    $favicon = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }

                // $path    = $request->file('favicon')->storeAs('uploads/logo/', $favicon);
            }

            $rules = [
                'app_name' => 'required|string|max:50',
                'default_language' => 'required|string|max:50',
                'footer_text' => 'required|string|max:50',
            ];

            $request->validate($rules);

            $arrEnv = [
                'APP_NAME' => $request->app_name,
                'DEFAULT_LANG' => $request->default_language,
                'FOOTER_TEXT' => $request->footer_text,
                'DISPLAY_LANDING' => $request->display_landing ?? 'off',
            ];

            Utility::setEnvironmentValue($arrEnv);


            // $settings = Utility::settings();
            // $post1['gdpr_cookie'] = (!empty($request->gdpr_cookie)) ? $request->gdpr_cookie : 'off' ;
            // $post1['cookie_text'] = $request->cookie_text;
            // $post1['color'] = $request->has('color') ? $request-> color : 'theme-3';
            // $post1['cust_theme_bg'] = (!empty($request->cust_theme_bg)) ? 'on' : 'off';
            // $post1['cust_darklayout'] = (!empty($request->cust_darklayout)) ? 'on' : 'off';
            // $post1['SITE_RTL'] = (!empty($request->SITE_RTL)) ? 'on' : 'off';

            // foreach ($post1 as $key => $data) {
            //     if (in_array($key, array_keys($settings))) {
            //         \DB::insert(
            //             'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
            //             [
            //                 $data,
            //                 $key,
            //                 \Auth::user()->getCreatedBy(),
            //             ]
            //         );
            //     }
            // }


            if (!empty($request->color) || !empty($request->cust_theme_bg) || !empty($request->cust_darklayout) || !empty($request->SITE_RTL) || !empty($request->gdpr_cookie) || !empty($request->disable_signup_button)) {
                $post1 = $request->all();
                if (!isset($request->cust_theme_bg)) {
                    $post1['cust_theme_bg'] = 'off';
                }
                if (!isset($request->cust_darklayout)) {
                    $post1['cust_darklayout'] = 'off';
                }
                if (!isset($request->display_landing)) {
                    $post1['display_landing'] = 'off';
                }

                if (!isset($request->gdpr_cookie)) {
                    $post1['gdpr_cookie'] = 'off';
                }

                // $post1['cookie_text'] = $request->cookie_text;

                if (!isset($request->disable_signup_button)) {
                    $post1['disable_signup_button'] = 'off';
                }


                $post1['SITE_RTL'] = (!empty($request->SITE_RTL)) ? 'on' : 'off';

                unset($post1['_token'], $post1['logo_dark'], $post1['logo_light'], $post1['favicon']);
                $settings = Utility::settings();
                foreach ($post1 as $key => $data) {
                    if (in_array($key, array_keys($settings))) {
                        \DB::insert(
                            'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                            [
                                $data,
                                $key,
                                \Auth::user()->getCreatedBy(),
                            ]
                        );
                    }
                }
            }

            return redirect()->back()->with('success', __('Settings updated successfully.'));


            Artisan::call('config:cache');
            Artisan::call('config:clear');
            return redirect()->back()->with('success', __('Logo updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function recaptchaSettingStore(Request $request)
    {


        $user = \Auth::user();
        $rules = [];

        if ($request->recaptcha_module == 'yes') {
            $rules['google_recaptcha_key'] = 'required|string|max:50';
            $rules['google_recaptcha_secret'] = 'required|string|max:50';
        }

        $validator = \Validator::make(
            $request->all(),
            $rules
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $arrEnv = [
            'RECAPTCHA_MODULE' => $request->recaptcha_module ?? 'no',
            'NOCAPTCHA_SITEKEY' => $request->google_recaptcha_key,
            'NOCAPTCHA_SECRET' => $request->google_recaptcha_secret,
        ];

        if (Utility::setEnvironmentValue($arrEnv)) {
            return redirect()->back()->with('success', __('Recaptcha Settings updated successfully'));
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public function saveGeneralSettings(Request $request)
    {
        if (Auth::user()->can('Store Settings')) {
            $post = [];
            if ($request->has('low_product_stock_threshold')) {
                $post['low_product_stock_threshold'] = $request->input('low_product_stock_threshold');
            }

            if (!empty($post) && count($post) > 0) {
                $created_at = $updated_at = date('Y-m-d H:i:s');

                foreach ($post as $key => $data) {
                    DB::insert(
                        'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                        [
                            $data,
                            $key,
                            Auth::user()->getCreatedBy(),
                            $created_at,
                            $updated_at,
                        ]
                    );
                }
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'mail_driver' => 'required|string|max:50',
                    'mail_host' => 'required|string|max:50',
                    'mail_port' => 'required|string|max:50',
                    'mail_username' => 'required|string|max:50',
                    'mail_password' => 'required|string|max:255',
                    'mail_encryption' => 'required|string|max:50',
                    'mail_from_address' => 'required|string|max:50',
                    'mail_from_name' => 'required|string|max:50',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $env = [
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
                'MAIL_FROM_NAME' => $request->mail_from_name,
                'FOOTER_LINK_1' => $request->footer_link_1,
                'FOOTER_LINK_2' => $request->footer_link_2,
                'FOOTER_LINK_3' => $request->footer_link_3,
                'FOOTER_VALUE_1' => $request->footer_value_1,
                'FOOTER_VALUE_2' => $request->footer_value_1,
                'FOOTER_VALUE_3' => $request->footer_value_1,
            ];

            Utility::setEnvironmentValue($env);

            return redirect()->back()->with('success', __('Settings updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function saveSystemSettings(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);

        if ($request->has('system_settings') && $request->system_settings == 1) {

            unset($post['system_settings']);
        } else {

            $validator = Validator::make(
                $request->all(),
                [
                    'company_name' => 'required',
                    'company_email' => 'required',
                    'company_email_from_name' => 'required',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
        }

        $created_at = $updated_at = date('Y-m-d H:i:s');
        foreach ($post as $key => $data) {
            DB::insert(
                'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                [
                    $data,
                    $key,
                    Auth::user()->getCreatedBy(),
                    $created_at,
                    $updated_at,
                ]
            );
        }

        return redirect()->back()->with('success', __('Settings updated successfully.'));
    }
    public function saveTemplateSettings(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);

        if (isset($post['purchase_invoice_template']) && (!isset($post['purchase_invoice_color']) || empty($post['purchase_invoice_color']))) {
            $post['purchase_invoice_color'] = "ffffff";
        }
        if ($request->purchase_logo) {
            $userDetail = \Auth::user();
            $user = User::findOrFail($userDetail['id']);
            $this->validate(
                $request, [
                            'purchase_logo' => 'required',
                        ]
            );
            if($request->hasFile('purchase_logo'))
            {
                $filenameWithExt = $request->file('purchase_logo')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('purchase_logo')->getClientOriginalExtension();
                $fileNameToStore = $user->id . '_' . 'purchase_logo' . '.' . $extension;
                $settings = Utility::settings();//Utility::getStorageSetting();
                $dir        = 'uploads/invoice_logo';

                $image_path = $dir . $settings['purchase_logo'];
                if(File::exists($image_path))
                {
                    File::delete($image_path);
                }

                $path = Utility::upload_file($request,'purchase_logo',$fileNameToStore,$dir,[]);
                // dd($path);
                if($path['flag'] == 1){
                    $url = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }
            if(!empty($request->purchase_logo))
            {
                $post['purchase_logo'] = $fileNameToStore;
            }
        }

        if (isset($post['sale_invoice_template']) && (!isset($post['sale_invoice_color']) || empty($post['sale_invoice_color']))) {
            $post['sale_invoice_color'] = "ffffff";
        }
        if ($request->sale_logo) {
            $userDetail = \Auth::user();
            $user = User::findOrFail($userDetail['id']);
            $this->validate(
                $request, [
                            'sale_logo' => 'required',
                        ]
            );
            if($request->hasFile('sale_logo'))
            {
                $filenameWithExt = $request->file('sale_logo')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('sale_logo')->getClientOriginalExtension();
                $fileNameToStore = $user->id . '_' . 'sale_logo' . '.' . $extension;
                $settings = Utility::settings();
                $dir        = 'uploads/invoice_logo';

                $image_path = $dir . $settings['sale_logo'];
                if(File::exists($image_path))
                {
                    File::delete($image_path);
                }

                $path = Utility::upload_file($request,'sale_logo',$fileNameToStore,$dir,[]);
                // dd($path);
                if($path['flag'] == 1){
                    $url = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }
            if(!empty($request->sale_logo))
            {
                $post['sale_logo'] = $fileNameToStore;
            }
        }

        if (isset($post['quotation_invoice_template']) && (!isset($post['quotation_invoice_color']) || empty($post['quotation_invoice_color']))) {
            $post['quotation_invoice_color'] = "ffffff";
        }
        if ($request->quotation_logo) {
            $userDetail = \Auth::user();
            $user = User::findOrFail($userDetail['id']);
            $this->validate(
                $request, [
                            'quotation_logo' => 'required',
                        ]
            );
            if($request->hasFile('quotation_logo'))
            {
                $filenameWithExt = $request->file('quotation_logo')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('quotation_logo')->getClientOriginalExtension();
                $fileNameToStore = $user->id . '_' . 'quotation_logo' . '.' . $extension;
                $settings = Utility::settings();
                $dir        = 'uploads/invoice_logo';

                $image_path = $dir . $settings['quotation_logo'];
                if(File::exists($image_path))
                {
                    File::delete($image_path);
                }

                $path = Utility::upload_file($request,'quotation_logo',$fileNameToStore,$dir,[]);
                // dd($path);
                if($path['flag'] == 1){
                    $url = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }
            if(!empty($request->quotation_logo))
            {
                $post['quotation_logo'] = $fileNameToStore;
            }
        }

        $created_at = $updated_at = date('Y-m-d H:i:s');

        foreach ($post as $key => $data) {
            DB::insert(
                'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                [
                    $data,
                    $key,
                    Auth::user()->getCreatedBy(),
                    $created_at,
                    $updated_at,
                ]
            );
        }

        if (isset($post['purchase_invoice_template'])) {
            return redirect()->back()->with('success', __('Purchase Invoice Setting updated successfully.'));
        }

        if (isset($post['sale_invoice_template'])) {
            return redirect()->back()->with('success', __('Sale Invoice Setting updated successfully'));
        }

        if (isset($post['quotation_invoice_template'])) {
            return redirect()->back()->with('success', __('Quotation Invoice Setting updated successfully'));
        }
    }

    public function saveInvoiceFooterSettings(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);

        $created_at = $updated_at = date('Y-m-d H:i:s');

        foreach ($post as $key => $data) {
            DB::insert(
                'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                [
                    $data,
                    $key,
                    Auth::user()->getCreatedBy(),
                    $created_at,
                    $updated_at,
                ]
            );
        }

        return redirect()->back()->with('success', __('Invoice Footer Setting updated successfully'));
    }

    public function testEmail(Request $request)
    {
        $data = [];
        $data['mail_driver'] = $request->mail_driver;
        $data['mail_host'] = $request->mail_host;
        $data['mail_port'] = $request->mail_port;
        $data['mail_username'] = $request->mail_username;
        $data['mail_password'] = $request->mail_password;
        $data['mail_encryption'] = $request->mail_encryption;
        $data['mail_from_address'] = $request->mail_from_address;
        $data['mail_from_name'] = $request->mail_from_name;

        return view('users.test_email', compact('data'));
    }

    public function testEmailSend(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'mail_driver' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            // return redirect()->back()->with('error', $messages->first());
        }

        try {
            config([
                'mail.driver' => $request->mail_driver,
                'mail.host' => $request->mail_host,
                'mail.port' => $request->mail_port,
                'mail.encryption' => $request->mail_encryption,
                'mail.username' => $request->mail_username,
                'mail.password' => $request->mail_password,
                'mail.from.address' => $request->mail_from_address,
                'mail.from.name' => $request->mail_from_name,
            ]);
            Mail::to($request->email)->send(new EmailTest());
        } catch (\Exception $e) {
            $smtp_error =__('E-Mail has been not sent due to SMTP configuration');
            return response()->json(
                ['is_success' => false,
                'message' => $smtp_error,
            ]);
        }
        return response()->json(['is_success' => true, 'message' => __('Email send Successfully')]);
    }


    public function storageSettingStore(Request $request)
    {

        if(isset($request->storage_setting) && $request->storage_setting == 'local')
        {

            $request->validate(
                [

                    'local_storage_validation' => 'required',
                    'local_storage_max_upload_size' => 'required',
                ]
            );

            $post['storage_setting'] = $request->storage_setting;
            $local_storage_validation = implode(',', $request->local_storage_validation);
            $post['local_storage_validation'] = $local_storage_validation;
            $post['local_storage_max_upload_size'] = $request->local_storage_max_upload_size;

        }

        if(isset($request->storage_setting) && $request->storage_setting == 's3')
        {
            $request->validate(
                [
                    's3_key'                  => 'required',
                    's3_secret'               => 'required',
                    's3_region'               => 'required',
                    's3_bucket'               => 'required',
                    's3_url'                  => 'required',
                    's3_endpoint'             => 'required',
                    's3_max_upload_size'      => 'required',
                    's3_storage_validation'   => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['s3_key']                     = $request->s3_key;
            $post['s3_secret']                  = $request->s3_secret;
            $post['s3_region']                  = $request->s3_region;
            $post['s3_bucket']                  = $request->s3_bucket;
            $post['s3_url']                     = $request->s3_url;
            $post['s3_endpoint']                = $request->s3_endpoint;
            $post['s3_max_upload_size']         = $request->s3_max_upload_size;
            $s3_storage_validation              = implode(',', $request->s3_storage_validation);
            $post['s3_storage_validation']      = $s3_storage_validation;
        }

        if(isset($request->storage_setting) && $request->storage_setting == 'wasabi')
        {
            $request->validate(
                [
                    'wasabi_key'                    => 'required',
                    'wasabi_secret'                 => 'required',
                    'wasabi_region'                 => 'required',
                    'wasabi_bucket'                 => 'required',
                    'wasabi_url'                    => 'required',
                    'wasabi_root'                   => 'required',
                    'wasabi_max_upload_size'        => 'required',
                    'wasabi_storage_validation'     => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['wasabi_key']                 = $request->wasabi_key;
            $post['wasabi_secret']              = $request->wasabi_secret;
            $post['wasabi_region']              = $request->wasabi_region;
            $post['wasabi_bucket']              = $request->wasabi_bucket;
            $post['wasabi_url']                 = $request->wasabi_url;
            $post['wasabi_root']                = $request->wasabi_root;
            $post['wasabi_max_upload_size']     = $request->wasabi_max_upload_size;
            $wasabi_storage_validation          = implode(',', $request->wasabi_storage_validation);
            $post['wasabi_storage_validation']  = $wasabi_storage_validation;
        }

        foreach($post as $key => $data)
        {

            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', $arr
            );
        }

        return redirect()->back()->with('success', __('Storage setting successfully updated.'));

    }


    public function saveTwilioSettings(Request $request){
        $post = [];
        $post['twilio_sid'] = $request->input('twilio_sid');
        $post['twilio_token'] = $request->input('twilio_token');
        $post['twilio_from'] = $request->input('twilio_from');
        $post['twilio_customer_notification'] = $request->has('twilio_customer_notification')?$request->input('twilio_customer_notification'):0;
        $post['twilio_vendor_notification'] = $request->has('twilio_vendor_notification')?$request->input('twilio_vendor_notification'):0;
        $post['twilio_quotation_notification'] = $request->has('twilio_quotation_notification')?$request->input('twilio_quotation_notification'):0;
        $post['twilio_sales_notification'] = $request->has('twilio_sales_notification')?$request->input('twilio_sales_notification'):0;
        $post['twilio_return_notification'] = $request->has('twilio_return_notification')?$request->input('twilio_return_notification'):0;
        $post['twilio_purchase_notification'] = $request->has('twilio_purchase_notification')?$request->input('twilio_purchase_notification'):0;
        // $post['twilio_payment_notification'] = $request->has('twilio_payment_notification')?$request->input('twilio_payment_notification'):0;
        // $post['twilio_reminder_notification'] = $request->has('twilio_reminder_notification')?$request->input('twilio_reminder_notification'):0;
    
    
        if(isset($post) && !empty($post) && count($post) > 0)
        {
            $created_at = $updated_at = date('Y-m-d H:i:s');
    
            foreach($post as $key => $data)
            {
                DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ', [
                                                                                                                                                                                                                      $data,
                                                                                                                                                                                                                      $key,
                                                                                                                                                                                                                      Auth::user()->id,
                                                                                                                                                                                                                      $created_at,
                                                                                                                                                                                                                      $updated_at,
                                                                                                                                                                                                                  ]
                );
            }
        }
    
        return redirect()->back()->with('success', __('Twilio updated successfully.'));
    }
    

    public function saveGoogleCalenderSettings(Request $request)
    {
        if(isset($request->is_enabled) && $request->is_enabled == 'on'){
            $validator = \Validator::make(
                $request->all(),
                [
                    'google_clender_id' => 'required',
                    'google_calender_json_file' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $post['is_enabled'] = $request->is_enabled;
        }else{
            $post['is_enabled'] = 'off';
        }
        if ($request->google_calender_json_file)
        {
           // $dir       = storage_path() . '/googlecalender';
           $dir=storage_path(). '/'.md5(time());

            if (!is_dir($dir)) {
                File::makeDirectory($dir, $mode = 0777, true, true);
            }
            $file_name = $request->google_calender_json_file->getClientOriginalName();
           // $file_path =  md5(time()) . "." . $request->google_calender_json_file->getClientOriginalExtension();
              $file_path=md5(time()).'/'.md5(time()).".". $request->google_calender_json_file->getClientOriginalExtension();

            $file = $request->file('google_calender_json_file');
            $file->move($dir, $file_path);
            $post['google_calender_json_file']            = $file_path;
        }
        if ($request->google_clender_id) {
            $post['google_clender_id']            = $request->google_clender_id;
            foreach ($post as $key => $data) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $data,
                        $key,
                        \Auth::user()->id,
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', __('Storage setting successfully updated.'));
    }

    public function saveSeoSettings(Request $request)
    {

            $validator = \Validator::make(
                $request->all(),
                [
                    'meta_keywords' => 'required',
                    'meta_description' => 'required',
                    'meta_image' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

        if ($request->meta_image)
        {
            $img_name = time() . '_' . 'meta_image.png';
            $dir = 'uploads/logo/';
            $validation = [

                'max:' . '20480',
            ];

            $path = Utility::upload_file($request, 'meta_image', $img_name, $dir, $validation);
            if ($path['flag'] == 1) {
                $logo_dark = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }


            $post['meta_image']  = $img_name;

        }

        $post['meta_keywords']            = $request->meta_keywords;
        $post['meta_description']            = $request->meta_description;

        foreach ($post as $key => $data) {
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                [
                    $data,
                    $key,
                    \Auth::user()->id,
                    date('Y-m-d H:i:s'),
                    date('Y-m-d H:i:s'),
                ]
            );
        }

        return redirect()->back()->with('success', __('Storage setting successfully updated.'));
    }


    public function saveCookieSettings(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                'cookie_title' => 'required',
                'cookie_description' => 'required',
                'strictly_cookie_title' => 'required',
                'strictly_cookie_description' => 'required',
                'more_information_title' => 'required',
                'contactus_url' => 'required',
            ]
        );
        // if ($validator->fails()) {
        //         $messages = $validator->getMessageBag();
        //         return redirect()->back()->with('error', $messages->first());
        //     }

        $post = $request->all();

        unset($post['_token']);

        if ($request->enable_cookie)
        {
            $post['enable_cookie'] = 'on';
        }
        else{
            $post['enable_cookie'] = 'off';
        }
        if ( $request->cookie_logging)
        {
            $post['cookie_logging'] = 'on';
        }
        else{
            $post['cookie_logging'] = 'off';
        }

        $post['cookie_title']            = $request->cookie_title;
        $post['cookie_description']            = $request->cookie_description;
        $post['strictly_cookie_title']            = $request->strictly_cookie_title;
        $post['strictly_cookie_description']            = $request->strictly_cookie_description;
        $post['more_information_title']            = $request->more_information_title;
        $post['contactus_url']            = $request->contactus_url;

        $settings = Utility::settings();
        foreach ($post as $key => $data) {

            if (in_array($key, array_keys($settings))) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                        $data,
                        $key,
                        \Auth::user()->creatorId(),
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', __('Cookie setting successfully saved.'));
    }

    public function CookieConsent(Request $request)
    {

        $settings= Utility::settings();
        
        if($settings['enable_cookie'] == "on" && $settings['cookie_logging'] == "on"){
            $allowed_levels = ['necessary', 'analytics', 'targeting'];
            $levels = array_filter($request['cookie'], function($level) use ($allowed_levels) {
                return in_array($level, $allowed_levels);
            });
            $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            // Generate new CSV line
            $browser_name = $whichbrowser->browser->name ?? null;
            $os_name = $whichbrowser->os->name ?? null;
            $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $device_type = self::get_device_type($_SERVER['HTTP_USER_AGENT']);

//            $ip = $_SERVER['REMOTE_ADDR'];
            $ip = '49.36.83.154';
            $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));


            $date = (new \DateTime())->format('Y-m-d');
            $time = (new \DateTime())->format('H:i:s') . ' UTC';


            $new_line = implode(',', [$ip, $date, $time,json_encode($request['cookie']), $device_type, $browser_language, $browser_name, $os_name,
                isset($query)?$query['country']:'',isset($query)?$query['region']:'',isset($query)?$query['regionName']:'',isset($query)?$query['city']:'',isset($query)?$query['zip']:'',isset($query)?$query['lat']:'',isset($query)?$query['lon']:'']);

            if(!file_exists(storage_path(). '/uploads/sample/data.csv')) {

                $first_line = 'IP,Date,Time,Accepted cookies,Device type,Browser language,Browser name,OS Name,Country,Region,RegionName,City,Zipcode,Lat,Lon';

                file_put_contents(storage_path() . '/uploads/sample/data.csv', $first_line . PHP_EOL , FILE_APPEND | LOCK_EX);
            }
            file_put_contents(storage_path() . '/uploads/sample/data.csv', $new_line . PHP_EOL , FILE_APPEND | LOCK_EX);

            return response()->json('success');
        }
        return response()->json('error');
    }
 
    public function get_device_type($user_agent) {
        $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';

        if(preg_match_all($mobile_regex, $user_agent)) {
            return 'mobile';
        } else {

            if(preg_match_all($tablet_regex, $user_agent)) {
                return 'tablet';
            } else {
                return 'desktop';
            }

        }
    }


    public function chatgptkey(Request $request){
        if (\Auth::user()->type == 'Owner') {
            $user = \Auth::user();
            if (!empty($request->chatgpt_key)) {
                $post = $request->all();
                
                $post['chatgpt_key'] = $request->chatgpt_key;

                if ($request->enable_chatgpt)
                {
                    $post['enable_chatgpt'] = 'on';
                }
                else{
                    $post['enable_chatgpt'] = 'off';
                }


                unset($post['_token']);

                
                $settings = Utility::settings();
                foreach ($post as $key => $data) {
                    
                    if (in_array($key, array_keys($settings))) { // this query change by me as per setiing table column
                        \DB::insert(
                            'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                $data,
                                $key,
                                \Auth::user()->creatorId(),
                            ]
                        );
                    }
                }
                
            }
            return redirect()->back()->with('success', __('Chatgpykey successfully saved.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    
}
