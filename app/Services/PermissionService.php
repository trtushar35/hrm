<?php

namespace App\Services;

use App\Models\Permission;
use Spatie\Permission\Models\Permission as SpatiePermission;

class PermissionService
{
    protected $permissionModel,$spatiePermissionModel;

    public function __construct(Permission $permissionModel,SpatiePermission $spatiePermissionModel)
    {
        $this->permissionModel = $permissionModel;
        $this->spatiePermissionModel = $spatiePermissionModel;
    }

    public function list()
    {
        return $this->permissionModel->query();
    }
    public function parentList()
    {
        return $this->permissionModel->whereNull('parent_id')->get();
    }

    public function all()
    {
        return $this->permissionModel->all();
    }

    public function find($id)
    {
        return $this->permissionModel->find($id);
    }

    public function create(array $data)
    {
        return $this->permissionModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->permissionModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function updateByName(array $data, $name)
    {
        $dataInfo = $this->permissionModel->where('name',$name)->firstOrFail();

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        return $this->permissionModel->find($id)->delete();

    }

    public function changeStatus($request)
    {
        $dataInfo = $this->permissionModel->findOrFail($request->id);

        $dataInfo->update($request->all());

        return $dataInfo;
    }
    public function listWithAllChild()
    {
        return $this->permissionModel
                ->whereNull('parent_id')
                ->with('child','child.child')
                ->get();
    }
}
