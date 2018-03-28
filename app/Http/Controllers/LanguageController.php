<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function LangJs()
    {
        $lang = config('app.locale');
        $strings = Cache::rememberForever('lang.js', function () {
            $lang = config('app.locale');

            $file   = glob(resource_path('lang/' . $lang . '.json'));
            $strings = require $file;

            return $strings;
        });

        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        exit();
    }
}
