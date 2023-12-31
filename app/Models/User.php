<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'parent_id',
        'type',
        'branch_id',
        'cash_register_id',
        'lang',
        'mode',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch','id','branch_id');
    }

    public function cashregister()
    {
        return $this->hasOne('App\Models\CashRegister','id','cash_register_id');
    }

    public function priceFormat($price)
    {
        $settings = Utility::settings();

        return (($settings['site_currency_symbol_position'] == "pre") ? $settings['site_currency_symbol'] : '') . number_format($price, 2) . (($settings['site_currency_symbol_position'] == "post") ? $settings['site_currency_symbol'] : '');
    }

    public function currencySymbol()
    {
        $settings = Utility::settings();

        return $settings['site_currency_symbol'];
    }

    public function dateFormat($date)
    {
        $settings = Utility::settings();

        return date($settings['site_date_format'], strtotime($date));
    }

    public function timeFormat($time)
    {
        $settings = Utility::settings();

        return date($settings['site_time_format'], strtotime($time));
    }

    public function datetimeFormat($datetime)
    {
        $settings = Utility::settings();

        return date($settings['site_date_format'], strtotime($datetime)) . ' ' . date($settings['site_time_format'], strtotime($datetime));
    }
    public function barcodeFormat()
    {
        $settings = Utility::settings();
        return isset($settings['barcode_format'])?$settings['barcode_format']:'code128';
    }
    public function barcodeType()
    {
        $settings = Utility::settings();
        return isset($settings['barcode_type'])?$settings['barcode_type']:'css';
    }

    public function purchaseInvoiceNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["purchase_invoice_prefix"] . sprintf("%05d", $number);
    }

    public static function saleInvoiceNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["sale_invoice_prefix"] . sprintf("%05d", $number);
    }

    public function purchaseInvoiceColor()
    {
        $settings = Utility::settings();

        return $settings['purchase_invoice_color'];
    }

    public function sellInvoiceNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["sale_invoice_prefix"] . sprintf("%05d", $number);
    }

    public function sellInvoiceColor()
    {
        $settings = Utility::settings();

        return $settings['sale_invoice_color'];
    }

    public function quotationInvoiceNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["quotation_invoice_prefix"] . sprintf("%05d", $number);
    }

    public function quotationInvoiceColor()
    {
        $settings = Utility::settings();

        return $settings['quotation_invoice_color'];
    }

    public function getCreatedBy()
    {
        return ($this->parent_id == '0') ? $this->id : $this->parent_id;
    }

    public function creatorId()
    {
        return ($this->parent_id == '0') ? $this->id : $this->parent_id;
    }


    public function isOwner()
    {
        return $this->parent_id == 0 && $this->branch_id == 0 && $this->cash_register_id == 0;
    }

    public function isUser()
    {
        return $this->parent_id != 0 && $this->parent_id == 1 && $this->branch_id != 0 && $this->cash_register_id != 0;
    }
    public static function getDefualtViewRouteByModule($module)
    {
        $userId      = \Auth::user()->id;
        // $defaultView = UserDefualtView::select('route')->where('module', $module)->where('user_id', $userId)->first();

        return !empty($defaultView) ? $defaultView->route : '';
    }

    public static function userDefaultDataRegister($user_id)
    {
        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();

        foreach ($allEmail as $email) {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => $user_id,
                    'is_active' => 1,
                ]
            );
        }
    }
}
