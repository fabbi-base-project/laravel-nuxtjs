<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Find.
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find($id);

    /**
     * Get all.
     *
     * @return Collection
     */
    public function all();

    /**
     * Index.
     *
     * @param array $data
     *
     * @return Collection|Paginator
     */
    public function index($data = []);

    /**
     * Store.
     *
     * @param array $data
     *
     * @return
     */
    public function store($data);

    /**
     * Show.
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function show($id);

    /**
     * Update.
     *
     * @param int $id
     * @param array $data
     *
     * @return Model
     */
    public function update($id, $data);

    /**
     * Delete.
     *
     * @param Collection|array|int $ids
     *
     * @return int
     */
    public function destroy($ids);

    /**
     * Check exist.
     *
     * @param int $id
     *
     * @return boolean
     */
    public function exist($id);

    /**
     * Store file.
     *
     * @param string $name
     * @param string $path
     *
     * @return string
     */
    public function storeFile($name, $path);
}
