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
    protected $categoryService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductImageRepositoryInterface $productImageRepository,
        CategoryService $categoryService
    )
    {
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
        $this->categoryService = $categoryService;
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
            $imagePath = null;
            if ($request->hasFile('image')) {
                if(is_array($request->file('image'))){
                    foreach ($request->file('image') as $image) {
                        $imagePath = $image->store('images/product', 'public');
                        $this->productImageRepository->create([
                            'product_id' => $data->id,
                            'link_image' => $imagePath
                        ]);
                    }
                }else{
                    $imagePath = $request->file('image')->store('images/product', 'public');
                    $this->productImageRepository->create([
                        'product_id' => $data->id,
                        'link_image' => $imagePath
                    ]);
                }
            }
            return $data;
        }
        return [];
    }

    public function show($id){
        $data = $this->productRepository->find($id);
        return $data;
    }

    public function findBySlug($slug){
        $data = $this->productRepository->findBySlug($slug);
        return $data;
    }

    public function getCategories($request){
        $data = $this->categoryService->list($request);
        return $data;
    }

    public function update($request, $id){
        $product = $this->filterData($request);
        $data = $this->productRepository->update($product, $id);

        if ($request->hasFile('image')) {
            $img_product = $this->productImageRepository->findByKey('product_id', $id, ['*'], [], 'all');
            if(!empty($img_product)){
                foreach ($img_product as $img) {
                    $this->productImageRepository->delete($img->id);
                }
            }
            if(is_array($request->file('image'))){
                foreach ($request->file('image') as $image) {
                    $imagePath = $image->store('images/product', 'public');
                    $this->productImageRepository->create([
                        'product_id' => $data->id,
                        'link_image' => $imagePath
                    ]);
                }
            }else{
                $imagePath = $request->file('image')->store('images/product', 'public');
                $this->productImageRepository->create([
                    'product_id' => $data->id,
                    'link_image' => $imagePath
                ]);
            }
        }
        return $data; 
    }

    public function delete($id){
        $data = $this->productRepository->delete($id);
        return $data;
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'slug' => slugify($data['name']) ?? null,
            'price' => $data['price'] && $data['price'] > 0 ? $data['price'] : 0,
            'description' => $data['description'] ?? null,
            'product_code' => $data['product_code'] ?? null,
            'sku' => $data['sku'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'keyword' => $data['keyword'] ?? $data['name']
        );
    }

    public function checkCode($product_code){
        $data = $this->productRepository->findByKey('product_code',$product_code);
        return $data;
    }
}