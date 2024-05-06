<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class Settings extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
    ];


    const DEFAULT_TAX_RATE = 1;
    const DEFAULT_DELIVERY_CHARGE = 2;
    const DEFAULT_DISCOUNT = 3;
    const SEND_EMAIL = 4;
    const ROUTE_PASSWORD = 5;


    public static $settingsNames = [
        self::DEFAULT_TAX_RATE => "Default Tax Rate",
        self::DEFAULT_DELIVERY_CHARGE => "Default Delivery Charge",
        self::DEFAULT_DISCOUNT => "Default Discount",
        self::SEND_EMAIL => "Send Email",
        self::ROUTE_PASSWORD => "Send Email",
    ];
    public static $settingsValues = [
        self::DEFAULT_TAX_RATE => 0,
        self::DEFAULT_DELIVERY_CHARGE => 0,
        self::DEFAULT_DISCOUNT => 0,
        self::SEND_EMAIL => false,
        self::ROUTE_PASSWORD => "5556", //should hash
    ];

    /**
     * Tax Rate Preference.
     *
     */
    public static function getDefaultTaxRate()
    {
        return Settings::find(self::DEFAULT_TAX_RATE);
    }

    public static function defaultTaxRateValue(): float
    {
        return self::getDefaultTaxRate()->value;
    }

    public static function updateDefaultTaxRate(float $value)
    {
        self::getDefaultTaxRate()->update(['value' => $value]);
    }


    /**
     * Delivery Charge Preference.
     *
     */
    public static function getDefaultDeliveryCharge()
    {
        return Settings::find(self::DEFAULT_DELIVERY_CHARGE);
    }

    public static function defaultDeliveryChargeValue(): float
    {
        return self::getDefaultDeliveryCharge()->value;
    }

    public static function updateDefaultDeliveryCharge(float $value): void
    {
        self::getDefaultDeliveryCharge()->update(['value' => $value]);
    }


    /**
     * Discount Preference.
     *
     */
    public static function getDefaultDiscount()
    {
        return Settings::find(self::DEFAULT_DISCOUNT);
    }

    public static function defaultDiscountValue(): float
    {
        return self::getDefaultDiscount()->value;
    }

    public static function updateDefaultDiscount(float $value): void
    {
        self::getDefaultDiscount()->update(['value' => $value]);
    }

    /**
     * Email Preference.
     *
     */
    public static function getEmailPreference()
    {
        return Settings::find(self::SEND_EMAIL);
    }

    public static function sendCustomerEmail(): bool
    {
        return self::getEmailPreference()->value;
    }

    public static function updateDefaultEmailPreference(bool $value): void
    {
        self::getEmailPreference()->update(['value' => $value]);
    }



    /**
     * Route password Preference.
     *
     */
    public static function getRoutePassword()
    {
        return Settings::find(self::ROUTE_PASSWORD);
    }

    public static function routePassword()
    {
        return self::getRoutePassword()->value;
    }

    public static function updateRoutePassword($value)
    {
        //Hash::make($value);
        self::getRoutePassword()->update(['value' => $value]);
    }
}
