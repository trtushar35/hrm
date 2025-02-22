<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class MakeService extends Command
{
    protected $signature = 'create:crud {controller} {model} {table}';
    protected $description = 'Create a new service and model file';

    public function handle()
    {
        $controller = $this->argument('controller');
        $model = $this->argument('model');
        $table = $this->argument('table');
        $service = $model . 'Service';


        // Request
        $requestPath = app_path('Http/Requests/' . $model . 'Request.php');
        $requestCode =  $this->generateRequest($model, $table);
        $this->createFile($requestPath,   $requestCode);

        // Controller
        $controllerPath = app_path('Http/Controllers/Backend/' . $controller . '.php');
        $controllerCode =  $this->generateControllerCode($model, $controller, $table);
        $this->createFile($controllerPath,  $controllerCode);

        // Service
        $servicePath = app_path('Services/' . $model . 'Service.php');
        $serviceCode =  $this->generateServiceCode($model);
        $this->createFile($servicePath,  $serviceCode);

        // Model
        $modelPath = app_path('Models/' . $model . '.php');
        $modelCode = $this->generateModelCode($model, $table);
        $this->createFile($modelPath,  $modelCode);

        // View
        $backendPath = resource_path('js/Pages/Backend/');
        $indexFile = $backendPath . $model . '/Index.vue';


        // Check if directory exists, if not create it
        if (!File::isDirectory($backendPath . $model)) {
            File::makeDirectory($backendPath . $model, 0755, true, true);
        }

        if (File::exists($indexFile)) {
            $this->error('Index file already exists at:' . $indexFile);
            return;
        }

        File::put($indexFile, $this->IndexVue($model));
        $this->info('Index created successfully:' . $indexFile);
    }

    // Function to create file
    private function createFile($filePath, $code)
    {
        if (File::exists($filePath)) {
            $this->error('File already exists: ' . $filePath);
            return;
        }

        File::put($filePath, $code);

        $this->info('File created successfully: ' . $filePath);
    }


    function generateModelCode($model, $table)
    {
        $code = <<<EOT
        <?php
        namespace App\Models;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        use Illuminate\Database\Eloquent\SoftDeletes;

        class $model extends Model
        {
            use HasFactory, SoftDeletes;


            protected static function boot()
            {
                parent::boot();
                static::saving(function (\$model) {
                    \$model->created_at = date('Y-m-d H:i:s');
                });

                static::updating(function (\$model) {
                    \$model->updated_at = date('Y-m-d H:i:s');
                });
            }

            public function getImageAttribute(\$value)
            {
                return (!is_null(\$value)) ? env('APP_URL') . '/public/storage/' . \$value : null;
            }

            public function getFileAttribute(\$value)
            {
                return (!is_null(\$value)) ? env('APP_URL') . '/public/storage/' . \$value : null;
            }
        }

        EOT;

        return $code;
    }


    function generateRequest($model, $table)
    {

        $code = <<<EOT
        <?php

            namespace App\Http\Requests;

            use Illuminate\Foundation\Http\FormRequest;

            class {$model}Request extends FormRequest
            {

                /**
                 * Get the validation rules that apply to the request.
                 *
                 * @return array<string, mixed>
                 */
                public function rules()
                {
                    switch (\$this->method()) {
                        case 'POST':
                            return [


                            ];
                            break;
                    }
                }

                public function messages()
                {
                    return [

                    ];
                }
            }

        EOT;

        return $code;
    }

    function generateServiceCode($model)
    {

        $code = <<<EOT
        <?php
        namespace App\Services;
        use App\Models\\$model;

        class {$model}Service
        {
            protected \$${model}Model;

            public function __construct($model \$${model}Model)
            {
                \$this->${model}Model = \$${model}Model;
            }

            public function list()
            {
                return  \$this->${model}Model->whereNull('deleted_at');
            }

            public function all()
            {
                return  \$this->${model}Model->whereNull('deleted_at')->all();
            }

            public function find(\$id)
            {
                return  \$this->${model}Model->find(\$id);
            }

            public function create(array \$data)
            {
                return  \$this->${model}Model->create(\$data);
            }

            public function update(array \$data, \$id)
            {
                \$dataInfo =  \$this->${model}Model->findOrFail(\$id);

                \$dataInfo->update(\$data);

                return \$dataInfo;
            }

            public function delete(\$id)
            {
                \$dataInfo =  \$this->${model}Model->find(\$id);

                if (!empty(\$dataInfo)) {

                    \$dataInfo->deleted_at = date('Y-m-d H:i:s');

                    \$dataInfo->status = 'Deleted';

                    return (\$dataInfo->save());
                }
                return false;
            }

            public function changeStatus(\$id,\$status)
            {
                \$dataInfo =  \$this->${model}Model->findOrFail(\$id);
                \$dataInfo->status = \$status;
                \$dataInfo->update();

                return \$dataInfo;
            }

            public function AdminExists(\$userName)
            {
                return  \$this->${model}Model->whereNull('deleted_at')
                    ->where(function (\$q) use (\$userName) {
                        \$q->where('email', strtolower(\$userName))
                            ->orWhere('phone', \$userName);
                    })->first();

            }


            public function activeList()
            {
                return  \$this->${model}Model->whereNull('deleted_at')->where('status', 'Active')->get();
            }

        }


        EOT;

        return $code;
    }

    function generateControllerCode($model, $controller, $table,)
    {


        $lowercaseModel = strtolower($model);
        $service = $model . 'Service';
        $code = <<<EOT
        <?php
        namespace App\Http\Controllers\Backend;

        use App\Http\Controllers\Controller;
        use App\Http\Requests\\{$model}Request;
        use Illuminate\Support\Facades\DB;
        use App\Services\\{$model}Service;
        use Illuminate\Http\Request;
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\Schema;
        use Inertia\Inertia;
        use App\Traits\SystemTrait;
        use Exception;

        class $controller extends Controller
        {
            use SystemTrait;

            protected \$$service;

            public function __construct($service \$$service)
            {
                \$this->$service = \$$service;
            }



            public function index()
            {
                return Inertia::render(
                    'Backend/$model/Index',
                    [
                        'pageTitle' => fn () => '$model List',
                        'breadcrumbs' => fn () => [
                            ['link' => null, 'title' => '$model Manage'],
                            ['link' => route('backend.$lowercaseModel.index'), 'title' => '$model List'],
                        ],
                        'tableHeaders' => fn () => \$this->getTableHeaders(),
                        'dataFields' => fn () => \$this->dataFields(),
                        'datas' => fn () => \$this->getDatas(),
                    ]
                );
            }


            public function create()
            {
                return Inertia::render(
                    'Backend/$model/Form',
                    [
                        'pageTitle' => fn () => '$model Create',
                        'breadcrumbs' => fn () => [
                            ['link' => null, 'title' => '$model Manage'],
                            ['link' => route('backend.$lowercaseModel.create'), 'title' => '$model Create'],
                        ],
                    ]
                );
            }


            public function store({$model}Request \$request)
            {

                DB::beginTransaction();
                try {

                    \$data = \$request->validated();

                    if (\$request->hasFile('image'))
                        \$data['image'] = \$this->imageUpload(\$request->file('image'), '$table');

                    if (\$request->hasFile('file'))
                        \$data['file'] = \$this->fileUpload(\$request->file('file'), '$table');


                    \$dataInfo = \$this->{$service}->create(\$data);

                    if (\$dataInfo) {
                        \$message = '$model created successfully';
                        \$this->storeAdminWorkLog(\$dataInfo->id, '$table', \$message);

                        DB::commit();

                        return redirect()
                            ->back()
                            ->with('successMessage', \$message);
                    } else {
                        DB::rollBack();

                        \$message = "Failed To create $model.";
                        return redirect()
                            ->back()
                            ->with('errorMessage', \$message);
                    }
                } catch (Exception \$err) {
                    //   dd(\$err);
                    DB::rollBack();
                    \$this->storeSystemError('Backend', '$controller', 'store', substr(\$err->getMessage(), 0, 1000));
                    dd(\$err);
                    DB::commit();
                    \$message = "Server Errors Occur. Please Try Again.";
                    // dd(\$message);
                    return redirect()
                        ->back()
                        ->with('errorMessage', \$message);
                }
            }

            public function edit(\$id)
            {
                \$$lowercaseModel = \$this->{$service}->find(\$id);

                return Inertia::render(
                    'Backend/$model/Form',
                    [
                        'pageTitle' => fn () => '$model Edit',
                        'breadcrumbs' => fn () => [
                            ['link' => null, 'title' => '$model Manage'],
                            ['link' => route('backend.$lowercaseModel.edit', \$id), 'title' => '$model Edit'],
                        ],
                        '$lowercaseModel' => fn () => \$$lowercaseModel,
                        'id' => fn () => \$id,
                    ]
                );
            }

            public function update({$model}Request \$request, \$id)
            {
                DB::beginTransaction();
                try {

                    \$data = \$request->validated();
                    \$$lowercaseModel = \$this->{$service}->find(\$id);

                    if (\$request->hasFile('image')) {
                        \$data['image'] = \$this->imageUpload(\$request->file('image'), '$table');
                        \$path = strstr(\${$lowercaseModel}->image, 'storage/');
                        if (file_exists(\$path)) {
                            unlink(\$path);
                        }
                    } else {

                        \$data['image'] = strstr(\${$lowercaseModel}->image ?? '', '$table');
                    }

                    if (\$request->hasFile('file')) {
                        \$data['file'] = \$this->fileUpload(\$request->file('file'), '$table/');
                        \$path = strstr(\${$lowercaseModel}->file, 'storage/');
                        if (file_exists(\$path)) {
                            unlink(\$path);
                        }
                    } else {

                        \$data['file'] = strstr(\${$lowercaseModel}->file ?? '', '$table/');
                    }

                    \$dataInfo = \$this->{$service}->update(\$data, \$id);

                    if (\$dataInfo->save()) {
                        \$message = '$model updated successfully';
                        \$this->storeAdminWorkLog(\$dataInfo->id, '$table', \$message);

                        DB::commit();

                        return redirect()
                            ->back()
                            ->with('successMessage', \$message);
                    } else {
                        DB::rollBack();

                        \$message = "Failed To update $table.";
                        return redirect()
                            ->back()
                            ->with('errorMessage', \$message);
                    }
                } catch (Exception \$err) {
                    DB::rollBack();
                    \$this->storeSystemError('Backend', '$controller', 'update', substr(\$err->getMessage(), 0, 1000));
                    DB::commit();
                    \$message = "Server Errors Occur. Please Try Again.";
                    return redirect()
                        ->back()
                        ->with('errorMessage', \$message);
                }
            }

            public function destroy(\$id)
            {

                DB::beginTransaction();

                try {

                    if (\$this->{$service}->delete(\$id)) {
                        \$message = '$model deleted successfully';
                        \$this->storeAdminWorkLog(\$id, '{$table}', \$message);

                        DB::commit();

                        return redirect()
                            ->back()
                            ->with('successMessage', \$message);
                    } else {
                        DB::rollBack();

                        \$message = "Failed To Delete $model.";
                        return redirect()
                            ->back()
                            ->with('errorMessage', \$message);
                    }
                } catch (Exception \$err) {
                    DB::rollBack();
                    \$this->storeSystemError('Backend', '$controller', 'destroy', substr(\$err->getMessage(), 0, 1000));
                    DB::commit();
                    \$message = "Server Errors Occur. Please Try Again.";
                    return redirect()
                        ->back()
                        ->with('errorMessage', \$message);
                }
            }

            public function changeStatus(Request \$request, \$id, \$status)
            {
                DB::beginTransaction();

                try {

                    \$dataInfo = \$this->{$service}->changeStatus(\$id, \$status);

                    if (\$dataInfo->wasChanged()) {
                        \$message = '$model ' . request()->status . ' Successfully';
                        \$this->storeAdminWorkLog(\$dataInfo->id, '$table', \$message);

                        DB::commit();

                        return redirect()
                            ->back()
                            ->with('successMessage', \$message);
                    } else {
                        DB::rollBack();

                        \$message = "Failed To " . request()->status . "$model.";
                        return redirect()
                            ->back()
                            ->with('errorMessage', \$message);
                    }
                } catch (Exception \$err) {
                    DB::rollBack();
                    \$this->storeSystemError('Backend', '$controller', 'changeStatus', substr(\$err->getMessage(), 0, 1000));
                    DB::commit();
                    \$message = "Server Errors Occur. Please Try Again.";
                    return redirect()
                        ->back()
                        ->with('errorMessage', \$message);
                }
            }
                }
        EOT;

        return $code;
    }

    function IndexVue($model)
    {
        $lowercaseModel = strtolower($model);
        $code = <<<EOT

        <script setup>
            import { ref } from "vue";
            import BackendLayout from '@/Layouts/BackendLayout.vue';
            import BaseTable from '@/Components/BaseTable.vue';
            import Pagination from '@/Components/Pagination.vue';
            import { router } from '@inertiajs/vue3';

            let props = defineProps({
                filters: Object,
            });

            const filters = ref({

                numOfData: props.filters?.numOfData ?? 10,
            });

            const applyFilter = () => {
                router.get(route('backend.$lowercaseModel.index'), filters.value, { preserveState: true });
            };

            </script>

            <template>
                <BackendLayout>

                    <div
                        class="w-full p-4 mt-3 duration-1000 ease-in-out bg-white rounded shadow-md shadow-gray-800/50 dark:bg-slate-900">



                        <div
                            class="flex justify-between w-full p-4 space-x-2 text-gray-700 rounded shadow-md bg-slate-600 shadow-gray-800/50 dark:bg-gray-700 dark:text-gray-200">

                            <div class="grid w-full grid-cols-1 gap-2 md:grid-cols-5">

                                <div class="flex space-x-2">
                                    <div class="w-full">
                                        <input id="name" v-model="filters.name"
                                            class="block w-full p-2 text-sm bg-gray-300 rounded shadow-sm border-slate-100 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                                            type="text" placeholder="Title" @input="applyFilter" />
                                    </div>

                                </div>
                            </div>

                            <div class="hidden min-w-24 md:block">
                                <select v-model="filters.numOfData" @change="applyFilter"
                                        class="w-full p-2 text-sm bg-gray-300 rounded shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600">
                                    <option value="10">show 10</option>
                                    <option value="20">show 20</option>
                                    <option value="30">show 30</option>
                                    <option value="40">show 40</option>
                                    <option value="100">show 100</option>
                                    <option value="150">show 150</option>
                                    <option value="500">show 500</option>
                                </select>
                            </div>
                        </div>

                        <div class="w-full my-3 overflow-x-auto">
                            <BaseTable />
                        </div>
                        <Pagination />
                    </div>
                </BackendLayout>
            </template>


        EOT;

        return $code;
    }
    
}
