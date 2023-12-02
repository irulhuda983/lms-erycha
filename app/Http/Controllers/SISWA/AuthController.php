<?php

namespace App\Http\Controllers\SISWA;

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
    
    public function issueTokenPeserta(ServerRequestInterface $request, Request $request2)
    {
        $request2->validate([
            'username' => "required|min:4|alpha_dash",
            'password' => 'required|min:6|max:25|string',
        ]);

        // $user = User::where('username', $request2->username)->orWhere('email', $request2->username)->first();

        // if( $user->role != 'siswa' ){
        //     return response()->json([
        //         'error' => 'forbidden',
        //         'message' => ['anda tidak mempunyai akses ke sini']
        //     ], 403);
        // }

        // $availableToken = DB::table('oauth_access_tokens')->where('user_id', $user->id)->where('revoked', 0)->first();

        // if($availableToken) {
        //     return response()->json([
        //         'error' => 'bad request',
        //         'message' => 'Akun anda sudah login di perangkat lain, hubungi administrator untuk mereset login anda.'
        //     ], 400);
        // }
        
        $response = parent::issueToken($request);
        $body = json_decode($response->content());

        if (isset($body->error)){
            return response()->json(['message' => 'Username dan sandi salah'], 403);
        }

        $oauth = (Controller::userAccessTokenId($body->access_token));
        $user = User::find($oauth->user_id);

        if( $user->role != 'siswa' ){
            return response()->json([
                'error' => 'forbidden',
                'message' => ['anda tidak mempunyai akses ke sini']
            ], 403);
        }

        if ($oauth){
            $affected = DB::table('oauth_access_tokens')->where('user_id', $oauth->user_id)->where('id', '!=', $oauth->id)->where('client_id', $oauth->client_id)->update([
                'revoked' => 1
            ]);
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
            $user = $request->user();
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->update(['revoked' => 1]);
            $user->save();

            return response()->json(['success' => true, 'error' => null, 'message' => 'success']);

            // $authToken = $request->header('authorization');
            // list($type, $token) = explode(' ', $authToken);


            // $tokenModel = Controller::userAccessTokenId($token);
            // if (!DB::table('oauth_access_tokens')->where('id', $tokenModel->id)->update(['revoked' => 1])){
            //     return response()->json([
            //         'success' => false,
            //         'error' => 'Internal Server Error',
            //         'message' => 'Internal Server Error',
            //     ], 500);
            // }

            // return response()->json(['success' => true, 'error' => null, 'message' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Internal Server Error',
                'message' => 'Internal Server Error',
            ], 500);
        }

    }
}
