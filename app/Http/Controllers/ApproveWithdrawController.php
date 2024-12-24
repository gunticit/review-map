<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApproveWithdrawController extends Controller
{
    public function index(Request $request){
        $data = array();
        $profiles = User::with(['accountPayment','certificationAccount' => function($query){
            return $query->with(['user','userVerified']);
        },'levelDetails'])
        ->get();
        if(!empty($profiles)){
            foreach($profiles as $profile){
                if($profile->hasRole('partner')){
                    $data['partners'][] = $profile;
                }
            }
        }
        return view('pages.admin.approve-widthdraw.index', $data);
    }
}
