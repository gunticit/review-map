<?php

namespace App\Http\Controllers;

use App\Models\CertificationAccount;
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
    public function confirmApprove(Request $request){
        $certification_id = $request->certification_id;
        $data = CertificationAccount::where('id', $certification_id)->update([
            'active' => 1,
            'user_verified' => auth()->user()->id,
            'verified_at' => now(),
            'updated_at' => now(),
            'updated_by' => auth()->user()->id
        ]);
        $data_certification = CertificationAccount::with(['user','userVerified'])->where('id', $certification_id)->first();
        return response()->json([
            'status' => 'success', 
            'id' => $certification_id,
            'user_verified' => $data_certification->userVerified?->name ?? '',
            'verified_at' => $data_certification->verified_at ?? ''
        ]);
    }
    public function reject(Request $request){
        $certification_id = $request->certification_id;
        CertificationAccount::where('id', $certification_id)->update([
            'active' => 0,
            'user_verified' => auth()->user()->id,
            'verified_at' => now(),
            'updated_at' => now(),
            'updated_by' => auth()->user()->id
        ]);
        $data_certification = CertificationAccount::with(['updatedBy'])->where('id', $certification_id)->first();
        return response()->json([
            'status' => 'success', 
            'id' => $certification_id,
            'user_verified' => $data_certification->userVerified?->name ?? '',
            'verified_at' => $data_certification->verified_at ?? ''
        ]);
    }
    public function refresh(Request $request){
        $certification_id = $request->certification_id;
        CertificationAccount::where('id', $certification_id)->update([
            'active' => 1,
            'user_verified' => null,
            'verified_at' => null,
            'updated_at' => now(),
            'updated_by' => auth()->user()->id
        ]);
        return response()->json([
            'status' => 'success', 
            'id' => $certification_id,
        ]);
    }
}
