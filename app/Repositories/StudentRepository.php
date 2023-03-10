<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository
{
    /**
     * create new instance
     *
     * @param Student $model
     */
    public function __construct(Student $model)
    {
        $this->model = $model;         
    }

    public function all()
    {
        return $this->model->all();
    }
    

    public function list()
    {
        $lists = Student::orderBy('created_at', 'decs')->paginate(15);
        return $lists;
    }
    
    // create new record
    public function create(array $data)
    {
        $data = $this->setPayload($data);
		return $this->model->create($data);
    }
    
    // update record in the database
    public function update(array $data, $id){
        $record = $this->find($id);
        $data = $this->setPayload($data);
        return $record->update($data);
    }
    
    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
    
    private function setPayload(array $payload)
	{
		return [
            'univ_roll_no'            =>    $payload['univ_roll_no'],
            'class_roll_no'           =>    $payload['class_roll_no'],
            'name'                    =>    $payload['name'],
            'batch'                   =>    $payload['batch'],
            'branch_type'             =>    $payload['branch_type'],
            'stream'                  =>    $payload['stream'],
            'training_sem'            =>    $payload['training_sem'],
            'shift'                   =>    $payload['shift'],
            'section'                 =>    $payload['section'],
            'email'                   =>    $payload['email'],
            'phone_number'            =>    $payload['phone_number'],
            'gender'                  =>    $payload['gender'],
            'category'                =>    $payload['category'],
            'blood_group'             =>    $payload['blood_group'],
            'height'                  =>    $payload['height'],
            'weight'                  =>    $payload['weight'],
            'father_name'             =>    $payload['father_name'],
            'father_phone_number'     =>    $payload['father_phone_number'],
            'mother_name'             =>    $payload['mother_name'],
            'mother_phone_number'     =>    $payload['mother_phone_number'],
            'address'                 =>    $payload['address'],
            'city'                    =>    $payload['city'],
            'state'                   =>    $payload['state'],
            'district'                =>    $payload['district'],
            'pincode'                 =>    $payload['pincode'],
            'form_status'             =>    $payload['form_status'],
        ];
	}
}