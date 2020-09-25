<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Storage;

abstract class RepositoryAbstract implements RepositoryInterface
{
    /**
     * @var string Model name
     */
    protected $modelName;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var with
     */
    protected $withs;

    /**
     * @var string Table name
     */
    protected $table;

    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function with($withs)
    {
        $this->withs = is_array($withs) ? $withs : [$withs];
        return $this;
    }

    /**
     * Find.
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        if ($this->withs) {
            $model = $this->model->with($this->withs)->find($id);
        } else {
            $model = $this->model->find($id);
        }
        
        return empty($model) ? false : $model;
    }

    /**
     * Get all.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Index.
     *
     * @param array $data
     *
     * @return Illuminate\Database\Eloquent\Collection|Illuminate\Contracts\Pagination\Paginator
     */
    public function index($data = [])
    {
        $perPage = $data['perPage'] ?? config('constants.PER_PAGE');

        return $this->model->paginate($perPage);
    }


    /**
     * Store.
     *
     * @param array $data
     *
     * @return
     */
    public function store($data)
    {
        return $this->model->create($data);
    }

    /**
     * Show.
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return $this->find($id);
    }

    /**
     * Update.
     *
     * @param int $id
     * @param array $data
     *
     * @return Model
     */
    public function update($id, $data)
    {
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }

    /**
     * Delete.
     *
     * @param Collection|array|int $ids
     *
     * @return int
     */
    public function destroy($ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Check exist.
     *
     * @param int $id
     *
     * @return boolean
     */
    public function exist($id)
    {
        return !empty($this->find($id));
    }

    /**
     * Store file.
     *
     * @param string $name
     * @param string $path
     *
     * @return string
     */
    public function storeFile($name, $path)
    {
        if (request()->hasFile($name)) {
            $file = request()->file($name);

            // Get filename with extension
            $filenameWithExt = request()->file($name)->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = request()->file($name)->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension;

            // Upload Image
            $path = request()->file($name)->storeAs($path, $fileNameToStore);
            Storage::url($path);

            return $path;
        }
    }
}
