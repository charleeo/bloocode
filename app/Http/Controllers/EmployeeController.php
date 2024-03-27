<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
   private $employeeService;
    public function __construct(EmployeeService $service){
        $this->employeeService = $service;
    }

    public function index(){
        return $this->employeeService->index();
    }
    public function create(CreateEmployeeRequest $request){
        return $this->employeeService->create($request);
    }
    public function update(UpdateEmployeeRequest $request,$id){
        return $this->employeeService->update($request, $id);
    }
    public function show($id){
        return $this->employeeService->show( $id);
    }
    public function delete($id){
        return $this->employeeService->delete( $id);
    }
    public function search(Request $request){
        return $this->employeeService->search( $request);
    }
}
