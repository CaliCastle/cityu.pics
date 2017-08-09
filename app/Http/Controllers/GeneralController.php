<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * Switches language by cookie.
     *
     * @param $language
     * @return $this
     */
    public function switchLanguage($language)
    {
        return redirect()->back()->withCookie(cookie()->forever('lang', $language));
    }
}
