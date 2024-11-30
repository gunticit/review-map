<?php

namespace App\Services;

use App\Enums\Status;
use App\Repositories\Mission\MissionRepositoryInterface;
use App\Http\Resources\MissionResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MissionService {
    protected $missionRepository, $walletService, $userService, $transactionHistoryService, $censorshipHistoryService;

    public function __construct(
        MissionRepositoryInterface $missionRepository, 
        WalletService $walletService, 
        UserService $userService,
        TransactionHistoryService $transactionHistoryService,
        CensorshipHistoryService $censorshipHistoryService
    )
    {
        $this->missionRepository = $missionRepository;
        $this->walletService = $walletService;
        $this->userService = $userService;
        $this->transactionHistoryService = $transactionHistoryService;
        $this->censorshipHistoryService = $censorshipHistoryService;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $supports = $this->missionRepository->list($request);
        $data = MissionResource::collection($supports)->resource;
        return $data;
    }

    public function find($id){
        $query = $this->missionRepository->query();
        $query->with(['comments','images','project']);
        $mission = $query->find($id);
        return $mission;
    }

    public function update($request, $id){
        $mission_info = $this->find($id);
        $status = 4; // Admin Duyệt
        if(!empty($mission->image_id)){
            $status = 4; // Nếu câu hỏi có hình ảnh thì admin duyệt
        }
        $mission = $time_completed = null;
        if($mission_info->user_id == Auth::user()->id && !empty($request->link_confirm)){
            $time_completed = Carbon::now();
            $mission = $this->missionRepository->update([
                'status' => $status,
                'link_confirm' => $request->link_confirm ?? '',
                'completed_at' => $time_completed,
            ], $id);

        }

        return $mission;
    }

    // Admin Duyệt Mission
    public function updateStatus($request, $id){
        try{
            DB::beginTransaction();
            $mission = $this->missionRepository->update([
                'status' => $request->status,
            ], $id);
            if($request->status == 1){
                $user_id = $mission['user_id'] ?? null;
                if($user_id){
                    // Cập nhật lại ví
                    $request_wallet = new Request();
                    $request_wallet->merge([
                        'user_id' => $user_id,
                        'money' => $this->checkMoneyByLevel($user_id),
                        'reference_id' => strtoupper(uniqid('MINE_')),
                    ]);
                    $wallet = $this->walletService->partnerMineMoney($request_wallet);
                    // Lưu lịch sử giao dịch
                    $request_histories = new Request();
                    $request_histories->merge([
                        'wallet_id' => $wallet->id,
                        'type' => 'mined',
                        'transaction_code' => strtoupper(uniqid('MINE_')),
                        'amount' => $this->checkMoneyByLevel($user_id),
                        'status' => 'completed',
                        'reference_id' => strtoupper(uniqid('MINE_')),
                    ]);
                    $this->transactionHistoryService->create($request_histories);
                    // Lưu lịch sử người duyệt
                    $request_censor_history = new Request();
                    $request_censor_history->merge([
                        'approver_id' => Auth::user()->id,
                        'mission_id' => $mission->id,
                        'partner_id' => $user_id,
                        'money' => $this->checkMoneyByLevel($user_id),
                    ]);
                    $this->censorshipHistoryService->create($request_censor_history);
                }
            }
            DB::commit();
            return $mission;
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function getRandomMission($request){
        $data = $this->missionRepository->getRandomMission($request);
        return $data;
    }

    public function getPrice($request){
        return 0;
    }

    public function updateNoImage($request, $id){
        $mission = $this->missionRepository->find($id);
        $count_check = $mission->num_check ?? 0;
        return $this->missionRepository->update([
            'no_image' => true,
            'num_check' => $count_check + 1
        ], $id);
    }

    public function updateNoReview($request, $id){
        $mission = $this->missionRepository->find($id);
        $count_check = $mission->num_check ?? 0;
        return $this->missionRepository->update([
            'no_review' => true,
            'num_check' => $count_check + 1
        ], $id);
    }
    
    public function checkMoneyByLevel($user_id = null){
        $user_id = $user_id ?? Auth::user()->id;
        $user_info = $this->userService->find($user_id);
        $money = 10000;
        if(!empty($user_info->level)){
            switch($user_info->level){
                case 5: 
                    $money = 14000;
                    break;
                case 4: 
                    $money = 13000;
                    break;
                case 3: 
                    $money = 12000;
                    break;
                case 2: 
                    $money = 11000;
                    break;
                case 1:
                    $money = 10000;
                    break;
                default: 
                    $money = 10000;
                    break;
            }
        }
        return $money;
    }
}