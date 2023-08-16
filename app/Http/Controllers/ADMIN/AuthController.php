<?php

namespace App\Http\Controllers\ADMIN;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class AuthController extends AccessTokenController
{
    
    public function issueTokenAdmin(ServerRequestInterface $request, Request $request2)
    {
        $request2->validate([
            'username' => "required|min:4|alpha_dash",
            'password' => 'required|min:6|max:25|string',
        ]);
        
        $response = parent::issueToken($request);
        $body = json_decode($response->content());

        if (isset($body->error)){
            return response()->json(['message' => 'Username dan sandi salah'], 403);
        }

        $oauth = (Controller::userAccessTokenId($body->access_token));
        $user = User::find($oauth->user_id);

        if( $user->role == 'siswa' ){
            return response()->json([
                'error' => 'forbidden',
                'message' => ['anda tidak mempunyai akses ke sini']
            ], 403);
        }

        return response()->json([
            'user' =>  new UserResource($user),
            'token' => $body,
        ]);
    }

    public function refreshToken(ServerRequestInterface $request)
    {
        $response = parent::issueToken($request);
        $body = json_decode($response->content());

        if (isset($body->error)){
            return response()->json(['message' => 'Username dan sandi salah'], 403);
        }

        $oauth = (Controller::userAccessTokenId($body->access_token));
        $user = User::find($oauth->user_id);

        return response()->json($body);
    }

    public function getMe(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function logout(Request $request) {
        try {
            $authToken = $request->header('authorization');
            list($type, $token) = explode(' ', $authToken);
            $tokenModel = Controller::userAccessTokenId($token);
            if (!DB::table('oauth_access_tokens')->where('id', $tokenModel->id)->update(['revoked' => 1])){
                return response()->json([
                    'success' => false,
                    'error' => 'Internal Server Error',
                    'message' => 'Internal Server Error',
                ], 500);
            }

            return response()->json(['success' => true, 'error' => null, 'message' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Internal Server Error',
                'message' => 'Internal Server Error',
            ], 500);
        }

    }
}
