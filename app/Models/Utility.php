<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;
use App\Mail\CommonEmailTemplate;
use Spatie\GoogleCalendar\Event as GoogleEvent;
use App\Models\Calendar;
use Twilio\Rest\Client;

class Utility extends Model
{
    public static function settings($user_id = 0)
    {

        $data = DB::table('settings');

        if (\Auth::check()) {
            $data = $data->where('created_by', '=', Auth::user()->getCreatedBy())->get();
            if (count($data) == 0) {
                $data = DB::table('settings')->where('created_by', '=', 1)->get();
            }
        } else {
            $data->where('created_by', '=', 1);
            $data = $data->get();
        }


        $settings = [
            "site_currency" => "Dollars",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INV",
            "invoice_title" => "",
            "invoice_text" => "",
            "invoice_color" => "#6676ef",
            "purchase_invoice_prefix" => "#PUR",
            "sale_invoice_prefix" => "#SALE",
            "quotation_invoice_prefix" => "#QUO",
            "low_product_stock_threshold" => "0",
            "footer_text" => "Copyright © 2022 POSGo",
            "default_language" => "en",
            "default_user_language" => "en",
            "invoice_footer_title" => "",
            "invoice_footer_notes" => "",
            "purchase_invoice_template" => "template1",
            "purchase_invoice_color" => "ffffff",
            "sale_invoice_template" => "template1",
            "sale_invoice_color" => "ffffff",
            "quotation_invoice_template" => "template1",
            "quotation_invoice_color" => "ffffff",
            "display_landing_page" => "on",
            "display_landing" => "on",
            "footer_link_1" => "Support",
            "footer_link_2" => "Term",
            "footer_link_3" => "Privacy",
            "footer_value_1" => "#",
            "footer_value_2" => "#",
            "footer_value_3" => "#",
            "tax_type" => "",
            "gdpr_cookie" => "off",
            "cookie_text" => "",
            "color" => "theme-3",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "SITE_RTL" => "off",
            "storage_setting" => "",
            "local_storage_validation" => "",
            "local_storage_max_upload_size" => "",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
            "barcode_type" => "code128",
            "barcode_format" =>"css",
            "google_calender_json_file" =>"",
            "google_clender_id"=>"",
            "is_enabled"=>"",
            "enable_cookie"=>"on",
            "necessary_cookies"=>"on",
            "cookie_logging"=>"on",
            "cookie_title"=>"We use cookies!",
            "cookie_description"=>"Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it",
            "strictly_cookie_title"=>"Strictly necessary cookies",
            "strictly_cookie_description"=>"These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly",
            "more_information_description"=>"For any queries in relation to our policy on cookies and your choices, please contact us",
            "contactus_url"=>"#",
            "twilio_sid"=>"",
            "twilio_token"=>"",
            "twilio_from"=>"",
            "enable_chatgpt"=>"",
            "chatgpt_key"=>"",
            "purchase_logo"=>"",
            "sale_logo"=>"",
            "quotation_logo"=>"",
            "company_logo_light" => "2-logo-light.png",
            "company_logo_dark" => "2-logo-dark.png",
            "company_favicon" => "2_favicon.png",
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }


    public static function settingsById($id)
    {
        // $id = \Auth::user()->creatorId();
        // dd($id);
        $data     = DB::table('settings');
        $data     = $data->where('created_by', '=', $id);
        $data     = $data->get();
        $settings = [
            "site_currency" => "USD",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "journal_prefix" => "#JUR",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "proposal_color" => "ffffff",
            "proposal_logo" => "2_proposal_logo.png",
            "retainer_logo" => "2_retainer_logo.png",
            "invoice_logo" => "2_invoice_logo.png",
            "bill_logo" => "2_bill_logo.png",
            "retainer_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "contract_prefix" => "#CON",
            "retainer_prefix" => "#RET",
            "footer_title" => "",
            "footer_notes" => "",
            "purchase_invoice_template" => "template1",
            "purchase_invoice_color" => "ffffff",
            "sale_invoice_template" => "template1",
            "sale_invoice_color" => "ffffff",
            "quotation_invoice_template" => "template1",
            "quotation_invoice_color" => "ffffff",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "retainer_template" => "template1",
            "contract_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_number" => "on",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "title_text" => "",
            // 'gdpr_cookie' => "off",
            'cookie_text' => "",
            "twilio_sid" => "",
            "twilio_token" => "",
            "twilio_from" => "",
            "enable_chatgpt"=>"",
            "chatgpt_key"=>"",
            "dark_logo" => "logo-dark.png",
            "light_logo" => "logo-light.png",
            "company_logo_light" => "2-logo-light.png",
            "company_logo_dark" => "2-logo-dark.png",
            "company_favicon" => "2_favicon.png",
            "SITE_RTL" => "off",
            "owner_signature" => "",
            "cust_darklayout" => "off",
            "payment_notification" => 1,
            "purchase_logo"=>"",
            "sale_logo"=>"",
            "quotation_logo"=>"",
            "enable_cookie"=>"on",
            "necessary_cookies"=>"on",
            "cookie_logging"=>"on",
            "cookie_title"=>"We use cookies!",
            "cookie_description"=>"Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it",
            "strictly_cookie_title"=>"Strictly necessary cookies",
            "strictly_cookie_description"=>"These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly",
            "more_information_description"=>"For any queries in relation to our policy on cookies and your choices, please contact us",
            "contactus_url"=>"#",
        ];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    public static function getStorageSetting()
    {

        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        $data     = $data->get();
        $settings = [
            "storage_setting" => "",
            "local_storage_validation" => "",
            "local_storage_max_upload_size" => "",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }


    public static function languages()
    {
        // $dir     = base_path() . '/resources/lang/';
        // $glob    = glob($dir . "*", GLOB_ONLYDIR);
        // $arrLang = array_map(
        //     function ($value) use ($dir) {
        //         return str_replace($dir, '', $value);
        //     },
        //     $glob
        // );
        // $arrLang = array_map(
        //     function ($value) use ($dir) {
        //         return preg_replace('/[0-9]+/', '', $value);
        //     },
        //     $arrLang
        // );
        // $arrLang = array_filter($arrLang);

        // return $arrLang;

        $languages=Utility::langList();

        if(\Schema::hasTable('languages')){
            $settings = Utility::langSetting();
            if(!empty($settings['disable_lang'])){
                $disabledlang =explode(',', $settings['disable_lang']);
                $languages = Languages::whereNotIn('code',$disabledlang)->pluck('fullName','code');
            }
            else{
                $languages = Languages::pluck('fullName','code');
            }
        }

        return $languages;
    }

    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    // get font-color code accourding to bg-color
    public static function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array(
            $r,
            $g,
            $b,
        );
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
    public static function getFontColor($color_code)
    {
        $rgb = self::hex2rgb($color_code);
        $R   = $G = $B = $C = $L = $color = '';
        $R = (floor($rgb[0]));
        $G = (floor($rgb[1]));
        $B = (floor($rgb[2]));
        $C = [
            $R / 255,
            $G / 255,
            $B / 255,
        ];
        for ($i = 0; $i < count($C); ++$i) {
            if ($C[$i] <= 0.03928) {
                $C[$i] = $C[$i] / 12.92;
            } else {
                $C[$i] = pow(($C[$i] + 0.055) / 1.055, 2.4);
            }
        }
        $L = 0.2126 * $C[0] + 0.7152 * $C[1] + 0.0722 * $C[2];
        if ($L > 0.179) {
            $color = 'black';
        } else {
            $color = 'white';
        }
        return $color;
    }

    public static function getValByName($key)
    {
        $setting = Utility::settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function getStartEndMonthDates()
    {
        $first_day_of_current_month = Carbon::now()->startOfMonth()->subMonth(0)->toDateString();
        // $last_day_of_current_month = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();

        $first_day_of_next_month = Carbon::now()->startOfMonth()->subMonth(-1)->toDateString();
        // $last_day_of_next_month = Carbon::now()->subMonth(-1)->endOfMonth()->toDateString();

        return ['start_date' => $first_day_of_current_month, 'end_date' => $first_day_of_next_month];
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";

        return file_put_contents($envFile, $str) ? true : false;
    }

    public static function convertStringToSlug($string = '')
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    public static function templateData()
    {
        $array = [];
        $array['colors']    = [
            '003580',
            '666666',
            '5e72e4',
            'f50102',
            'f9b034',
            'fbdd03',
            'c1d82f',
            '37a4e4',
            '8a7966',
            '6a737b',
            '050f2c',
            '0e3666',
            '3baeff',
            '3368e6',
            'b84592',
            'f64f81',
            'f66c5f',
            'fac168',
            '46de98',
            '40c7d0',
            'be0028',
            '2f9f45',
            '371676',
            '52325d',
            '511378',
            '0f3866',
            '48c0b6',
            '297cc0',
            'ffffff',
            '000000',
        ];
        $array['templates'] = [
            "template1" => "New York",
            "template2" => "Toronto",
            "template3" => "Rio",
            "template4" => "London",
            "template5" => "Istanbul",
            "template6" => "Mumbai",
            "template7" => "Hong Kong",
            "template8" => "Tokyo",
            "template9" => "Sydney",
            "template10" => "Paris",
        ];
        return $array;
    }

    public static function getSuperAdminValByName($key)
    {
        $data = DB::table('settings');
        $data = $data->where('name', '=', $key);
        $data = $data->first();
        if (!empty($data)) {
            $record = $data->value;
        } else {
            $record = '';
        }
        return $record;
    }



    public static function getselectedThemeColor()
    {
        $color = env('THEME_COLOR');
        if ($color == "" || $color == null) {
            $color = 'blue';
        }
        return $color;
    }

    public static function getAllThemeColors()
    {
        $colors = [
            'blue', 'denim', 'sapphire', 'olympic', 'violet', 'black', 'cyan', 'dark-blue-natural', 'gray-dark', 'light-blue', 'light-purple', 'magenta', 'orange-mute', 'pale-green', 'rich-magenta', 'rich-red', 'sky-gray'
        ];
        return $colors;
    }

    public static function colorset()
    {
        if (\Auth::user()) {
            $user = \Auth::user();
            $setting = DB::table('settings')->pluck('value', 'name')->toArray();
        } else {
            $setting = DB::table('settings')->pluck('value', 'name')->toArray();
        }
        return $setting;
    }

    public static function get_superadmin_logo()
    {

        $is_dark_mode = self::getValByName('cust_darklayout');
        if ($is_dark_mode == 'on') {
            return 'logo-light.png';
        } else {
            return 'logo-dark.png';
        }
    }
    public static function get_company_logo()
    {


        $is_dark_mode = self::getValByName('cust_darklayout');

        if ($is_dark_mode == 'on') {
            $logo = self::getValByName('cust_darklayout');
            return Utility::getValByName('company_logo_light');
        } else {
            return Utility::getValByName('company_logo_dark');
        }
    }

    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj)
    {

        $usr = \Auth::user();
        //  dd();
        //Remove Current Login user Email don't send mail to them
        unset($mailTo[$usr->id]);

        $mailTo = array_values($mailTo);

        if($usr->type != 'super admin')
        {

            // find template is exist or not in our record
            $template = EmailTemplate::where('slug', $emailTemplate)->first();
            // dd($template,$emailTemplate);

            if(isset($template) && !empty($template))
            {

                // check template is active or not by company
                $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', $usr->creatorId())->first();
                //  dd($is_active);
                if($is_active->is_active == 1)
                {

                    $settings = self::settings();
                    // dd($settings);
                    // get email content language base
                    $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();

                    $content->from = $template->from;

                    if(!empty($content->content))
                    {
                        //    dd($content);
                        $content->content = self::replaceVariable($content->content, $obj);


                        // send email
                        try
                        {
                            // dd($mailTo,$content,$settings);
                            Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                        }
                        catch(\Exception $e)
                        {


                            $error = __('E-Mail has been not sent due to SMTP configuration');
                        }

                        if(isset($error))
                        {
                            $arReturn = [
                                'is_success' => false,
                                'error' => $error,
                            ];
                        }
                        else
                        {
                            $arReturn = [
                                'is_success' => true,
                                'error' => false,
                            ];
                        }
                    }
                    else
                    {
                        $arReturn = [
                            'is_success' => false,
                            'error' => __('Mail not send, email is empty'),
                        ];
                    }

                    return $arReturn;
                }
                else
                {
                    return [
                        'is_success' => true,
                        'error' => false,
                    ];
                }
            }
            else
            {
                return [
                    'is_success' => false,
                    'error' => __('Mail not send, email not found'),
                ];
            }
        }
    }
    public static function defaultEmail()
    {
        // Email Template
        $emailTemplate = [
            'New user',
            'New Customer',
            'New Vendor',
            'New Quote',

        ];

        foreach ($emailTemplate as $eTemp) {
            EmailTemplate::create(
                [
                    'name' => $eTemp,
                    'from' => env('APP_NAME'),
                    'slug' => strtolower(str_replace(' ', '_', $eTemp)),
                    'created_by' => 1,
                ]
            );
        }

        $defaultTemplate = [
            'New user' => [
                'subject' => 'New user',
                'lang' => [
                    'ar' => '<p>مرحبًا,<b> {user_name} </b>!</p>
                            <p>مرحبًا بك في التطبيق الخاص بنا تفاصيل تسجيل الدخول الخاصة بـ <b> {app_name}</b> هو <br></p>
                            <p><b>البريد الإلكتروني   : </b>{user_email}</p>
                            <p><b>كلمة المرور   : </b>{user_password}</p>
                            <p><b>عنوان url للتطبيق    : </b>{app_url}</p>
                            <p>شكرا لتواصلك معنا،</p>
                            <p>{app_name}</p>',


                    'da' => '<p>Hej,<b> {user_name} </b>!</p>
                            <p>Velkommen til vores app, hvor du kan logge ind <b> {app_name}</b> er <br></p>
                            <p><b>E-mail   : </b>{user_email}</p>
                            <p><b>Adgangskode : </b>{user_password}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p> Tak fordi du tog kontakt med os,</p>
                            <p>{app_name}</p>',

                    'de' => '<p>Hallo,<b> {user_name} </b>!</p>
                            <p>Willkommen in unserer App für Ihre Login-Daten <b> {app_name}</b> ist <br></p>
                            <p><b>Email   : </b>{user_email}</p>
                            <p><b>Passwort   : </b>{user_password}</p>
                            <p><b> App-URL    : </b>{app_url}</p>
                            <p>Danke, dass Sie sich mit uns verbunden haben,</p>
                            <p>{app_name}</p>',

                    'en' => '<p>Hello,<b> {user_name} </b>!</p>
                            <p>Welcome to our app yore login detail for <b> {app_name}</b> is <br></p>
                            <p><b>Email   : </b>{user_email}</p>
                            <p><b>Password   : </b>{user_password}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p>Thank you for connecting with us,</p>
                            <p>{app_name}</p>',

                    'es' => '<p>Hola,<b> {user_name} </b>!</p>
                            <p>Bienvenido a nuestra aplicación antaño detalles de inicio de sesión para <b> {app_name}</b> es <br></p>
                            <p><b>Correo electrónico   : </b>{user_email}</p>
                            <p><b>Clave   : </b>{user_password}</p>
                            <p><b>URL de la aplicación  : </b>{app_url}</p>
                            <p>Gracias por conectar con nosotras,</p>
                            <p>{app_name}</p>',

                    'fr' => '<p>Bonjour,<b> {user_name} </b>!</p>
                            <p>Bienvenue sur notre application autrefois les informations de connexion pour <b> {app_name}</b> est <br></p>
                            <p><b>E-mail   : </b>{user_email}</p>
                            <p><b>Mot de passe   : </b>{user_password}</p>
                            <p><b>URL de l\'application   : </b>{app_url}</p>
                            <p>Merci de nous avoir contacté,</p>
                            <p>{app_name}</p>',

                    'it' => '<p>Ciao,<b> {user_name} </b>!</p>
                            <p>Benvenuto nella nostra app per i tuoi dati di accesso <b> {app_name}</b> è <br></p>
                            <p><b>E-mail   : </b>{user_email}</p>
                            <p><b>Parola d\'ordine   : </b>{user_password}</p>
                            <p><b>URL dell\'app    : </b>{app_url}</p>
                            <p>Grazie per esserti connesso con noi,</p>
                            <p>{app_name}</p>',

                    'ja' => '<p>こんにちは,<b> {user_name} </b>!</p>
                            <p>私たちのアプリのyoreログインの詳細へようこそ <b> {app_name}</b> は <br></p>
                            <p><b>Eメール   : </b>{user_email}</p>
                            <p><b>パスワード   : </b>{user_password}</p>
                            <p><b>アプリのURL    : </b>{app_url}</p>
                            <p>ご連絡ありがとうございます,</p>
                            <p>{app_name}</p>',

                    'nl' => '<p>Hallo,<b> {user_name} </b>!</p>
                            <p>Welkom bij de inloggegevens van onze app voor: <b> {app_name}</b> is <br></p>
                            <p><b>E-mail   : </b>{user_email}</p>
                            <p><b>Wachtwoord   : </b>{user_password}</p>
                            <p><b>App-URL    : </b>{app_url}</p>
                            <p>Bedankt voor het contact met ons,</p>
                            <p>{app_name}</p>',

                    'pl' => '<p>Witam,<b> {user_name} </b>!</p>
                            <p>Witamy w naszej aplikacji yore dane logowania do <b> {app_name}</b> jest <br></p>
                            <p><b>E-mail   : </b>{user_email}</p>
                            <p><b>Hasło   : </b>{user_password}</p>
                            <p><b>URL aplikacji    : </b>{app_url}</p>
                            <p>Dziękujemy za kontakt z nami,</p>
                            <p>{app_name}</p>',

                    'ru' => '<p>Привет,<b> {user_name} </b>!</p>
                            <p>Добро пожаловать в наше приложение. <b> {app_name}</b> является <br></p>
                            <p><b>Эл. адрес   : </b>{user_email}</p>
                            <p><b>Пароль   : </b>{user_password}</p>
                            <p><b>URL приложения    : </b>{app_url}</p>
                            <p>Спасибо, что связались с нами,</p>
                            <p>{app_name}</p>',

                    'pt' => '<p>Olá,<b> {user_name} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{user_email}</p>
                            <p><b>Senha   : </b>{user_password}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',

                    'tr' => '<p>Merhaba,<b> {user_name} </b>!</p>
                            <p>Uygulamamıza hoş geldiniz, eski <b> {app_name}</b> için giriş ayrıntısı <br></p>
                            <p><b>E-posta : </b>{user_email}</p>
                            <p><b>Parola : </b>{user_password}</p>
                            <p><b>Uygulama url : </b>{app_url}</p>
                            <p>Bizimle bağlantı kurduğunuz için teşekkür ederiz,</p>
                            <p>{app_name}</p>',

                    'he' => '<p>שלום,<b> {user_name} </b>!</p>
                            <p>ברוך הבא לאפליקציה שלנו, פרטי ההתחברות של <b> {app_name}</b> הוא <br></p>
                            <p><b>דוא"ל: </b>{user_email}</p>
                            <p><b>סיסמה: </b>{user_password}</p>
                            <p><b>כתובת אתר של אפליקציה: </b>{app_url}</p>
                            <p>תודה שהתחברת אלינו,</p>
                            <p>{app_name}</p>',

                    'zh' => '<p>您好，<b> {user_name} </b>！</p>
                            <p>欢迎使用我们的应用，<b> {app_name}</b> 的登录详细信息是<br></p>
                            <p><b>电子邮件：</b>{user_email}</p>
                            <p><b>密码：</b>{user_password}</p>
                            <p><b>应用程序网址：</b>{app_url}</p>
                            <p>感谢您与我们联系，</p>
                            <p>{app_name}</p>',

                    'pt-br' => '<p>Olá,<b> {user_name} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{user_email}</p>
                            <p><b>Senha   : </b>{user_password}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',
                ],
            ],

            'New Customer' => [
                'subject' => 'New Customer',
                'lang' => [
                    'ar' => '<p>مرحبًا,<b> {customer_name} </b>!</p>
                            <p>مرحبًا بك في التطبيق الخاص بنا تفاصيل تسجيل الدخول الخاصة بـ <b> {app_name}</b> هو <br></p>
                            <p><b>البريد الإلكتروني   : </b>{customer_email}</p>
                            <p><b>عنوان url للتطبيق    : </b>{app_url}</p>
                            <p><b>عنوان العميل   : </b>{customer_address}</p>
                            <p><b>بلد العميل   : </b>{customer_country}</p>
                            <p><b>الرمز البريدي للعميل   : </b>{customer_zipcode}</p>
                            <p>شكرا لتواصلك معنا,</p>
                            <p>{app_name}</p>',

                    'da' => '<p>Hej,<b> {customer_name} </b>!</p>
                            <p>Velkommen til vores app, hvor du kan logge ind <b> {app_name}</b> er <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p><b>Kundeadresse   : </b>{customer_address}</p>
                            <p><b>Kundeland   : </b>{customer_country}</p>
                            <p><b>Kundens postnummer   : </b>{customer_zipcode}</p>
                            <p>Tak fordi du tog kontakt med os,</p>
                            <p>{app_name}</p>',

                    'de' => '<p>Hallo,<b> {customer_name} </b>!</p>
                            <p>Willkommen in unserer App für Ihre Login-Daten <b> {app_name}</b> ist <br></p>
                            <p><b>Email   : </b>{customer_email}</p>
                            <p><b>App-URL    : </b>{app_url}</p>
                            <p><b>Kundenadresse   : </b>{customer_address}</p>
                            <p><b>Kundenland   : </b>{customer_country}</p>
                            <p><b>Postleitzahl des Kunden : </b>{customer_zipcode}</p>
                            <p>Vielen Dank, dass Sie sich mit uns verbunden haben,</p>
                            <p>{app_name}</p>',

                    'en' => '<p>Hello,<b> {customer_name} </b>!</p>
                            <p>Welcome to our app yore login detail for <b> {app_name}</b> is <br></p>
                            <p><b>Email   : </b>{customer_email}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p><b>Customer Address   : </b>{customer_address}</p>
                            <p><b>Customer Country   : </b>{customer_country}</p>
                            <p><b>Customer Zipcode   : </b>{customer_zipcode}</p>
                            <p>Thank you for connecting with us,</p>
                            <p>{app_name}</p>',

                    'es' => '<p>Hola,<b> {customer_name} </b>!</p>
                            <p>Bienvenido a nuestra aplicación antaño detalles de inicio de sesión para <b> {app_name}</b> es <br></p>
                            <p><b>Correo electrónico   : </b>{customer_email}</p>
                            <p><b>URL de la aplicación    : </b>{app_url}</p>
                            <p><b>Dirección del cliente   : </b>{customer_address}</p>
                            <p><b>País del cliente   : </b>{customer_country}</p>
                            <p><b>Código postal del cliente   : </b>{customer_zipcode}</p>
                            <p>Gracias por conectar con nosotros,</p>
                            <p>{app_name}</p>',

                    'fr' => '<p>Bonjour,<b> {customer_name} </b>!</p>
                            <p>Bienvenue sur notre application autrefois les informations de connexion pour <b> {app_name}</b> est <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL de l\'application   : </b>{app_url}</p>
                            <p><b>Adresse du client   : </b>{customer_address}</p>
                            <p><b>Pays du client   : </b>{customer_country}</p>
                            <p><b>Code postal du client   : </b>{customer_zipcode}</p>
                            <p>Merci de nous avoir contacté,</p>
                            <p>{app_name}</p>',

                    'it' => '<p>Ciao,<b> {customer_name} </b>!</p>
                            <p>Benvenuto nella nostra app per i tuoi dati di accesso <b> {app_name}</b> è <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL dell\'app    : </b>{app_url}</p>
                            <p><b>Indirizzo del cliente   : </b>{customer_address}</p>
                            <p><b>Paese cliente   : </b>{customer_country}</p>
                            <p><b>Codice postale del cliente   : </b>{customer_zipcode}</p>
                            <p>Grazie per esserti connesso con noi,</p>
                            <p>{app_name}</p>',

                    'ja' => '<p>こんにちは,<b> {customer_name} </b>!</p>
                            <p>私たちのアプリのyoreログインの詳細へようこそ <b> {app_name}</b> は <br></p>
                            <p><b>Eメール   : </b>{customer_email}</p>
                            <p><b>アプリのURL    : </b>{app_url}</p>
                            <p><b>お客様の住所   : </b>{customer_address}</p>
                            <p><b>顧客の国   : </b>{customer_country}</p>
                            <p><b>顧客の郵便番号   : </b>{customer_zipcode}</p>
                            <p>ご連絡ありがとうございます,</p>
                            <p>{app_name}</p>',

                    'nl' => '<p>Hallo,<b> {customer_name} </b>!</p>
                            <p>Welkom bij de inloggegevens van onze app voor: <b> {app_name}</b> is <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>App-URL    : </b>{app_url}</p>
                            <p><b>Klant adres   : </b>{customer_address}</p>
                            <p><b>Land van klant   : </b>{customer_country}</p>
                            <p><b>Postcode klant   : </b>{customer_zipcode}</p>
                            <p>Bedankt voor het contact met ons,</p>
                            <p>{app_name}</p>',

                    'pl' => '<p>Witam,<b> {customer_name} </b>!</p>
                            <p>Witamy w naszej aplikacji yore dane logowania do <b> {app_name}</b> jest <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL aplikacji    : </b>{app_url}</p>
                            <p><b>Adres klienta   : </b>{customer_address}</p>
                            <p><b>Kraj klienta   : </b>{customer_country}</p>
                            <p><b>Kod pocztowy klienta   : </b>{customer_zipcode}</p>
                            <p>Dziękujemy za kontakt z nami,</p>
                            <p>{app_name}</p>',

                    'ru' => '<p>Привет,<b> {customer_name} </b>!</p>
                            <p>Добро пожаловать в наше приложение. <b> {app_name}</b> является <br></p>
                            <p><b>Эл. адрес   : </b>{customer_email}</p>
                            <p><b>URL приложения    : </b>{app_url}</p>
                            <p><b>Адрес клиента   : </b>{customer_address}</p>
                            <p><b>Страна клиента  : </b>{customer_country}</p>
                            <p><b>Страна клиента  : </b>{customer_zipcode}</p>
                            <p>Спасибо, что связались с нами,</p>
                            <p>{app_name}</p>',

                    'pt' => '<p>Olá,<b> {customer_name} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p><b>Endereço do cliente   : </b>{customer_address}</p>
                            <p><b>País do cliente   : </b>{customer_country}</p>
                            <p><b>CEP do cliente   : </b>{customer_zipcode}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',

                    'tr' => '<p>Merhaba,<b> {customer_name} </b>!</p>
                            <p>Uygulamamıza hoş geldiniz, eski <b> {app_name}</b> için giriş ayrıntısı <br></p>
                            <p><b>E-posta : </b>{customer_email}</p>
                            <p><b>Uygulama url : </b>{app_url}</p>
                            <p><b>Müşteri Adresi : </b>{customer_address}</p>
                            <p><b>Müşteri Ülkesi : </b>{customer_country}</p>
                            <p><b>Müşteri Posta Kodu : </b>{customer_zipcode}</p>
                            <p>Bizimle bağlantı kurduğunuz için teşekkür ederiz,</p>
                            <p>{app_name}</p>',

                    'he' => '<p>שלום,<b> {customer_name} </b>!</p>
                            <p>ברוך הבא לאפליקציה שלנו, פרטי ההתחברות של <b> {app_name}</b> הוא <br></p>
                            <p><b>דוא"ל: </b>{customer_email}</p>
                            <p><b>כתובת אתר של אפליקציה: </b>{app_url}</p>
                            <p><b>כתובת לקוח: </b>{customer_address}</p>
                            <p><b>ארץ לקוח: </b>{customer_country}</p>
                            <p><b>מיקוד לקוח : </b>{customer_zipcode}</p>
                            <p>תודה שהתחברת אלינו,</p>
                            <p>{app_name}</p>',

                    'zh' => '<p>您好，<b> {customer_name} </b>！</p>
                            <p>欢迎使用我们的应用，<b> {app_name}</b> 的登录详细信息是<br></p>
                            <p><b>电子邮件：</b>{customer_email}</p>
                            <p><b>应用程序网址：</b>{app_url}</p>
                            <p><b>客户地址：</b>{customer_address}</p>
                            <p><b>客户国家/地区：</b>{customer_country}</p>
                            <p><b>客户邮政编码：</b>{customer_zipcode}</p>
                            <p>感谢您与我们联系，</p>
                            <p>{app_name}</p>',

                    'pt-br' => '<p>Olá,<b> {customer_name} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p><b>Endereço do cliente   : </b>{customer_address}</p>
                            <p><b>País do cliente   : </b>{customer_country}</p>
                            <p><b>CEP do cliente   : </b>{customer_zipcode}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',
                ],
            ],

            'New Vendor' => [
                'subject' => 'New Vendor',
                'lang' => [
                    'ar' => '<p>مرحبًا,<b> {vendor_name} </b>!</p>
                        <p>مرحبًا بك في التطبيق الخاص بنا تفاصيل تسجيل الدخول الخاصة بـ <b> {app_name}</b> هو <br></p>
                        <p><b>البريد الإلكتروني   : </b>{vendor_email}</p>
                        <p><b>عنوان url للتطبيق    : </b>{app_url}</p>
                        <p><b>عنوان البائع   : </b>{vendor_address}</p>
                        <p><b>بلد البائع   : </b>{vendor_country}</p>
                        <p><b>الرمز البريدي للبائع   : </b>{vendor_zipcode}</p>
                        <p>شكرا لتواصلك معنا,</p>
                        <p>{app_name}</p>',

                    'da' => '<p>Hej,<b> {vendor_name} </b>!</p>
                            <p>Velkommen til vores app, hvor du kan logge ind <b> {app_name}</b> er <br></p>
                            <p><b>E-mail   : </b>{vendor_email}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p><b>Leverandørens adresse   : </b>{vendor_address}</p>
                            <p><b>Leverandørland   : </b>{vendor_country}</p>
                            <p><b>Leverandørens postnummer   : </b>{vendor_zipcode}</p>
                            <p>Tak fordi du tog kontakt med os,</p>
                            <p>{app_name}</p>',

                    'de' => '<p>Hallo,<b> {vendor_name} </b>!</p>
                            <p>Willkommen in unserer App für Ihre Login-Daten <b> {app_name}</b> ist <br></p>
                            <p><b>Email   : </b>{vendor_email}</p>
                            <p><b>App-URL    : </b>{app_url}</p>
                            <p><b>Adresse des Anbieters   : </b>{vendor_address}</p>
                            <p><b>Land des Anbieters   : </b>{vendor_country}</p>
                            <p><b>Postleitzahl des Anbieters   : </b>{vendor_zipcode}</p>
                            <p>Vielen Dank, dass Sie sich mit uns verbunden haben,</p>
                            <p>{app_name}</p>',

                    'en' => '<p>Hello,<b> {vendor_name} </b>!</p>
                            <p>Welcome to our app yore login detail for <b> {app_name}</b> is <br></p>
                            <p><b>Email   : </b>{vendor_email}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p><b>Vendor Address   : </b>{vendor_address}</p>
                            <p><b>Vendor Country   : </b>{vendor_country}</p>
                            <p><b>Vendor Zipcode   : </b>{vendor_zipcode}</p>
                            <p>Thank you for connecting with us,</p>
                            <p>{app_name}</p>',

                    'es' => '<p>Hallo,<b> {vendor_name} </b>!</p>
                            <p>Willkommen in unserer App für Ihre Login-Daten <b> {app_name}</b> ist <br></p>
                            <p><b>Email   : </b>{vendor_email}</p>
                            <p><b>App-URL    : </b>{app_url}</p>
                            <p><b>Adresse des Anbieters   : </b>{vendor_address}</p>
                            <p><b>Land des Anbieters   : </b>{vendor_country}</p>
                            <p><b>Postleitzahl des Anbieters   : </b>{vendor_zipcode}</p>
                            <p>Vielen Dank, dass Sie sich mit uns verbunden haben,</p>
                            <p>{app_name}</p>',

                    'fr' => '<p>Bonjour,<b> {vendor_name} </b>!</p>
                            <p>Bienvenue sur notre application autrefois les informations de connexion pour <b> {app_name}</b> est <br></p>
                            <p><b>E-mail   : </b>{vendor_email}</p>
                            <p><b>URL de l\'application    : </b>{app_url}</p>
                            <p><b>Adresse du vendeur   : </b>{vendor_address}</p>
                            <p><b>Pays du vendeur   : </b>{vendor_country}</p>
                            <p><b>Code postal du vendeur   : </b>{vendor_zipcode}</p>
                            <p>Merci de nous avoir contacté,</p>
                            <p>{app_name}</p>',

                    'it' => '<p>Ciao,<b> {vendor_name} </b>!</p>
                            <p>Benvenuto nella nostra app per i tuoi dati di accesso <b> {app_name}</b> è <br></p>
                            <p><b>E-mail   : </b>{vendor_email}</p>
                            <p><b>URL dell\'app    : </b>{app_url}</p>
                            <p><b>Indirizzo del venditore   : </b>{vendor_address}</p>
                            <p><b>Paese fornitore   : </b>{vendor_country}</p>
                            <p><b>Codice postale del venditore   : </b>{vendor_zipcode}</p>
                            <p>Grazie per esserti connesso con noi,</p>
                            <p>{app_name}</p>',

                    'ja' => '<p>こんにちは,<b> {vendor_name} </b>!</p>
                            <p>私たちのアプリのyoreログインの詳細へようこそ <b> {app_name}</b> は <br></p>
                            <p><b>Eメール   : </b>{vendor_email}</p>
                            <p><b>アプリのURL    : </b>{app_url}</p>
                            <p><b>ベンダーの住所   : </b>{vendor_address}</p>
                            <p><b>ベンダーの国   : </b>{vendor_country}</p>
                            <p><b>ベンダーの郵便番号   : </b>{vendor_zipcode}</p>
                            <p>ご連絡ありがとうございます,</p>
                            <p>{app_name}</p>',

                    'nl' => '<p>Hallo,<b> {vendor_name} </b>!</p>
                            <p>Welkom bij de inloggegevens van onze app voor: <b> {app_name}</b> is <br></p>
                            <p><b>E-mail   : </b>{vendor_email}</p>
                            <p><b>App-URL   : </b>{app_url}</p>
                            <p><b>Adres leverancier  : </b>{vendor_address}</p>
                            <p><b>Land van leverancier  : </b>{vendor_country}</p>
                            <p><b>Postcode leverancier   : </b>{vendor_zipcode}</p>
                            <p>Bedankt voor het contact met ons,</p>
                            <p>{app_name}</p>',

                    'pl' => '<p>Witam,<b> {vendor_name} </b>!</p>
                            <p>Witamy w naszej aplikacji yore dane logowania do <b> {app_name}</b> jest <br></p>
                            <p><b>E-mail   : </b>{vendor_email}</p>
                            <p><b>URL aplikacji    : </b>{app_url}</p>
                            <p><b>Adres dostawcy   : </b>{vendor_address}</p>
                            <p><b>Kraj dostawcy   : </b>{vendor_country}</p>
                            <p><b>Kod pocztowy dostawcy   : </b>{vendor_zipcode}</p>
                            <p>Dziękujemy za kontakt z nami,</p>
                            <p>{app_name}</p>',

                    'ru' => '<p>Привет,<b> {vendor_name} </b>!</p>
                            <p>Добро пожаловать в наше приложение. <b> {app_name}</b> является <br></p>
                            <p><b>Эл. адрес   : </b>{vendor_email}</p>
                            <p><b>URL приложения    : </b>{app_url}</p>
                            <p><b>Адрес поставщика   : </b>{vendor_address}</p>
                            <p><b>Страна поставщика   : </b>{vendor_country}</p>
                            <p><b>Почтовый индекс поставщика  : </b>{vendor_zipcode}</p>
                            <p>Спасибо, что связались с нами,</p>
                            <p>{app_name}</p>',

                    'pt' => '<p>Olá,<b> {vendor_name} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{vendor_email}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p><b>Endereço do fornecedor   : </b>{vendor_address}</p>
                            <p><b>País do fornecedor   : </b>{vendor_country}</p>
                            <p><b>CEP do fornecedor   : </b>{vendor_zipcode}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',

                    'tr' => '<p>Merhaba,<b> {vendor_name} </b>!</p>
                            <p>Uygulamamıza hoş geldiniz, eski <b> {app_name}</b> için giriş ayrıntısı <br></p>
                            <p><b>E-posta : </b>{vendor_email}</p>
                            <p><b>Uygulama urlsi : </b>{app_url}</p>
                            <p><b>Satıcı Adresi : </b>{vendor_address}</p>
                            <p><b>Satıcı Ülke : </b>{vendor_country}</p>
                            <p><b>Satıcı Posta Kodu : </b>{vendor_zipcode}</p>
                            <p>Bizimle bağlantı kurduğunuz için teşekkür ederiz,</p>
                            <p>{app_name}</p>',

                    'he' => '<p>שלום,<b> {vendor_name} </b>!</p>
                            <p>ברוך הבא לאפליקציה שלנו, פרטי ההתחברות של <b> {app_name}</b> הוא <br></p>
                            <p><b>דוא"ל: </b>{vendor_email}</p>
                            <p><b>כתובת אתר של אפליקציה: </b>{app_url}</p>
                            <p><b>כתובת ספק: </b>{vendor_address}</p>
                            <p><b>ארץ הספק: </b>{vendor_country}</p>
                            <p><b>מיקוד הספק: </b>{vendor_zipcode}</p>
                            <p>תודה שהתחברת אלינו,</p>
                            <p>{app_name}</p>',

                    'zh' => '<p>您好，<b> {vendor_name} </b>！</p>
                            <p>欢迎使用我们的应用，<b> {app_name}</b> 的登录详细信息是<br></p>
                            <p><b>电子邮件：</b>{vendor_email}</p>
                            <p><b>应用程序网址：</b>{app_url}</p>
                            <p><b>供应商地址：</b>{vendor_address}</p>
                            <p><b>供应商国家/地区：</b>{vendor_country}</p>
                            <p><b>供应商邮政编码：</b>{vendor_zipcode}</p>
                            <p>感谢您与我们联系，</p>
                            <p>{app_name}</p>',

                    'pt-br' => '<p>Olá,<b> {vendor_name} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{vendor_email}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p><b>Endereço do fornecedor   : </b>{vendor_address}</p>
                            <p><b>País do fornecedor   : </b>{vendor_country}</p>
                            <p><b>CEP do fornecedor   : </b>{vendor_zipcode}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',
                ],
            ],

            'New Quote' => [
                'subject' => 'New Quote',
                'lang' => [
                    'ar' => '<p>مرحبًا,<b> {quotation_customers} </b>!</p>
                            <p>مرحبًا بك في التطبيق الخاص بنا تفاصيل تسجيل الدخول الخاصة بـ <b> {app_name}</b> هو <br></p>
                            <p><b>البريد الإلكتروني   : </b>{customer_email}</p>
                            <p><b>عنوان url للتطبيق    : </b>{app_url}</p>
                            <p><b>رقم مرجع الاقتباس   : </b>{quotation_reference_no}</p>
                            <p><b>تاريخ الاقتباس  : </b>{quotation_date}</p>
                            <p>شكرا لتواصلك معنا,</p>
                            <p>{app_name}</p>',

                    'da' => '<p>Hej,<b> {quotation_customers} </b>!</p>
                            <p>Velkommen til vores app, hvor du kan logge ind <b> {app_name}</b> er <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p><b>Tilbudsreferencenr   : </b>{quotation_reference_no}</p>
                            <p><b>Tilbudsdato  : </b>{quotation_date}</p>
                            <p>Tak fordi du tog kontakt med os,</p>
                            <p>{app_name}</p>',

                    'de' => '<p>Hallo,<b> {quotation_customers} </b>!</p>
                            <p>Willkommen in unserer App für Ihre Login-Daten <b> {app_name}</b> ist <br></p>
                            <p><b>Email   : </b>{customer_email}</p>
                            <p><b>App-URL    : </b>{app_url}</p>
                            <p><b>Zitat-Referenz-Nr   : </b>{quotation_reference_no}</p>
                            <p><b>Angebotsdatum : </b>{quotation_date}</p>
                            <p>Vielen Dank, dass Sie sich mit uns verbunden haben,</p>
                            <p>{app_name}</p>',

                    'en' => '<p>Hello,<b> {quotation_customers} </b>!</p>
                            <p>Welcome to our app yore login detail for <b> {app_name}</b> is <br></p>
                            <p><b>Email   : </b>{customer_email}</p>
                            <p><b>App url    : </b>{app_url}</p>
                            <p><b>Quotation Reference No   : </b>{quotation_reference_no}</p>
                            <p><b>Quotation Date  : </b>{quotation_date}</p>
                            <p>Thank you for connecting with us,</p>
                            <p>{app_name}</p>',

                    'es' => '<p>Hola,<b> {quotation_customers} </b>!</p>
                            <p>Bienvenido a nuestra aplicación antaño detalles de inicio de sesión para <b> {app_name}</b> es <br></p>
                            <p><b>Correo electrónico   : </b>{customer_email}</p>
                            <p><b>URL de la aplicación    : </b>{app_url}</p>
                            <p><b>Número de referencia de cotización   : </b>{quotation_reference_no}</p>
                            <p><b>Fecha de cotización  : </b>{quotation_date}</p>
                            <p>Gracias por conectar con nosotras,</p>
                            <p>{app_name}</p>',

                    'fr' => '<p>Bonjour,<b> {quotation_customers} </b>!</p>
                            <p>Bienvenue sur notre application autrefois les informations de connexion pour <b> {app_name}</b> est <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL de l\'application   : </b>{app_url}</p>
                            <p><b>Référence du devis Non  : </b>{quotation_reference_no}</p>
                            <p><b>Date de cotation  : </b>{quotation_date}</p>
                            <p>Merci de nous avoir contacté,</p>
                            <p>{app_name}</p>',

                    'it' => '<p>Ciao,<b> {quotation_customers} </b>!</p>
                            <p>Benvenuto nella nostra app per i tuoi dati di accesso <b> {app_name}</b> è <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL dell\'app    : </b>{app_url}</p>
                            <p><b>Riferimento preventivo n   : </b>{quotation_reference_no}</p>
                            <p><b>Data di preventivo  : </b>{quotation_date}</p>
                            <p>Grazie per esserti connesso con noi,</p>
                            <p>{app_name}</p>',

                    'ja' => '<p>こんにちは,<b> {quotation_customers} </b>!</p>
                            <p>私たちのアプリのyoreログインの詳細へようこそ <b> {app_name}</b> は <br></p>
                            <p><b>Eメール   : </b>{customer_email}</p>
                            <p><b>アプリのURL    : </b>{app_url}</p>
                            <p><b>見積もり参照番号   : </b>{quotation_reference_no}</p>
                            <p><b>見積もり日  : </b>{quotation_date}</p>
                            <p>ご連絡ありがとうございます,</p>
                            <p>{app_name}</p>',

                    'nl' => '<p>Hallo,<b> {quotation_customers} </b>!</p>
                            <p>Welkom bij de inloggegevens van onze app voor: <b> {app_name}</b> is <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>App-URL    : </b>{app_url}</p>
                            <p><b>Referentienummer offerte:   : </b>{quotation_reference_no}</p>
                            <p><b>Offertedatum:  : </b>{quotation_date}</p>
                            <p>Bedankt voor het contact met ons,</p>
                            <p>{app_name}</p>',

                    'pl' => '<p>Witam,<b> {quotation_customers} </b>!</p>
                            <p>Witamy w naszej aplikacji yore dane logowania do <b> {app_name}</b> jest <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL aplikacji    : </b>{app_url}</p>
                            <p><b>Numer referencyjny oferty  : </b>{quotation_reference_no}</p>
                            <p><b>Data wyceny  : </b>{quotation_date}</p>
                            <p>Dziękujemy za kontakt z nami,</p>
                            <p>{app_name}</p>',

                    'ru' => '<p>Привет,<b> {quotation_customers} </b>!</p>
                            <p>Добро пожаловать в наше приложение. <b> {app_name}</b> является <br></p>
                            <p><b>Эл. адрес   : </b>{customer_email}</p>
                            <p><b>URL приложения    : </b>{app_url}</p>
                            <p><b>Цитата Номер ссылки   : </b>{quotation_reference_no}</p>
                            <p><b>Дата котировки  : </b>{quotation_date}</p>
                            <p>Спасибо, что связались с нами,</p>
                            <p>{app_name}</p>',

                    'pt' => '<p>Olá,<b> {quotation_customers} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p><b>Nº de referência de cotação   : </b>{quotation_reference_no}</p>
                            <p><b>Data de cotação  : </b>{quotation_date}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',

                    'tr' => '<p>Merhaba,<b> {quotation_customers} </b>!</p>
                            <p>Uygulamamıza hoş geldiniz, eski <b> {app_name}</b> için giriş ayrıntısı <br></p>
                            <p><b>E-posta : </b>{customer_email}</p>
                            <p><b>Uygulama url : </b>{app_url}</p>
                            <p><b>Teklif Referans No : </b>{quotation_reference_no}</p>
                            <p><b>Teklif Tarihi : </b>{quotation_date}</p>
                            <p>Bizimle bağlantı kurduğunuz için teşekkür ederiz,</p>
                            <p>{app_name}</p>',

                    'he' => '<p>שלום,<b> {quotation_customers} </b>!</p>
                            <p>ברוך הבא לאפליקציה שלנו, פרטי ההתחברות של <b> {app_name}</b> הוא <br></p>
                            <p><b>דוא"ל: </b>{customer_email}</p>
                            <p><b>כתובת אתר של אפליקציה: </b>{app_url}</p>
                            <p><b>מספר סימוכין להצעת מחיר: </b>{quotation_reference_no}</p>
                            <p><b>תאריך הצעת מחיר: </b>{quotation_date}</p>
                            <p>תודה שהתחברת אלינו,</p>
                            <p>{app_name}</p>',

                    'zh' => '<p>您好，<b> {quotation_customers} </b>！</p>
                            <p>欢迎使用我们的应用，<b> {app_name}</b> 的登录详细信息是<br></p>
                            <p><b>电子邮件：</b>{customer_email}</p>
                            <p><b>应用程序网址：</b>{app_url}</p>
                            <p><b>报价参考编号：</b>{quotation_reference_no}</p>
                            <p><b>报价日期：</b>{quotation_date}</p>
                            <p>感谢您与我们联系，</p>
                            <p>{app_name}</p>',

                    'pt-br' => '<p>Olá,<b> {quotation_customers} </b>!</p>
                            <p>Bem-vindo ao nosso aplicativo antigo detalhe de login para <b> {app_name}</b> é <br></p>
                            <p><b>E-mail   : </b>{customer_email}</p>
                            <p><b>URL do aplicativo    : </b>{app_url}</p>
                            <p><b>Nº de referência de cotação   : </b>{quotation_reference_no}</p>
                            <p><b>Data de cotação  : </b>{quotation_date}</p>
                            <p>Obrigado por conectar com a gente,</p>
                            <p>{app_name}</p>',
                ],
            ],
        ];

        $email = EmailTemplate::all();

        foreach ($email as $e) {
            foreach ($defaultTemplate[$e->name]['lang'] as $lang => $content) {
                EmailTemplateLang::create(
                    [
                        'parent_id' => $e->id,
                        'lang' => $lang,
                        'subject' => $defaultTemplate[$e->name]['subject'],
                        'content' => $content,
                    ]
                );
            }
        }
    }


    public static function userDefaultData()
    {
        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();
        foreach ($allEmail as $email) {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => 1,
                    'is_active' => 1,
                ]
            );
        }
    }

    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{user_name}',
            '{user_email}',
            '{user_password}',
            '{owner_name}',
            '{owner_email}',
            '{owner_password}',
            '{vendor_name}',
            '{vendor_email}',
            '{vendor_phone_number}',
            '{vendor_address}',
            '{vendor_country}',
            '{vendor_zipcode}',
            '{customer_name}',
            '{customer_email}',
            '{customer_phone_number}',
            '{customer_address}',
            '{customer_country}',
            '{customer_zipcode}',
            '{quotation_date}',
            '{quotation_reference_no}',
            '{quotation_customers}',
            '{app_name}',
            '{company_name}',
            '{app_url}',
            '{email}',
            '{password}',
        ];
        $arrValue    = [
            'user_name' => '-',
            'user_email' => '-',
            'user_password' => '-',
            'owner_name' => '-',
            'owner_email' => '-',
            'owner_password' => '-',
            'vendor_name' => '-',
            'vendor_email' => '-',
            'vendor_phone_number' => '-',
            'vendor_address' => '-',
            'vendor_country' => '-',
            'vendor_zipcode' => '-',
            'customer_name' => '-',
            'customer_email' => '-',
            'customer_phone_number' => '-',
            'customer_address' => '-',
            'customer_country' => '-',
            'customer_zipcode' => '-',
            'quotation_date' => '-',
            'quotation_reference_no' => '-',
            'quotation_customers' => '-',
            'app_name' => '-',
            'company_name' => '-',
            'app_url' => '-',
            'email' => '-',
            'password' => '-',
        ];

