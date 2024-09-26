<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;

class ProfileService {
    protected $profileRepository;

    public function __construct(
        ProductRepositoryInterface $profileRepository,
    )
    {
        $this->profileRepository = $profileRepository;
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
        $data = $this->profileRepository->update($request, $id);
        return $data; 
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'slug' => $data['slug'] ?? null,
            'package' => $data['package'] ?? null,
            'is_slow' => $data['is_slow'] ?? null,
        );
    }
}