<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    protected $employeeModel;

    public function __construct(Employee $employeeModel)
    {
        $this->employeeModel = $employeeModel;
    }

    public function list()
    {
        return $this->employeeModel->with('department', 'designation')->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->employeeModel->with('department', 'designation')->whereNull('deleted_at')->all();
    }

    public function find($id)
    {
        return $this->employeeModel->with('department', 'designation')->find($id);
    }

    public function create(array $data)
    {
        return $this->employeeModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->employeeModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->employeeModel->find($id);

        if (!empty($dataInfo)) {
            $dataInfo->deleted_at = date('Y-m-d H:i:s');
            $dataInfo->status = 'Deleted';
            $dataInfo->save();

            return $dataInfo;
        }
        return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->employeeModel->findOrFail($request->id);

        $dataInfo->update(['status' =>$request->status]);

        return $dataInfo;
    }

    public function activeList()
    {
        return $this->employeeModel->with('department', 'designation')->whereNull('deleted_at')->where('status', 'Active')->get();
    }
}
