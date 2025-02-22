<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Inertia\Inertia;
use App\Http\Requests\RoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Services\AdminService;
use App\Traits\SystemTrait;
use Illuminate\Support\Facades\DB;
use Exception;

class RoleController extends Controller
{
    use SystemTrait;

    protected $roleService, $permissionService, $AdminService;


    public function __construct(RoleService $roleService, PermissionService $permissionService, AdminService $AdminService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->AdminService = $AdminService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Role/Index',
            [
                'pageTitle' => fn () => 'Role List',
                'breadcrumbs' => fn () => [
                    ['link' => null, 'title' => 'Role Manage'],
                    ['link' => route('backend.role.index'), 'title' => 'Role List'],
                ],
                'tableHeaders' => fn () => $this->getTableHeaders(),
                'dataFields' => fn () => $this->dataFields(),
                'datas' => fn () => $this->getDatas(),
                'filters' => request()->only(['numOfData', 'name']),
            ]
        );
    }



    private function getDatas()
    {
        $query = $this->roleService->list();


        if (request()->filled('name')) {
            $query->where(function ($q) {
                $q->where('name', 'like', request()->name . '%');
            });
        }

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;
            $customData->role_name = $data->name;
            $customData->guard_name = $data->guard_name;

            $customData->hasLink = true;
            $customData->links = [

                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.role.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.role.destroy', $data->id),
                    'linkLabel' => getLinkLabel('Delete', null, null)
                ]
            ];
            return $customData;
        });

        return regeneratePagination($formatedDatas, $datas->total(), $datas->perPage(), $datas->currentPage());
    }

    private function dataFields()
    {
        return [
            ['fieldName' => 'index', 'class' => 'text-center'],
            ['fieldName' => 'role_name', 'class' => 'text-center'],
            ['fieldName' => 'guard_name', 'class' => 'text-center'],
        ];
    }
    private function getTableHeaders()
    {
        return [
            'Sl/No',
            'Role Name',
            'Guard Name',
            'Action'
        ];
    }


    public function create()
    {
        return Inertia::render(
            'Backend/Role/Form',
            [
                'pageTitle' => fn () => 'Role Create',
                'breadcrumbs' => fn () => [
                    ['link' => null, 'title' => 'Role Manage'],
                    ['link' => route('backend.role.create'), 'title' => 'Role Create'],
                ],
                'permissions' => fn () => $this->permissionService->listWithAllChild(),
            ]
        );
    }

    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $dataInfo = $this->roleService->create($data);
            if ($dataInfo) {
                $this->roleService->syncPermissions($dataInfo->id, $request->permission_ids);
                $message = 'Role created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'roles', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Role.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'RoleController', 'store', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $role = $this->roleService->spatieRoleFind($id);

        //    dd($role->permissions);
        return Inertia::render(
            'Backend/Role/Form',
            [
                'pageTitle' => fn () => 'Role Edit',
                'breadcrumbs' => fn () => [
                    ['link' => null, 'title' => 'Role Manage'],
                    ['link' => route('backend.role.edit', $role->id), 'title' => 'Role Edit'],
                ],
                'permissions' => fn () => $this->permissionService->listWithAllChild(),
                'role' => $role,
                'id' =>  $id,
            ]
        );
    }

    public function update(RoleRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            if ($this->roleService->update($data, $id)) {
                $role = $this->roleService->syncPermissions($id, $request->permission_ids);
                $users = $this->AdminService->list()->where('status', 'Active')->where('role_id', $id)->get();
                //dd($permissions);
                foreach ($users as $key => $user)
                    $user->syncRoles($role->id);

                $message = 'Role updated successfully';
                $this->storeAdminWorkLog($id, 'roles', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Role.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'RoleController', 'update', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();

        try {
            // $dataInfo = $this->roleService->delete($id);

            if ($this->roleService->delete($id)) {
                $message = 'Role deleted successfully';
                $this->storeAdminWorkLog($id, 'roles', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Role.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'RoleController', 'destroy', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function changeStatus()
    {
        DB::beginTransaction();

        try {
            $dataInfo = $this->roleService->changeStatus(request());

            if ($dataInfo->wasChanged()) {
                $message = 'Role ' . request()->status . ' Successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'roles', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To " . request()->status . " Role.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'RoleController', 'changeStatus', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }
}
