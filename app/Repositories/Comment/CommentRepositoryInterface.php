<?php
namespace App\Repositories\Comment;

interface CommentRepositoryInterface
{
    public function list($request);
    public function deleteByKeyLimit($key, $value, $limit = null, $column = null);
}
