<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Requests\PermissionRequest;
use App\Services\PermissionService;
use App\Traits\SystemTrait;
use Illuminate\Support\Facades\DB;
use Exception;

class PermissionController extends Controller
{
    use SystemTrait;

    protected $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Permission/Index',
            [
                'pageTitle' => fn() => 'Permission List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Permission Manage'],
                    ['link' => route('backend.permission.index'), 'title' => 'Permission List'],
                ],
                'tableHeaders' => fn() => $this->getTableHeaders(),
                'dataFields' => fn() => $this->dataFields(),
                'datas' => fn() => $this->getDatas(),
                'filters' => request()->only(['numOfData', 'name']),
            ]
        );
    }



    private function getDatas()
    {
        $query = $this->permissionService->list()
        ->with('parent');


        if (request()->filled('name')) {
            $query->where(function ($q) {
                $q->where('name', 'like', request()->name . '%');
            });
        }

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;
            $customData->permission_name = getPermissionName($data->name);
            $customData->parent_permission = getPermissionName($data->parent?->name);

            $customData->hasLink = true;
            $customData->links = [

                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.permission.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.permission.destroy', $data->id),
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
            ['fieldName' => 'permission_name', 'class' => 'text-center'],
            ['fieldName' => 'parent_permission', 'class' => 'text-center'],
        ];
    }
    private function getTableHeaders()
    {
        return [
            'Sl/No',
            'Permission Name',
            'Parent Permission Name',
            'Action'
        ];
    }


    public function create()
    {
        return Inertia::render(
            'Backend/Permission/Form',
            [
                'pageTitle' => fn() => 'Permission Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Permission Manage'],
                    ['link' => route('backend.permission.create'), 'title' => 'Permission Create'],
                ],
                'permissions'=>fn()=>$this->permissionService->parentList(),
            ]
        );
    }

    public function store(PermissionRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $dataInfo = $this->permissionService->create($data);
            if ($dataInfo) {
                $message = 'Permission created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'Permissions', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Permission.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'PermissionController', 'store', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $permission = $this->permissionService->find($id);

        return Inertia::render(
            'Backend/Permission/Form',
            [
                'pageTitle' => fn() => 'Permission Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Permission Manage'],
                    ['link' => route('backend.permission.edit', $permission->id), 'title' => 'Permission Edit'],
                ],
                'permissions'=>fn()=>$this->permissionService->parentList(),
                'permission' => $permission,
                'id' =>  $id,
            ]
        );
    }

    public function update(PermissionRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
          // dd(request()->all());
            $dataInfo = $this->permissionService->update($data, $id);
            if ($dataInfo->wasChanged()) {
                $message = 'Permission updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'Permissions', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Permission.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'PermissionController', 'update', substr($err->getMessage(), 0, 1000));
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
           // $dataInfo = $this->permissionService->delete($id);

            if ($this->permissionService->delete($id)) {
                $message = 'Permission deleted successfully';
                $this->storeAdminWorkLog($id, 'Permissions', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Permission.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'PermissionController', 'destroy', substr($err->getMessage(), 0, 1000));
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
            $dataInfo = $this->permissionService->changeStatus(request());

            if ($dataInfo->wasChanged()) {
                $message = 'Permission ' . request()->status . ' Successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'Permissions', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To " . request()->status . " Permission.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'PermissionController', 'changeStatus', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }
}
