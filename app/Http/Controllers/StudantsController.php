<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class StudantsController extends Controller
{

    public function list()
    {
        try {
            return response()->json(
                \App\Studant::with('user')->get()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function get($id)
    {
        try {
            return response()->json(
                \App\Studant::with('user')->findOrFail($id)
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
                \App\Studant::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }
            $studant = new \App\Studant();
            $studant->user_id = $request->input('user_id');
            $studant->service_id = $request->input('service_id');
            $studant->teacher_id = $request->input('teacher_id');
            $studant->family_id = $request->input('family_id');
            $studant->responsible_id = $request->input('responsible_id');
            $studant->responsible_kinship = $request->input('responsible_kinship');
            $studant->other_kinship = $request->input('other_kinship');
            $studant->school_id = $request->input('school_id');
            $studant->entry_date = $request->input('entry_date');
            $studant->grade = $request->input('grade');
            $studant->subject = $request->input('subject');
            $studant->info = $request->input('info');
            $studant->calendar_color = $request->input('calendar_color');
            $studant->payment_method = $request->input('payment_method');
            $studant->payment_value = $request->input('payment_value');
            $studant->discount = $request->input('discount');
            $studant->save();
            return response()->json(
                $studant, 201
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
            //     \App\Studant::$rules
            // );
            // if($validator->fails()) {
            //     return response()->json(
            //         $validator->messages(), 422
            //     )->setEncodingOptions(JSON_NUMERIC_CHECK);
            // }
            $studant = \App\Studant::findOrFail($id);
            if($request->has('service_id')) {
                $studant->service_id = $request->input('service_id');
            }
            if($request->has('teacher_id')) {
                $studant->teacher_id = $request->input('teacher_id');
            }
            if($request->has('family_id')) {
                $studant->family_id = $request->input('family_id');
            }
            if($request->has('responsible_id')) {
                $studant->responsible_id = $request->input('responsible_id');
            }
            if($request->has('responsible_kinship')) {
                $studant->responsible_kinship = $request->input('responsible_kinship');
            }
            if($request->has('other_kinship')) {
                $studant->other_kinship = $request->input('other_kinship');
            }
            if($request->has('school_id')) {
                $studant->school_id = $request->input('school_id');
            }
            if($request->has('entry_date')) {
                $studant->entry_date = $request->input('entry_date');
            }
            if($request->has('grade')) {
                $studant->grade = $request->input('grade');
            }
            if($request->has('subject')) {
                $studant->subject = $request->input('subject');
            }
            if($request->has('info')) {
                $studant->info = $request->input('info');
            }
            if($request->has('calendar_color')) {
                $studant->calendar_color = $request->input('calendar_color');
            }
            if($request->has('payment_method')) {
                $studant->payment_method = $request->input('payment_method');
            }
            if($request->has('payment_value')) {
                $studant->payment_value = $request->input('payment_value');
            }
            if($request->has('discount')) {
                $studant->discount = $request->input('discount');
            }
            $studant->save();
            return response()->json(
                $studant, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $studant = \App\Studant::findOrFail($id);
            if($studant->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
