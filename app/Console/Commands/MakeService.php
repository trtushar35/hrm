<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Str;

class MakeService extends Command
{
    // protected $signature = 'create:crud {controller} {model} {table}';
    // protected $description = 'Create a new service and model file';
    
    protected $signature = 'make:dynamic {name} {--m : model} {--c : controller} {--r : request} {--s : service} {--v : view} {--se : seeder} {--f : factory}';
    protected $description = 'Create dynamic resources: model, controller, request, service, view, seeder, factory';

    public function handle()
    {
        // $controller = $this->argument('controller');
        // $model = $this->argument('model');
        // $table = $this->argument('table');
        // $service = $model . 'Service';

        $name = $this->argument('name');
        $model = $name; 
        $controller = $model . 'Controller';
        $service = $model . 'Service';
        $lowercaseName = strtolower($name);
        $table = Str::snake(Str::plural($lowercaseName)); 

        //Table
        $timestamp = date('Y_m_d_His');
        $tablePath = database_path('migrations/'. $timestamp.'_create_'.$table.'_table.php');
        $tableCode = $this->generateTable($model, $table);
        $this->createFile($tablePath , $tableCode);

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
        $formFile = $backendPath . $model . '/Form.vue';
        $indexFile = $backendPath . $model . '/Index.vue';

        //Route
        $routePath = base_path('routes');
        $routeFile = $routePath . '/backend.php';
        $routeFiles = $routePath . '/backend.php';
        
        $generatedNamespace = $this->generateRouteName($model, $table);
        

        $existingRoute = File::get($routeFiles);
        $insertMarkerUper = "//don't remove this comment from route namespace";
        
        if (str_contains($existingRoute, $insertMarkerUper)) {
            $newContent = str_replace($insertMarkerUper, "$generatedNamespace\n\n\t$insertMarkerUper", $existingRoute);
            File::put($routeFiles, $newContent);
            echo "Routes Namespace added successfully to backend.php file.\n";
        } else {
            echo "Marker for insertion not found in backend.php file.\n";
        }

        $generatedCode = $this->generateRouteCode($model, $table);

        $existingRoutes = File::get($routeFile);
        $insertMarker = "//don't remove this comment from route body";

        if (str_contains($existingRoutes, $insertMarker)) {
            $newContent = str_replace($insertMarker, "$generatedCode\n\n\t$insertMarker", $existingRoutes);
            File::put($routeFile, $newContent);
            echo "Routes added successfully to backend.php file.\n";
        } else {
            echo "Marker for insertion not found in backend.php file.\n";
        }

        //Add Menu Seeder
        $menuPath = database_path('seeders');
        $menuFile = $menuPath . '/MenuSeeder.php';
        
        $generateMenuCode = $this->generateMenuCode($model, $table);
        
        $existingMenus = File::get($menuFile);
        
        $insertMarkers = "//don't remove this comment from menu seeder";
        
        if (str_contains($existingMenus, $insertMarkers)) {
            $newContents = str_replace($insertMarkers, "$generateMenuCode\n\n\t$insertMarkers", $existingMenus);
            File::put($menuFile, $newContents);
            echo "Menu added successfully to MenuSeeder.php file.\n";
        } else {
            echo "Marker for insertion not found in MenuSeeder.php file.\n";
        }

        // Check if directory exists, if not create it
        if (!File::isDirectory($backendPath . $model)) {
            File::makeDirectory($backendPath . $model, 0755, true, true);
        }


        if (File::exists($formFile)) {
            $this->error('Create file already exists at:' . $formFile);
            return;
        }

        if (File::exists($indexFile)) {
            $this->error('Index file already exists at:' . $indexFile);
            return;
        }

        File::put($formFile, $this->FormVue($model));
        $this->info('Form created successfully:' . $formFile);

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

    function generateRouteName($model, $table)
    {
$code = <<<EOT
use App\Http\Controllers\Backend\\{$model}Controller;

EOT;
        return $code;
    }

    function generateRouteCode($model, $table)
    {
        $lowercaseModel = strtolower($model);
        $code = <<<EOT
            //for $model
            Route::resource('$lowercaseModel', {$model}Controller::class);
            Route::get('$lowercaseModel/{id}/status/{status}/change', [{$model}Controller::class, 'changeStatus'])->name('$lowercaseModel.status.change');

        EOT;
        return $code;
    }

    function generateMenuCode($model, $table)
    {
        $lowercaseModel = strtolower($model);
        $code = <<<EOT
            [
                'name' => '$model Manage',
                'icon' => 'layers',
                'route' => null,
                'description' => null,
                'sorting' => 1,
                'permission_name' => '$lowercaseModel-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => '$model Add',
                        'icon' => 'plus-circle',
                        'route' => 'backend.$lowercaseModel.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => '$lowercaseModel-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => '$model List',
                        'icon' => 'list',
                        'route' => 'backend.$lowercaseModel.index',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => '$lowercaseModel-list',
                        'status' => 'Active',
                    ],
                ],
            ],

