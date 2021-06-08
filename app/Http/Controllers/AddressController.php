<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function list()
    {
        try {
            return response()->json(
                \App\Address::with('user')->get()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function get($id)
    {
        try {
            return response()->json(
                \App\Address::with('user')->findOrFail($id)
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
                \App\Address::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }

            $address = new \App\Address();
            $address->street = $request->input('street');
            $address->number = $request->input('number');
            $address->city = $request->input('city');
            $address->state = $request->input('state');
            $address->complement = $request->input('complement');
            $address->district = $request->input('district');
            $address->postalcode = $request->input('postalcode');
            $address->country = $request->input('country');
            $address->save();
            return response()->json(
                $address->toArray(), 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);;
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $address = \App\Address::findOrFail($id);
            if($address->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // $validator = Validator::make(
            //     $request->all(),
            //     \App\Address::$rules
            // );
            // if($validator->fails()) {
            //     return response()->json(
            //         $validator->messages(), 422
            //     )->setEncodingOptions(JSON_NUMERIC_CHECK);
            // }

            $address = \App\Address::findOrFail($id);
            if($request->has('street')) {
                $address->street = $request->input('street');
            }
            if($request->has('number')) {
                $address->number = $request->input('number');
            }
            if($request->has('city')) {
                $address->city = $request->input('city');
            }
            if($request->has('state')) {
                $address->state = $request->input('state');
            }
            if($request->has('complement')) {
                $address->complement = $request->input('complement');
            }
            if($request->has('district')) {
                $address->district = $request->input('district');
            }
            if($request->has('postalcode')) {
                $address->postalcode = $request->input('postalcode');
            }
            if($request->has('country')) {
                $address->country = $request->input('country');
            }
            $address->save();
            return response()->json(
                $address->toArray(), 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);;
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
