<?php
namespace App\Http\Responses;
use Laravel\Fortify\Contracts\LoginResponse as ContractsLoginResponse;

class LoginResponse implements ContractsLoginResponse
{
  public function toResponse($request)
  {
    // return $request;
    // $accessToken = $request->user()->createToken('UeducationToken');
    return response()->json([
      // 'accessToken' => $accessToken->plainTextToken
      'accessToken' => $request->user()->createToken('UeducationToken')->plainTextToken
    ],200);
  }
}


?>