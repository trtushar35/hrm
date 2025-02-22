<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    protected $departmentModel;

    public function __construct(Department $departmentModel)
    {
        $this->departmentModel = $departmentModel;
    }

    public function list()
    {
        return $this->departmentModel->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->departmentModel->whereNull('deleted_at')->all();
    }

    public function find($id)
    {
        return $this->departmentModel->find($id);
    }

    public function create(array $data)
    {
        return $this->departmentModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->departmentModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->departmentModel->find($id);

        if (!empty($dataInfo)) {

            $dataInfo->deleted_at = date('Y-m-d H:i:s');

            $dataInfo->status = 'Deleted';

            return ($dataInfo->save());
        }
        return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->departmentModel->findOrFail($request->id);

        $dataInfo->update(['status' => $request->status]);

        return $dataInfo;
    }

    public function activeList()
    {
        return $this->departmentModel->whereNull('deleted_at')->where('status', 'Active')->get();
    }

}
