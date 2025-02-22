<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\LibraryService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ModuleMakerController extends Controller
{
    protected $libraryService;

    public function __construct(LibraryService $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    public function index()
    {

        // start get models name
        $modelsDirectory = app_path('Models');
        $modelFiles = File::files($modelsDirectory);
        $modelsName = [];
        foreach ($modelFiles as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $modelsName[] = $fileName;
        }
        // end get models name

        // end fillable attributes
        if (isset(request()->model)) {
            $modelName = request()->model;
            $className = '\App\Models\\' . $modelName;
            $model = new $className();
            $fillableAttributes = $model->getFillable();
        }
        // end fillable attributes

        if (request()->method() == 'POST') {
            $validationRules = [
                'modelName' => 'required|string',
                'fields.*.field_name' => 'required|string',
                'fields.*.data_type' => 'required|string',
                'formField' => 'required',
            ];

            request()->validate($validationRules);

            $response = $this->createFile(request());
        }

        return Inertia::render(
            'Backend/ModuleMaker/Index',
            [
                'pageTitle' => 'Module Maker',
                'breadcrumbs' => [
                    ['link' => route('backend.moduleMaker'), 'title' => 'Module Maker'],
                ],
                'dataTypes' => fn () => $this->libraryService->getDataTypes(),
                'modelsName' => fn () => $modelsName,
                'fillableAttributes' => fn () => $fillableAttributes ?? null,
            ]
        );
    }

    public function createFile($request)
    {
        $postData = $request->all();
        $postData['path'] = base_path();

        $stubFilePath = base_path('routes/backend.php');
        $postData['stubContent'] = file_get_contents($stubFilePath);

        $stubFilePath = base_path('database/seeders/MenuSeeder.php');
        $postData['menuSeeder'] = file_get_contents($stubFilePath);

        $postData['path'] = base_path();

        // $response = Http::post('http://dev.cms.com/api/v1/module-make', $postData);
        //$response = Http::withoutVerifying()->post('http://dev.inertiajs.com/api/v1/module-make', $postData);
        $response = Http::withoutVerifying()->post('https://inertiajs.al-mamun.dev/api/v1/module-make', $postData);

        if ($response->successful()) {

            $responseData = $response->json();
            $success = 0;
            $fail = 0;

            foreach ($responseData['data'] as $key => $data) {
                if ($data["folder"]) {
                    if (!File::exists($data["folder"])) {
                        File::makeDirectory($data["folder"], 0755, true);
                    }
                }
                if (file_put_contents($data['path'], $data['content']) !== false) {
                    $success++;
                    if ($data['artisan'] ?? false) {
                        shell_exec($data['artisan']);
                    }
                } else {
                    $fail++;
                }
            }

            return $success;
        } else {

            //dump($response->status());
            //dd($response->body());
            return false;
        }
    }
}
