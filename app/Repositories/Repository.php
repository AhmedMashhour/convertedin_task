<?php


namespace App\Repositories;


use Illuminate\Support\Str;

class Repository
{
    protected mixed $getModel;

    public function __construct(string $model)
    {
        $this->getModel = new $model();
    }

    public static function getRepository(string $model){
        $modelObj = 'App\\Models\\'.$model;
        if (class_exists('App\\Repositories\\'.$model.'Repository')) {
            $repoClass = 'App\\Repositories\\'.$model.'Repository';
            return new $repoClass($modelObj);
        }
        else {
            return new Repository($modelObj);
        }
    }


    public function getAll(array $relatedObjects = []) :object
    {
        return $this->getModel->with($relatedObjects);
    }

    public function getById(int $id ,array $relatedObjects = [] ,array $relatedObjectsCount = [])  :?object
    {
        return $this->getModel->with($relatedObjects)->withCount($relatedObjectsCount)->find($id);
    }

    public function getByIdAndLock(int $id ,array $relatedObjects = [])  :?object
    {
        return $this->getModel->with($relatedObjects)->lockForUpdate()->find($id);
    }

    public function getByKey(string $key ,string $value ,array $relatedObjects = [])  :object
    {
        return $this->getModel->with($relatedObjects)->where($key,$value);
    }

    public function getByKeys($conditions, $relatedObjects = []){
        return $this->getModel->with($relatedObjects)->where($conditions);
    }

    public function multipleSort(object $modelObj ,array $sort = []) :object
    {

        foreach ($sort as $value) {
            $modelObj->orderBy($value['sort_by'], $value['sort_type']);
        }

        return $modelObj;
    }

    public function create(array $data) :object
    {
        return $this->getModel->create($data);
    }



    public function insertMany(array $data) :void
    {
        $this->getModel->insert($data);
    }

    public function update(object $modelObj,array $data)  :object
    {
        $modelObj->update($data);

        return $modelObj;
    }

    public function updateByIds(array $ids ,string $key ,array $data) :bool
    {
        $updateAc = $this->getModel->whereIn($key , $ids)->update($data);

        return $updateAc;
    }

    public function delete(array $ids) :int
    {
        $deleteAc = $this->getModel->destroy($ids);

        return $deleteAc;
    }

    public function loadRelatedObjects(object $modelObject , array $relatedObjects = []) :object
    {
        return $modelObject->load($relatedObjects);
    }

    public function forceDelete($modelObjects) :int
    {
        $deleteCount = 0;
        foreach ($modelObjects as $modelObj)
        {
            $modelObj->forceDelete();
            $deleteCount++;
        }
        return $deleteCount;
    }


    public function sync(object $model ,string $relation ,array $array) :void
    {
        $model->$relation()->sync($array);
    }

}
