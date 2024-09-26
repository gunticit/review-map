<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Services\ProfileService;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        if($request->method() == 'POST'){
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
            $this->profileService->edit($request);
            return response()->json([
                'status' => true,
                'message' => __('message.success')
            ]);
        }
        $profile = User::find(auth()->user()->id);
        $company = Company::where('user_id', auth()->user()->id)->first();
        return view('auth.profile.edit', [
            'profile' => $profile,
            'company' => $company
        ]);
    }
}
