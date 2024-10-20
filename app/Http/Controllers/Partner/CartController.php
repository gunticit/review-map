<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
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
        $wallet->balance_formatted = $this->formatCurrencyVND($wallet->balance);
        return view('pages.partner.cart.index', compact('cart', 'wallet', 'user'));
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

    private function formatCurrencyVND($number)
    {
        return number_format($number, 0, ',', '.') . ' VND';
    }
}
