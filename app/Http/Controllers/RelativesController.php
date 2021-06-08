<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class RelativesController extends Controller
{

    public function list()
    {
        try {
            return response()->json(
                \App\Relative::with(['user', 'family'])->get()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                \App\Relative::$rules
            );

            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }
            $relative = new \App\Relative();
            $relative->user_id = $request->input('user_id');
            $relative->family_id = $request->input('family_id');
            $relative->save();
            return response()->json(
                $relative, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request, $id) {
        try {
            // $validator = Validator::make(
            //     $request->all(),
            //     \App\Relative::$rules
            // );

            // if($validator->fails()) {
            //     return response()->json(
            //         $validator->messages(), 422
            //     )->setEncodingOptions(JSON_NUMERIC_CHECK);
            // }
            $relative = \App\Relative::findOrFail($id);
            if($request->has('user_id')) {
                $relative->user_id = $request->input('user_id');
            }
            if($request->has('family_id')) {
                $relative->family_id = $request->input('family_id');
            }
            $relative->save();
            return response()->json(
                $relative, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $delete = \App\Relative::findOrFail($id);
            if($delete->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
