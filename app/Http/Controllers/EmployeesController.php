<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function list()
    {
        try {
            return response()->json(
                \App\Employee::with(['user'])->get()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function get($id)
    {
        try {
            return response()->json(
                \App\Employee::with(['user'])->findOrFail($id)
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function listTeachers()
    {
        try {
            $techer = \App\EmployeeType::where('role', 'teacher')->first();
            return response()->json(
                \App\Employee::with(['user'])->where('type_id', $techer->id)->get()
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
                \App\Employee::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }

            $employee = new \App\Employee();
            $employee->user_id = $request->input('user_id');
            $employee->type_id = $request->input('type_id');
            $employee->bio = $request->input('bio');
            $employee->know_from = $request->input('know_from');
            $employee->hiring_date = $request->input('hiring_date');
            $employee->salary_type = $request->input('salary_type');
            $employee->salary = $request->input('salary');
            $employee->bank_name = $request->input('bank_name');
            $employee->bank_office = $request->input('bank_office');
            $employee->bank_account = $request->input('bank_account');
            $employee->bank_city = $request->input('bank_city');
            $employee->save();
            return response()->json(
                $employee, 201
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
            //     \App\Employee::$rules
            // );
            // if($validator->fails()) {
            //     return response()->json(
            //         $validator->messages(), 422
            //     )->setEncodingOptions(JSON_NUMERIC_CHECK);
            // }

            $employee = \App\Employee::find($id);
            if($request->has('type_id')) {
                $employee->type_id = $request->input('type_id');
            }
            if($request->has('bio')) {
                $employee->bio = $request->input('bio');
            }
            if($request->has('know_from')) {
                $employee->know_from = $request->input('know_from');
            }
            if($request->has('hiring_date')) {
                $employee->hiring_date = $request->input('hiring_date');
            }
            if($request->has('salary_type')) {
                $employee->salary_type = $request->input('salary_type');
            }
            if($request->has('salary')) {
                $employee->salary = $request->input('salary');
            }
            if($request->has('bank_name')) {
                $employee->bank_name = $request->input('bank_name');
            }
            if($request->has('bank_office')) {
                $employee->bank_office = $request->input('bank_office');
            }
            if($request->has('bank_account')) {
                $employee->bank_account = $request->input('bank_account');
            }
            if($request->has('bank_city')) {
                $employee->bank_city = $request->input('bank_city');
            }
            $employee->save();
            return response()->json(
                $employee, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $employee = \App\Employee::findOrFail($id);
            if($employee->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
