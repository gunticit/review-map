<?php
namespace App\Repositories\Wallet;

use App\Models\Wallet;
use App\Repositories\BaseRepository;
use App\Repositories\Wallet\WalletRepositoryInterface;

class WalletRepository extends BaseRepository implements WalletRepositoryInterface
{
    protected $model;

    public function __construct(Wallet $wallet)
    {
        $this->model = $wallet;
    }

    public function getBalance($request){
        $user_id = $request['user_id'] ?? null;
        if(!empty($user_id)){
            $balance = $this->model->where('user_id', $user_id)->first();
            return $balance;
        }
    }

    public function update($data, $id){
        return $this->model->where('id', $id)->where('user_id', $data['user_id'])->update($data);
    }
}
