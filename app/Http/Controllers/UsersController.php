<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Excel;
use DB;
use Exception;
use App\Services\UserService;

class UsersController extends Controller
{
    public $successStatus = 200;
    
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //data fetched from database in $User
        $this->service->listUser();
        return $request->json([
            'list' => $lists,
        ],
        $this->successStatus);
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(CreateUserExcelRequest $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            if($request->hasFile('user_file')){
                try{
                    DB::beginTransaction();
                    $path = $request->file('user_file')->getRealPath();
                    $data = Excel::load($path)->get();
                    if($data->count()){
                        foreach ($data as $key => $value) {
                            $password=str_random(6);
                            $user[] = [
                                'name'    => $value->name, 
                                'username' => $value->username,
                                'email' => $value->email,
                                'phone_number' => $value->phone_number,
                                'password'=>bcrypt($password),
                                'type'=>$type
                            ];
                        }
                        if(!empty($user)){
                            $userCreate = $this->service->createUser($user);
                            DB::commit();    
                            //DB::table('users')->insert($arr);
                            return response() //Json response with status 200 and token and user type
                            ->json([
                                'response'=>'Inserted',
                                'postCreate' => $userCreate,
                            ],
                            $this->successStatus);
                        }
                        else{
                            return response()->json(['error' => 'Post Failed'], 401); //Json response with status 401 and error message
                        }
                    }
                }
                catch(Exception $e){
                    DB::rollback();
                    return $this->respondException($e);
                }
            }
        }
    }
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(User $user)
    {
        return request()->json($user , $this->successStatus);
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
