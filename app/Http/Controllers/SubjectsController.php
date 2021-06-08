<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function list()
    {
        try {
            return response()->json(
                \App\Subject::all()
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
                \App\Subject::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }

            $employee = new \App\Subject();
            $employee->name = $request->input('name');
            $employee->save();
            return response()->json(
                $employee, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function patch(Request $request)
    {
        try {
            $patchsData = $request->all();
            $subjects = [];
            foreach($patchsData as $subject) {
                $subjects[] = \App\Subject::create($subject);
            }
            return response()->json(
                $subjects, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $subject = \App\Subject::findOrFail($id);
            if($subject->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function getByUser($userID) {
        try {
            $user = \App\User::findOrFail($userID);
            return response()->json(
                $user->subjects
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
