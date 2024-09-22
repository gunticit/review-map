<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use Illuminate\Validation\ValidationException;

class ProductService {
    protected $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Authenticates the product with the given credentials.
     *
     * @param array $credentials The product's login credentials.
     * @return mixed|null The authenticated product if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $products = $this->productRepository->list($request);
        $products = ProductResource::collection($products)->resource;
        $data = array(
            'products' => $products,
            'total' => count($products)
        );
        return $data;
    }

    public function fullList($request){
        $products = $this->productRepository->list($request);
        return $products;
    }

    public function create($request){
        $product = $this->filterData($request);
        $data = $this->productRepository->create($product);
        return $data;
    }

    public function show($id){
        $data = $this->productRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $product = $this->filterData($request);
        $data = $this->productRepository->update($product, $id);
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