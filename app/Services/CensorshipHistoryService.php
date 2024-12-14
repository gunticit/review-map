<?php

namespace App\Services;
use App\Http\Resources\CensorshipHistoryResource;
use App\Repositories\CensorshipHistory\CensorshipHistoryRepositoryInterface;
use Illuminate\Validation\ValidationException;

class CensorshipHistoryService {
    protected $censorshipHistoryRepository;

    public function __construct(
        CensorshipHistoryRepositoryInterface $censorshipHistoryRepository,
    )
    {
        $this->censorshipHistoryRepository = $censorshipHistoryRepository;
    }

    /**
     * Authenticates the paymentwallet with the given credentials.
     *
     * @param array $credentials The paymentwallet's login credentials.
     * @return mixed|null The authenticated paymentwallet if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $censorshipHistoryRepository = $this->censorshipHistoryRepository->list($request);
        return $censorshipHistoryRepository;
    }
    public function create($request){
        $data = $this->getData($request);
        $censorshipHistoryRepository = $this->censorshipHistoryRepository->create($data);
        return $censorshipHistoryRepository;
    }
    public function getAll($request){
        $censorshipHistoryRepository = $this->censorshipHistoryRepository->getAll($request);
        return $censorshipHistoryRepository;
    }
    /**
     * Prepare the data for create or update CensorshipHistory.
     *
     * @param Request $request
     * @return array
     */
    public function getData($request){
        return [
            'approver_id' => $request->approver_id,
            'mission_id' => $request->mission_id,
            'partner_id' => $request->partner_id,
            'money' => $request->money ?? null,
            'status' => $request->status
        ];
    }
}