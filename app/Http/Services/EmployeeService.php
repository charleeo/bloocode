<?php
namespace  App\Http\Services;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeService {

    public function create(CreateEmployeeRequest $request) {
        $validated = $request->validated();
        try {
            $employee = Employee::create($validated);
            if( $employee ) {
                return response()->json([
                    'message' => 'Employee created',
                    'data' => $employee,
                    'status' => true,
                    'error' => false
                ],201);
            }else{
                return response()->json([
                    'message' => 'Employee was not created. Please retry',
                    'data' => null,
                    'status' => false,
                    'error' => true
                ],200);
            }
        }catch (Exception $e) {
            info(''. $e->getMessage());
            return response()->json([
                'message' => 'There was an internal server error',
                'data' => null,
                'status' => false,
                'error' => true
            ],500);
        }
    }
    public function update(UpdateEmployeeRequest $request, $id) {
        $validated = $request->validated();
        try {
            $employee = Employee::findOrFail($id);
            if( $employee ) {
                 $employee->update($validated);
                return response()->json([
                    'message' => 'Employee updated',
                    'data' => $employee,
                    'status' => true,
                    'error' => false
                ],200);
            }else{
                return response()->json([
                    'message' => 'Employee was not updated. Please retry',
                    'data' => null,
                    'status' => false,
                    'error' => true
                ],200);
            }
        }catch (Exception $e) {
            return response()->json([
                'message' => 'There was an internal server error',
                'data' => null,
                'status' => false,
                'error' => true
            ],500);
        }
    }

    public function show($id)
    {
        try{
            $employee = DB::table('employees')
            ->leftJoin('assignments', 'assignments.employee_id', 'employees.id')
            ->leftJoin('roles', 'roles.id', 'assignments.role_id')
            ->where('employees.id', $id)
            ->select(
                'employees.name as employee_name',
                'employees.email',
                'employees.status',
                'roles.name as role'
            )->get();

            if( $employee ) {
                return response()->json([
                    'message' => 'Employee found',
                    'data' => $employee,
                    'status' => true,
                    'error' => false
                ],200);
        }else{
            return response()->json([
                'message' => 'Employee not found',
                'data' => $employee,
                'status' => false,
                'error' => true
            ],200);

        }

        }catch(Exception $e) {
            info('erro'. $e->getMessage());
            return response()->json([
                'message' => 'There was an internal server error',
                'data' => null,
                'status' => false,
                'error' => true
            ],500);

        }
    }
    public function index()
    {
        try{
            $employees = DB::table('employees')
            ->leftJoin('assignments', 'assignments.employee_id', 'employees.id')
            ->leftJoin('roles', 'roles.id', 'assignments.role_id')
            ->select(
                'employees.name as employee_name',
                'employees.email',
                'employees.status',
                'roles.name as role'
            )->get();
            if( $employees ) {
            return response()->json([
                'message' => 'Employee found',
                'data' => $employees,
                'status' => true,
                'error' => false
            ],200);
        }else{
            return response()->json([
                'message' => 'Employee not found',
                'data' => $employees,
                'status' => false,
                'error' => true
            ],200);

        }

        }catch(Exception $e) {
            info(''. $e->getMessage());
            return response()->json([
                'message' => 'There was an internal server error',
                'data' => null,
                'status' => false,
                'error' => true
            ],500);

        }
    }

    public function delete($id)
    {
        try{

            $employee = Employee::findOrFail($id);
            $employee->delete();
            return response()->json([
                'message' => 'Employee deleted',
                'data' => $employee,
                'status' => true,
                'error' => false
            ],200);
        } catch(Exception $e) {
            info(''. $e->getMessage());
            return response()->json([
                'message' => 'There was an internal server error',
                'data' => null,
                'status' => false,
                'error' => true
            ],500);

        }
    }

    public function search(Request $request)
    {
        $name = $request->query('name');
        $id = $request->query('id');
        
        $employees = Employee::where('name', 'like', '%' . $name . '%')
        ->orWhere('id', $id)
        ->get();
        if(count($employees) > 0) {
            return response()->json([
                'message' => 'Employee found',
                'data' => $employees,
                'status' => true,
                'error' => false
            ],200);
            
        }else{
            return response()->json([
                'message' => 'No Employee found',
                'data' => $employees,
                'status' => false,
                'error' => true
            ],200);

        }
    }

    
}