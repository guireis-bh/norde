<?php
namespace App\Http\Controllers\Auth;

use Exception;
use App\User;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;

class AccessTokenController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
     /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    public function issueToken(ServerRequestInterface $request)
    {
        try {

            $username = $request->getParsedBody()['username'];
            $user = new \App\User();
            $data = $user->findForPassport($username)->toArray();
            $data['oauth'] = json_decode(parent::issueToken($request)->getContent(), true);
            
            if(isset($data['oauth']["error"])) {
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);
            }

            $data['redirect'] = $this->redirectTo;
            return response()->json($data);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 401);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            return response()->json(['message' => 'A senha não confere com o usuário'], 401);
        }
        catch (Exception $e) {
            return response()->json(['message' => 'Ocerreu algum erro no login, tente novamente mais tarde'], 500);
        }
    }
}