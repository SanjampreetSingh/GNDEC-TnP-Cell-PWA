<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Services\StudentService;
use DB;
use Exception;
use Notification;
use Auth;

class StudentsController extends Controller
{
    public function __construct(StudentService $service)
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
        $student = Student::orderBy('created_at', 'decs')->paginate(30);
        return $this->respondData($student);
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
    public function store(CreateStudentRequest $request)
    {
        $student = $request->all();
        try {
            DB::beginTransaction();
            if (!$student) {
                return $this->respondUnauthorized('Student Registeration Failed');
            }
            $studentCreate = $this->service->createStudent($student);
            DB::commit();
            $data=[
                'StudentCreate' => $studentCreate
            ];
            return $this->respondSuccess('Inserted',$data);
        }
        catch (Exception $e) {
            DB::rollback();
            return $this->respondException($e);
        }
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Student $student)
    {
        $student = $this->student->where('id', $student)->first();
        return $this->respondData($student);
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Student $student)
    {
        return $this->respondData($student);
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Student $student)
    {
        try {
            DB::beginTransaction();
            if(!$student){
                return $this->respondError('Failed', 401); 
            }
            $student = $this->service->updateStudent($request->all(),$student->id);
            DB::commit();
            return $this->respondSuccess('Updated',$student);
        } catch (Exception $e) {
            DB::rollback();
            return $this->respondException($e);
        }
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Student $student)
    {
        $this->service->deleteStudent($student->id);
        return $this->respondSuccess('Deleted');
    }
}
