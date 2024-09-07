<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function create(){
        return view('auth.profile.create');
    }
    public function edit(Request $request){
        if($request->method() == 'POST'){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
                'telephone' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            ]);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }
            $profile = User::find(auth()->user()->id);
            $profile->name = $request->name;
            $profile->email = $request->email;
            $profile->telephone = $request->telephone;
            $profile->country_code = $request->country_code ?? '';
            $profile->save();
            return response()->json([
                'status' => true,
                'message' => __('message.success')
            ]);
        }
        $profile = User::find(auth()->user()->id);
        $company = Company::where('user_id', auth()->user()->id)->first();
        return view('auth.profile.edit', [
            'profile' => $profile,
            'company' => $company,
            'departments' => $departments
        ]);
    }
}
