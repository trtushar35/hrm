<?php

namespace App\Services;

use App\Models\Designation;

class DesignationService
{
    protected $designationModel;

    public function __construct(Designation $designationModel)
    {
        $this->designationModel = $designationModel;
    }

    public function list()
    {
        return $this->designationModel->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->designationModel->whereNull('deleted_at')->all();
    }

    public function find($id)
    {
        return $this->designationModel->find($id);
    }

    public function create(array $data)
    {
        return $this->designationModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->designationModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->designationModel->find($id);

        if (!empty($dataInfo)) {

            $dataInfo->deleted_at = date('Y-m-d H:i:s');

            $dataInfo->status = 'Deleted';

            return ($dataInfo->save());
        }
        return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->designationModel->findOrFail($request->id);

        $dataInfo->update(['status' => $request->status]);

        return $dataInfo;
    }

    public function activeList()
    {
        return $this->designationModel->whereNull('deleted_at')->where('status', 'Active')->get();
    }

}
