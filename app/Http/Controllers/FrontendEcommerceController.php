<?php

namespace App\Http\Controllers;

class FrontendEcommerceController extends Controller
{
    public function index()
    {
        return view('client.e-commerce');
    }
}