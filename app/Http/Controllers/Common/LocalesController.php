<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocalesController extends Controller
{
    public function switch(Request $request)
    {
        if (in_array($request->input('locale'), config('translatable.locales'))) {
            $locale = $request->input('locale');
            \Session::put('locale', $locale);
        }

        return back();
    }
}
