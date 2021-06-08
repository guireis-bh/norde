<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolsController extends Controller
{
    public function list()
    {
        return response()->json(
            \App\School::all()
        )->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
}
