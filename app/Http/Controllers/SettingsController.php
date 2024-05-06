<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function show(): View
    {
        $settings = Settings::all()->keyBy('id');
        return view('settings.show', [
            'taxRate' => $settings[Settings::DEFAULT_TAX_RATE]->value,
            'deliveryCharge' => $settings[Settings::DEFAULT_DELIVERY_CHARGE]->value,
            'discount' => $settings[Settings::DEFAULT_DISCOUNT]->value,
            // 'sendEmail' => $settings[Settings::SEND_EMAIL]->value,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {

        $request->validate([
            'tax_rate' => ['required', 'integer', 'between:0,100'],
            'delivery_charge' => ['required', 'digits_between:0,' . PHP_INT_MAX],
            'discount' => ['required', 'digits_between:0,' . PHP_INT_MAX],
            // 'send_email' => ['required', 'boolean'],
        ]);

        Settings::updateDefaultTaxRate($request->tax_rate);
        Settings::updateDefaultDeliveryCharge($request->delivery_charge);
        Settings::updateDefaultDiscount($request->discount);
        // Settings::updateDefaultEmailPreference($request->send_email);

        return Redirect::back()->with("success", Lang::get("messages.settings_update"));
    }


    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'min:4'],
        ]);


        if ($request->current_password != (string)Settings::routePassword()) {
            throw ValidationException::withMessages([
                'current_password' => [Lang::get('auth.password')],
            ]);
        }

        Settings::updateRoutePassword($request->new_password);
        return Redirect::back()->with("success", Lang::get("messages.settings_update"));
    }
}
