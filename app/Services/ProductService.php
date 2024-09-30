<?php

namespace App\Services;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductImage\ProductImageRepositoryInterface;
use Illuminate\Validation\ValidationException;

class ProductService {
    protected $productRepository, $productImageRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductImageRepositoryInterface $productImageRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
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
        return $products;
    }

    public function fullList($request){
        $products = $this->productRepository->list($request);
        return $products;
    }

    public function create($request){
        $product = $this->filterData($request);
        $data = $this->productRepository->create($product);
        if($data) {
            if ($request->hasFile('image')) {
                $photo = Helper::uploadFile($request->file('image'), 'uploads/products/'.date('Y-m').'/'.$request->product_code);
                $photo = $photo['hash_name'];
                $this->productImageRepository->create([
                    'product_id' => $data->id,
                    'link_image' => $photo
                ]);
            }
            return $data;
        }
        return [];
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
            'category_id' => $data['category_id'] ?? null,
            'slug' => slugify($data['name']) ?? null,
            'price' => $data['price'] ?? null,
            'description' => $data['description'] ?? null,
            'product_code' => $data['product_code'] ?? null,
            'sku' => $data['sku'] ?? null,
            'stock' => $data['stock'] ?? null,
            'keyword' => $data['keyword'] ?? $data['name']
        );
    }
}