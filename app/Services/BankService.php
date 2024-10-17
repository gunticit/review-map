<?php

namespace App\Services;
use App\Http\Resources\BankResource;
use App\Repositories\Bank\BankRepositoryInterface;
use Illuminate\Validation\ValidationException;

class BankService {
    protected $bankRepository;

    public function __construct(
        BankRepositoryInterface $bankRepository,
    )
    {
        $this->bankRepository = $bankRepository;
    }

    /**
     * Authenticates the paymentwallet with the given credentials.
     *
     * @param array $credentials The paymentwallet's login credentials.
     * @return mixed|null The authenticated paymentwallet if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $banks = $this->bankRepository->list($request);
        return $banks;
    }
}