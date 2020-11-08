<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\SendsAPIResponses;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    use SendsAPIResponses;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return $this->sendErrorAPIResponse(['errors' => $validator->errors()
                                                                      ->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $request['password']       = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user                      = User::create($request->toArray());
        $token                     = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response                  = ['token' => $token];

        return $this->sendSuccessAPIResponse($response, Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'    => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->sendErrorAPIResponse(['errors' => $validator->errors()
                                                                      ->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::where('username', $request->username)
                    ->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token    = $user->createToken('Laravel Password Grant Client')->accessToken;

                return \response()->json([
                                             'error' => false,
                                             'access_token' => $token
                                         ], Response::HTTP_OK);
            } else {
                $response = ["message" => "Password mismatch"];

                return $this->sendErrorAPIResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            $response = ["message" => 'User does not exist'];

            return $this->sendErrorAPIResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()
                         ->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];

        return $this->sendSuccessAPIResponse($response, Response::HTTP_OK);
    }

    public function welcome(Request $request)
    {
        $response = ['message' => 'You have been successfully logged in!'];

        $key         = "my-jwt-key";
        $response = JWT::encode($response, $key, 'HS256');
        return $this->sendSuccessAPIResponse($response, Response::HTTP_OK);
    }

    public function getBinaryData(Request $request){
        return $this->binarySearch($request->array, $request->search);
    }

    public function binarySearch(Array $arr, $x)
    {
        if (empty($arr)) {
            return $this->sendErrorAPIResponse('Empty Array', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $low = 0;
        $high = count($arr) - 1;

        while ($low <= $high) {
            // compute middle index
            $mid = floor(($low + $high) / 2);

            // element found at mid
            if($arr[$mid] == $x) {
                return $this->sendSuccessAPIResponse("Element Found", Response::HTTP_OK);
            }

            if ($x < $arr[$mid]) {
                // search the left side of the array
                $high = $mid -1;
            }
            else {
                // search the right side of the array
                $low = $mid + 1;
            }
        }

        // If we reach here element x doesnt exist
        return $this->sendErrorAPIResponse('Not Found', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
