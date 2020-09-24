<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SellersController extends Controller
{
    public function show(User $seller): View
    {
        return view('client.sellers.show', compact('seller'));
    }
}
