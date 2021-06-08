<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function list()
    {
        try {
            return response()->json(
                \App\User::with('address')->get()
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
                \App\User::$rules
            );
            if($validator->fails()) {
                return response()->json(
                    $validator->messages(), 422
                )->setEncodingOptions(JSON_NUMERIC_CHECK);
            }

            $user = new \App\User();
            $user->status_id = $request->input('status', 1);
            $user->salute = $request->input('salute');
            $user->name = $request->input('name');
            $user->surname = $request->input('surname');
            $user->birthday = $request->input('birthday');
            $user->rg = $request->input('rg');
            $user->cpf = $request->input('cpf');
            $user->email = $request->input('email');
            $user->email2 = $request->input('email2');
            $user->cellphone = $request->input('cellphone');
            $user->homephone = $request->input('homephone');
            $user->workphone = $request->input('workphone');
            $user->know_from = $request->input('know_from');
            $user->address_id = $request->input('address_id');
            if(!$request->has('password')) {
                $temporary = str_random(8);
            }
            $user->password = \Hash::make($request->input('password', $temporary ?? null));
            $user->save();
            $user->assignRole($request->input('role', null));
            $this->processSubjects($request->input('subjects', false), $user);
            if(!empty($temporary)) {
                $user->configs()->create([
                    'key' => 'temporary_password',
                    'value' => $temporary,
                    'type' => 'string'
                ]);
            }
            return response()->json(
                $user, 201
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
            //     \App\User::$rules
            // );
            // if($validator->fails()) {
            //     return response()->json(
            //         $validator->messages(), 422
            //     )->setEncodingOptions(JSON_NUMERIC_CHECK);
            // }

            $user = \App\User::findOrFail($id);
            if($request->has('status_id')) {
                $user->status_id = $request->input('status', 1);
            }
            if($request->has('salute')) {
                $user->salute = $request->input('salute');
            }
            if($request->has('name')) {
                $user->name = $request->input('name');
            }
            if($request->has('surname')) {
                $user->surname = $request->input('surname');
            }
            if($request->has('birthday')) {
                $user->birthday = $request->input('birthday');
            }
            if($request->has('rg')) {
                $user->rg = $request->input('rg');
            }
            if($request->has('cpf')) {
                $user->cpf = $request->input('cpf');
            }
            if($request->has('email')) {
                $user->email = $request->input('email');
            }
            if($request->has('email2')) {
                $user->email2 = $request->input('email2');
            }
            if($request->has('cellphone')) {
                $user->cellphone = $request->input('cellphone');
            }
            if($request->has('homephone')) {
                $user->homephone = $request->input('homephone');
            }
            if($request->has('workphone')) {
                $user->workphone = $request->input('workphone');
            }
            if($request->has('know_from')) {
                $user->know_from = $request->input('know_from');
            }
            if($request->has('address_id')) {
                $user->address_id = $request->input('address_id');
            }
            if($request->has('password')) {
                $user->password = \Hash::make($request->input('password'));
            }
            $this->processSubjects($request->input('subjects', false), $user);
            $user->save();
            if($request->has('role')) {
                $user->assignRole($request->input('role', null));
            }
            return response()->json(
                $user, 201
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function get($id)
    {
        try {
            return response()->json(
                \App\User::with(['address', 'configs'])->findOrFail($id)
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function delete($id)
    {
        try {
            $user = \App\User::findOrFail($id);
            if($user->delete()) {
                return response('', 204);
            }
            return response('', 500);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function sendCreatedMail($id)
    {
        try {
            $user = \App\User::findOrFail($id);
            Mail::to($user)->send(new \App\Mail\CreatedUser($user));
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = \App\User::where('id', $request->user()->id)
                ->firstOrFail();
            if(!\Hash::check($request->input('old'), $user->password)) {
                return response('Senha incorreta', 500);
            }
            if($request->input('password') !== $request->input('repassword')) {
                return response('Senhas diferentes', 500);
            }
            $user->password = \Hash::make($request->input('password'));
            $user->save();
            return response('', 201);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function simplifiedPermissions(Request $request)
    {
        try {
            $permissions = array_map(function ($permission) {
                return $permission['name'];
            }, $request->user()->getAllPermissions()->toArray());
            return response()->json($permissions)
                ->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    /**
     * Undocumented function
     *
     * @param array $subjects
     * @param User $user
     * @return void
     */
    private function processSubjects($subjects, &$user)
    {
        try {
            if(is_array($subjects)) {
                $user->subjects()->sync($subjects);
            }
        } catch(\Exception $e) {
            dd($e);
        }
    }
}
