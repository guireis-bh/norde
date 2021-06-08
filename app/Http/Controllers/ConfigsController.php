<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{

    public function list()
    {
        try {
            return response()->json(
                \App\Config::with('user')->get()
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
                \App\Config::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }
            $config = new \App\Config();
            $config->user_id = $request->input('user_id');
            $config->key = $request->input('key');
            $config->type = $request->input('type');
            $config->value = $request->input('value');
            return response()->json(
                $config, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function userConfigs($id)
    {
        try {
            return response()->json(
                \App\Config::where('user_id', $id)->get()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function userPatch(Request $request, $id)
    {
        try {
            $configsData = $request->all();
            $configs = [];
            foreach($configsData as $config) {
                $config['user_id'] = $id;
                $configs[] = \App\Config::create($config);
            }
            return response()->json(
                $configs, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $config = \App\Config::findOrFail($id);
            if($config->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function updateUserConfig(Request $request, $id, $slug)
    {
        try {
            $config = \App\Config::where('key', $slug)
                ->where('user_id', $id)->first() ?? new \App\Config();
            $configData = [
                'key' => $slug,
                'user_id' => $id,
                'value' => $request->input('value'),
                'type' => $request->input('type', 'string'),
            ];
            $validator = Validator::make(
                $configData,
                \App\Config::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }
            $config->fill($configData);
            $config->save();

            return response()->json($config, 201)
                ->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
