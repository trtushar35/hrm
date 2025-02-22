<?php

namespace App\Services;

use App\Models\Menu;

class MenuRepository
{
    protected $model;

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }
    public function parentMenu()
    {
        return $this->model->whereNull('deleted_at')->whereNull('parent_id')->get();
    }
    public function list()
    {
        return $this->model->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->model->whereNull('deleted_at')->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->model->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->model->find($id);

        if(!empty($dataInfo)){

            $dataInfo->deleted_at=date('Y-m-d H:i:s');

            $dataInfo->status='Deleted';

            return ($dataInfo->save());
        }
            return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->model->findOrFail($request->id);

        $dataInfo->update($request->all());

        return $dataInfo;
    }
}
