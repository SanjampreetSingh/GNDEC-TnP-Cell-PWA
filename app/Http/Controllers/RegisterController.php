<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\SetPasswordRequest;
use DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\RegisterService;

class RegisterController extends Controller
{
    public function __construct(RegisterService $service)
    {
        $this->service = $service;
        
    }
    
    public function register(UserRegisterRequest $request)
    {
        $values = $request->all();
        $user = User::where([
            ['username', '=',$values['username']],
            [ 'email', '=',$values['email']],
            ['phone_number', '=',$values['phone_number']]
            ])->first();
            if (!$token = JWTAuth::fromUser($user)) {
                return $this->respondUnauthorized();
            }
            try{
                $data = [
                    'access_token' => $token,
                    'authenticated' => true
                ];
                return $this->respondSuccess('User Verified', $data);
            }   
            catch(JWTException $e)
            {
                DB::rollback();
                return $this->respondException($e);
            }   
        }  
        
        public function setPassword(SetPasswordRequest $request){
            $auth = JWTAuth::parseToken()->authenticate();
            $password = $request->only('password');
            $user = JWTAuth::user();
            try{
                DB::beginTransaction();
                $user->password = bcrypt($password['password']);
                $user->is_verified = true;
                $user->save();
                DB::commit();
                $this->service->RegisterMailWithInstructions();
                return $this->respondSuccess('Congrats!! Your password has been set successfully!', $user);
            }
            catch(JWTException $e)
            {
                DB::rollback();
                return $this->respondException($e);
            }   
            
            
        }
        
    }
    