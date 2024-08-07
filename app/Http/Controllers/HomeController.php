<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $data;

    /**
     * Show home page.
     * 
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        $setting = Settings::find(6);
        $this->data['deleted_order'] = $setting->value;

        return view("home.show", $this->data);
    }
}
