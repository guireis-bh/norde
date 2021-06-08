<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeTypesController extends Controller
{
    public function list()
    {
        return response()->json(
            \App\EmployeeType::all()
        )->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
}
