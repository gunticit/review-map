<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;

class UserService {
    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        return $this->userRepository->list($request);
    }

    public function fullList($request){
        $projects = $this->userRepository->list($request);
        return $projects;
    }
    
    public function find($id){
        return $this->userRepository->find($id);
    }

    public function totalWidthdraw($id){
        return $this->userRepository->totalWithdraw($id);
    }
}