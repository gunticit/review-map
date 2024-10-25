<?php
namespace App\Repositories\User;

use App\Mail\OtpMail;
use App\Repositories\BaseRepository;
use App\Models\User;
use Hash;
use Mail;

class  UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function list($request){
        $query = $this->model->query();
        if(isset($request->type)){
            if($request->type == 'partner'){
                $query = $query->with('missions');
            }
            $query = $query->role($request->type);
        }
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
    public function generateOtp($user)
    {
        $otp = rand(1000, 9999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5); // OTP có hạn 5 phút
        $user->save();

        // Gửi OTP qua email
        Mail::to($user->email)->send(new OtpMail($otp));

        return $otp;
    }

    public function verifyOtp($user)
    {
        $user->email_verified_at = now();
        $user->otp = null;
        $user->save();
    }

    public function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
    }
    public function clearOtp($user)
    {
        // Xóa mã OTP của người dùng
        $user->otp = null;
        $user->save();
    }
    public function totalWithdraw($id){
        $query = $this->model->query();
        $query = $query->with('transactionHistories')->get();
        return $query;
    }
}
