<?php

namespace App\Services;

use App\Models\Role;
use Spatie\Permission\Models\Role as SpatieRole;

class RoleService
{
    protected $roleModel;
    protected $spatieRoleModel;

    public function __construct(Role $roleModel,SpatieRole $spatieRoleModel)
    {
        $this->roleModel = $roleModel;
        $this->spatieRoleModel = $spatieRoleModel;
    }

    public function list()
    {
        return $this->roleModel->query();
    }

    public function all()
    {
        return $this->roleModel->all();
    }

    public function find($id)
    {
        return $this->roleModel->find($id);
    }
    public function spatieRoleFind($id)
    {
        $roleInfo= $this->spatieRoleModel->find($id);
        $roleInfo->permission_ids=$roleInfo->permissions->pluck('id')->toArray();
        return $roleInfo;
    }

    public function create(array $data)
    {
        return $this->roleModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->roleModel->findOrFail($id);

        $dataInfo->name=$data['name'];

        $dataInfo->guard_name=$data['guard_name'];

        $dataInfo->updated_at=now();

        return $dataInfo->save();
    }

    public function delete($id)
    {
        return $this->roleModel->find($id)->delete();

        // if(!empty($dataInfo)){

        //     $dataInfo->deleted_at=date('Y-m-d H:i:s');

        //     $dataInfo->status='Deleted';

        //     return ($dataInfo->save());
        // }
        //     return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->roleModel->findOrFail($request->id);

        $dataInfo->update($request->all());

        return $dataInfo;
    }

    public function syncPermissions($roleId,$permissions)
    {
        $roleInfo=$this->spatieRoleModel->find($roleId);

        $roleInfo->syncPermissions($permissions);

        return $roleInfo;
    }
    public function roleHasPermission($roleId)
    {
        $roleInfo=$this->spatieRoleModel->find($roleId);

        $roleInfo->syncPermissions($permissions);

        return $roleInfo;
    }
}
