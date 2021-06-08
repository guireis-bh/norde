<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Cria um usuário
     *
     * @param Request $request
     * @return \App\User
     */
    protected function createUser(Request $request)
    {
        try {
            $address = $this->createAddress($request);

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
            $user->password = $request->input('password', str_random(8));
            $user->address_id = $address->id;
            $user->save();

            return $user;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Cria um endereço
     *
     * @param Request $request
     * @return \App\Address
     */
    protected function createAddress(Request $request)
    {
        try {
            
        } catch(\Exception $e) {
            throw $e;
        }
    }
}
