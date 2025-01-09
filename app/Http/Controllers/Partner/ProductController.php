<?php

namespace App\Http\Controllers\Partner;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService, $cartService;
    public function __construct(
        ProductService $productService,
        CartService $cartService
    )
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = $this->productService->list($request);
        $cart_info = Helper::getCart(auth()->user()->id);
        $cart_info = $cart_info->cartProducts ?? null;
        $total_item = 0;
        $prices = 0;
        $cart_id = 0;
        if(!empty($cart_info)){
            foreach ($cart_info as $item){
                $data_cart['data'][] = array(
                    'product_id' => $item->products->id,
                    'quantity' => $item->quantity ?? 0,
                    'product_image' => $item->products?->images[0]?->link_image ?? '',
                    'product_name' => $item->products?->name ?? [],
                    'product_price' => $item->products?->price ?? 0,
                    'slug' => $item->products?->slug
                );
                $total_item += $item->quantity;
                $prices += $item->products?->price * $item->quantity;
                $cart_id = $item->cart_id;
            }
        }
        $data_cart['total_quantity'] = $total_item;
        $data_cart['total_price'] = $prices;
        $data_cart['cart_id'] = $cart_id;
        return view('pages.partner.store.product',[
            'categories' => $categories,
            'products' => $products,
            'filter_data' => $request->all(),
            'cart_info' => $data_cart,
            'total_item' => $total_item
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
        $product_info = $this->productService->findBySlug($slug);
        $cart_info = Helper::getCart(auth()->user()->id);
        $list_product = array();
        $total_item = 0;
        $total_price = 0;
        if($cart_info && !empty($cart_info?->cartProducts)){
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
        $cart_info = Helper::getCart(auth()->user()->id);
        $cart_info = $cart_info->cartProducts ?? null;
        $total_item = 0;
        $prices = 0;
        $cart_id = 0;
        if(!empty($cart_info)){
            foreach ($cart_info as $item){
                $data_cart['data'][] = array(
                    'product_id' => $item->products->id,
                    'quantity' => $item->quantity ?? 0,
                    'product_image' => $item->products?->images[0]?->link_image ?? '',
                    'product_name' => $item->products?->name ?? [],
                    'product_price' => $item->products?->price ?? 0,
                    'slug' => $item->products?->slug
                );
                $total_item += $item->quantity;
                $prices += $item->products?->price * $item->quantity;
                $cart_id = $item->cart_id;
            }
        }
        $data_cart['total_quantity'] = $total_item;
        $data_cart['total_price'] = $prices;
        $data_cart['cart_id'] = $cart_id;
        return view('pages.partner.store.product-detail',[
            'product_info' => $product_info,
            'list_product' => $list_product,
            'total_item' => $total_item,
            'total_price' => $total_price,
            'cart_info' => $data_cart,
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

    public function checkoutPage(Request $request){
        $data = array();
        $data['user_info'] = auth()->user();
        $data['cart_info'] = $this->cartService->find($request);
        return view('pages.partner.checkout.index', $data);
    }
}
