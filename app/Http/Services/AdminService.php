<?php
namespace App\Http\Services;

use App\Http\Requests\AssignRoleToEmployeeRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateEmployeeStatusRequest;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Role;
use Exception;

class AdminService {
    public function assignRole(AssignRoleToEmployeeRequest $request)
    {
        $validated = $request->validated();
        $assignment=null;
        $employee = Employee::findOrFail($validated['employee_id']);
        
        if($employee){

          $assignment =  Assignment::updateOrCreate(
                [ 'employee_id' => $validated['employee_id']], 

                $validated
            );
        }
       
        return response()->json([
            'message' => 'Role created',
            'data' => $assignment,
            'status' => true,
            'error' => false
        ],201);
    }

    public function createRole(CreateRoleRequest $request)
    {
        $validated = $request->validated();
        try {
            $role = Role::updateOrCreate($validated);
            if( $role ) {
                return response()->json([
                    'message' => 'Role created',
                    'data' => $role,
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
            return response()->json([
                'message' => 'There was an internal server error',
                'data' => null,
                'status' => false,
                'error' => true
            ],500);
        }
    }

    public function updateStatus(UpdateEmployeeStatusRequest $request, $id)
    {
        try{
            $employee = Employee::findOrFail($id);
            $employee->status = $request->input('status');
            $employee->save();
            return response()->json([
                'message' => 'Employee status updated',
                'data' => $employee,
                'status' => true,
                'error' => false
            ],200);

        }
        catch (Exception $e) {
            info(''. $e->getMessage());
            return response()->json([
                'message' => 'There was an internal server error',
                'data' => null,
                'status' => false,
                'error' => true
            ],500);
        }

    }

    public function adminDashboard()
    {
        $totalEmployees = Employee::count();
   
        $totalRoles = Role::count();
        return response()->json([
            'status' => true,
            'data' => [
                'total_roles' => $totalRoles,
                'total_employees' => $totalEmployees,

            ],
            'error' => false,
            'message' => 'Dashbaord data'
        ]);
    }

}