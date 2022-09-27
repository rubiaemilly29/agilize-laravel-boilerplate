<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ProvaController
{
    public function __construct(
    )
    {

    }

    public function create(Request $request)
    {
        dd($request->query());
    }
}