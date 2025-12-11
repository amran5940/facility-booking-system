<?php

namespace App\Controllers;

class LanguageController extends BaseController
{
    public function switch($locale = 'ms')
    {
        // Validate locale
        $supportedLocales = ['ms', 'en'];
        
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'ms';
        }
        
        // Set locale in session
        session()->set('locale', $locale);
        
        // Set the locale for the current request
        $this->request->setLocale($locale);
        
        // Redirect back to previous page
        return redirect()->back()->with('success', 'Language changed successfully');
    }
}
