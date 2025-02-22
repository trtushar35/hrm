<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Services\AdminService;
use App\Services\RoleService;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class AdminController extends Controller
{
    use SystemTrait;

    protected $adminService, $roleService;

    public function __construct(AdminService $adminService, RoleService $roleService)
    {
        $this->adminService = $adminService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Admin/Index',
            [
                'pageTitle' => fn () => 'User List',
                'breadcrumbs' => fn () => [
                    ['link' => null, 'title' => 'User Manage'],
                    ['link' => route('backend.admin.index'), 'title' => 'User List'],
                ],
                'tableHeaders' => fn () => $this->getTableHeaders(),
                'dataFields' => fn () => $this->dataFields(),
                'datas' => fn () => $this->getDatas(),
                'roles' => fn () => $this->roleService->all(),
                'filters' => request()->only(['numOfData', 'name', 'division', 'district', 'upazila', 'union']),
            ]
        );
    }

    private function getDatas()
    {
        $query = $this->adminService->list()->with('role');

        if (request()->filled('name')) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . request()->name . '%')
                    ->orWhere('last_name', 'like', '%' . request()->name . '%');
            });
        }

        if (request()->filled('phone'))
            $query->where('phone', 'like', request()->phone . '%');

        if (request()->filled('email'))
            $query->where('email', 'like', request()->email . '%');

        if (request()->filled('role_id'))
            $query->where('role', request()->role_id);

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;
            $customData->name = $data->name;
            $customData->email = $data->email;
            $customData->phone = $data->phone;
            $customData->role_name = $data->role?->name;
            $customData->photo = '<img src="' . $data->photo . '" height="50" width="50"/>';
            $customData->address = $data->address;
            $customData->status = getStatusText($data->status);

            $customData->hasLink = true;
            $customData->links = [
                [
                    'linkClass' => 'semi-bold text-white statusChange ' . (($data->status == 'Active') ? "bg-gray-500" : "bg-green-500"),
                    'link' => route('backend.admin.status.change', ['id' => $data->id, 'status' => $data->status == 'Active' ? 'Inactive' : 'Active']),
                    'linkLabel' => getLinkLabel((($data->status == 'Active') ? "Inactive" : "Active"), null, null)
                ],
                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.admin.edit',  $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.admin.destroy', $data->id),
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
            ['fieldName' => 'photo', 'class' => 'text-center'],
            ['fieldName' => 'name', 'class' => 'text-center'],
            ['fieldName' => 'email', 'class' => 'text-center'],
            ['fieldName' => 'phone', 'class' => 'text-center'],
            ['fieldName' => 'address', 'class' => 'text-center'],
            ['fieldName' => 'role_name', 'class' => 'text-center'],
            ['fieldName' => 'status', 'class' => 'text-center'],
        ];
    }
    private function getTableHeaders()
    {
        return [
            'Sl/No',
            'Photo',
            'Name',
            'Email',
            'Phone',
            'Address',
            'Role Name',
            'Status',
            'Action',
        ];
    }

    public function create()
    {
        return Inertia::render(
            'Backend/Admin/Form',
            [
                'pageTitle' => fn () => 'User Create',
                'breadcrumbs' => fn () => [
                    ['link' => null, 'title' => 'User Manage'],
                    ['link' => route('backend.admin.create'), 'title' => 'User Create'],
                ],
                'roles' => fn () => $this->roleService->all(),
            ]
        );
    }

    public function store(AdminRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();

            if ($request->hasFile('photo'))
                $data['photo'] = $this->imageUpload($request->file('photo'), 'users');

            $dataInfo = $this->adminService->create($data);

            if ($dataInfo) {
                $message = 'User created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'admins', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create user.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'AdminController', 'store', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $user = $this->adminService->find($id);

        return Inertia::render(
            'Backend/Admin/Form',
            [
                'pageTitle' => fn () => 'User Edit',
                'breadcrumbs' => fn () => [
                    ['link' => null, 'title' => 'User Manage'],
                    ['link' => route('backend.admin.edit', $user->id), 'title' => 'Branch Edit'],
                ],
                'user' => fn () => $user,
                'id' => fn () => $id,
                'roles' => fn () => $this->roleService->all(),
            ]
        );
    }

    public function update(AdminRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $admin = $this->adminService->find($id);
            $data = $request->validated();
            if ($request->hasFile('photo')) {
                $data['photo'] = $this->imageUpload($request->file('photo'), 'users');
                if (isset($admin->photo)) {
                    $path = strstr($admin->photo, 'storage/');
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            } else {
                $data['photo'] = strstr($admin->photo, 'users/'); //remove text before specified text
            }

            $dataInfo = $this->adminService->update($data, $id);
            if ($dataInfo->wasChanged()) {
                $message = 'User updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'admins', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Branch.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'AdminController', 'update', substr($err->getMessage(), 0, 1000));
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
            $dataInfo = $this->adminService->delete($id);

            if ($dataInfo->wasChanged()) {
                $message = 'User deleted successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'admins', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete User.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'AdminController', 'destroy', substr($err->getMessage(), 0, 1000));
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
            $dataInfo = $this->adminService->changeStatus(request());

            if ($dataInfo->wasChanged()) {
                $message = 'User ' . request()->status . ' Successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'admins', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To " . request()->status . " User.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'AdminController', 'changeStatus', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }
}
