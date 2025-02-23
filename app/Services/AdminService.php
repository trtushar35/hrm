<?php

namespace App\Services;

use App\Models\Admin;

class AdminService
{
    protected $adminModel;

    public function __construct(Admin $adminModel)
    {
        $this->adminModel = $adminModel;
    }

    public function list()
    {
        return $this->adminModel->with('department', 'designation')->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->adminModel->with('department', 'designation')->whereNull('deleted_at')->all();
    }

    public function find($id)
    {
        return $this->adminModel->with('department', 'designation')->find($id);
    }

    public function create(array $data)
    {
        return $this->adminModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->adminModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->adminModel->find($id);


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
        $dataInfo = $this->adminModel->findOrFail($request->id);

        $dataInfo->update(['status' =>$request->status]);

        return $dataInfo;
    }

    public function AdminExists($userName)
    {
        return $this->adminModel->whereNull('deleted_at')
            ->where(function ($q) use ($userName) {
                $q->where('email', strtolower($userName))
                    ->orWhere('phone', $userName);
            })->first();
    }


    public function activeList()
    {
        return $this->adminModel->with('department', 'designation')->whereNull('deleted_at')->where('status', 'Active')->get();
    }
}
