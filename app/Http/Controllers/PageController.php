<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display FAQ page
     */
    public function faq()
    {
        return view('public.pages.faq');
    }

    /**
     * Display Legal Notice page
     */
    public function legalNotice()
    {
        return view('public.pages.legal-notice');
    }

    /**
     * Display Terms and Conditions page
     */
    public function terms()
    {
        return view('public.pages.terms');
    }

    /**
     * Display Privacy Policy page
     */
    public function privacy()
    {
        return view('public.pages.privacy');
    }
}
