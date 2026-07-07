<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function privacy(Request $request): View
    {
        $lang = $this->resolveLang($request);

        return view('pages.privacy', ['lang' => $lang]);
    }

    public function terms(Request $request): View
    {
        $lang = $this->resolveLang($request);

        return view('pages.terms', ['lang' => $lang]);
    }

    private function resolveLang(Request $request): string
    {
        if ($request->has('lang') && in_array($request->lang, ['en', 'id'])) {
            session(['pages_lang' => $request->lang]);

            return $request->lang;
        }

        return session('pages_lang', 'en');
    }
}
