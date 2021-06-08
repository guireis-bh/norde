<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class FamiliesController extends Controller
{

    public function list()
    {
        try {
            return response()->json(
                \App\Family::with('relatives.user')->get()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function get($id)
    {
        try {
            return response()->json(
                \App\Family::with('relatives.user')->findOrFail($id)
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function listResponsibles($id)
    {
        try {
            return response()->json(
                \App\Family::with('relatives.user')->findOrFail($id)
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
                \App\Family::$rules
            );

            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }

            $family = new \App\Family();
            $family->name = $request->input('name');
            $family->save();
            return response()->json(
                $family, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // $validator = Validator::make(
            //     $request->all(),
            //     \App\Family::$rules
            // );

            // if($validator->fails()) {
            //     return response()->json(
            //         $validator->messages(), 422
            //     )->setEncodingOptions(JSON_NUMERIC_CHECK);
            // }

            $family = \App\Family::findOrFail($id);
            if($request->has('name')) {
                $family->name = $request->input('name');
            }
            $family->save();
            return response()->json(
                $family, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $family = \App\Family::findOrFail($id);
            if($family->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
