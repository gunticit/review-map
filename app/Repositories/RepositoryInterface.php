<?php
namespace App\Repositories;
 
use Illuminate\Database\Query\Builder;
 
interface RepositoryInterface
{
    public function all();
 
    public function create(array $data);
 
    public function update(array $data, $id);
 
    public function delete($id);
 
    public function show($id);
 
    public function find($id);
 
    public function pagination($query, array $columns);
 
    public function filter(array $columns, array $orderBy);
 
    public function bulkDelete(array $ids);
 
    public function insertGetId(array $data);
 
    public function updateOrCreate(array $params, array $data);
 
}