        foreach($obj as $key => $val)
        {
            $arrValue[$key] = $val;
        }

        $settings = Utility::settings();
        $company_name = $settings['company_name'];

        $arrValue['app_name']     =  $company_name;
        $arrValue['company_name'] = self::settings()['company_name'];
        $arrValue['app_url']      = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }



    public static function upload_file($request,$key_name,$name,$path,$custom_validation =[]){

        try{
            $settings = Utility::settings();
            // dd($settings);
            if(!empty($settings['storage_setting'])){
                if($settings['storage_setting'] == 'wasabi'){

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size'])? $settings['wasabi_max_upload_size']:'2048';
                    $mimes =  !empty($settings['wasabi_storage_validation'])? $settings['wasabi_storage_validation']:'';

                }else if($settings['storage_setting'] == 's3'){
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size'])? $settings['s3_max_upload_size']:'2048';
                    $mimes =  !empty($settings['s3_storage_validation'])? $settings['s3_storage_validation']:'';

                }else{
                    $max_size = !empty($settings['local_storage_max_upload_size'])? $settings['local_storage_max_upload_size']:'2048';

                    $mimes =  !empty($settings['local_storage_validation'])? $settings['local_storage_validation']:'';
                }


                $file = $request->$key_name;


                if(count($custom_validation) > 0){
                    $validation =$custom_validation;
                }else{

                    $validation =[
                        'mimes:'.$mimes,
                        'max:'.$max_size,
                    ];

                }
                $validator = \Validator::make($request->all(), [
                    $key_name =>$validation
                ]);

                if($validator->fails()){
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    // if($settings['storage_setting']=='local'){

                    //     \Storage::disk()->putFileAs(
                    //         $path,
                    //         $request->file($key_name),
                    //         $name
                    //     );
                    //     $path = $path.$name;
                    // }
                    if($settings['storage_setting']=='local')
                    {
                        $request->$key_name->move(storage_path($path), $name);
                        $path = $path.$name;
                    }
                    else if($settings['storage_setting'] == 'wasabi'){

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;

                    }else if($settings['storage_setting'] == 's3'){

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;
                    }


                    $res = [
                        'flag' => 1,
                        'msg'  =>'success',
                        'url'  => $path
                    ];
                    return $res;
                }

            }else{
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        }catch(\Exception $e){
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }


    public static function get_file($path){
        $settings = Utility::settings();

        try {
            if($settings['storage_setting'] == 'wasabi'){
                config(
                    [
                        'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                        'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                        'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                        'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                        'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                    ]
                );
            }elseif($settings['storage_setting'] == 's3'){
                config(
                    [
                        'filesystems.disks.s3.key' => $settings['s3_key'],
                        'filesystems.disks.s3.secret' => $settings['s3_secret'],
                        'filesystems.disks.s3.region' => $settings['s3_region'],
                        'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                        'filesystems.disks.s3.use_path_style_endpoint' => false,
                    ]
                );
            }

            return \Storage::disk($settings['storage_setting'])->url($path);
        } catch (\Throwable $th) {
            return '';
        }
    }
    public static function colorCodeData($type)
    {
        if($type == 'event')
        {
            return 1;
        }
        elseif ($type == 'zoom_meeting')
        {
            return 2;
        }
        elseif ($type == 'task')
        {
            return 3;
        }
        elseif ($type == 'appointment')
        {
            return 11;
        }
        elseif ($type == 'rotas')
        {
            return 3;
        }
        elseif ($type == 'holiday')
        {
            return 4;
        }
        elseif ($type == 'call')
        {
            return 10;
        }
        elseif ($type == 'meeting')
        {
            return 5;
        }
        elseif ($type == 'leave')
        {
            return 6;
        }
        elseif ($type == 'work_order')
        {
            return 7;
        }
        elseif ($type == 'lead')
        {
            return 7;
        }
        elseif ($type == 'deal')
        {
            return 8;
        }
        elseif ($type == 'interview_schedule')
        {
            return 9;
        }
        else{
            return 11;
        }


    }

    public static $colorCode=[
        1=>'event-warning',
        2=>'event-secondary',
        3=>'event-success',
        4=>'event-warning',
        5=>'event-danger',
        6=>'event-dark',
        7=>'event-black',
        8=>'event-info',
        9=>'event-secondary',
        10=>'event-success',
        11=>'event-warning',

    ];


    public static function send_twilio_msg($to,$slug,$obj,$user_id = null)
    {

        $notification_template = NotificationTemplates::where('slug',$slug)->first();
// dd($notification_template);
        if (!empty($notification_template) && !empty($obj))
        {
            if(!empty($user_id))
            {
                $user = User::find($user_id);
                // dd($user);
            }
            else
            {
                $user = \Auth::user();
                // dd('hi');
            }
            $curr_noti_tempLang = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', $user->lang)->where('created_by', '=', $user->id)->first();
            // dd($curr_noti_tempLang);
            if(empty($curr_noti_tempLang))
            {
                $curr_noti_tempLang = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', $user->lang)->first();
            }
            if(empty($curr_noti_tempLang))
            {
                $curr_noti_tempLang       = NotificationTemplateLangs::where('parent_id', '=', $notification_template->id)->where('lang', 'en')->first();
            }
            if (!empty($curr_noti_tempLang) && !empty($curr_noti_tempLang->content))
            {
                $msg = self::replaceVariable($curr_noti_tempLang->content, $obj);
            }
        }

        // For testing commant dd
    //    dd($msg);    

        if (isset($msg))
        {
            $settings = Utility::settingsById($user->id);
            $account_sid = $settings['twilio_sid'];
            $auth_token = $settings['twilio_token'];
            $twilio_number = $settings['twilio_from'];
            try {
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($to, [
                    'from' => $twilio_number,
                    'body' => $msg,
                ]);
            } catch (\Exception $e) {
            }
        }


    }


    public static function googleCalendarConfig()
    {
        $setting = Utility::settings();
      //  $path = storage_path('googlecalender/'.$setting['google_calender_json_file']);
        $path=storage_path($setting['google_calender_json_file']);
        config([
            'google-calendar.default_auth_profile' => 'service_account',
            'google-calendar.auth_profiles.service_account.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.token_json' => $path,
            'google-calendar.calendar_id' => isset($setting['google_clender_id'])?$setting['google_clender_id']:'',
            'google-calendar.user_to_impersonate' => '',

        ]);
    }

    public static function addCalendarData($request , $type)
    {

        Self::googleCalendarConfig();

        $event = new GoogleEvent();
        $event->name = $request->title;
        $event->startDateTime = Carbon::parse($request->start);
        $event->endDateTime = Carbon::parse($request->end);
        $event->colorId = Self::colorCodeData($type);

        $event->save();
    }

    public static function getCalendarData( $type)
    {

        Self::googleCalendarConfig();

        $data= GoogleEvent::get();

        $type=Self::colorCodeData($type);
        $arrayJson = [];
        foreach($data as $val)
        {
            $end_date=date_create($val->endDateTime);
            date_add($end_date,date_interval_create_from_date_string("1 days"));

            if($val->colorId=="$type"){

                $arrayJson[] = [
                    "id"=> $val->id,
                    "title" => $val->summary,
                    "start" => $val->startDateTime,
                    "end" => date_format($end_date,"Y-m-d H:i:s"),
                    "className" => Self::$colorCode[$type],
                    "allDay" => true,
                ];
            }

        }

        return $arrayJson;
    }


    public static function getSeoSetting()
    {

        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        $data     = $data->get();
        $settings = [
           
            "meta_image" => "",
            "meta_keywords" => "",
            "meta_description" => "",
        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    
    public static function webhookSetting($module)
    {
        
        $webhook = Webhook::where('module', $module)->where('created_by', '=', \Auth::user()->creatorId())->first();
        // dd($webhook);
        if (!empty($webhook)) {
            $url = $webhook->url;
            $method = $webhook->method;
            $reference_url  = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $data['method'] = $method;
            $data['reference_url'] = $reference_url;
            $data['url'] = $url;
            return $data;
        }
        return false;
    }
    
    public static function WebhookCall($url = null, $parameter = null, $method = 'POST')
    {

        if (!empty($url) && !empty($parameter)) {
            try {

                $curlHandle = curl_init($url);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameter);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                $curlResponse = curl_exec($curlHandle);
                curl_close($curlHandle);
                if (empty($curlResponse)) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return false;
        }
    }



    public static function flagOfCountry(){
        $arr = [
            'ar' => '🇦🇪 ar',
            'da' => '🇩🇰 da',
            'de' => '🇩🇪 de',
            'es' => '🇪🇸 es',
            'fr' => '🇫🇷 fr',
            'it' =>  '🇮🇹 it',
            'ja' => '🇯🇵 ja',
            'nl' => '🇳🇱 nl',
            'pl'=> '🇵🇱 pl',
            'ru' => '🇷🇺 ru',
            'pt' => '🇵🇹 pt',
            'en' => '🇮🇳 en',
            'tr' => '🇹🇷 tr',
            'pt-br' => '🇵🇹 pt-br',
        ];
        return $arr;
    }

    // public static function get_plan_id(){
    //     $user_plan = User::where('id',\Auth::user()->creatorId())->pluck('plan_id');
    //     $plan = Plan::where('id',$user_plan)->first();
    //     // dd($plan);
    //     return $plan['enable_chatgpt'];
    // }

    public static function langList(){
        $languages = [
            "ar" => "Arabic",
            "zh" => "Chinese",
            "da" => "Danish",
            "de" => "German",
            "en" => "English",
            "es" => "Spanish",
            "fr" => "French",
            "he" => "Hebrew",
            "it" => "Italian",
            "ja" => "Japanese",
            "nl" => "Dutch",
            "pl" => "Polish",
            "pt" => "Portuguese",
            "ru" => "Russian",
            "tr" => "Turkish",
            "pt-br" => "Portuguese(Brazil)",
        ];
        return $languages;
    }

    public static function languagecreate(){
        
        $languages=Utility::langList();
        foreach($languages as $key => $lang)
        {
            $languageExist = Languages::where('code',$key)->first();
            if(empty($languageExist))
            {
                $language = new Languages();
                $language->code = $key;
                $language->fullName = $lang;
                $language->save();
            }
        }
    }
    public static function langSetting(){
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1)->get();
        if (count($data) == 0) {
            $data = DB::table('settings')->where('created_by', '=', 1)->get();
        }
        $settings= [];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }


    public static function priceFormat($settings, $price)
    {
        return (($settings['site_currency_symbol_position'] == "pre") ? $settings['site_currency_symbol'] : '') . number_format($price, 2) . (($settings['site_currency_symbol_position'] == "post") ? $settings['site_currency_symbol'] : '');
    }
    

}
