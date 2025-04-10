<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Services\DepartmentService;
use App\Services\DesignationService;
use Illuminate\Support\Facades\DB;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class EmployeeController extends Controller
{
    use SystemTrait;

    protected $employeeService, $departmentService, $designationService;

    public function __construct(EmployeeService $employeeService, DepartmentService $departmentService, DesignationService $designationService)
    {
        $this->employeeService = $employeeService;
        $this->departmentService = $departmentService;
        $this->designationService = $designationService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Employee/Index',
            [
                'pageTitle' => fn() => 'Employee List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Employee Manage'],
                    ['link' => route('backend.employee.index'), 'title' => 'Employee List'],
                ],
                'tableHeaders' => fn() => $this->getTableHeaders(),
                'dataFields' => fn() => $this->dataFields(),
                'datas' => fn() => $this->getDatas(),
                'filters' => request()->only(['numOfData', 'name', 'division', 'district', 'upazila', 'union']),
                'departments' => fn() => $this->departmentService->activeList(),
                'designations' => fn() => $this->designationService->activeList()
            ]
        );
    }

    private function getDatas()
    {
        $query = $this->employeeService->list();

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

        if (request()->filled('department_id'))
            $query->where('department_id', request()->department_id);

        if (request()->filled('designation_id'))
            $query->where('designation_id', request()->designation_id);

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;
            $customData->name = $data->name;
            $customData->email = $data->email;
            $customData->phone = $data->phone;
            $customData->department_id = $data->department?->name;
            $customData->designation_id = $data->designation?->name;
            $customData->salary = $data->salary;
            $customData->photo = '<img src="' . $data->photo . '" height="50" width="50"/>';
            $customData->address = $data->address;
            $customData->status = getStatusText($data->status);

            $customData->hasLink = true;
            $customData->links = [
                [
                    'linkClass' => 'semi-bold text-white statusChange ' . (($data->status == 'Active') ? "bg-gray-500" : "bg-green-500"),
                    'link' => route('backend.employee.status.change', ['id' => $data->id, 'status' => $data->status == 'Active' ? 'Inactive' : 'Active']),
                    'linkLabel' => getLinkLabel((($data->status == 'Active') ? "Inactive" : "Active"), null, null)
                ],
                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.employee.edit',  $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.employee.destroy', $data->id),
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
            ['fieldName' => 'department_id', 'class' => 'text-center'],
            ['fieldName' => 'designation_id', 'class' => 'text-center'],
            ['fieldName' => 'salary', 'class' => 'text-center'],
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
            'Department',
            'Designation',
            'Salary',
            'Status',
            'Action',
        ];
    }

    public function create()
    {
        return Inertia::render(
            'Backend/Employee/Form',
            [
                'pageTitle' => fn() => 'Employee Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Employee Manage'],
                    ['link' => route('backend.employee.create'), 'title' => 'Employee Create'],
                ],
                'departments' => fn() => $this->departmentService->activeList(),
                'designations' => fn() => $this->designationService->activeList(),
            ]
        );
    }

    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();

            if ($request->hasFile('photo'))
                $data['photo'] = $this->imageUpload($request->file('photo'), 'Employees');

            $dataInfo = $this->employeeService->create($data);

            if ($dataInfo) {
                $message = 'Employee created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'employees', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Employee.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'EmployeeController', 'store', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $Employee = $this->employeeService->find($id);

        return Inertia::render(
            'Backend/Employee/Form',
            [
                'pageTitle' => fn() => 'Employee Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Employee Manage'],
                    ['link' => route('backend.employee.edit', $Employee->id), 'title' => 'Employee Edit'],
                ],
                'employee' => fn() => $Employee,
                'id' => fn() => $id,
                'departments' => fn() => $this->departmentService->activeList(),
                'designations' => fn() => $this->designationService->activeList(),
            ]
        );
    }

    public function update(EmployeeRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $admin = $this->employeeService->find($id);
            $data = $request->validated();

            if ($request->hasFile('photo')) {
                $data['photo'] = $this->imageUpload($request->file('photo'), 'Employees');
                if (isset($admin->photo)) {
                    $path = strstr($admin->photo, 'storage/');
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            } else {
                $data['photo'] = strstr($admin->photo, 'Employees/');
            }

            $dataInfo = $this->employeeService->update($data, $id);
            if ($dataInfo->wasChanged()) {
                $message = 'Employee updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'employees', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Employee.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'EmployeeController', 'update', substr($err->getMessage(), 0, 1000));
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
            $dataInfo = $this->employeeService->delete($id);

            if ($dataInfo) {
                $message = 'Employee deleted successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'employees', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Employee.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'EmployeeController', 'destroy', substr($err->getMessage(), 0, 1000));
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
            $dataInfo = $this->employeeService->changeStatus(request());

            if ($dataInfo) {
                $message = 'Employee ' . request()->status . ' Successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'employees', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To " . request()->status . " Employee.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'EmployeeController', 'changeStatus', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }
}
