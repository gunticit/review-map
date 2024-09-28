<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\Profile\ProfileRepositoryInterface;
use Illuminate\Validation\ValidationException;

class ProfileService {
    protected $profileRepository, $companyRepository;
    protected $folderAvatar = 'avatars';

    public function __construct(
        ProfileRepositoryInterface $profileRepository,
        CompanyRepositoryInterface $companyRepository
    )
    {
        $this->profileRepository = $profileRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * Authenticates the product with the given credentials.
     *
     * @param array $credentials The product's login credentials.
     * @return mixed|null The authenticated product if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $products = $this->profileRepository->list($request);
        return $products;
    }

    public function fullList($request){
        $products = $this->profileRepository->list($request);
        return $products;
    }

    public function create($request){
        $product = $this->filterData($request);
        $data = $this->profileRepository->create($product);
        return $data;
    }

    public function show($id){
        $data = $this->profileRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $data = $this->filterData($request);
        if ($request->hasFile('avatar')) {
            $dataAvatar = Helper::uploadFile($request->file('avatar'), $this->folderAvatar);
            $fileAvatar = $dataAvatar['hash_name'];
            $data = array_merge($data, ['avatar' => $fileAvatar]);
        }
        $data = $this->profileRepository->update($data, $id);
        return $data; 
    }

    public function updateProfileCompany($request){
        $data = $this->filterDataCompany($request);
        $company = $this->companyRepository->findWith($data, 'tax|email');
        if(!$company){
            $company_data = $this->companyRepository->create($data);
        }else{
            $company_data = $this->companyRepository->update($data, $company->id);
        }
        $this->profileRepository->update(['company_id' => $company_data['id']], auth()->user()->id);
        return $company_data;
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'telephone' => $data['telephone'] ?? null,
            'country_code' => $data['country_code'] ?? null
        );
    }
    
    public function filterDataCompany($request){
        $data = is_array($request) ? $request : $request->all();
        return array(
            'name' => $data['company_name'] ?? null,
            'email' => $data['company_email'] ?? null,
            'tax' => $data['tax'] ?? null,
            'is_receive' => $data['is_receive'] ?? 0,
            'address' => $data['company_address'] ?? null,
        );
    }
}