<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{

    public function list()
    {
        try {
            return response()->json(
                \App\Schedule::all()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function listStudants($id)
    {
        try {
            return response()->json(
                \App\ScheduleStudant::where('schedule_id', $id)->get()
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function get($id)
    {
        try {
            return response()->json(
                \App\Schedule::findOrFail($id)
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function getStudant($id)
    {
        try {
            return response()->json(
                \App\ScheduleStudant::findOrFail($id)
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
                \App\Schedule::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
     
     
            }
            $schedule = new \App\Schedule();
            $schedule->teacher_id = $request->input('teacher_id');
            $schedule->day = $request->input('day');
            $schedule->hour_end = $request->input('hour_end');
            $schedule->hour_begin = $request->input('hour_begin');
            $schedule->time_left = $request->input('time_left', 0);
            $schedule->save();
            return response()->json(
                $schedule, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function storeStudant(Request $request, $scheduleID)
    {
        try {
            $scheduleStudant = new \App\ScheduleStudant();
            $scheduleStudant->schedule_id = $request->input('schedule_id');
            $scheduleStudant->studant_id = $request->input('studant_id');
            $scheduleStudant->time_reserved = $request->input('time_reserved');
            $scheduleStudant->save();
            return response()->json(
                $scheduleStudant, 201
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
            //     \App\Schedule::$rules
            // );
            // if($validator->fails()) {
            //     return response()->json(
            //         $validator->messages(), 422
            //     )->setEncodingOptions(JSON_NUMERIC_CHECK);
     
     
            // }
            $schedule = \App\Schedule::findOrFail($id);
            if($request->has('day')) {
                $schedule->day = $request->input('day');
            }
            if($request->has('hour_end')) {
                $schedule->hour_end = $request->input('hour_end');
            }
            if($request->has('hour_begin')) {
                $schedule->hour_begin = $request->input('hour_begin');
            }
            if($request->has('time_left')) {
                $schedule->time_left = $request->input('time_left');
            }
            $schedule->save();
            return response()->json(
                $schedule, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function updateStudant(Request $request, $id)
    {
        try {
            $scheduleStudant = \App\ScheduleStudant::findOrFail($id);
            $scheduleStudant->time_done = $request->input('time_done');
            $scheduleStudant->save();
            return response()->json(
                $scheduleStudant, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $schedule = \App\Schedule::findOrFail($id);
            if($schedule->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function deleteStudant($id)
    {
        try {
            $scheduleStudant = \App\ScheduleStudant::findOrFail($id);
            if($scheduleStudant->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
