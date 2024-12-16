<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Wallet;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\WalletService;

class CartController extends Controller
{
    private $cartService, $walletService, $productService;
    public function __construct(
        CartService $cartService,
        WalletService $walletService,
        ProductService $productService
    ){
        $this->cartService = $cartService;
        $this->walletService = $walletService;
        $this->productService = $productService;
    }
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        $cart->load('products.images');
        $total = 0;
        if ($cart->products->count() > 0) {
            $cart->products->each(function ($product) use (&$total) {
                $subtotal = $product->price * $product->pivot->quantity;
                $total += $subtotal;

                $productDate = date('Y-m', strtotime($product->created_at));
                $productCode = $product->product_code;
                $productLinkImage = $product->images->first()->link_image ?? '';

                $product->price_formatted = $this->formatCurrencyVND($product->price);
                $product->subtotal_formatted = $this->formatCurrencyVND($subtotal);
                $product->image = "storage/app/public/uploads/quantri/uploads/products/{$productDate}/{$productCode}/{$productLinkImage}"; 
            });
        }
        $cart->total = $total;
        $cart->total_formatted = $this->formatCurrencyVND($total);

        $wallet = Wallet::where('user_id', $user->id)->first();
        // $wallet->balance_formatted = isset($wallet->balance) && $wallet->balance > 0 ? $this->formatCurrencyVND($wallet->balance) : 0;
        $balance = isset($wallet->balance) && $wallet->balance > 0 ? $this->formatCurrencyVND($wallet->balance) : 0;
        return view('pages.partner.cart.index', compact('cart', 'wallet', 'user', 'balance'));
    }

    public function updateQuantity(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = Cart::where('user_id', Auth::user()->id)->first();
            $product = Product::findOrFail($request->id);

            switch ($request->action) {
                case 'increase':
                    $currentQuantity = $cart->products()->where('product_id', $product->id)->first()->pivot->quantity ?? 0;
                    $newQuantity = $currentQuantity + $request->quantity;
                    $cart->products()->updateExistingPivot($product->id, ['quantity' => $newQuantity]);
                    break;
                case 'decrease':
                    $currentQuantity = $cart->products()->where('product_id', $product->id)->first()->pivot->quantity ?? 0;
                    $newQuantity = $currentQuantity - $request->quantity;
                    if ($newQuantity < 1) {
                        $cart->products()->detach($product);
                    } else {
                        $cart->products()->updateExistingPivot($product->id, ['quantity' => $newQuantity]);
                    }
                    break;
                case 'change':
                    $cart->products()->updateExistingPivot($product->id, ['quantity' => $request->quantity]);
                    break;
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ]);
        }
    }

    public function deleteItem(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = Cart::where('user_id', Auth::user()->id)->first();
            $product = Product::findOrFail($request->id);
            $cart->products()->detach($product);
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra']);
        }
    }

    public function applyVoucher(Request $request)
    {
        $discount = 0;
        $total = $request->total;
        $totalOriginal = $request->total_original;

        $totalFormatted = $this->formatCurrencyVND($total);
        $totalOriginalFormatted = $this->formatCurrencyVND($totalOriginal);

        $voucher = Voucher::where('code', $request->voucher_code)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false, 
                'message' => "Mã giảm giá không hợp lệ",
                'total_formatted' => $totalFormatted,
                'total_original_formatted' => $totalOriginalFormatted
            ]);
        }

        if ($voucher->status != 'active') {
            return response()->json([
                'success' => false, 
                'message' => "Mã giảm giá không hợp lệ", 
                'total_formatted' => $totalFormatted,
                'total_original_formatted' => $totalOriginalFormatted
            ]);
        }

        if ($voucher->start_date > now() || $voucher->end_date < now()) {
            return response()->json([
                'success' => false, 
                'message' => "Mã giảm giá đã hết hạn", 
                'total_formatted' => $totalFormatted,
                'total_original_formatted' => $totalOriginalFormatted
            ]);
        }

        if ($voucher->uses_left >= $voucher->max_uses) {
            return response()->json([
                'success' => false, 
                'message' => "Mã giảm giá đã hết lượt sử dụng", 
                'total_formatted' => $totalFormatted,
                'total_original_formatted' => $totalOriginalFormatted
            ]);
        }

        if ($voucher->min_order_value > $request->total) {
            return response()->json([
                'success' => false, 
                'message' => "Tổng giá trị đơn hàng phải lớn hơn {$this->formatCurrencyVND($voucher->min_order_value)}", 
                'total_formatted' => $totalFormatted,
                'total_original_formatted' => $totalOriginalFormatted
            ]);
        }

        if ($voucher->discount_type == 'percent') {
            $discount = $request->total * $voucher->discount_value / 100;
        }

        if ($voucher->discount_type == 'fixed') {
            $discount = $voucher->discount_value;
        }

        $totalAfterDiscount = $request->total - $discount;

        $discountFormatted = $this->formatCurrencyVND($discount);
        $totalAfterDiscountFormatted = $this->formatCurrencyVND($totalAfterDiscount);

        return response()->json([
            'success' => true, 
            'voucher_id' => $voucher->id,
            'total' => $total,
            'discount' => $discount,
            'total_after_discount' => $totalAfterDiscount,
            'total_formatted' => $totalFormatted, 
            'discount_formatted' => $discountFormatted,
            'total_after_discount_formatted' => $totalAfterDiscountFormatted
        ]);
    }

    public function ajaxStore(CartRequest $request){
        $wallet_info = $this->walletService->checkWalletUser(auth()->user()->id);
        $product_info = $this->productService->show($request->product_id);
        if($product_info->stock < $request->quantity){
            return response()->json([
                'success' => false,
                'message' => 'Số lượng sản phẩm đã hết!'
            ]);
        }
        if($wallet_info->balance < ($product_info->price * $request->quantity) && $wallet_info->balance > 10000){
            return response()->json([
                'success' => false,
                'message' => 'Số tiền trong ví hiện tại không đủ để thanh toán.'
            ]);
        }
        $request = $request->merge([
            'user_id' => auth()->user()->id
        ]);
        $check_cart = $this->cartService->find($request);
        if(!$check_cart){
            $this->cartService->store($request);
        }else{
            if(!empty($check_cart->products)){
                $check_product_id = false;
                foreach($check_cart->products as $product){
                    if($request->product_id == $product->id){
                        $check_product_id = true;
                        $quantity = $product->pivot->quantity;
                        $request = $request->merge([
                            'product_id' => $product->id,
                            'quantity' => $quantity + $request->quantity
                        ]);   
                        $this->cartService->update($request);
                    }
                }
                if(!$check_product_id){
                    $request = $request->merge([
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity
                    ]);   
                    $this->cartService->update($request);
                }
            }
        }
        $cart_info = $this->cartService->find($request);
        $list_product = $cart_info->products()->get();
        $dt_list_product = array();
        if(!empty($list_product)){
            $total_price = 0;
            $total_quantity = 0;
            foreach($list_product as $product){
               $dt_list_product[] = array(
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'name' => $product->name,
                    'price' => $product->price
               ); 
               $total_quantity += $product->pivot->quantity;
               $total_price += $product->price * $product->pivot->quantity;
            }
            $data = array(
                'cart_id' => $cart_info->id,
                'user_id' => $cart_info->id,
                'total' => $cart_info->total,
                'list_product' => $list_product,
                'total_price' => $this->formatCurrencyVND($total_quantity),
                'total_quantity' => $total_quantity
            );
        }
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Đặt hàng thành công'
        ]);
    }

    public function findCartByUserIdAjax(Request $request){
        $cart_info = $this->cartService->findCartByUserIdAjax($request);
        return response()->json([
            'success' => true,
            'data' => $cart_info
        ]);
    }

    private function formatCurrencyVND($number)
    {
        return number_format($number, 0, ',', '.') . ' VND';
    }
}
