<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Services\ProfileService;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use UploadFile;

    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;   
    }
    
    public function create(){
        return view('auth.profile.create');
    }
    public function edit(Request $request){
        $profile = User::find(auth()->user()->id);
        $company = array();
        if(!empty($profile->company_id)){
            $company = Company::find($profile->company_id);
        }
        $departments = Department::all();
        return view('auth.profile.edit', [
            'profile' => array(
                'id'         => $profile->id ?? null,
                'name'   => $profile->name ?? null,
                'username' => $profile->username ?? null,
                'avatar' => $profile->avatar ? getAssetStorageLocal("avatars/{$profile->avatar}") : null,
                'email'     => $profile->email ?? null,
                'telephone'   => $profile->telephone ?? null,
                'language'   => $profile->language ?? null,
                'dark_mode'  => $profile->dark_mode ?? null,
                'country_code' => $profile->country_code ?? null,
                'department_id' => $profile->department_id ?? null
            ),
            'company' => $company,
            'departments' => $departments,
        ]);
    }

    public function editPartner(Request $request){
        $user = auth()->user();
        $profile = User::where('id',($user->id))->with('accountPayment','certificationAccount','levelDetails')->first();
        $data = [
            'profile' => array(
                'id'         => $profile->id ?? null,
                'name'   => $profile->name ?? null,
                'username' => $profile->username ?? null,
                'avatar' => $profile->avatar ? getAssetStorageLocal("avatars/{$profile->avatar}") : null,
                'email'     => $profile->email ?? null,
                'telephone'   => $profile->telephone ?? null,
                'language'   => $profile->language ?? null,
                'dark_mode'  => $profile->dark_mode ?? null,
                'country_code' => $profile->country_code ?? null,
                'contract' => $profile->certificationAccount?->contract ?? null,
                'front_id_image' => $profile->certificationAccount?->front_id_image ?? null,
                'back_id_image' => $profile->certificationAccount?->back_id_image ?? null,
            ),
            'levelDetails' => $profile->levelDetails ?? null,
            'accountPayment' => $profile->accountPayment ?? null
        ];
        return view('auth.profile.partner.edit', $data);
    }

    public function updateAccountPayment(Request $request, $id){
        Auth::user()->accountPayment()->updateOrCreate(['user_id' => $id], $request->all());
        return response()->json([
           'status' => true,
           'message' => __('message.success')
        ]);
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)],
            'telephone' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $this->profileService->update($request, auth()->user()->id);
        return response()->json([
            'status' => true,
            'message' => __('message.success')
        ]);
    }
    public function updateProfileCompany(Request $request){
        $this->profileService->updateProfileCompany($request);
        return response()->json([
            'status' => true,
            'message' => __('message.success')
        ]);
    }
}
