<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleToEmployeeRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateEmployeeStatusRequest;
use App\Http\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $adminService;
    public function __construct(AdminService $service){
        $this->adminService = $service;
    }

    public function createRole(CreateRoleRequest $request)
    {
        return $this->adminService ->createRole($request);
    }
    public function updateEmployeeStatus(UpdateEmployeeStatusRequest $request, $id)
    {
        return $this->adminService ->updateStatus($request, $id);
    }
    public function adminDashboard()
    {
        return $this->adminService->adminDashboard();
    }
    public function assignRole(AssignRoleToEmployeeRequest $request)
    {
        return $this->adminService ->assignRole($request);
    }
}
