<?php
namespace App\Repositories\AuthSocial;

use App\Repositories\BaseRepository;
use App\Models\User;

class  AuthSocialRepository extends BaseRepository implements AuthSocialRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
