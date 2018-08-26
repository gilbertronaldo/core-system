<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/26/18
 * Time: 8:44 PM
 */

namespace GilbertRonaldo\CoreSystem\Controllers;

use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class AuthController
 * @package GilbertRonaldo\CoreSystem\Controllers
 */
class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = auth()->attempt($credentials)) {
                throw new CoreException('Invalid Credentials', 401);
            }

            $data = $this->responseWithToken($token);
            $response = CoreResponse::ok($data);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return array
     */
    public function logout()
    {
        try {

            auth()->invalidate();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * Get the token array structure.
     *
     * @param $token
     * @return array
     */
    private function responseWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
