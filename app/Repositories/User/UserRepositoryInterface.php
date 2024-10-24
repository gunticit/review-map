<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function list($request);
    public function generateOtp($user);
    public function verifyOtp($user);
    public function resetPassword($user, $password);
    public function clearOtp($user);
    public function totalWithdraw($id);
}
