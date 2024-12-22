<?php

namespace App\Http\Controllers\Partner;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = $this->productService->list($request);
        $cart_info = Helper::getCart(auth()->user()->id);
        return view('pages.partner.store.product',[
            'categories' => $categories,
            'products' => $products,
            'filter_data' => $request->all(),
            'cart_info' => $cart_info
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function findBySlug(string $slug){
        $product = $this->productService->findBySlug($slug);
        $cart_info = Helper::getCart(auth()->user()->id);
        $list_product = array();
        $total_item = 0;
        $total_price = 0;
        if($cart_info && !empty($cart_info->cartProducts)){
            foreach ($cart_info->cartProducts as $item){
                if(!empty($item->products)){
                    $total_item += $item->quantity;
                    $total_price += $item->products['price'] * $item->quantity;
                    $list_product[] = array(
                        'name' => $item->products['name'],
                        'quantity' => $item->quantity,
                        'desription' => $item->products['description'],
                        'price' => $item->products['price']
                    );
                }
            }
        }
        return view('pages.partner.store.product-detail',[
            'product' => $product,
            'list_product' => $list_product,
            'total_item' => $total_item,
            'total_price' => $total_price
        ]);
    }

    public function partnerFindProduct(Request $request){
        if(!$request->id){
            return response()->json_encode([
                'title' => 'Chi tiết sản phẩm bằng ajax',
                'status' => false,
                'message' => 'Thiếu params id truyền vào'
            ]);
        }
        $product_info = $this->productService->find($request->id);
        return response()->json_encode([
            'title' => 'Chi tiết sản phẩm bằng ajax',
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $product_info
        ]);
    }
}