        EOT;
        return $code;
    }

    function generateModelCode($model, $table)
    {
        $code = <<<EOT
        <?php
        namespace App\Models;
        use Illuminate\Contracts\Auth\MustVerifyEmail;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Foundation\Auth\User as Authenticatable;
        use Illuminate\Notifications\Notifiable;
        use Illuminate\Support\Facades\Hash;
        use Spatie\Permission\Traits\HasRoles;

        class $model extends Authenticatable
        {
            use Notifiable,HasFactory;

            protected \$table = '$table';

            protected \$fillable = [
                            'name',
                        ];

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

    function generateTable($model, $table){
        $code = <<<EOT
          <?php

            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\Schema;

            return new class extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create('$table', function (Blueprint \$table) {
                        \$table->id();
                        \$table->enum('status',['Active','Inactive','Deleted'])->default('Active');
                        \$table->softDeletes();
                        \$table->timestamps();
                    });
                }

                /**
                 * Reverse the migrations.
                 *
                 * @return void
                 */
                public function down()
                {
                    Schema::dropIfExists('$table');
                }
            };

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
         public function rules()
            {
                switch (\$this->method()) {
                    case 'POST':
                        return [
                            'name' => 'required|string|max:255',
                            'email' => 'required|email|unique:admins,email|max:255',
                            'photo' => 'file|mimes:png,jpg,jpeg|max:25048',
                        ];
                        break;

                    case 'PUT':
                        return [
                            'name' => 'required|string|max:255',
                            'email' => 'required|email|max:255|unique:admins,id,' . \$this->id,
                            'photo' => 'nullable|file|mimes:png,jpg,jpeg|max:25048',
                        ];
                        break;
                    case 'PATCH':

                        break;
                }
            }

            /**
             * Get custom error messages for validator errors.
             *
             * @return array<string, mixed>
             */
            public function messages()
            {

                return [
                    'name.required' => __('The first name field is required.'),
                    'email.required' => __('The email field is required.'),
                    'email.email' => __('Please enter a valid email address.'),
                    'email.unique' => __('This email address is already taken.'),
                    'photo.file' => __('The photo must be a file.'),
                    'photo.mimes' => __('The photo must be a file of type: png, jpg, jpeg.'),
                    'photo.max' => __('The photo may not be greater than :max kilobytes.'),
                ];
            }
        }
        EOT;

        return $code;
    }

    function generateServiceCode($model)
    {

        $lowercaseModel = strtolower($model);
        $code = <<<EOT
        <?php
        namespace App\Services;
        use App\Models\\$model;

        class {$model}Service
        {
            protected \$${model}Model;

            public function __construct($model \$${lowercaseModel}Model)
            {
                \$this->${lowercaseModel}Model = \$${lowercaseModel}Model;
            }

            public function list()
            {
                return  \$this->${lowercaseModel}Model->whereNull('deleted_at');
            }

            public function all()
            {
                return  \$this->${lowercaseModel}Model->whereNull('deleted_at')->all();
            }

            public function find(\$id)
            {
                return  \$this->${lowercaseModel}Model->find(\$id);
            }

            public function create(array \$data)
            {
                return  \$this->${lowercaseModel}Model->create(\$data);
            }

            public function update(array \$data, \$id)
            {
                \$dataInfo =  \$this->${lowercaseModel}Model->findOrFail(\$id);

                \$dataInfo->update(\$data);

                return \$dataInfo;
            }

            public function delete(\$id)
            {
                \$dataInfo =  \$this->${lowercaseModel}Model->find(\$id);

                if (!empty(\$dataInfo)) {

                    \$dataInfo->deleted_at = date('Y-m-d H:i:s');

                    \$dataInfo->status = 'Deleted';

                    return (\$dataInfo->save());
                }
                return false;
            }

            public function changeStatus(\$id,\$status)
            {
                \$dataInfo =  \$this->${lowercaseModel}Model->findOrFail(\$id);
                \$dataInfo->status = \$status;
                \$dataInfo->update();

                return \$dataInfo;
            }

            public function AdminExists(\$userName)
            {
                return  \$this->${lowercaseModel}Model->whereNull('deleted_at')
                    ->where(function (\$q) use (\$userName) {
                        \$q->where('email', strtolower(\$userName))
                            ->orWhere('phone', \$userName);
                    })->first();

            }


            public function activeList()
            {
                return  \$this->${lowercaseModel}Model->whereNull('deleted_at')->where('status', 'Active')->get();
            }

        }


        EOT;

        return $code;
    }

    function generateControllerCode($model, $controller, $table,)
    {


        $lowercaseModel = strtolower($model);
        $services = $model . 'Service';
        $service = $lowercaseModel . 'Service';
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

            public function __construct($services \$$service)
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

            private function getDatas()
            {
                \$query = \$this->{$service}->list();

                if (request()->filled('name'))
                    \$query->where('name', 'like', request()->name . '%');


                \$datas = \$query->paginate(request()->numOfData ?? 10)->withQueryString();

                \$formatedDatas = \$datas->map(function (\$data, \$index) {
                    \$customData = new \stdClass();
                    \$customData->index = \$index + 1;
                    \$customData->name = \$data->name;
                    \$customData->photo = '<img src="' . \$data->photo . '" height="50" width="50"/>';
                    \$customData->status = getStatusText(\$data->status);

                    \$customData->hasLink = true;
                    \$customData->links = [
                        [
                            'linkClass' => 'semi-bold text-white statusChange ' . ((\$data->status == 'Active') ? "bg-gray-500" : "bg-green-500"),
                            'link' => route('backend.$lowercaseModel.status.change', ['id' => \$data->id, 'status' => \$data->status == 'Active' ? 'Inactive' : 'Active']),
                            'linkLabel' => getLinkLabel(((\$data->status == 'Active') ? "Inactive" : "Active"), null, null)
                        ],
                        [
                            'linkClass' => 'bg-yellow-400 text-black semi-bold',
                            'link' => route('backend.$lowercaseModel.edit',  \$data->id),
                            'linkLabel' => getLinkLabel('Edit', null, null)
                        ],
                        [
                            'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                            'link' => route('backend.$lowercaseModel.destroy', \$data->id),
                            'linkLabel' => getLinkLabel('Delete', null, null)
                        ]

                    ];
                    return \$customData;
                });

                return regeneratePagination(\$formatedDatas, \$datas->total(), \$datas->perPage(), \$datas->currentPage());
            }

            private function dataFields()
            {
                return [
                    ['fieldName' => 'index', 'class' => 'text-center'],
                    ['fieldName' => 'photo', 'class' => 'text-center'],
                    ['fieldName' => 'name', 'class' => 'text-center'],
                    ['fieldName' => 'status', 'class' => 'text-center'],
                ];
            }
            private function getTableHeaders()
            {
                return [
                    'Sl/No',
                    'Photo',
                    'Name',
                    'Status',
                    'Action',
                ];
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
                    //dd(\$err);
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

    function FormVue($model)
    {
        $lowercaseModel = strtolower($model);
        $code = <<<EOT


        <script setup>
            import { ref, onMounted } from 'vue';
            import BackendLayout from '@/Layouts/BackendLayout.vue';
            import { router, useForm, usePage } from '@inertiajs/vue3';
            import InputError from '@/Components/InputError.vue';
            import InputLabel from '@/Components/InputLabel.vue';
            import PrimaryButton from '@/Components/PrimaryButton.vue';
            import AlertMessage from '@/Components/AlertMessage.vue';
            import { displayResponse, displayWarning } from '@/responseMessage.js';

            const props = defineProps(['$lowercaseModel', 'id']);

            const form = useForm({
                name: props.$lowercaseModel?.name ?? '',
                _method: props.$lowercaseModel?.id ? 'put' : 'post',
            });

            const handlePhotoChange = (event) => {
                const file = event.target.files[0];
                form.photo = file;

                // Display photo preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    form.photoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            };

            const submit = () => {
                const routeName = props.id ? route('backend.$lowercaseModel.update', props.id) : route('backend.$lowercaseModel.store');
                form.transform(data => ({
                    ...data,
                    remember: '',
                    isDirty: false,
                })).post(routeName, {

                    onSuccess: (response) => {
                        if (!props.id)
                            form.reset();
                        displayResponse(response);
                    },
                    onError: (errorObject) => {

                        displayWarning(errorObject);
                    },
                });
            };

            </script>

            <template>
                <BackendLayout>
                    <div
                        class="w-full mt-3 transition duration-1000 ease-in-out transform bg-white border border-gray-700 rounded-md shadow-lg shadow-gray-800/50 dark:bg-slate-900">

                        <div
                            class="flex items-center justify-between w-full text-gray-700 bg-gray-100 rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200 shadow-gray-800/50">
                            <div>
                                <h1 class="p-4 text-xl font-bold dark:text-white">{{ \$page.props.pageTitle }}</h1>
                            </div>
                            <div class="p-4 py-2">
                            </div>
                        </div>

                        <form @submit.prevent="submit" class="p-4">
                            <AlertMessage />
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">

                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel for="photo" value="Photo" />
                                    <div v-if="form.photoPreview">
                                        <img :src="form.photoPreview" alt="Photo Preview" class="max-w-xs mt-2" height="60"
                                            width="60" />
                                    </div>
                                    <input id="photo" type="file" accept="image/*"
                                        class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                                        @change="handlePhotoChange" />
                                    <InputError class="mt-2" :message="form.errors.photo" />
                                </div>

                                <div class="col-span-1 md:col-span-1">
                                    <InputLabel for="first_name" value="First Name" />
                                    <input id="first_name"
                                        class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                                        v-model="form.first_name" type="text" placeholder="First Name" />
                                    <InputError class="mt-2" :message="form.errors.first_name" />
                                </div>

                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    {{ ((props.id ?? false) ? 'Update' : 'Create') }}
                                </PrimaryButton>
                            </div>
                        </form>

                    </div>
                </BackendLayout>
            </template>


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